import { getAllPendingSurveys, deleteSurvey, getPendingCount } from './offline-db.js';

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('pending-surveys-tbody');
    const pendingCountCard = document.getElementById('pending-sync-count');
    const lastSyncedCard = document.getElementById('last-synced-time');
    const emptyStateRow = document.getElementById('empty-state-row');

    // ─── Format Date ────────────────────────────────────────────────────────
    function formatDate(isoString) {
        const date = new Date(isoString);
        const options = { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
        return date.toLocaleDateString('en-US', options);
    }

    function timeAgo(isoString) {
        const now = new Date();
        const past = new Date(isoString);
        const diffMs = now - past;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);

        if (diffMins < 1) return 'Just now';
        if (diffMins < 60) return `${diffMins}m ago`;
        if (diffHours < 24) return `${diffHours}h ago`;
        return `${diffDays}d ago`;
    }

    // ─── Build a Client Display Name ────────────────────────────────────────
    function getClientName(record) {
        const d = record.data || {};
        const first = d.firstName || '';
        const middle = d.middleName || '';
        const last = d.lastName || '';
        const suffix = d.suffix && d.suffix !== '--N/A--' ? ` ${d.suffix}` : '';

        const fullName = `${first} ${middle ? middle + ' ' : ''}${last}${suffix}`.trim();
        return fullName || 'Unnamed Client';
    }

    // ─── Get Survey Type Label ──────────────────────────────────────────────
    function getSurveyType(record) {
        const d = record.data || {};
        return d.msmeClassification || d.statusOfClient || 'MSME Survey';
    }

    // ─── Render a Single Row ────────────────────────────────────────────────
    function createRow(record) {
        const tr = document.createElement('tr');
        tr.setAttribute('data-record-id', record.id);
        tr.className = 'transition-all duration-300';

        tr.innerHTML = `
            <td class="px-lg py-md font-bold text-primary">${getClientName(record)}</td>
            <td class="px-lg py-md">${formatDate(record.timestamp)}</td>
            <td class="px-lg py-md">${getSurveyType(record)}</td>
            <td class="px-lg py-md">
                <span class="flex items-center gap-xs text-secondary-fixed-dim font-bold">
                    <span class="w-2 h-2 rounded-full bg-secondary"></span> Queued
                </span>
            </td>
            <td class="px-lg py-md text-right flex justify-end gap-sm">
                <button class="sync-single-btn text-primary hover:underline font-bold" data-id="${record.id}">Sync Now</button>
                <button class="delete-single-btn text-on-surface-variant hover:text-error" data-id="${record.id}" title="Delete">
                    <span class="material-symbols-outlined text-[20px]" data-icon="delete">delete</span>
                </button>
            </td>
        `;

        // Sync single record
        tr.querySelector('.sync-single-btn').addEventListener('click', async (e) => {
            e.preventDefault();
            const btn = e.currentTarget;
            const id = btn.dataset.id;

            if (!navigator.onLine) {
                showStatusToast('Cannot sync — you are offline.', 'error');
                return;
            }

            btn.textContent = 'Syncing…';
            btn.disabled = true;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch('/surveyor/merge', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(record.data),
                });

                if (!response.ok) throw new Error(`Server responded with ${response.status}`);

                await deleteSurvey(id);

                // Animate row removal
                tr.style.opacity = '0';
                tr.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    tr.remove();
                    refreshCounts();
                }, 300);

                showStatusToast('Survey synced successfully!', 'success');
            } catch (err) {
                console.error('Sync failed:', err);
                btn.textContent = 'Retry';
                btn.disabled = false;

                // Show failed status on this row
                const statusCell = tr.querySelector('td:nth-child(4) span');
                if (statusCell) {
                    statusCell.innerHTML = `
                        <span class="material-symbols-outlined text-[16px]" data-icon="error_outline">error_outline</span> Failed
                    `;
                    statusCell.className = 'flex items-center gap-xs text-error font-bold';
                }

                showStatusToast('Sync failed. Please try again.', 'error');
            }
        });

        // Delete single record
        tr.querySelector('.delete-single-btn').addEventListener('click', async (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;

            if (!confirm('Delete this unsaved survey? This cannot be undone.')) return;

            try {
                await deleteSurvey(id);
                tr.style.opacity = '0';
                tr.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    tr.remove();
                    refreshCounts();
                }, 300);
                showStatusToast('Record deleted.', 'info');
            } catch (err) {
                console.error('Delete failed:', err);
                showStatusToast('Failed to delete record.', 'error');
            }
        });

        return tr;
    }

    // ─── Show Empty State ───────────────────────────────────────────────────
    function showEmptyState() {
        if (!emptyStateRow) return;
        emptyStateRow.classList.remove('hidden');
    }

    function hideEmptyState() {
        if (!emptyStateRow) return;
        emptyStateRow.classList.add('hidden');
    }

    // ─── Simple Toast ───────────────────────────────────────────────────────
    function showStatusToast(message, type = 'info') {
        const existing = document.getElementById('surveyor-toast');
        if (existing) existing.remove();

        const colors = {
            success: 'bg-green-600',
            error: 'bg-red-600',
            info: 'bg-blue-600',
        };
        const icons = {
            success: 'check_circle',
            error: 'error',
            info: 'info',
        };

        const toast = document.createElement('div');
        toast.id = 'surveyor-toast';
        toast.className = `fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-white ${colors[type]} transform translate-y-4 opacity-0 transition-all duration-500 ease-out`;
        toast.innerHTML = `
            <span class="material-symbols-outlined">${icons[type]}</span>
            <span class="text-sm font-medium">${message}</span>
        `;

        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
        });

        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.remove(), 500);
        }, 3500);
    }

    // ─── Refresh Counts in Cards ────────────────────────────────────────────
    async function refreshCounts() {
        try {
            const count = await getPendingCount();
            if (pendingCountCard) pendingCountCard.textContent = count;

            // Update empty state
            const tbody = document.getElementById('pending-surveys-tbody');
            const dataRows = tbody?.querySelectorAll('tr:not(#empty-state-row)');
            if (!dataRows || dataRows.length === 0) {
                showEmptyState();
            } else {
                hideEmptyState();
            }
        } catch (err) {
            console.error('Error refreshing counts:', err);
        }
    }

    // ─── Load All Pending Surveys ───────────────────────────────────────────
    async function loadPendingSurveys() {
        try {
            const surveys = await getAllPendingSurveys();

            // Clear existing static rows (keep the empty state row)
            const existingRows = tableBody.querySelectorAll('tr:not(#empty-state-row)');
            existingRows.forEach(r => r.remove());

            if (surveys.length === 0) {
                showEmptyState();
                if (pendingCountCard) pendingCountCard.textContent = '0';
                if (lastSyncedCard) lastSyncedCard.textContent = '—';
                return;
            }

            hideEmptyState();

            // Sort by timestamp descending (newest first)
            surveys.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

            // Update card counts
            if (pendingCountCard) pendingCountCard.textContent = surveys.length;
            if (lastSyncedCard) lastSyncedCard.textContent = timeAgo(surveys[0].timestamp);

            // Render rows with staggered animation
            surveys.forEach((record, index) => {
                const row = createRow(record);
                row.style.opacity = '0';
                row.style.transform = 'translateY(8px)';
                tableBody.appendChild(row);

                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 50 * index);
            });
        } catch (err) {
            console.error('Error loading pending surveys:', err);
            if (pendingCountCard) pendingCountCard.textContent = '—';
        }
    }

    // ─── Sync All Button ────────────────────────────────────────────────────
    const syncAllBtn = document.getElementById('sync-all-btn');
    if (syncAllBtn) {
        syncAllBtn.addEventListener('click', async () => {
            if (!navigator.onLine) {
                showStatusToast('Cannot sync — you are offline.', 'error');
                return;
            }

            const surveys = await getAllPendingSurveys();
            if (surveys.length === 0) {
                showStatusToast('No pending surveys to sync.', 'info');
                return;
            }

            syncAllBtn.disabled = true;
            const originalContent = syncAllBtn.innerHTML;
            syncAllBtn.innerHTML = `<span class="material-symbols-outlined animate-spin">progress_activity</span> Syncing…`;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            let synced = 0;
            let failed = 0;

            for (const record of surveys) {
                try {
                    const response = await fetch('/surveyor/merge', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(record.data),
                    });
                    if (!response.ok) throw new Error(`Status ${response.status}`);
                    await deleteSurvey(record.id);
                    synced++;
                } catch (err) {
                    console.error(`Failed to sync ${record.id}:`, err);
                    failed++;
                }
            }

            syncAllBtn.disabled = false;
            syncAllBtn.innerHTML = originalContent;

            if (synced > 0) showStatusToast(`${synced} survey${synced > 1 ? 's' : ''} synced!`, 'success');
            if (failed > 0) showStatusToast(`${failed} survey${failed > 1 ? 's' : ''} failed. Will retry later.`, 'error');

            await loadPendingSurveys();
        });
    }

    // ─── Init ───────────────────────────────────────────────────────────────
    loadPendingSurveys();
});