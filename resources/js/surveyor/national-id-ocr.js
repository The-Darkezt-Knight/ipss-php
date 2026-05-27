import { createWorker } from 'tesseract.js';

const OCR_OPTIONS = {
    workerPath: '/tesseract/worker.min.js',
    corePath: '/tesseract',
    langPath: '/tesseract/lang-data',
    gzip: true,
};

const FIELD_IDS = {
    first_name: 'firstName',
    middle_name: 'middleName',
    last_name: 'lastName',
    sex: 'sex',
    birth_date: 'birthdate',
};

let activeStream = null;

export async function startCamera(videoElement) {
    if (!navigator.mediaDevices?.getUserMedia) {
        throw new Error('Camera is not available in this browser.');
    }

    stopCamera(videoElement);

    activeStream = await navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: { ideal: 'environment' },
            width: { ideal: 1600 },
            height: { ideal: 1000 },
        },
        audio: false,
    });

    videoElement.srcObject = activeStream;
    await videoElement.play();
    return activeStream;
}

export function stopCamera(videoElement) {
    if (activeStream) {
        activeStream.getTracks().forEach(track => track.stop());
        activeStream = null;
    }

    if (videoElement) {
        videoElement.pause();
        videoElement.srcObject = null;
    }
}

export function captureImage(videoElement, canvasElement) {
    const width = videoElement.videoWidth;
    const height = videoElement.videoHeight;

    if (!width || !height) {
        throw new Error('Camera preview is not ready yet.');
    }

    canvasElement.width = width;
    canvasElement.height = height;
    const context = canvasElement.getContext('2d');
    context.drawImage(videoElement, 0, 0, width, height);

    return canvasToBlob(canvasElement, 'image/jpeg', 0.92);
}

export async function preprocessImage(imageBlob, canvasElement) {
    const bitmap = await createImageBitmap(imageBlob);
    const maxWidth = 1800;
    const scale = Math.min(1, maxWidth / bitmap.width);
    const width = Math.round(bitmap.width * scale);
    const height = Math.round(bitmap.height * scale);

    canvasElement.width = width;
    canvasElement.height = height;

    const context = canvasElement.getContext('2d', { willReadFrequently: true });
    context.drawImage(bitmap, 0, 0, width, height);

    const imageData = context.getImageData(0, 0, width, height);
    const pixels = imageData.data;
    const contrast = 1.35;
    const midpoint = 128;

    for (let index = 0; index < pixels.length; index += 4) {
        const gray = (pixels[index] * 0.299) + (pixels[index + 1] * 0.587) + (pixels[index + 2] * 0.114);
        const adjusted = clamp(((gray - midpoint) * contrast) + midpoint);
        pixels[index] = adjusted;
        pixels[index + 1] = adjusted;
        pixels[index + 2] = adjusted;
    }

    context.putImageData(imageData, 0, 0);
    bitmap.close?.();

    return canvasToBlob(canvasElement, 'image/png');
}

export async function runOcr(imageBlob, onProgress = () => {}) {
    const worker = await createWorker('eng', 1, {
        ...OCR_OPTIONS,
        logger: message => {
            if (message.status) {
                onProgress(message);
            }
        },
    });

    try {
        await worker.setParameters({
            tessedit_char_whitelist: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.,-/ ',
            preserve_interword_spaces: '1',
        });

        const result = await worker.recognize(imageBlob);
        return {
            text: result.data.text || '',
            confidence: Number(result.data.confidence || 0),
        };
    } catch (error) {
        const message = String(error?.message || error);
        if (message.includes('eng.traineddata') || message.includes('Failed to fetch')) {
            throw new Error('OCR assets are missing or not cached. Reconnect once, reload the app, then try scanning again.');
        }
        throw error;
    } finally {
        await worker.terminate();
    }
}

export function parsePhilippineNationalIdText(rawText) {
    const text = normalizeOcrText(rawText);
    const lines = text.split('\n').map(line => line.trim()).filter(Boolean);

    const extracted = {
        first_name: '',
        middle_name: '',
        last_name: '',
        sex: '',
        birth_date: '',
        raw_text: rawText || '',
    };

    extracted.last_name = findLabelValue(lines, [
        /last\s*name/i,
        /apelyido/i,
    ]);

    const givenNames = findLabelValue(lines, [
        /given\s*names?/i,
        /first\s*name/i,
        /mga\s*pangalan/i,
    ]);

    extracted.middle_name = findLabelValue(lines, [
        /middle\s*name/i,
        /gitnang\s*pangalan/i,
    ]);

    if (givenNames) {
        extracted.first_name = givenNames;
    }

    extracted.sex = normalizeSex(findLabelValue(lines, [
        /^sex$/i,
        /kasarian/i,
    ]) || findInlineSex(text));

    extracted.birth_date = normalizeDate(findLabelValue(lines, [
        /date\s*of\s*birth/i,
        /petsa\s*ng\s*kapanganakan/i,
        /birth\s*date/i,
    ]) || findInlineDate(text));

    Object.keys(extracted).forEach(key => {
        if (key !== 'raw_text') {
            extracted[key] = cleanField(extracted[key]);
        }
    });

    return extracted;
}

export function fillSurveyFormFields(fields, root = document) {
    Object.entries(FIELD_IDS).forEach(([key, id]) => {
        const value = fields[key];
        const element = root.getElementById ? root.getElementById(id) : document.getElementById(id);

        if (!element || !value) return;

        if (element.tagName === 'SELECT') {
            const matchingOption = Array.from(element.options).find(option => (
                option.value.toLowerCase() === value.toLowerCase()
                || option.textContent.trim().toLowerCase() === value.toLowerCase()
            ));
            if (matchingOption) {
                element.value = matchingOption.value;
            }
        } else {
            element.value = value;
        }

        element.dispatchEvent(new Event('input', { bubbles: true }));
        element.dispatchEvent(new Event('change', { bubbles: true }));
    });
}

function findLabelValue(lines, labelPatterns) {
    for (let index = 0; index < lines.length; index += 1) {
        const line = lines[index];
        const pattern = labelPatterns.find(candidate => candidate.test(line));
        if (!pattern) continue;

        const inline = line
            .replace(pattern, '')
            .replace(/^[\s:.\-/]+/, '')
            .trim();

        if (isUsableValue(inline)) {
            return inline;
        }

        for (let offset = 1; offset <= 2; offset += 1) {
            const nextLine = lines[index + offset];
            if (isUsableValue(nextLine) && !looksLikeLabel(nextLine)) {
                return nextLine;
            }
        }
    }

    return '';
}

function findInlineSex(text) {
    const match = text.match(/\b(?:sex|kasarian)\s*[:\-]?\s*(male|female|m|f)\b/i);
    return match?.[1] || '';
}

function findInlineDate(text) {
    const match = text.match(/\b(\d{1,2}[\/\-.]\d{1,2}[\/\-.]\d{2,4}|[A-Z][a-z]{2,8}\s+\d{1,2},?\s+\d{4})\b/);
    return match?.[1] || '';
}

function normalizeOcrText(rawText) {
    return String(rawText || '')
        .replace(/\r/g, '\n')
        .replace(/[|_]+/g, ' ')
        .replace(/[ \t]+/g, ' ')
        .replace(/\n{2,}/g, '\n')
        .trim();
}

function normalizeSex(value) {
    const normalized = String(value || '').trim().toLowerCase();
    if (/^(m|male)\b/.test(normalized)) return 'Male';
    if (/^(f|female)\b/.test(normalized)) return 'Female';
    return '';
}

function normalizeDate(value) {
    const text = String(value || '').trim();
    if (!text) return '';

    const numeric = text.match(/(\d{1,2})[\/\-.](\d{1,2})[\/\-.](\d{2,4})/);
    if (numeric) {
        const month = numeric[1].padStart(2, '0');
        const day = numeric[2].padStart(2, '0');
        const year = numeric[3].length === 2 ? `19${numeric[3]}` : numeric[3];
        return `${year}-${month}-${day}`;
    }

    const parsed = Date.parse(text.replace(/,/g, ''));
    if (!Number.isNaN(parsed)) {
        return new Date(parsed).toISOString().slice(0, 10);
    }

    return '';
}

function cleanField(value) {
    return String(value || '')
        .replace(/[^A-Za-z0-9\s.\-/]/g, '')
        .replace(/\s{2,}/g, ' ')
        .trim();
}

function looksLikeLabel(value) {
    return /last\s*name|given\s*names?|middle\s*name|date\s*of\s*birth|petsa|sex|kasarian/i.test(value);
}

function isUsableValue(value) {
    return Boolean(value && cleanField(value).length >= 1);
}

function clamp(value) {
    return Math.max(0, Math.min(255, value));
}

function canvasToBlob(canvas, type, quality) {
    return new Promise((resolve, reject) => {
        canvas.toBlob((blob) => {
            if (blob) {
                resolve(blob);
            } else {
                reject(new Error('Unable to create image blob from canvas.'));
            }
        }, type, quality);
    });
}
