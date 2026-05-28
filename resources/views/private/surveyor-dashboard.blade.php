<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>Surveyor's Dashboard</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
            rel="stylesheet"
        />
        <link
            href="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.css"
            rel="stylesheet"
        />
        <link
            href="{{ asset('css/maplibre-map.css') }}"
            rel="stylesheet"
        />
        <style>
            .material-symbols-outlined {
                font-variation-settings:
                    "FILL" 0,
                    "wght" 400,
                    "GRAD" 0,
                    "opsz" 24;
            }
            /* Custom scrollbar for institutional look */
            ::-webkit-scrollbar {
                width: 6px;
            }
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            ::-webkit-scrollbar-thumb {
                background: #c3c6d1;
                border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #737780;
            }

            .glass-card {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(8px);
            }
        </style>
        <script id="tailwind-config">
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "inverse-on-surface": "#f0f0f3",
                            "tertiary-fixed": "#dde3e7",
                            "surface-container-highest": "#e2e2e5",
                            "surface-dim": "#dadadc",
                            "secondary-container": "#cbe2fc",
                            primary: "#001e40",
                            "surface-tint": "#3a5f94",
                            "secondary-fixed-dim": "#b2c9e2",
                            tertiary: "#191f22",
                            "on-error-container": "#93000a",
                            "on-background": "#1a1c1e",
                            "inverse-primary": "#a7c8ff",
                            "on-tertiary-fixed-variant": "#41484b",
                            "on-primary-container": "#799dd6",
                            background: "#f9f9fc",
                            "surface-container-low": "#f3f3f6",
                            "on-tertiary": "#ffffff",
                            "inverse-surface": "#2f3133",
                            "surface-variant": "#e2e2e5",
                            "on-primary": "#ffffff",
                            "tertiary-fixed-dim": "#c1c7cb",
                            "on-secondary-fixed": "#041d30",
                            "surface-container-high": "#e8e8ea",
                            "surface-container-lowest": "#ffffff",
                            "on-error": "#ffffff",
                            "error-container": "#ffdad6",
                            "on-primary-fixed-variant": "#1f477b",
                            "on-secondary-container": "#4f657b",
                            outline: "#737780",
                            "surface-container": "#eeeef0",
                            secondary: "#4a6077",
                            "on-tertiary-fixed": "#161c1f",
                            "on-primary-fixed": "#001b3c",
                            "surface-bright": "#f9f9fc",
                            "secondary-fixed": "#cee5ff",
                            error: "#ba1a1a",
                            "primary-container": "#003366",
                            "on-secondary-fixed-variant": "#33495e",
                            "on-secondary": "#ffffff",
                            "primary-fixed": "#d5e3ff",
                            "outline-variant": "#c3c6d1",
                            "on-tertiary-container": "#969ca0",
                            surface: "#f9f9fc",
                            "primary-fixed-dim": "#a7c8ff",
                            "on-surface-variant": "#43474f",
                            "on-surface": "#1a1c1e",
                            "tertiary-container": "#2e3437",
                        },
                        borderRadius: {
                            DEFAULT: "0.125rem",
                            lg: "0.25rem",
                            xl: "0.5rem",
                            full: "0.75rem",
                        },
                        spacing: {
                            "margin-mobile": "16px",
                            md: "16px",
                            lg: "24px",
                            xl: "32px",
                            gutter: "24px",
                            xs: "4px",
                            unit: "4px",
                            xxl: "48px",
                            sm: "8px",
                            "container-max": "1280px",
                        },
                        fontFamily: {
                            "label-lg": ["Public Sans"],
                            "body-lg": ["Public Sans"],
                            "body-md": ["Public Sans"],
                            "display-lg": ["Public Sans"],
                            "body-sm": ["Public Sans"],
                            "headline-sm": ["Public Sans"],
                            "headline-md": ["Public Sans"],
                            "headline-lg": ["Public Sans"],
                            "label-md": ["Public Sans"],
                            "headline-lg-mobile": ["Public Sans"],
                        },
                        fontSize: {
                            "label-lg": [
                                "14px",
                                {
                                    lineHeight: "20px",
                                    letterSpacing: "0.01em",
                                    fontWeight: "600",
                                },
                            ],
                            "body-lg": [
                                "18px",
                                { lineHeight: "28px", fontWeight: "400" },
                            ],
                            "body-md": [
                                "16px",
                                { lineHeight: "24px", fontWeight: "400" },
                            ],
                            "display-lg": [
                                "48px",
                                {
                                    lineHeight: "56px",
                                    letterSpacing: "-0.02em",
                                    fontWeight: "700",
                                },
                            ],
                            "body-sm": [
                                "14px",
                                { lineHeight: "20px", fontWeight: "400" },
                            ],
                            "headline-sm": [
                                "20px",
                                { lineHeight: "28px", fontWeight: "600" },
                            ],
                            "headline-md": [
                                "24px",
                                { lineHeight: "32px", fontWeight: "600" },
                            ],
                            "headline-lg": [
                                "32px",
                                { lineHeight: "40px", fontWeight: "700" },
                            ],
                            "label-md": [
                                "12px",
                                {
                                    lineHeight: "16px",
                                    letterSpacing: "0.02em",
                                    fontWeight: "600",
                                },
                            ],
                            "headline-lg-mobile": [
                                "24px",
                                { lineHeight: "32px", fontWeight: "700" },
                            ],
                        },
                    },
                },
            };
        </script>
    </head>
    <body class="bg-background text-on-surface font-body-md overflow-hidden">
        <!-- TopAppBar -->
        <header
            class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-md h-16 bg-surface dark:bg-on-surface border-b border-outline-variant dark:border-outline"
        >
            <div
                class="text-headline-sm font-headline-sm font-bold text-primary dark:text-primary-fixed-dim"
            >
                Surveyor's Dashboard
            </div>
            <div class="flex items-center gap-lg">
                <div class="flex items-center gap-sm">
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="inline"
                    >
                        @csrf
                        <button
                            type="submit"
                            class="ml-md text-label-md font-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors px-sm py-xs"
                        >
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </header>
        <div class="flex pt-16 h-screen">
            <!-- SideNavBar -->
            <aside
                class="fixed left-0 top-16 h-[calc(100vh-64px)] w-64 z-40 flex flex-col p-md bg-surface-container-low dark:bg-tertiary-container border-r border-outline-variant dark:border-outline hidden md:flex"
            >
                <div class="flex items-center gap-md mb-xl">
                    <div
                        class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center overflow-hidden"
                    >
                        <!--<img alt="Surveyor Profile" class="w-full h-full object-cover" src=''/>-->
                    </div>
                    <div>
                        <p
                            id="surveyor-name"
                            class="text-label-lg font-label-lg text-primary"
                        >
                            {{ $employee->first_name }} {{ $employee->last_name
                            }}
                        </p>
                        <p
                            id="surveyor-id"
                            class="text-body-sm font-body-sm text-on-surface-variant"
                        >
                            ID: #{{ $employee->govt_id }}
                        </p>
                    </div>
                </div>

                <nav class="flex-1 flex flex-col gap-xs">
                    <a
                        class="flex items-center gap-md p-md bg-secondary-container text-on-secondary-container rounded-lg font-bold transition-transform duration-100 scale-[0.98]"
                        href="{{ route('private.surveyor-dashboard') }}"
                    >
                        <span
                            class="material-symbols-outlined"
                            data-icon="dashboard"
                            >dashboard</span
                        >
                        <span class="text-label-lg font-label-lg"
                            >Dashboard</span
                        >
                    </a>

                    <a
                        class="flex items-center gap-md p-md text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-all group"
                        href="{{ route('private.surveyor') }}"
                    >
                        <span
                            class="material-symbols-outlined"
                            data-icon="sync_alt"
                            >sync_alt</span
                        >
                        <span class="text-label-lg font-label-lg"
                            >Sync History</span
                        >
                    </a>
                </nav>

                <a id="add-new-survey-link" href="{{route('private.form')}}" target="_blank">
                    <button
                        id="add-new-survey-button"
                        class="mt-auto w-full py-md bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-sm hover:opacity-90 transition-opacity"
                    >
                        <span class="material-symbols-outlined" data-icon="add"
                            >add</span
                        >
                    </button>
                </a>
            </aside>

            <!-- Main Content Area -->
            <main class="ml-64 flex-1 overflow-y-auto p-lg">
                <!-- Jurisdiction Badge -->
                <section
                    class="bg-primary-fixed/10 border border-primary-fixed-dim/30 rounded-xl p-lg mb-lg shadow-sm"
                    data-district-code="{{ $employee->district_code ?? '' }}"
                >
                    <div class="flex items-center gap-sm mb-md">
                        <span class="material-symbols-outlined text-primary">shield_person</span>
                        <span class="text-label-lg font-label-lg text-primary">Assigned Jurisdiction</span>
                    </div>
                    <div class="grid grid-cols-3 gap-lg mb-lg">
                        <div>
                            <p class="text-label-md font-label-md text-on-surface-variant">Region</p>
                            <p class="text-body-md font-semibold text-on-surface">{{ $employee->region ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-label-md font-label-md text-on-surface-variant">Province</p>
                            <p class="text-body-md font-semibold text-on-surface">{{ $employee->province ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-label-md font-label-md text-on-surface-variant">District</p>
                            <p class="text-body-md font-semibold text-on-surface">{{ $employee->district ?? '—' }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-end gap-lg">
                        <div class="flex-1 min-w-[200px]">
                            <label
                                class="block text-label-md font-label-md text-on-surface-variant mb-xs"
                                >City / Municipality</label
                            >
                            <select
                                id="geo-city"
                                class="w-full border border-outline rounded-lg p-md text-body-sm bg-white focus:ring-primary focus:border-primary"
                            >
                                <option value="">Loading cities…</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label
                                class="block text-label-md font-label-md text-on-surface-variant mb-xs"
                                >Barangay</label
                            >
                            <select
                                id="geo-barangay"
                                class="w-full border border-outline rounded-lg p-md text-body-sm bg-white focus:ring-primary focus:border-primary"
                                disabled
                            >
                                <option value="">Select Barangay</option>
                            </select>
                        </div>
                    </div>
                </section>
                <!-- Header Section -->
                <div class="mb-xl flex justify-between items-end">
                    <div>
                        <h1
                            id="dashboard-heading"
                            class="text-headline-lg font-headline-lg text-primary"
                        >
                            Surveyed Clients
                        </h1>
                    </div>
                </div>
                <!-- Summary Metrics (Institutional Style Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-lg mb-xl">
                    <div
                        class="bg-surface-container-low p-lg border border-outline-variant rounded-lg"
                    >
                        <div class="flex items-center justify-between mb-sm">
                            <span
                                class="material-symbols-outlined text-primary bg-secondary-fixed p-sm rounded-full"
                                >store</span
                            >
                        </div>
                        <p
                            class="text-body-sm font-body-sm text-on-surface-variant uppercase tracking-wider"
                        >
                            Total Registered
                        </p>
                        <h3
                            id="total-count"
                            class="text-headline-md font-headline-md text-primary mt-xs"
                        >
                            —
                        </h3>
                    </div>
                    <!--
                    <div
                        class="bg-surface-container-low p-lg border border-outline-variant rounded-lg"
                    >
                        <div class="flex items-center justify-between mb-sm">
                            <span
                                class="material-symbols-outlined text-error bg-error-container p-sm rounded-full"
                                >history_edu</span
                            >
                            <span class="text-label-md font-label-md text-error"
                                >Urgent</span
                            >
                        </div>
                        <p
                            class="text-body-sm font-body-sm text-on-surface-variant uppercase tracking-wider"
                        >
                            Pending Renewals
                        </p>
                        <h3
                            class="text-headline-md font-headline-md text-primary mt-xs"
                        >
                            56
                        </h3>
                    </div>
                    -->
                </div>
                <!-- All Clients Map -->
                <section class="bg-surface border border-outline-variant rounded-lg overflow-hidden mb-lg shadow-sm">
                    <div class="px-lg py-md border-b border-outline-variant bg-surface-container-low flex items-center justify-between">
                        <div>
                            <h2 class="text-headline-sm font-headline-sm text-primary">All Assigned Clients Map</h2>
                            <p class="text-body-sm text-on-surface-variant">Pins show clients with saved latitude and longitude.</p>
                        </div>
                        <span class="material-symbols-outlined text-primary">map</span>
                    </div>
                    <div class="relative">
                        <div id="surveyor-clients-map" class="h-[420px] w-full overflow-hidden"></div>
                        <div class="absolute bottom-md left-md bg-white/90 backdrop-blur-sm p-md rounded-lg border border-outline-variant/15 space-y-xs">
                            <p class="font-label-md text-label-md text-on-surface mb-xs">Status Legend</p>
                            <div class="flex items-center gap-sm">
                                <div class="h-3 w-3 rounded-full bg-[#D97706]"></div>
                                <span class="text-[10px] text-on-surface-variant">Pending</span>
                            </div>
                            <div class="flex items-center gap-sm">
                                <div class="h-3 w-3 rounded-full bg-[#001E40]"></div>
                                <span class="text-[10px] text-on-surface-variant">Returned</span>
                            </div>
                            <div class="flex items-center gap-sm">
                                <div class="h-3 w-3 rounded-full bg-[#84cc16]"></div>
                                <span class="text-[10px] text-on-surface-variant">Verified</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Filter and Search Bar -->
                <section
                    class="bg-surface border border-outline-variant rounded-lg p-lg mb-lg shadow-sm"
                >
                    <div class="flex flex-wrap items-end gap-lg">
                        <div class="flex-1 min-w-[300px]">
                            <label
                                class="block text-label-md font-label-md text-on-surface-variant mb-xs"
                                >Search Context</label
                            >
                            <div
                                class="flex items-center border border-outline rounded-lg px-md bg-white focus-within:border-primary focus-within:ring-1 focus-within:ring-primary"
                            >
                                <span
                                    class="material-symbols-outlined text-on-surface-variant"
                                    >search</span
                                >
                                <input
                                    class="w-full py-md px-sm border-none focus:ring-0 text-body-md"
                                    placeholder="Search by name, owner or business ID..."
                                    type="text"
                                />
                            </div>
                        </div>
                        <div class="w-48">
                            <label
                                class="block text-label-md font-label-md text-on-surface-variant mb-xs"
                                >Category</label
                            >
                            <select
                                class="w-full border border-outline rounded-lg p-md text-body-sm bg-white focus:ring-primary focus:border-primary"
                            >
                                <option>All Categories</option>
                                <option>Agriculture</option>
                                <option>Retail</option>
                                <option>Service</option>
                                <option>Manufacturing</option>
                            </select>
                        </div>
                        <div class="w-48">
                            <label
                                class="block text-label-md font-label-md text-on-surface-variant mb-xs"
                                >MSME Level</label
                            >
                            <select
                                class="w-full border border-outline rounded-lg p-md text-body-sm bg-white focus:ring-primary focus:border-primary"
                            >
                                <option>All Levels</option>
                                <option>Micro</option>
                                <option>Small</option>
                                <option>Medium</option>
                                <option>Large</option>
                            </select>
                        </div>
                        <div class="w-48">
                            <label
                                class="block text-label-md font-label-md text-on-surface-variant mb-xs"
                                >Status</label
                            >
                            <select
                                class="w-full border border-outline rounded-lg p-md text-body-sm bg-white focus:ring-primary focus:border-primary"
                            >
                                <option>All Statuses</option>
                                <option>Active</option>
                                <option>Inactive</option>
                                <option>Pending</option>
                            </select>
                        </div>
                    </div>
                </section>
                <!-- Data Table (Institutional with Zebra Striping) -->
                <div
                    class="bg-surface border border-outline-variant rounded-lg overflow-hidden"
                >
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-surface-container-low text-label-md font-label-md text-on-surface-variant border-b border-outline-variant"
                                >
                                    <th class="px-lg py-md">Client Name</th>
                                    <th class="px-lg py-md">Client ID</th>
                                    <th class="px-lg py-md">Category</th>
                                    <th class="px-lg py-md">MSME Level</th>
                                    <th class="px-lg py-md">Reg. Date</th>
                                    <th class="px-lg py-md">Status</th>
                                    <th class="px-lg py-md text-right">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="clients-tbody" class="divide-y divide-outline-variant">
                                <!-- Empty state -->
                                <tr id="empty-state-row">
                                    <td colspan="7" class="px-lg py-xxl text-center">
                                        <div class="flex flex-col items-center gap-md text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[48px] text-outline">location_on</span>
                                            <p class="text-body-md font-bold">Select a location</p>
                                            <p class="text-body-sm">Choose a Region, Province, City, and Barangay above to load registered clients.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Entry Count -->
                    <div
                        class="px-lg py-md bg-surface-container-lowest flex items-center justify-between border-t border-outline-variant"
                    >
                        <span id="table-entry-count" class="text-body-sm text-on-surface-variant"
                            ></span
                        >
                    </div>
                </div>
                <!-- Footer -->
                <footer
                    class="w-full py-lg px-xl flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto mt-xxl border-t border-outline-variant bg-surface-container-lowest"
                >
                    <p
                        class="text-body-sm font-body-sm text-on-surface-variant mb-md md:mb-0"
                    >
                        © 2026 Department of Trade and Industry. All data is
                        encrypted and official.
                    </p>
                    <div class="flex gap-lg">
                        <a
                            class="text-label-md font-label-md text-on-surface-variant hover:text-primary transition-colors"
                            href="#"
                            >Privacy Policy</a
                        >
                        <a
                            class="text-label-md font-label-md text-on-surface-variant hover:text-primary transition-colors"
                            href="#"
                            >Terms of Service</a
                        >
                        <a
                            class="text-label-md font-label-md text-on-surface-variant hover:text-primary transition-colors"
                            href="#"
                            >Help Desk</a
                        >
                    </div>
                </footer>
            </main>
        </div>
        <!-- Background Pattern Decorative Element -->
        <div
            class="fixed inset-0 pointer-events-none z-[-1] opacity-[0.03]"
            style="
                background-image: radial-gradient(#001e40 1px, transparent 1px);
                background-size: 40px 40px;
            "
        ></div>
        <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
        <script>
            const surveyorClientMapPoints = @json($clientMapPoints ?? []);

            document.addEventListener('DOMContentLoaded', function () {
                const citySelect = document.getElementById('geo-city');
                const barangaySelect = document.getElementById('geo-barangay');
                const tbody = document.getElementById('clients-tbody');
                const heading = document.getElementById('dashboard-heading');
                const totalCount = document.getElementById('total-count');
                const entryCount = document.getElementById('table-entry-count');
                const addLink = document.getElementById('add-new-survey-link');
                const baseFormUrl = addLink ? addLink.getAttribute('href') : '';
                const dashboardMapEl = document.getElementById('surveyor-clients-map');

                // Read district code from the jurisdiction section's data attribute
                const jurisdictionSection = document.querySelector('[data-district-code]');
                const districtCode = jurisdictionSection ? jurisdictionSection.dataset.districtCode : '';

                function escapeHtml(value) {
                    return String(value ?? '').replace(/[&<>"']/g, character => ({
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;',
                    }[character]));
                }

                function initializeDashboardMap() {
                    if (!dashboardMapEl || typeof maplibregl === 'undefined') return;

                    // Negros Island bounding box: [west, south, east, north]
                    const negrosBounds = [122.25, 9.0, 123.55, 11.1];
                    // Pad bounds by ~8 % so the map doesn't feel cramped at the edges
                    const lngPad = (negrosBounds[2] - negrosBounds[0]) * 0.08;
                    const latPad = (negrosBounds[3] - negrosBounds[1]) * 0.08;
                    const paddedBounds = [
                        [negrosBounds[0] - lngPad, negrosBounds[1] - latPad],
                        [negrosBounds[2] + lngPad, negrosBounds[3] + latPad],
                    ];

                    const map = new maplibregl.Map({
                        container: dashboardMapEl,
                        style: 'https://basemaps.cartocdn.com/gl/voyager-gl-style/style.json',
                        center: [122.9509, 10.6765],
                        zoom: 9,
                        minZoom: 8,
                        maxZoom: 19,
                        maxBounds: paddedBounds,
                        attributionControl: true,
                    });
                    map.addControl(new maplibregl.NavigationControl(), 'top-right');

                    // Build GeoJSON from server-provided points
                    const geojson = {
                        type: 'FeatureCollection',
                        features: surveyorClientMapPoints
                            .filter(c => Number.isFinite(c.latitude) && Number.isFinite(c.longitude))
                            .map(c => ({
                                type: 'Feature',
                                geometry: { type: 'Point', coordinates: [c.longitude, c.latitude] },
                                properties: {
                                    name: c.name || '',
                                    client_id: c.client_id || '',
                                    survey_status: c.survey_status || 'pending',
                                    url: c.url || '',
                                },
                            })),
                    };

                    map.on('load', () => {
                        // ── Clustered GeoJSON source ──
                        map.addSource('clients', {
                            type: 'geojson',
                            data: geojson,
                            cluster: true,
                            clusterMaxZoom: 14,
                            clusterRadius: 50,
                        });

                        // ── Cluster circles ──
                        map.addLayer({
                            id: 'clusters',
                            type: 'circle',
                            source: 'clients',
                            filter: ['has', 'point_count'],
                            paint: {
                                'circle-color': [
                                    'step', ['get', 'point_count'],
                                    '#3a5f94',   // < 20
                                    20, '#1f477b', // 20-99
                                    100, '#001e40', // ≥ 100
                                ],
                                'circle-radius': [
                                    'step', ['get', 'point_count'],
                                    18,          // < 20
                                    20, 24,      // 20-99
                                    100, 32,     // ≥ 100
                                ],
                                'circle-stroke-width': 3,
                                'circle-stroke-color': 'rgba(255,255,255,0.85)',
                            },
                        });

                        // ── Cluster count labels ──
                        map.addLayer({
                            id: 'cluster-count',
                            type: 'symbol',
                            source: 'clients',
                            filter: ['has', 'point_count'],
                            layout: {
                                'text-field': '{point_count_abbreviated}',
                                'text-size': 13,
                                'text-font': ['Open Sans Bold'],
                            },
                            paint: {
                                'text-color': '#ffffff',
                            },
                        });

                        // ── Individual point halo ──
                        map.addLayer({
                            id: 'unclustered-point-halo',
                            type: 'circle',
                            source: 'clients',
                            filter: ['!', ['has', 'point_count']],
                            paint: {
                                'circle-color': [
                                    'case',
                                    ['==', ['get', 'survey_status'], 'verified'], '#d9f99d',
                                    ['==', ['get', 'survey_status'], 'returned'], '#bfdbfe',
                                    '#FEF3C7',
                                ],
                                'circle-radius': 14,
                                'circle-opacity': 0.5,
                            },
                        });

                        // ── Individual point markers (status-coloured) ──
                        map.addLayer({
                            id: 'unclustered-point',
                            type: 'circle',
                            source: 'clients',
                            filter: ['!', ['has', 'point_count']],
                            paint: {
                                'circle-color': [
                                    'case',
                                    ['==', ['get', 'survey_status'], 'verified'], '#84cc16',
                                    ['==', ['get', 'survey_status'], 'returned'], '#001E40',
                                    '#D97706',
                                ],
                                'circle-radius': 7,
                                'circle-stroke-width': 2,
                                'circle-stroke-color': '#ffffff',
                            },
                        });

                        // ── Click cluster → zoom in ──
                        map.on('click', 'clusters', async (e) => {
                            const features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
                            const clusterId = features[0].properties.cluster_id;
                            const zoom = await map.getSource('clients').getClusterExpansionZoom(clusterId);
                            map.easeTo({ center: features[0].geometry.coordinates, zoom });
                        });

                        // ── Click single point → popup ──
                        map.on('click', 'unclustered-point', (e) => {
                            const coords = e.features[0].geometry.coordinates.slice();
                            const props = e.features[0].properties;
                            const statusLabel = {
                                verified: '<span style="color:#84cc16;font-weight:700">● Verified</span>',
                                returned: '<span style="color:#001E40;font-weight:700">● Returned</span>',
                                pending: '<span style="color:#D97706;font-weight:700">● Pending</span>',
                            }[props.survey_status] || '<span style="color:#D97706;font-weight:700">● Pending</span>';

                            new maplibregl.Popup({ offset: 12 })
                                .setLngLat(coords)
                                .setHTML(`
                                    <strong>${escapeHtml(props.name)}</strong>
                                    <span>${escapeHtml(props.client_id || 'No client ID')}</span><br>
                                    ${statusLabel}
                                `)
                                .addTo(map);
                        });

                        // ── Pointer cursors ──
                        map.on('mouseenter', 'clusters', () => { map.getCanvas().style.cursor = 'pointer'; });
                        map.on('mouseleave', 'clusters', () => { map.getCanvas().style.cursor = ''; });
                        map.on('mouseenter', 'unclustered-point', () => { map.getCanvas().style.cursor = 'pointer'; });
                        map.on('mouseleave', 'unclustered-point', () => { map.getCanvas().style.cursor = ''; });

                        // ── Fit bounds to data ──
                        if (geojson.features.length > 0) {
                            const bounds = new maplibregl.LngLatBounds();
                            geojson.features.forEach(f => bounds.extend(f.geometry.coordinates));
                            map.fitBounds(bounds, { padding: 48, maxZoom: 16 });
                        }
                    });
                }

                initializeDashboardMap();

                // ── Helpers ──────────────────────────────────────────────
                function resetSelect(select, defaultText) {
                    select.innerHTML = `<option value="">${defaultText}</option>`;
                    select.disabled = true;
                }

                function populateSelect(select, data, defaultText) {
                    select.innerHTML = `<option value="">${defaultText}</option>`;
                    select.disabled = false;
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.code;
                        opt.textContent = item.name;
                        select.appendChild(opt);
                    });
                }

                function showLoading() {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="px-lg py-xxl text-center">
                                <div class="flex flex-col items-center gap-md text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[36px] text-primary animate-spin">progress_activity</span>
                                    <p class="text-body-md">Loading clients...</p>
                                </div>
                            </td>
                        </tr>`;
                }

                function showEmpty(msg) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="px-lg py-xxl text-center">
                                <div class="flex flex-col items-center gap-md text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[48px] text-outline">folder_open</span>
                                    <p class="text-body-md font-bold">No clients found</p>
                                    <p class="text-body-sm">${msg}</p>
                                </div>
                            </td>
                        </tr>`;
                }

                function showInitial() {
                    tbody.innerHTML = `
                        <tr id="empty-state-row">
                            <td colspan="7" class="px-lg py-xxl text-center">
                                <div class="flex flex-col items-center gap-md text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[48px] text-outline">location_on</span>
                                    <p class="text-body-md font-bold">Select a location</p>
                                    <p class="text-body-sm">Choose a City and Barangay above to load registered clients.</p>
                                </div>
                            </td>
                        </tr>`;
                }

                // Extracts short MSME level label from full classification string
                function msmeShort(val) {
                    if (!val) return '—';
                    const match = val.match(/^(\w+)/); // first word: Micro, Small, Medium, Large, Not
                    if (match) {
                        if (match[1] === 'Not') return 'N/A';
                        return match[1];
                    }
                    return val;
                }

                function formatDate(dateStr) {
                    if (!dateStr) return '—';
                    const d = new Date(dateStr);
                    return d.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
                }

                function buildFullName(c) {
                    let name = '';
                    if (c.first_name) name += c.first_name;
                    if (c.middle_name) name += ' ' + c.middle_name;
                    if (c.last_name) name += ' ' + c.last_name;
                    if (c.suffix && c.suffix !== '--N/A--') name += ' ' + c.suffix;
                    return name.trim() || '—';
                }

                // ── Update "Add New" link with geo params ────────────
                function updateAddLink() {
                    if (!addLink) return;
                    const params = new URLSearchParams();
                    if (citySelect.value) params.set('cityMunicipalityCode', citySelect.value);
                    if (barangaySelect.value) params.set('baranggayCode', barangaySelect.value);
                    const qs = params.toString();
                    addLink.href = qs ? baseFormUrl + '?' + qs : baseFormUrl;
                }

                // ── Load Clients by Barangay ─────────────────────────
                async function loadClients(barangayCode) {
                    showLoading();
                    try {
                        const res = await fetch(`/api/clients?barangay_code=${barangayCode}`);
                        const clients = await res.json();

                        // Update heading
                        const brgyName = barangaySelect.options[barangaySelect.selectedIndex]?.text || '';
                        heading.textContent = `Registered Clients — ${brgyName}`;
                        totalCount.textContent = clients.length.toLocaleString();
                        entryCount.textContent = `Showing ${clients.length} entries`;

                        if (clients.length === 0) {
                            showEmpty('No registered clients in this barangay yet. Use the + button to add one.');
                            return;
                        }

                        tbody.innerHTML = '';
                        clients.forEach((c, i) => {
                            const zebraClass = i % 2 === 1 ? 'bg-tertiary-container/5' : '';
                            const tr = document.createElement('tr');
                            tr.className = `${zebraClass} hover:bg-surface-container transition-colors group`;
                            tr.innerHTML = `
                                <td class="px-lg py-lg">
                                    <div class="flex flex-col">
                                        <span class="text-body-md font-semibold text-primary">${buildFullName(c)}</span>
                                    </div>
                                </td>
                                <td class="px-lg py-lg text-body-sm">
                                    ${c.client_id || '—'}
                                </td>
                                <td class="px-lg py-lg">
                                    <span class="px-md py-xs bg-tertiary-fixed text-on-tertiary-fixed rounded-full text-label-md">${c.category_of_client || '—'}</span>
                                </td>
                                <td class="px-lg py-lg text-body-sm">
                                    ${msmeShort(c.msme_classification)}
                                </td>
                                <td class="px-lg py-lg text-body-sm">
                                    ${formatDate(c.created_at)}
                                </td>
                                <td class="px-lg py-lg">
                                    <span class="flex items-center gap-xs text-on-surface text-label-md">
                                        <span class="h-2 w-2 rounded-full bg-green-600"></span>
                                        ${c.status_of_client || 'Registered'}
                                    </span>
                                </td>
                                <td class="px-lg py-lg text-right">
                                    <div class="flex justify-end gap-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="${c.show_url}" class="px-md py-xs text-primary border border-primary rounded text-label-md font-bold hover:bg-primary hover:text-on-primary transition-all">View</a>
                                    </div>
                                </td>`;
                            tbody.appendChild(tr);
                        });
                    } catch (err) {
                        console.error('Error loading clients:', err);
                        showEmpty('Failed to load clients. Please try again.');
                    }
                }

                // ── Load Cities by District ──────────────────────────
                async function loadCitiesByDistrict() {
                    if (!districtCode) {
                        citySelect.innerHTML = '<option value="">No district assigned</option>';
                        return;
                    }
                    try {
                        const res = await fetch(`/api/cities-municipalities?district_code=${districtCode}`);
                        const data = await res.json();
                        populateSelect(citySelect, data, 'Select City / Municipality');
                    } catch (err) {
                        console.error('Error loading cities:', err);
                        citySelect.innerHTML = '<option value="">Failed to load</option>';
                    }
                }

                // ── Cascading: City → Barangay ──────────────────────
                citySelect.addEventListener('change', async function () {
                    resetSelect(barangaySelect, 'Select Barangay');
                    heading.textContent = 'Registered Clients';
                    totalCount.textContent = '—';
                    entryCount.textContent = '';
                    showInitial();
                    updateAddLink();

                    // Persist selection
                    localStorage.setItem('ipss-selectedCity', this.value);
                    localStorage.removeItem('ipss-selectedBarangay');

                    if (this.value) {
                        try {
                            const res = await fetch(`/api/barangays?city_municipality_code=${this.value}`);
                            const data = await res.json();
                            populateSelect(barangaySelect, data, 'Select Barangay');
                        } catch (err) {
                            console.error('Error loading barangays:', err);
                        }
                    }
                });

                barangaySelect.addEventListener('change', function () {
                    updateAddLink();
                    // Persist selection
                    localStorage.setItem('ipss-selectedBarangay', this.value);

                    if (this.value) {
                        loadClients(this.value);
                    } else {
                        heading.textContent = 'Registered Clients';
                        totalCount.textContent = '—';
                        entryCount.textContent = '';
                        showInitial();
                    }
                });

                // ── Init ─────────────────────────────────────────────
                async function initDashboard() {
                    await loadCitiesByDistrict();

                    // Restore persisted city selection
                    const savedCity = localStorage.getItem('ipss-selectedCity');
                    if (savedCity && Array.from(citySelect.options).some(o => o.value === savedCity)) {
                        citySelect.value = savedCity;

                        // Load barangays for the saved city
                        if (savedCity) {
                            try {
                                const res = await fetch(`/api/barangays?city_municipality_code=${savedCity}`);
                                const data = await res.json();
                                populateSelect(barangaySelect, data, 'Select Barangay');

                                // Restore persisted barangay selection
                                const savedBarangay = localStorage.getItem('ipss-selectedBarangay');
                                if (savedBarangay && Array.from(barangaySelect.options).some(o => o.value === savedBarangay)) {
                                    barangaySelect.value = savedBarangay;
                                    updateAddLink();
                                    loadClients(savedBarangay);
                                }
                            } catch (err) {
                                console.error('Error restoring barangays:', err);
                            }
                        }
                    }
                }

                initDashboard();
            });
        </script>
    </body>
</html>
