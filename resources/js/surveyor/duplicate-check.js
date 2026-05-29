const CLIENT_IDENTITY_CACHE_PREFIX = 'ipss-client-identities:';

export class DuplicateSyncError extends Error {
    constructor(decision) {
        super(decision.message || 'Duplicate client record detected.');
        this.name = 'DuplicateSyncError';
        this.decision = decision;
    }
}

export class DuplicateWarningCancelledError extends Error {
    constructor(decision) {
        super('Name match warning was not confirmed.');
        this.name = 'DuplicateWarningCancelledError';
        this.decision = decision;
    }
}

export function normalizeNamePart(value) {
    return String(value ?? '').trim().replace(/\s+/g, ' ').toLocaleLowerCase();
}

export function normalizePhilSys(value) {
    return String(value ?? '').trim().replace(/[\s-]+/g, '').toLocaleLowerCase();
}

export function getSurveyBarangayCode(data = {}) {
    return data.barangayCode || data.baranggayCode || localStorage.getItem('ipss-selectedBarangay') || '';
}

export function cacheClientIdentityList(barangayCode, identities = []) {
    if (!barangayCode) return;

    localStorage.setItem(
        `${CLIENT_IDENTITY_CACHE_PREFIX}${barangayCode}`,
        JSON.stringify({
            barangayCode,
            cachedAt: new Date().toISOString(),
            identities,
        })
    );
}

export function getCachedClientIdentityList(barangayCode) {
    if (!barangayCode) return [];

    try {
        const cached = JSON.parse(localStorage.getItem(`${CLIENT_IDENTITY_CACHE_PREFIX}${barangayCode}`) || 'null');
        return Array.isArray(cached?.identities) ? cached.identities : [];
    } catch (err) {
        console.warn('[Duplicate Check] Failed to parse cached client identities:', err);
        return [];
    }
}

export async function fetchAndCacheClientIdentityList(barangayCode) {
    if (!barangayCode) return [];

    const response = await fetch(`/api/clients/identity-list?barangay_code=${encodeURIComponent(barangayCode)}`, {
        headers: {
            Accept: 'application/json',
        },
    });

    if (!response.ok) {
        throw new Error(`Failed to fetch client identities: ${response.status}`);
    }

    const identities = await response.json();
    cacheClientIdentityList(barangayCode, identities);
    return identities;
}

export async function getClientIdentityListForBarangay(barangayCode) {
    if (!barangayCode) return { identities: [], source: 'missing-barangay' };

    if (navigator.onLine) {
        try {
            const identities = await fetchAndCacheClientIdentityList(barangayCode);
            return { identities, source: 'network' };
        } catch (err) {
            console.warn('[Duplicate Check] Network lookup failed; using cache when available:', err);
        }
    }

    return {
        identities: getCachedClientIdentityList(barangayCode),
        source: 'cache',
    };
}

export function evaluateSurveyDuplicate(data = {}, identities = [], source = 'cache') {
    const survey = {
        philippine_identification_system: normalizePhilSys(data.philippineIdentificationSystem),
        first_name: normalizeNamePart(data.firstName),
        middle_name: normalizeNamePart(data.middleName),
        last_name: normalizeNamePart(data.lastName),
    };

    let philSysMatch = null;
    let nameMatch = null;
    let fullMatch = null;

    for (const client of identities) {
        const normalizedClient = {
            philippine_identification_system: normalizePhilSys(client.philippine_identification_system),
            first_name: normalizeNamePart(client.first_name),
            middle_name: normalizeNamePart(client.middle_name),
            last_name: normalizeNamePart(client.last_name),
        };

        const philSysMatches = survey.philippine_identification_system === normalizedClient.philippine_identification_system;
        const nameMatches =
            survey.first_name === normalizedClient.first_name &&
            survey.middle_name === normalizedClient.middle_name &&
            survey.last_name === normalizedClient.last_name;

        if (philSysMatches && nameMatches) {
            fullMatch = client;
            break;
        }

        if (philSysMatches && !philSysMatch) {
            philSysMatch = client;
        }

        if (nameMatches && !nameMatch) {
            nameMatch = client;
        }
    }

    if (fullMatch) {
        return {
            status: 'full_block',
            severity: 'error',
            canSync: false,
            source,
            match: fullMatch,
            message: 'Duplicate blocked: PhilSys and full name already match an existing client in this barangay.',
        };
    }

    if (philSysMatch) {
        return {
            status: 'philsys_block',
            severity: 'error',
            canSync: false,
            source,
            match: philSysMatch,
            message: 'Duplicate blocked: PhilSys already exists in this barangay.',
        };
    }

    if (nameMatch) {
        return {
            status: 'name_warning',
            severity: 'warning',
            canSync: true,
            source,
            match: nameMatch,
            message: 'Possible duplicate: first, middle, and last name match an existing client in this barangay.',
        };
    }

    if (source === 'missing-barangay') {
        return {
            status: 'unchecked',
            severity: 'info',
            canSync: true,
            source,
            match: null,
            message: 'Duplicate check skipped because this survey has no barangay.',
        };
    }

    return {
        status: 'clear',
        severity: 'success',
        canSync: true,
        source,
        match: null,
        message: 'No duplicate match found.',
    };
}

export async function checkSurveyDuplicate(data = {}) {
    const barangayCode = getSurveyBarangayCode(data);
    const { identities, source } = await getClientIdentityListForBarangay(barangayCode);
    return evaluateSurveyDuplicate(data, identities, source);
}

export async function assertSurveyCanSync(data = {}, options = {}) {
    const decision = await checkSurveyDuplicate(data);

    if (!decision.canSync) {
        throw new DuplicateSyncError(decision);
    }

    if (decision.status === 'name_warning' && options.confirmNameWarning) {
        const confirmed = confirm(`${decision.message}\n\nDo you still want to sync this survey?`);
        if (!confirmed) {
            throw new DuplicateWarningCancelledError(decision);
        }
    }

    if (decision.status === 'name_warning' && options.requireConfirmation && !options.confirmNameWarning) {
        throw new DuplicateWarningCancelledError(decision);
    }

    return decision;
}
