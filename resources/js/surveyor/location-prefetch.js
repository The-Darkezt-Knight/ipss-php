/**
 * Location Data Pre-Fetcher
 *
 * This script runs on the Surveyor Dashboard page (right after login).
 * It downloads ALL location data (regions, provinces, cities, barangays)
 * in a single API call and stores it in IndexedDB so the form's cascading
 * dropdowns work fully offline.
 */

import { hasLocationCache, prefetchLocations } from './offline-db.js';

document.addEventListener('DOMContentLoaded', () => {
    if (!navigator.onLine) {
        console.log('[Location Prefetch] Offline — skipping prefetch.');
        return;
    }

    hasLocationCache()
        .then((cached) => {
            if (!cached) {
                console.log('[Location Prefetch] No cache found — downloading all locations...');
                return prefetchLocations().then((counts) => {
                    console.log('[Location Prefetch] ✓ Cached successfully:', counts);
                });
            } else {
                console.log('[Location Prefetch] ✓ Location data already cached.');
            }
        })
        .catch((err) => {
            console.error('[Location Prefetch] Failed:', err);
        });
});
