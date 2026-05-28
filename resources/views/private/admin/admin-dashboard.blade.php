<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>IPSS Admin Dashboard</title>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700;800&amp;display=swap"
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
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
            rel="stylesheet"
        />
        <style>
            body {
                font-family: "Public Sans", sans-serif;
                background-color: #f9f9fc;
            }
            .material-symbols-outlined {
                font-variation-settings:
                    "FILL" 0,
                    "wght" 400,
                    "GRAD" 0,
                    "opsz" 24;
            }
            .custom-scrollbar::-webkit-scrollbar {
                width: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #c3c6d1;
                border-radius: 10px;
            }
        </style>
        <script id="tailwind-config">
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "on-error-container": "#93000a",
                            "surface-container-highest": "#e2e2e5",
                            primary: "#001e40",
                            "on-background": "#1a1c1e",
                            surface: "#f9f9fc",
                            "surface-container-low": "#f3f3f6",
                            "error-container": "#ffdad6",
                            error: "#ba1a1a",
                            "secondary-fixed": "#cee5ff",
                            "surface-container-lowest": "#ffffff",
                            "on-tertiary-container": "#969ca0",
                            "on-tertiary-fixed": "#161c1f",
                            "surface-tint": "#3a5f94",
                            "tertiary-fixed-dim": "#c1c7cb",
                            outline: "#737780",
                            "on-primary-fixed": "#001b3c",
                            "on-primary-container": "#799dd6",
                            "surface-container-high": "#e8e8ea",
                            "on-tertiary": "#ffffff",
                            "tertiary-container": "#2e3437",
                            tertiary: "#191f22",
                            "on-primary": "#ffffff",
                            "inverse-primary": "#a7c8ff",
                            secondary: "#4a6077",
                            "surface-bright": "#f9f9fc",
                            "outline-variant": "#c3c6d1",
                            "primary-container": "#003366",
                            "on-primary-fixed-variant": "#1f477b",
                            "secondary-fixed-dim": "#b2c9e2",
                            "on-secondary-container": "#4f657b",
                            "tertiary-fixed": "#dde3e7",
                            "surface-dim": "#dadadc",
                            "surface-container": "#eeeef0",
                            "on-tertiary-fixed-variant": "#41484b",
                            "on-surface": "#1a1c1e",
                            "on-secondary": "#ffffff",
                            "secondary-container": "#cbe2fc",
                            "on-secondary-fixed": "#041d30",
                            background: "#f9f9fc",
                            "inverse-on-surface": "#f0f0f3",
                            "on-error": "#ffffff",
                            "inverse-surface": "#2f3133",
                            "surface-variant": "#e2e2e5",
                            "primary-fixed": "#d5e3ff",
                            "on-surface-variant": "#43474f",
                            "on-secondary-fixed-variant": "#33495e",
                            "primary-fixed-dim": "#a7c8ff",
                        },
                        borderRadius: {
                            DEFAULT: "0.125rem",
                            lg: "0.25rem",
                            xl: "0.5rem",
                            full: "0.75rem",
                        },
                        spacing: {
                            xxl: "48px",
                            sm: "8px",
                            xs: "4px",
                            xl: "32px",
                            lg: "24px",
                            gutter: "24px",
                            md: "16px",
                            "margin-mobile": "16px",
                            "container-max": "1280px",
                            unit: "4px",
                        },
                        fontFamily: {
                            "headline-md": ["Public Sans"],
                            "label-md": ["Public Sans"],
                            "headline-lg-mobile": ["Public Sans"],
                            "body-sm": ["Public Sans"],
                            "label-lg": ["Public Sans"],
                            "headline-lg": ["Public Sans"],
                            "body-lg": ["Public Sans"],
                            "headline-sm": ["Public Sans"],
                            "display-lg": ["Public Sans"],
                            "body-md": ["Public Sans"],
                        },
                        fontSize: {
                            "headline-md": [
                                "24px",
                                { lineHeight: "32px", fontWeight: "600" },
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
                            "body-sm": [
                                "14px",
                                { lineHeight: "20px", fontWeight: "400" },
                            ],
                            "label-lg": [
                                "14px",
                                {
                                    lineHeight: "20px",
                                    letterSpacing: "0.01em",
                                    fontWeight: "600",
                                },
                            ],
                            "headline-lg": [
                                "32px",
                                { lineHeight: "40px", fontWeight: "700" },
                            ],
                            "body-lg": [
                                "18px",
                                { lineHeight: "28px", fontWeight: "400" },
                            ],
                            "headline-sm": [
                                "20px",
                                { lineHeight: "28px", fontWeight: "600" },
                            ],
                            "display-lg": [
                                "48px",
                                {
                                    lineHeight: "56px",
                                    letterSpacing: "-0.02em",
                                    fontWeight: "700",
                                },
                            ],
                            "body-md": [
                                "16px",
                                { lineHeight: "24px", fontWeight: "400" },
                            ],
                        },
                    },
                },
            };
        </script>
    </head>
    <body class="bg-background text-on-surface">
        <div class="flex h-screen overflow-hidden">
            <!-- SideNavBar Component -->
            <aside
                class="hidden md:flex flex-col h-full border-r border-outline-variant/15 py-md bg-surface dark:bg-surface-dim docked left-0 w-64"
            >
                <div class="px-lg pb-xl">
                    <div class="flex items-center gap-md">
                        <img
                            alt="City Seal"
                            class="w-10 h-10"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAcG6f6ozFIMiJQ9ur28QaRkgZQ12cR4J-7giUJt7UIXBAu1tp8Q0GLPY610tlEf-QJ9tdX9XCe5ASAdl_H0m3Cd0pbxdR0T-7flfL1SkF-TwASv-9nvcVNTkj5NMIG67Ryaloou8vG8L35COC__UTQGuixrjMR_9foLRUjTKHh2tbx5MXwW-nH3lG_z4iBr92TduOL9r5O4AJ-kcdkV_9wZivg0fLuADAUDLffQ-K3WCpl1xwa-vGlZ2LpVEIeY0qkDPKVajq8_qxK"
                        />
                        <div>
                            <h1
                                class="font-headline-sm text-headline-sm font-bold text-primary"
                            >
                                Admin
                            </h1>
                            <p
                                class="font-label-md text-label-md text-on-surface-variant"
                            >
                                Governance Portal
                            </p>
                        </div>
                    </div>
                </div>
                <nav class="flex-1 space-y-1">
                    <!-- Dashboard (Active) -->
                    <button
                        class="admin-nav-link flex w-[calc(100%-16px)] items-center px-lg py-md bg-secondary-fixed dark:bg-primary-container text-on-secondary-fixed dark:text-on-primary-container rounded-xl mx-2 my-1 transition-all translate-x-1 duration-200"
                        type="button"
                        data-admin-view="dashboard"
                    >
                        <span
                            class="material-symbols-outlined mr-md"
                            data-icon="dashboard"
                            >dashboard</span
                        >
                        <span class="font-label-lg text-label-lg"
                            >Dashboard</span
                        >
                    </button>
                    <a
                        class="flex items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all"
                        href="#"
                    >
                        <span
                            class="material-symbols-outlined mr-md"
                            data-icon="analytics"
                            >analytics</span
                        >
                        <span class="font-label-lg text-label-lg"
                            >Analytics</span
                        >
                    </a>
                    <button
                        class="admin-nav-link flex w-[calc(100%-16px)] items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all"
                        type="button"
                        data-admin-view="surveyors"
                    >
                        <span
                            class="material-symbols-outlined mr-md"
                            data-icon="group"
                            >group</span
                        >
                        <span class="font-label-lg text-label-lg"
                            >Surveyors</span
                        >
                    </button>
                    <button
                        class="admin-nav-link flex w-[calc(100%-16px)] items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all"
                        type="button"
                        data-admin-view="verification"
                    >
                        <span
                            class="material-symbols-outlined mr-md"
                            data-icon="fact_check"
                            >fact_check</span
                        >
                        <span class="font-label-lg text-label-lg"
                            >Verification Queue</span
                        >
                    </button>
                </nav>
                <div class="mt-auto pt-md border-t border-outline-variant/15">
                    <a
                        class="flex items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all"
                        href="#"
                    >
                        <span
                            class="material-symbols-outlined mr-md"
                            data-icon="help"
                            >help</span
                        >
                        <span class="font-label-lg text-label-lg">Support</span>
                    </a>
                    <a
                        class="flex items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all"
                        href="#"
                    >
                        <span
                            class="material-symbols-outlined mr-md"
                            data-icon="history"
                            >history</span
                        >
                        <span class="font-label-lg text-label-lg">Archive</span>
                    </a>
                </div>
            </aside>
            <!-- Main Content Area -->
            <div
                class="flex-1 flex flex-col h-full overflow-y-auto custom-scrollbar"
            >
                <!-- Dashboard Content -->
                <main
                    class="p-lg md:p-xxl max-w-container-max mx-auto w-full space-y-lg"
                >
                    <section
                        id="admin-dashboard-panel"
                        data-admin-panel="dashboard"
                        class="admin-panel space-y-lg"
                    >
                        <div
                            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-md"
                        >
                            <div>
                                <h2
                                    class="font-headline-lg text-headline-lg text-primary"
                                >
                                    System Overview
                                </h2>
                                <p
                                    class="font-body-md text-body-md text-on-surface-variant"
                                >
                                    Real-time status of the Civic Trust
                                    ecosystem across all administrative regions.
                                </p>
                            </div>
                            <button
                                class="flex items-center gap-sm bg-primary text-on-primary px-lg py-md rounded-xl font-label-lg text-label-lg hover:opacity-90 transition-opacity"
                            >
                                <span
                                    class="material-symbols-outlined"
                                    data-icon="download"
                                    >download</span
                                >
                                Export System Report
                            </button>
                        </div>
                        <!-- KPI Grid -->
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-lg"
                        >
                            <div
                                class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl flex flex-col gap-sm"
                            >
                                <div class="flex justify-between items-start">
                                    <span
                                        class="material-symbols-outlined text-primary-container p-sm bg-secondary-fixed rounded-lg"
                                        data-icon="person_add"
                                        >person_add</span
                                    >
                                    <span
                                        class="text-on-surface-variant font-label-md text-label-md flex items-center"
                                        >All</span
                                    >
                                </div>
                                <p
                                    class="font-label-lg text-label-lg text-on-surface-variant"
                                >
                                    Total Clients
                                </p>
                                <p
                                    class="font-headline-md text-headline-md text-on-surface"
                                >
                                    {{ number_format($dashboardClientCounts['total'] ?? 0) }}
                                </p>
                            </div>
                            <div
                                class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl flex flex-col gap-sm"
                            >
                                <div class="flex justify-between items-start">
                                    <span
                                        class="material-symbols-outlined text-error p-sm bg-error-container rounded-lg"
                                        data-icon="pending_actions"
                                        >pending_actions</span
                                    >
                                    <span
                                        class="text-error font-label-md text-label-md flex items-center"
                                        >Priority</span
                                    >
                                </div>
                                <p
                                    class="font-label-lg text-label-lg text-on-surface-variant"
                                >
                                    Pending Verifications
                                </p>
                                <p
                                    class="font-headline-md text-headline-md text-on-surface"
                                >
                                    {{ number_format($dashboardClientCounts['pending'] ?? 0) }}
                                </p>
                            </div>
                            <div
                                class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl flex flex-col gap-sm"
                            >
                                <div class="flex justify-between items-start">
                                    <span
                                        class="material-symbols-outlined text-green-700 p-sm bg-green-100 rounded-lg"
                                        data-icon="verified"
                                        >verified</span
                                    >
                                    <span
                                        class="text-green-700 font-label-md text-label-md flex items-center"
                                        >Accepted</span
                                    >
                                </div>
                                <p
                                    class="font-label-lg text-label-lg text-on-surface-variant"
                                >
                                    Verified Clients
                                </p>
                                <p
                                    class="font-headline-md text-headline-md text-on-surface"
                                >
                                    {{ number_format($dashboardClientCounts['verified'] ?? 0) }}
                                </p>
                            </div>
                            <div
                                class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl flex flex-col gap-sm"
                            >
                                <div class="flex justify-between items-start">
                                    <span
                                        class="material-symbols-outlined text-primary p-sm bg-secondary-fixed rounded-lg"
                                        data-icon="assignment_return"
                                        >assignment_return</span
                                    >
                                    <span
                                        class="text-primary font-label-md text-label-md flex items-center"
                                        >Returned</span
                                    >
                                </div>
                                <p
                                    class="font-label-lg text-label-lg text-on-surface-variant"
                                >
                                    Returned Clients
                                </p>
                                <p
                                    class="font-headline-md text-headline-md text-on-surface"
                                >
                                    {{ number_format($dashboardClientCounts['returned'] ?? 0) }}
                                </p>
                            </div>
                        </div>
                        <!-- Bento Grid Layout -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
                            <!-- Density Map Section -->
                            <div
                                class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant/15 rounded-xl overflow-hidden flex flex-col"
                            >
                                <div
                                    class="p-lg border-b border-outline-variant/15 flex justify-between items-center"
                                >
                                    <div>
                                        <h3
                                            class="font-headline-sm text-headline-sm text-primary"
                                        >
                                            Verified Client Map
                                        </h3>
                                        <p
                                            class="font-body-sm text-body-sm text-on-surface-variant"
                                        >
                                            Accepted client surveys with saved latitude and longitude.
                                        </p>
                                    </div>
                                    <button
                                        type="button"
                                        id="dashboard-verified-map-refresh"
                                        class="p-2 bg-surface-container-low border border-outline-variant/20 rounded-lg"
                                        title="Refresh verified client locations"
                                    >
                                        <span class="material-symbols-outlined" data-icon="refresh">refresh</span>
                                    </button>
                                </div>
                                <div class="relative h-[400px] bg-surface-container-highest">
                                    <div id="dashboard-verified-map" class="h-full w-full"></div>
                                    <div
                                        id="dashboard-verified-map-empty"
                                        class="absolute inset-0 hidden items-center justify-center bg-surface-container-highest/90 p-lg text-center text-on-surface-variant"
                                    >
                                        <div>
                                            <span class="material-symbols-outlined text-[40px] text-lime-700 mb-sm">location_off</span>
                                            <p class="font-label-lg text-label-lg text-primary">No verified client locations</p>
                                            <p class="text-body-sm">Verified clients appear here when latitude and longitude are saved.</p>
                                        </div>
                                    </div>
                                    <div
                                        class="absolute bottom-md left-md bg-white/90 backdrop-blur-sm p-md rounded-lg border border-outline-variant/15 space-y-sm"
                                    >
                                        <p
                                            class="font-label-md text-label-md text-on-surface"
                                        >
                                            Verified Clients
                                            <span id="dashboard-verified-map-count" class="ml-1 inline-flex items-center justify-center min-w-[20px] px-1.5 py-0.5 rounded-full bg-lime-200 text-lime-800 text-[10px] font-bold">0</span>
                                        </p>
                                        <div class="flex items-center gap-md">
                                            <div
                                                class="h-3 w-3 rounded-full bg-lime-500 ring-4 ring-lime-100"
                                            ></div>
                                            <span
                                                class="text-[10px] text-on-surface-variant"
                                                >Accepted survey location</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Activity Feed Section -->
                            <div
                                class="bg-surface-container-lowest border border-outline-variant/15 rounded-xl flex flex-col"
                            >
                                <div
                                    class="p-lg border-b border-outline-variant/15 flex justify-between items-center"
                                >
                                    <h3
                                        class="font-headline-sm text-headline-sm text-primary"
                                    >
                                        System Activity
                                    </h3>
                                    <button
                                        class="text-primary font-label-md text-label-md hover:underline"
                                    >
                                        View All
                                    </button>
                                </div>
                                <div
                                    class="flex-1 overflow-y-auto custom-scrollbar p-lg space-y-lg"
                                >
                                    <!-- Activity Item 1 -->
                                    <div class="flex gap-md group">
                                        <div
                                            class="relative flex flex-col items-center"
                                        >
                                            <div
                                                class="w-2 h-2 rounded-full bg-green-500 ring-4 ring-green-100"
                                            ></div>
                                            <div
                                                class="w-px h-full bg-outline-variant/20 mt-1"
                                            ></div>
                                        </div>
                                        <div class="pb-md">
                                            <p
                                                class="font-label-lg text-label-lg text-on-surface"
                                            >
                                                Batch verification completed
                                            </p>
                                            <p
                                                class="font-body-sm text-body-sm text-on-surface-variant"
                                            >
                                                Zone 4 (North Central) records
                                                cleared by Admin-02.
                                            </p>
                                            <span
                                                class="text-xs text-on-tertiary-container mt-xs block"
                                                >12 mins ago</span
                                            >
                                        </div>
                                    </div>
                                    <!-- Activity Item 2 -->
                                    <div class="flex gap-md group">
                                        <div
                                            class="relative flex flex-col items-center"
                                        >
                                            <div
                                                class="w-2 h-2 rounded-full bg-primary ring-4 ring-secondary-fixed"
                                            ></div>
                                            <div
                                                class="w-px h-full bg-outline-variant/20 mt-1"
                                            ></div>
                                        </div>
                                        <div class="pb-md">
                                            <p
                                                class="font-label-lg text-label-lg text-on-surface"
                                            >
                                                New Surveyor Credentials Issued
                                            </p>
                                            <p
                                                class="font-body-sm text-body-sm text-on-surface-variant"
                                            >
                                                Surveyor ID #8829 activated for
                                                the Riverside district.
                                            </p>
                                            <span
                                                class="text-xs text-on-tertiary-container mt-xs block"
                                                >45 mins ago</span
                                            >
                                        </div>
                                    </div>
                                    <!-- Activity Item 3 -->
                                    <div class="flex gap-md group">
                                        <div
                                            class="relative flex flex-col items-center"
                                        >
                                            <div
                                                class="w-2 h-2 rounded-full bg-error ring-4 ring-error-container"
                                            ></div>
                                            <div
                                                class="w-px h-full bg-outline-variant/20 mt-1"
                                            ></div>
                                        </div>
                                        <div class="pb-md">
                                            <p
                                                class="font-label-lg text-label-lg text-on-surface"
                                            >
                                                Discrepancy Detected
                                            </p>
                                            <p
                                                class="font-body-sm text-body-sm text-on-surface-variant"
                                            >
                                                Regional compliance dip in East
                                                Ward. Automated alert sent.
                                            </p>
                                            <span
                                                class="text-xs text-on-tertiary-container mt-xs block"
                                                >2 hours ago</span
                                            >
                                        </div>
                                    </div>
                                    <!-- Activity Item 4 -->
                                    <div class="flex gap-md group">
                                        <div
                                            class="relative flex flex-col items-center"
                                        >
                                            <div
                                                class="w-2 h-2 rounded-full bg-on-tertiary-container ring-4 ring-tertiary-fixed"
                                            ></div>
                                        </div>
                                        <div class="pb-md">
                                            <p
                                                class="font-label-lg text-label-lg text-on-surface"
                                            >
                                                System Maintenance
                                            </p>
                                            <p
                                                class="font-body-sm text-body-sm text-on-surface-variant"
                                            >
                                                Nightly backup and encryption
                                                verification scheduled for
                                                01:00.
                                            </p>
                                            <span
                                                class="text-xs text-on-tertiary-container mt-xs block"
                                                >4 hours ago</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-surface-container-lowest border border-outline-variant/15 rounded-xl overflow-hidden">
                            <div class="px-lg py-md border-b border-outline-variant/15 flex items-center justify-between">
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-primary">Verified Clients</h3>
                                    <p class="text-body-sm text-on-surface-variant">Client surveys accepted by admin.</p>
                                </div>
                                <span class="inline-flex items-center gap-xs rounded-full bg-green-100 px-md py-xs text-label-md font-label-md text-green-800">
                                    <span class="material-symbols-outlined text-[16px]">verified</span>
                                    {{ number_format($dashboardClientCounts['verified'] ?? 0) }}
                                </span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse text-left">
                                    <thead class="bg-surface-container-low border-b border-outline-variant/20">
                                        <tr>
                                            <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Business / Client</th>
                                            <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Surveyor</th>
                                            <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Category</th>
                                            <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Verified Date</th>
                                            <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dashboardVerifiedClients as $client)
                                            @php
                                                $clientName = trim(implode(' ', array_filter([
                                                    $client->first_name,
                                                    $client->middle_name,
                                                    $client->last_name,
                                                    $client->suffix && $client->suffix !== '--N/A--' ? $client->suffix : null,
                                                ]))) ?: 'Unnamed Client';
                                                $surveyorName = $surveyorNames[$client->surveyed_by] ?? 'Unknown Surveyor';
                                            @endphp
                                            <tr class="zebra-stripe hover:bg-surface-container transition-colors">
                                                <td class="px-md py-4">
                                                    <div class="flex items-center gap-md">
                                                        <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center shrink-0">
                                                            <span class="material-symbols-outlined text-green-700">verified_user</span>
                                                        </div>
                                                        <div>
                                                            <div class="font-semibold text-primary">{{ $clientName }}</div>
                                                            <div class="text-body-sm text-on-surface-variant">Ref: {{ $client->client_id ?? 'Auto-generated' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-md py-4 text-body-sm">{{ $surveyorName }}</td>
                                                <td class="px-md py-4 text-body-sm text-on-surface-variant">{{ $client->category_of_client ?? '—' }}</td>
                                                <td class="px-md py-4 text-body-sm text-on-surface-variant">
                                                    {{ optional($client->updated_at)->format('M d, Y - h:i A') ?? 'Not recorded' }}
                                                </td>
                                                <td class="px-md py-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-green-100 text-green-800">
                                                        verified
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="px-lg py-xxl text-center text-on-surface-variant" colspan="5">
                                                    No verified client records yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <section
                        id="surveyor-management-panel"
                        data-admin-panel="surveyors"
                        class="admin-panel hidden space-y-xl"
                    >
                        <div class="max-w-container-max mx-auto space-y-xl">

                            <!-- Featured Analytics Cards -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
                                <div
                                    class="lg:col-span-2 bg-surface-container-low rounded-xl p-lg border border-outline-variant/15"
                                >
                                    <div
                                        class="flex justify-between items-start mb-xl"
                                    >
                                        <div>
                                            <h3
                                                class="font-headline-sm text-headline-sm text-primary"
                                            >
                                                Map where the surveyor is
                                            </h3>
                                            <p
                                                class="font-body-sm text-body-sm text-on-surface-variant"
                                            >
                                                Current positions from the latest submitted client surveys.
                                            </p>
                                        </div>
                                        <button
                                            type="button"
                                            id="surveyor-map-refresh"
                                            class="p-2 bg-surface-container-lowest border border-outline-variant/20 rounded-lg"
                                            title="Refresh surveyor locations"
                                        >
                                            <span
                                                class="material-symbols-outlined"
                                                data-icon="refresh"
                                                >refresh</span
                                            >
                                        </button>
                                    </div>
                                    <div
                                        class="aspect-[21/9] min-h-[360px] w-full bg-surface-container-highest rounded-lg overflow-hidden relative"
                                    >
                                        <div id="admin-surveyor-map" class="h-full w-full"></div>
                                        <div
                                            id="admin-surveyor-map-empty"
                                            class="absolute inset-0 hidden items-center justify-center bg-surface-container-highest/90 p-lg text-center text-on-surface-variant"
                                        >
                                            <div>
                                                <span class="material-symbols-outlined text-[40px] text-primary mb-sm">location_off</span>
                                                <p class="font-label-lg text-label-lg text-primary">No active surveyor locations</p>
                                                <p class="text-body-sm">Surveyors appear here after submitting a client survey and disappear when they log out.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="bg-surface-container-lowest border border-outline-variant/15 rounded-xl p-lg flex flex-col"
                                >
                                    <h3
                                        class="font-headline-sm text-headline-sm text-primary mb-md"
                                    >
                                        Quick Actions
                                    </h3>
                                    <div class="space-y-sm flex-1">
                                        <button
                                            class="w-full flex items-center justify-between p-md bg-surface hover:bg-surface-container-low rounded-lg border border-outline-variant/10 transition-all group"
                                        >
                                            <div
                                                class="flex items-center gap-md"
                                            >
                                                <span
                                                    class="material-symbols-outlined text-primary"
                                                    data-icon="add_location"
                                                    >add_location</span
                                                >
                                                <span
                                                    class="font-label-lg text-label-lg"
                                                    >New Assignment</span
                                                >
                                            </div>
                                            <span
                                                class="material-symbols-outlined opacity-0 group-hover:opacity-100 transition-opacity"
                                                data-icon="arrow_forward"
                                                >arrow_forward</span
                                            >
                                        </button>
                                        <button
                                            class="w-full flex items-center justify-between p-md bg-surface hover:bg-surface-container-low rounded-lg border border-outline-variant/10 transition-all group"
                                        >
                                            <div
                                                class="flex items-center gap-md"
                                            >
                                                <span
                                                    class="material-symbols-outlined text-primary"
                                                    data-icon="assignment_late"
                                                    >assignment_late</span
                                                >
                                                <span
                                                    class="font-label-lg text-label-lg"
                                                    >Review Flagged Data</span
                                                >
                                            </div>
                                            <span
                                                class="material-symbols-outlined opacity-0 group-hover:opacity-100 transition-opacity"
                                                data-icon="arrow_forward"
                                                >arrow_forward</span
                                            >
                                        </button>
                                        <button
                                            class="w-full flex items-center justify-between p-md bg-surface hover:bg-surface-container-low rounded-lg border border-outline-variant/10 transition-all group"
                                        >
                                            <div
                                                class="flex items-center gap-md"
                                            >
                                                <span
                                                    class="material-symbols-outlined text-primary"
                                                    data-icon="rate_review"
                                                    >rate_review</span
                                                >
                                                <span
                                                    class="font-label-lg text-label-lg"
                                                    >Performance Reviews</span
                                                >
                                            </div>
                                            <span
                                                class="material-symbols-outlined opacity-0 group-hover:opacity-100 transition-opacity"
                                                data-icon="arrow_forward"
                                                >arrow_forward</span
                                            >
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <section
                        id="verification-queue-panel"
                        data-admin-panel="verification"
                        class="admin-panel hidden space-y-lg"
                    >
                        <div class="max-w-container-max mx-auto space-y-lg">
                            <!-- Page Header & Stats -->
                            <div
                                class="flex flex-col lg:flex-row lg:items-end justify-between gap-md"
                            >
                                <div>
                                    <nav
                                        class="flex items-center gap-xs text-on-surface-variant mb-2"
                                    >
                                        <span class="font-body-sm text-body-sm"
                                            >Admin</span
                                        >
                                        <span
                                            class="material-symbols-outlined text-[14px]"
                                            >chevron_right</span
                                        >
                                        <span
                                            class="font-body-sm text-body-sm font-semibold text-primary"
                                            >Verification Queue</span
                                        >
                                    </nav>
                                    <h2
                                        class="font-headline-lg text-headline-lg text-primary"
                                    >
                                        Verification Queue
                                    </h2>
                                    <p
                                        class="text-on-surface-variant font-body-md mt-1"
                                    >
                                        Efficiently process and validate pending
                                        municipal survey requests.
                                    </p>
                                </div>
                                <!-- Quick Stats Chips -->
                                <div class="flex flex-wrap gap-sm">
                                    <div class="bg-surface-container rounded-xl px-md py-2 border border-outline-variant/10 flex items-center gap-sm">
                                        <span class="material-symbols-outlined text-secondary text-[20px]">pending_actions</span>
                                        <span class="text-body-sm font-semibold">{{ $verificationStatusCounts['pending'] ?? 0 }} Pending</span>
                                    </div>
                                    <div class="bg-surface-container rounded-xl px-md py-2 border border-outline-variant/10 flex items-center gap-sm">
                                        <span class="material-symbols-outlined text-primary text-[20px]">assignment_return</span>
                                        <span class="text-body-sm font-semibold">{{ $verificationStatusCounts['returned'] ?? 0 }} Returned</span>
                                    </div>
                                    <div class="bg-surface-container rounded-xl px-md py-2 border border-outline-variant/10 flex items-center gap-sm">
                                        <span class="material-symbols-outlined text-green-700 text-[20px]">verified</span>
                                        <span class="text-body-sm font-semibold">{{ $verificationStatusCounts['verified'] ?? 0 }} Verified</span>
                                    </div>
                                    <div class="bg-surface-container rounded-xl px-md py-2 border border-outline-variant/10 flex items-center gap-sm">
                                        <span class="material-symbols-outlined text-error text-[20px]">cancel</span>
                                        <span class="text-body-sm font-semibold">{{ $verificationStatusCounts['rejected'] ?? 0 }} Rejected</span>
                                    </div>
                                </div>
                            </div>
                            @if (session('success'))
                                <div class="rounded-xl border border-green-200 bg-green-50 px-md py-sm text-body-sm text-green-800">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="rounded-xl border border-red-200 bg-red-50 px-md py-sm text-body-sm text-red-800">
                                    {{ $errors->first() }}
                                </div>
                            @endif                            <!-- Filter Bar -->
                            <div
                                class="bg-surface-container-lowest rounded-xl border border-outline-variant/15 p-md flex flex-wrap gap-md items-center"
                            >
                                <div class="flex items-center gap-sm flex-grow">
                                    <span
                                        class="text-label-lg font-label-lg text-on-surface-variant"
                                        >Filter by:</span
                                    >
                                    <select
                                        class="bg-surface-container-low border border-outline-variant rounded-lg px-md py-1.5 text-body-sm focus:ring-2 focus:ring-primary/20"
                                    >
                                        <option>Date: Newest First</option>
                                        <option>Date: Oldest First</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-sm">
                                    <button
                                        class="flex items-center gap-xs px-md py-2 border border-outline text-on-surface rounded-lg hover:bg-surface-container-low transition-all text-label-lg font-label-lg"
                                    >
                                        <span
                                            class="material-symbols-outlined text-[18px]"
                                            >download</span
                                        >
                                        Export
                                    </button>
                                </div>
                            </div>
                            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/15 overflow-hidden">
                                <div class="px-lg py-md border-b border-outline-variant/15 flex items-center justify-between">
                                    <div>
                                        <h3 class="font-headline-sm text-headline-sm text-primary">Client Location Map</h3>
                                        <p class="text-body-sm text-on-surface-variant">Pins show pending and returned clients with saved latitude and longitude.</p>
                                    </div>
                                    <button
                                        type="button"
                                        id="verification-client-map-refresh"
                                        class="p-2 bg-surface-container-low border border-outline-variant/20 rounded-lg"
                                        title="Refresh client locations"
                                    >
                                        <span class="material-symbols-outlined" data-icon="refresh">refresh</span>
                                    </button>
                                </div>
                                <div class="relative h-[420px] bg-surface-container-highest">
                                    <div id="verification-client-map" class="h-full w-full"></div>
                                    <div
                                        id="verification-client-map-empty"
                                        class="absolute inset-0 hidden items-center justify-center bg-surface-container-highest/90 p-lg text-center text-on-surface-variant"
                                    >
                                        <div>
                                            <span class="material-symbols-outlined text-[40px] text-primary mb-sm">location_off</span>
                                            <p class="font-label-lg text-label-lg text-primary">No pending or returned client locations</p>
                                            <p class="text-body-sm">Pending and returned clients appear here when their records have saved latitude and longitude.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pending Client Queue -->
                            <div
                                class="bg-surface-container-lowest rounded-xl border border-outline-variant/15 overflow-hidden"
                            >
                                <div class="px-lg py-md border-b border-outline-variant/15 flex items-center justify-between">
                                    <div>
                                        <h3 class="font-headline-sm text-headline-sm text-primary">Pending Client Data</h3>
                                        <p class="text-body-sm text-on-surface-variant">Client submissions waiting for admin response.</p>
                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table
                                        class="w-full border-collapse text-left"
                                    >
                                        <thead
                                            class="bg-surface-container-low border-b border-outline-variant/20"
                                        >
                                            <tr>
                                                <th
                                                    class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider w-12"
                                                >
                                                    <input
                                                        class="rounded border-outline-variant text-primary focus:ring-primary"
                                                        type="checkbox"
                                                    />
                                                </th>
                                                <th
                                                    class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Business / Client
                                                </th>
                                                <th
                                                    class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Owner
                                                </th>
                                                <th
                                                    class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Surveyor
                                                </th>
                                                <th
                                                    class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Submission Date
                                                </th>
                                                <th
                                                    class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Status
                                                </th>
                                                <th
                                                    class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider text-right"
                                                >
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($verificationClients as $client)
                                                @php
                                                    $status = $client->survey_status ?: 'pending';
                                                    $clientName = trim(implode(' ', array_filter([
                                                        $client->first_name,
                                                        $client->middle_name,
                                                        $client->last_name,
                                                        $client->suffix && $client->suffix !== '--N/A--' ? $client->suffix : null,
                                                    ]))) ?: 'Unnamed Client';
                                                    $surveyorName = $surveyorNames[$client->surveyed_by] ?? 'Unknown Surveyor';
                                                    $statusClass = match ($status) {
                                                        'verified' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-error-container text-error',
                                                        'returned' => 'bg-secondary-container text-primary',
                                                        default => 'bg-amber-100 text-amber-800',
                                                    };
                                                @endphp
                                                <tr class="zebra-stripe hover:bg-surface-container transition-colors group">
                                                    <td class="px-md py-4">
                                                        <input class="rounded border-outline-variant text-primary focus:ring-primary" type="checkbox" />
                                                    </td>
                                                    <td class="px-md py-4">
                                                        <div class="flex items-center gap-md">
                                                            <div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
                                                                <span class="material-symbols-outlined text-primary">person</span>
                                                            </div>
                                                            <div>
                                                                <div class="font-semibold text-primary">{{ $clientName }}</div>
                                                                <div class="text-body-sm text-on-surface-variant">Ref: {{ $client->client_id ?? 'Auto-generated' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-md py-4 text-body-md">{{ $clientName }}</td>
                                                    <td class="px-md py-4">
                                                        <div class="flex items-center gap-xs">
                                                            <span class="material-symbols-outlined text-[16px] text-on-surface-variant">badge</span>
                                                            <span class="text-body-sm">{{ $surveyorName }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-md py-4 text-body-sm text-on-surface-variant">
                                                        {{ optional($client->created_at)->format('M d, Y - h:i A') ?? 'Not recorded' }}
                                                    </td>
                                                    <td class="px-md py-4">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase {{ $statusClass }}">
                                                            {{ $status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-md py-4">
                                                        <div class="flex justify-end gap-sm">
                                                            @if ($status === 'rejected')
                                                                <form method="POST" action="{{ route('admin.clients.destroy-rejected', $client) }}" onsubmit="return confirm('Delete this rejected client record?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="p-1.5 text-error hover:bg-red-100 rounded transition-colors" title="Delete rejected client" type="submit">
                                                                        <span class="material-symbols-outlined text-error">delete</span>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                @if ($status === 'returned')
                                                                    <form method="POST" action="{{ route('admin.clients.survey-status', $client) }}">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="survey_status" value="pending" />
                                                                        <button class="p-1.5 text-amber-700 hover:bg-amber-100 rounded transition-colors" title="Set back to pending" type="submit">
                                                                            <span class="material-symbols-outlined text-amber-700">pending_actions</span>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <form method="POST" action="{{ route('admin.clients.survey-status', $client) }}">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="survey_status" value="verified" />
                                                                        <button class="p-1.5 text-green-700 hover:bg-green-100 rounded transition-colors" title="Verify client" type="submit">
                                                                            <span class="material-symbols-outlined text-green-700">verified</span>
                                                                        </button>
                                                                    </form>
                                                                    <form method="POST" action="{{ route('admin.clients.survey-status', $client) }}">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="hidden" name="survey_status" value="returned" />
                                                                        <button class="p-1.5 text-primary hover:bg-secondary-container rounded transition-colors" title="Return to surveyor" type="submit">
                                                                            <span class="material-symbols-outlined text-primary">assignment_return</span>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                <form method="POST" action="{{ route('admin.clients.survey-status', $client) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="survey_status" value="rejected" />
                                                                    <button class="p-1.5 text-error hover:bg-red-100 rounded transition-colors" title="Reject" type="submit">
                                                                        <span class="material-symbols-outlined text-error">cancel</span>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="px-lg py-xxl text-center text-on-surface-variant" colspan="7">
                                                        No pending client submissions.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Queue Summary -->
                                <div
                                    class="flex flex-col sm:flex-row items-center justify-between px-lg py-4 bg-surface-container-low border-t border-outline-variant/15 gap-md"
                                >
                                    <span
                                        class="text-body-sm text-on-surface-variant"
                                        >Showing
                                        <span class="font-bold text-on-surface"
                                            >{{ $verificationClients->firstItem() ?? 0 }} - {{ $verificationClients->lastItem() ?? 0 }}</span
                                        >
                                        of {{ $verificationClients->total() }} client submissions</span
                                    >
                                    <div class="flex flex-wrap items-center justify-end gap-sm">
                                        @if ($verificationClients->onFirstPage())
                                            <span class="p-2 border border-outline-variant rounded-lg text-on-surface-variant opacity-30">
                                                <span class="material-symbols-outlined">chevron_left</span>
                                            </span>
                                        @else
                                            <a class="p-2 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high" href="{{ $verificationClients->previousPageUrl() }}#verification">
                                                <span class="material-symbols-outlined">chevron_left</span>
                                            </a>
                                        @endif

                                        @foreach ($verificationClients->getUrlRange(1, $verificationClients->lastPage()) as $page => $url)
                                            <a class="px-3 py-1 border rounded-lg text-body-sm font-bold {{ $verificationClients->currentPage() === $page ? 'border-primary bg-primary text-on-primary' : 'border-outline-variant text-on-surface-variant hover:bg-surface-container-high' }}"
                                                href="{{ $url }}#verification">{{ $page }}</a>
                                        @endforeach

                                        @if ($verificationClients->hasMorePages())
                                            <a class="p-2 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high" href="{{ $verificationClients->nextPageUrl() }}#verification">
                                                <span class="material-symbols-outlined">chevron_right</span>
                                            </a>
                                        @else
                                            <span class="p-2 border border-outline-variant rounded-lg text-on-surface-variant opacity-30">
                                                <span class="material-symbols-outlined">chevron_right</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Returned Client Queue -->
                            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/15 overflow-hidden">
                                <div class="px-lg py-md border-b border-outline-variant/15 flex items-center justify-between">
                                    <div>
                                        <h3 class="font-headline-sm text-headline-sm text-primary">Returned Client Data</h3>
                                        <p class="text-body-sm text-on-surface-variant">Client records returned to surveyors for checkups and revision.</p>
                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse text-left">
                                        <thead class="bg-surface-container-low border-b border-outline-variant/20">
                                            <tr>
                                                <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Business / Client</th>
                                                <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Owner</th>
                                                <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Surveyor</th>
                                                <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Returned Date</th>
                                                <th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($returnedClients as $client)
                                                @php
                                                    $clientName = trim(implode(' ', array_filter([
                                                        $client->first_name,
                                                        $client->middle_name,
                                                        $client->last_name,
                                                        $client->suffix && $client->suffix !== '--N/A--' ? $client->suffix : null,
                                                    ]))) ?: 'Unnamed Client';
                                                    $surveyorName = $surveyorNames[$client->surveyed_by] ?? 'Unknown Surveyor';
                                                @endphp
                                                <tr class="zebra-stripe hover:bg-surface-container transition-colors group">
                                                    <td class="px-md py-4">
                                                        <div class="flex items-center gap-md">
                                                            <div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
                                                                <span class="material-symbols-outlined text-primary">assignment_return</span>
                                                            </div>
                                                            <div>
                                                                <div class="font-semibold text-primary">{{ $clientName }}</div>
                                                                <div class="text-body-sm text-on-surface-variant">Ref: {{ $client->client_id ?? 'Auto-generated' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-md py-4 text-body-md">{{ $clientName }}</td>
                                                    <td class="px-md py-4">
                                                        <div class="flex items-center gap-xs">
                                                            <span class="material-symbols-outlined text-[16px] text-on-surface-variant">badge</span>
                                                            <span class="text-body-sm">{{ $surveyorName }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-md py-4 text-body-sm text-on-surface-variant">
                                                        {{ optional($client->updated_at)->format('M d, Y - h:i A') ?? 'Not recorded' }}
                                                    </td>
                                                    <td class="px-md py-4">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-secondary-container text-primary">
                                                            returned
                                                        </span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="px-lg py-xxl text-center text-on-surface-variant" colspan="5">
                                                        No returned client submissions.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="flex flex-col sm:flex-row items-center justify-between px-lg py-4 bg-surface-container-low border-t border-outline-variant/15 gap-md">
                                    <span class="text-body-sm text-on-surface-variant">
                                        Showing <span class="font-bold text-on-surface">{{ $returnedClients->firstItem() ?? 0 }} - {{ $returnedClients->lastItem() ?? 0 }}</span>
                                        of {{ $returnedClients->total() }} returned client submissions
                                    </span>
                                    <div class="flex flex-wrap items-center justify-end gap-sm">
                                        @if ($returnedClients->onFirstPage())
                                            <span class="p-2 border border-outline-variant rounded-lg text-on-surface-variant opacity-30">
                                                <span class="material-symbols-outlined">chevron_left</span>
                                            </span>
                                        @else
                                            <a class="p-2 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high" href="{{ $returnedClients->previousPageUrl() }}#verification">
                                                <span class="material-symbols-outlined">chevron_left</span>
                                            </a>
                                        @endif

                                        @foreach ($returnedClients->getUrlRange(1, $returnedClients->lastPage()) as $page => $url)
                                            <a class="px-3 py-1 border rounded-lg text-body-sm font-bold {{ $returnedClients->currentPage() === $page ? 'border-primary bg-primary text-on-primary' : 'border-outline-variant text-on-surface-variant hover:bg-surface-container-high' }}"
                                                href="{{ $url }}#verification">{{ $page }}</a>
                                        @endforeach

                                        @if ($returnedClients->hasMorePages())
                                            <a class="p-2 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high" href="{{ $returnedClients->nextPageUrl() }}#verification">
                                                <span class="material-symbols-outlined">chevron_right</span>
                                            </a>
                                        @else
                                            <span class="p-2 border border-outline-variant rounded-lg text-on-surface-variant opacity-30">
                                                <span class="material-symbols-outlined">chevron_right</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Details Panel (Asymmetric Layout Hint) -->
                            <div
                                class="grid grid-cols-1 lg:grid-cols-3 gap-lg mt-xl"
                            >
            
                                
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
        <!-- Modal Placeholder (Reject Action) -->
        <div
            class="fixed inset-0 bg-on-background/40 backdrop-blur-sm z-[100] hidden items-center justify-center p-md"
            id="actionModal"
        >
            <div
                class="bg-surface-container-lowest rounded-2xl w-full max-w-md p-xl shadow-2xl border border-outline-variant/20"
            >
                <div class="flex items-center gap-md mb-lg">
                    <div
                        class="w-12 h-12 rounded-full flex items-center justify-center"
                        id="modalIcon"
                    ></div>
                    <h4
                        class="font-headline-sm text-headline-sm"
                        id="modalTitle"
                    >
                        Action Required
                    </h4>
                </div>
                <div class="space-y-md">
                    <p
                        class="text-body-md text-on-surface-variant"
                        id="modalDescription"
                    >
                        Are you sure you want to perform this action for
                        <span
                            class="font-bold text-on-surface"
                            id="businessName"
                        ></span
                        >?
                    </p>
                    <div>
                        <label class="block font-label-lg text-label-lg mb-2"
                            >Internal Comments (Mandatory)</label
                        >
                        <textarea
                            class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-md text-body-sm focus:ring-2 focus:ring-primary/20"
                            placeholder="Enter reason for this action..."
                            rows="3"
                        ></textarea>
                    </div>
                </div>
                <div class="flex gap-md mt-xl">
                    <button
                        class="flex-1 py-3 border border-outline text-on-surface font-bold rounded-xl hover:bg-surface-container-low transition-colors"
                        onclick="closeModal()"
                    >
                        Cancel
                    </button>
                    <button
                        class="flex-1 py-3 text-on-primary font-bold rounded-xl transition-all"
                        id="confirmBtn"
                    >
                        Confirm Action
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Navigation Shell (Bottom Bar) -->
        <div
            class="md:hidden fixed bottom-0 left-0 right-0 bg-surface-container-lowest border-t border-outline-variant/15 flex justify-around py-sm z-50"
        >
            <button
                class="admin-nav-link flex flex-col items-center gap-xs text-primary"
                type="button"
                data-admin-view="dashboard"
            >
                <span
                    class="material-symbols-outlined"
                    data-icon="dashboard"
                    style="font-variation-settings: &quot;FILL&quot; 1"
                    >dashboard</span
                >
                <span class="text-[10px] font-label-md">Home</span>
            </button>
            <a
                class="flex flex-col items-center gap-xs text-on-surface-variant"
                href="#"
            >
                <span class="material-symbols-outlined" data-icon="analytics"
                    >analytics</span
                >
                <span class="text-[10px] font-label-md">Data</span>
            </a>
            <button
                class="admin-nav-link flex flex-col items-center gap-xs text-on-surface-variant"
                type="button"
                data-admin-view="surveyors"
            >
                <span class="material-symbols-outlined" data-icon="group"
                    >group</span
                >
                <span class="text-[10px] font-label-md">Surveyors</span>
            </button>
            <button
                class="admin-nav-link flex flex-col items-center gap-xs text-on-surface-variant"
                type="button"
                data-admin-view="verification"
            >
                <span class="material-symbols-outlined" data-icon="fact_check"
                    >fact_check</span
                >
                <span class="text-[10px] font-label-md">Queue</span>
            </button>
        </div>
        <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
        <script>
            let surveyorLocationPoints = @json($surveyorLocations ?? []);
            let adminSurveyorMap = null;
            let adminSurveyorMapLoaded = false;
            let verificationClientMapPoints = @json($adminClientMapPoints ?? []);
            let verificationClientMap = null;
            let verificationClientMapLoaded = false;
            let dashboardVerifiedMapPoints = @json($dashboardVerifiedMapPoints ?? []);
            let dashboardVerifiedMap = null;
            let dashboardVerifiedMapLoaded = false;

            const modal = document.getElementById("actionModal");
            const modalTitle = document.getElementById("modalTitle");
            const modalIcon = document.getElementById("modalIcon");
            const confirmBtn = document.getElementById("confirmBtn");
            const businessNameSpan = document.getElementById("businessName");
            const surveyorMapEl = document.getElementById("admin-surveyor-map");
            const surveyorMapEmptyEl = document.getElementById("admin-surveyor-map-empty");
            const surveyorMapRefreshBtn = document.getElementById("surveyor-map-refresh");
            const verificationClientMapEl = document.getElementById("verification-client-map");
            const verificationClientMapEmptyEl = document.getElementById("verification-client-map-empty");
            const verificationClientMapRefreshBtn = document.getElementById("verification-client-map-refresh");
            const dashboardVerifiedMapEl = document.getElementById("dashboard-verified-map");
            const dashboardVerifiedMapEmptyEl = document.getElementById("dashboard-verified-map-empty");
            const dashboardVerifiedMapRefreshBtn = document.getElementById("dashboard-verified-map-refresh");

            function escapeHtml(value) {
                return String(value ?? "").replace(/[&<>"']/g, (character) => ({
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#039;",
                })[character]);
            }

            function formatSurveyorUpdatedAt(value) {
                if (!value) return "Just submitted";

                const date = new Date(value);
                if (Number.isNaN(date.getTime())) return "Just submitted";

                return date.toLocaleString("en-US", {
                    month: "short",
                    day: "numeric",
                    hour: "2-digit",
                    minute: "2-digit",
                });
            }

            function buildSurveyorLocationGeoJson() {
                return {
                    type: "FeatureCollection",
                    features: surveyorLocationPoints
                        .filter((surveyor) => Number.isFinite(Number(surveyor.latitude)) && Number.isFinite(Number(surveyor.longitude)))
                        .map((surveyor) => ({
                            type: "Feature",
                            geometry: {
                                type: "Point",
                                coordinates: [Number(surveyor.longitude), Number(surveyor.latitude)],
                            },
                            properties: {
                                id: surveyor.id,
                                name: surveyor.name || "Unnamed Surveyor",
                                govt_id: surveyor.govt_id || "",
                                district: surveyor.district || "",
                                updated_at: surveyor.updated_at || "",
                            },
                        })),
                };
            }

            function setSurveyorMapEmptyState(isEmpty) {
                if (!surveyorMapEmptyEl) return;
                surveyorMapEmptyEl.classList.toggle("hidden", !isEmpty);
                surveyorMapEmptyEl.classList.toggle("flex", isEmpty);
            }

            function fitSurveyorMapToData(geojson) {
                if (!adminSurveyorMap || geojson.features.length === 0) return;

                const bounds = new maplibregl.LngLatBounds();
                geojson.features.forEach((feature) => bounds.extend(feature.geometry.coordinates));
                adminSurveyorMap.fitBounds(bounds, { padding: 56, maxZoom: 16 });
            }

            function refreshSurveyorMapSource({ fit = false } = {}) {
                if (!adminSurveyorMapLoaded) return;

                const geojson = buildSurveyorLocationGeoJson();
                const source = adminSurveyorMap.getSource("surveyors");
                if (source) {
                    source.setData(geojson);
                }

                setSurveyorMapEmptyState(geojson.features.length === 0);

                if (fit) {
                    fitSurveyorMapToData(geojson);
                }
            }

            function initializeSurveyorMap() {
                if (!surveyorMapEl || adminSurveyorMap || typeof maplibregl === "undefined") return;

                const negrosBounds = [122.25, 9.0, 123.55, 11.1];
                const lngPad = (negrosBounds[2] - negrosBounds[0]) * 0.08;
                const latPad = (negrosBounds[3] - negrosBounds[1]) * 0.08;
                const paddedBounds = [
                    [negrosBounds[0] - lngPad, negrosBounds[1] - latPad],
                    [negrosBounds[2] + lngPad, negrosBounds[3] + latPad],
                ];

                adminSurveyorMap = new maplibregl.Map({
                    container: surveyorMapEl,
                    style: "https://basemaps.cartocdn.com/gl/positron-gl-style/style.json",
                    center: [122.9509, 10.6765],
                    zoom: 9,
                    minZoom: 8,
                    maxZoom: 19,
                    maxBounds: paddedBounds,
                    attributionControl: true,
                });

                adminSurveyorMap.addControl(new maplibregl.NavigationControl(), "top-right");

                adminSurveyorMap.on("load", () => {
                    adminSurveyorMapLoaded = true;
                    adminSurveyorMap.addSource("surveyors", {
                        type: "geojson",
                        data: buildSurveyorLocationGeoJson(),
                    });

                    adminSurveyorMap.addLayer({
                        id: "surveyor-presence-halo",
                        type: "circle",
                        source: "surveyors",
                        paint: {
                            "circle-color": "#a7c8ff",
                            "circle-radius": 18,
                            "circle-opacity": 0.35,
                            "circle-stroke-width": 1,
                            "circle-stroke-color": "#ffffff",
                        },
                    });

                    adminSurveyorMap.addLayer({
                        id: "surveyor-presence-point",
                        type: "circle",
                        source: "surveyors",
                        paint: {
                            "circle-color": "#001e40",
                            "circle-radius": 8,
                            "circle-stroke-width": 3,
                            "circle-stroke-color": "#ffffff",
                        },
                    });

                    adminSurveyorMap.on("click", "surveyor-presence-point", (event) => {
                        const coordinates = event.features[0].geometry.coordinates.slice();
                        const props = event.features[0].properties;

                        new maplibregl.Popup({ offset: 12 })
                            .setLngLat(coordinates)
                            .setHTML(`
                                <strong>${escapeHtml(props.name)}</strong>
                                <span>${escapeHtml(props.govt_id ? `ID: ${props.govt_id}` : "No government ID")}</span><br>
                                <span>${escapeHtml(props.district || "No district")}</span><br>
                                <span>Last survey: ${escapeHtml(formatSurveyorUpdatedAt(props.updated_at))}</span>
                            `)
                            .addTo(adminSurveyorMap);
                    });

                    adminSurveyorMap.on("mouseenter", "surveyor-presence-point", () => {
                        adminSurveyorMap.getCanvas().style.cursor = "pointer";
                    });
                    adminSurveyorMap.on("mouseleave", "surveyor-presence-point", () => {
                        adminSurveyorMap.getCanvas().style.cursor = "";
                    });

                    refreshSurveyorMapSource({ fit: true });
                });
            }

            async function fetchSurveyorLocations({ fit = false } = {}) {
                try {
                    const response = await fetch("{{ route('admin.surveyor-locations') }}", {
                        headers: { "Accept": "application/json" },
                    });

                    if (!response.ok) {
                        throw new Error(`Server responded with ${response.status}`);
                    }

                    surveyorLocationPoints = await response.json();
                    refreshSurveyorMapSource({ fit });
                } catch (error) {
                    console.error("Failed to load surveyor locations:", error);
                }
            }

            surveyorMapRefreshBtn?.addEventListener("click", () => fetchSurveyorLocations({ fit: true }));

            function buildVerificationClientMapGeoJson() {
                return {
                    type: "FeatureCollection",
                    features: verificationClientMapPoints
                        .filter((client) => Number.isFinite(Number(client.latitude)) && Number.isFinite(Number(client.longitude)))
                        .map((client) => ({
                            type: "Feature",
                            geometry: {
                                type: "Point",
                                coordinates: [Number(client.longitude), Number(client.latitude)],
                            },
                            properties: {
                                id: client.id,
                                name: client.name || "Unnamed Client",
                                client_id: client.client_id || "",
                                category: client.category || "",
                                survey_status: client.survey_status || "pending",
                            },
                        })),
                };
            }

            function setVerificationClientMapEmptyState(isEmpty) {
                if (!verificationClientMapEmptyEl) return;
                verificationClientMapEmptyEl.classList.toggle("hidden", !isEmpty);
                verificationClientMapEmptyEl.classList.toggle("flex", isEmpty);
            }

            function fitVerificationClientMapToData(geojson) {
                if (!verificationClientMap || geojson.features.length === 0) return;

                const bounds = new maplibregl.LngLatBounds();
                geojson.features.forEach((feature) => bounds.extend(feature.geometry.coordinates));
                verificationClientMap.fitBounds(bounds, { padding: 56, maxZoom: 16 });
            }

            function refreshVerificationClientMapSource({ fit = false } = {}) {
                if (!verificationClientMapLoaded) return;

                const geojson = buildVerificationClientMapGeoJson();
                const source = verificationClientMap.getSource("verification-clients");
                if (source) {
                    source.setData(geojson);
                }

                setVerificationClientMapEmptyState(geojson.features.length === 0);

                if (fit) {
                    fitVerificationClientMapToData(geojson);
                }
            }

            function initializeVerificationClientMap() {
                if (!verificationClientMapEl || verificationClientMap || typeof maplibregl === "undefined") return;

                const negrosBounds = [122.25, 9.0, 123.55, 11.1];
                const lngPad = (negrosBounds[2] - negrosBounds[0]) * 0.08;
                const latPad = (negrosBounds[3] - negrosBounds[1]) * 0.08;
                const paddedBounds = [
                    [negrosBounds[0] - lngPad, negrosBounds[1] - latPad],
                    [negrosBounds[2] + lngPad, negrosBounds[3] + latPad],
                ];

                verificationClientMap = new maplibregl.Map({
                    container: verificationClientMapEl,
                    style: "https://basemaps.cartocdn.com/gl/positron-gl-style/style.json",
                    center: [122.9509, 10.6765],
                    zoom: 9,
                    minZoom: 8,
                    maxZoom: 19,
                    maxBounds: paddedBounds,
                    attributionControl: true,
                });

                verificationClientMap.addControl(new maplibregl.NavigationControl(), "top-right");

                verificationClientMap.on("load", () => {
                    verificationClientMapLoaded = true;
                    verificationClientMap.addSource("verification-clients", {
                        type: "geojson",
                        data: buildVerificationClientMapGeoJson(),
                        cluster: true,
                        clusterMaxZoom: 14,
                        clusterRadius: 50,
                    });

                    verificationClientMap.addLayer({
                        id: "verification-client-clusters",
                        type: "circle",
                        source: "verification-clients",
                        filter: ["has", "point_count"],
                        paint: {
                            "circle-color": [
                                "step", ["get", "point_count"],
                                "#FEF3C7",
                                20, "#FDE68A",
                                100, "#FCD34D",
                            ],
                            "circle-radius": [
                                "step", ["get", "point_count"],
                                18,
                                20, 24,
                                100, 32,
                            ],
                            "circle-stroke-width": 3,
                            "circle-stroke-color": "rgba(255,255,255,0.85)",
                        },
                    });

                    verificationClientMap.addLayer({
                        id: "verification-client-cluster-count",
                        type: "symbol",
                        source: "verification-clients",
                        filter: ["has", "point_count"],
                        layout: {
                            "text-field": "{point_count_abbreviated}",
                            "text-size": 13,
                            "text-font": ["Open Sans Bold"],
                        },
                        paint: {
                            "text-color": "#ffffff",
                        },
                    });

                    verificationClientMap.addLayer({
                        id: "verification-client-point",
                        type: "circle",
                        source: "verification-clients",
                        filter: ["!", ["has", "point_count"]],
                        paint: {
                            "circle-color": [
                                "case",
                                ["==", ["get", "survey_status"], "returned"],
                                "#001E40",
                                "#FEF3C7",
                            ],
                            "circle-radius": 7,
                            "circle-stroke-width": 2,
                            "circle-stroke-color": [
                                "case",
                                ["==", ["get", "survey_status"], "returned"],
                                "#ffffff",
                                "#D97706",
                            ],
                        },
                    });

                    verificationClientMap.on("click", "verification-client-clusters", async (event) => {
                        const features = verificationClientMap.queryRenderedFeatures(event.point, { layers: ["verification-client-clusters"] });
                        const clusterId = features[0].properties.cluster_id;
                        const zoom = await verificationClientMap.getSource("verification-clients").getClusterExpansionZoom(clusterId);
                        verificationClientMap.easeTo({ center: features[0].geometry.coordinates, zoom });
                    });

                    verificationClientMap.on("click", "verification-client-point", (event) => {
                        const coordinates = event.features[0].geometry.coordinates.slice();
                        const props = event.features[0].properties;

                        new maplibregl.Popup({ offset: 12 })
                            .setLngLat(coordinates)
                            .setHTML(`
                                <strong>${escapeHtml(props.name)}</strong>
                                <span>${escapeHtml(props.client_id || "No client ID")}</span><br>
                                <span>${escapeHtml(props.category || "No category")}</span><br>
                                <span>Status: ${escapeHtml(props.survey_status || "pending")}</span>
                            `)
                            .addTo(verificationClientMap);
                    });

                    verificationClientMap.on("mouseenter", "verification-client-clusters", () => {
                        verificationClientMap.getCanvas().style.cursor = "pointer";
                    });
                    verificationClientMap.on("mouseleave", "verification-client-clusters", () => {
                        verificationClientMap.getCanvas().style.cursor = "";
                    });
                    verificationClientMap.on("mouseenter", "verification-client-point", () => {
                        verificationClientMap.getCanvas().style.cursor = "pointer";
                    });
                    verificationClientMap.on("mouseleave", "verification-client-point", () => {
                        verificationClientMap.getCanvas().style.cursor = "";
                    });

                    refreshVerificationClientMapSource({ fit: true });
                });
            }

            async function fetchVerificationClientLocations({ fit = false } = {}) {
                try {
                    const response = await fetch("{{ route('admin.client-locations') }}?ts=" + Date.now(), {
                        headers: { "Accept": "application/json" },
                        cache: "no-store",
                    });

                    if (!response.ok) {
                        throw new Error(`Server responded with ${response.status}`);
                    }

                    verificationClientMapPoints = await response.json();
                    refreshVerificationClientMapSource({ fit });
                } catch (error) {
                    console.error("Failed to load client locations:", error);
                }
            }

            verificationClientMapRefreshBtn?.addEventListener("click", () => fetchVerificationClientLocations({ fit: true }));

            function buildDashboardVerifiedMapGeoJson() {
                return {
                    type: "FeatureCollection",
                    features: dashboardVerifiedMapPoints
                        .filter((client) => Number.isFinite(Number(client.latitude)) && Number.isFinite(Number(client.longitude)))
                        .map((client) => ({
                            type: "Feature",
                            geometry: {
                                type: "Point",
                                coordinates: [Number(client.longitude), Number(client.latitude)],
                            },
                            properties: {
                                id: client.id,
                                name: client.name || "Unnamed Client",
                                client_id: client.client_id || "",
                                category: client.category || "",
                                survey_status: client.survey_status || "verified",
                                latitude: Number(client.latitude),
                                longitude: Number(client.longitude),
                            },
                        })),
                };
            }

            function setDashboardVerifiedMapEmptyState(isEmpty) {
                if (!dashboardVerifiedMapEmptyEl) return;
                dashboardVerifiedMapEmptyEl.classList.toggle("hidden", !isEmpty);
                dashboardVerifiedMapEmptyEl.classList.toggle("flex", isEmpty);
            }

            function fitDashboardVerifiedMapToData(geojson) {
                if (!dashboardVerifiedMap || geojson.features.length === 0) return;

                const bounds = new maplibregl.LngLatBounds();
                geojson.features.forEach((feature) => bounds.extend(feature.geometry.coordinates));
                dashboardVerifiedMap.fitBounds(bounds, { padding: 56, maxZoom: 16 });
            }

            function updateDashboardVerifiedMapCount(count) {
                const countEl = document.getElementById("dashboard-verified-map-count");
                if (countEl) countEl.textContent = count;
            }

            function refreshDashboardVerifiedMapSource({ fit = false } = {}) {
                if (!dashboardVerifiedMapLoaded) return;

                const geojson = buildDashboardVerifiedMapGeoJson();
                const source = dashboardVerifiedMap.getSource("dashboard-verified-clients");
                if (source) {
                    source.setData(geojson);
                }

                setDashboardVerifiedMapEmptyState(geojson.features.length === 0);
                updateDashboardVerifiedMapCount(geojson.features.length);

                if (fit) {
                    fitDashboardVerifiedMapToData(geojson);
                }
            }

            function initializeDashboardVerifiedMap() {
                if (!dashboardVerifiedMapEl || dashboardVerifiedMap || typeof maplibregl === "undefined") return;

                const negrosBounds = [122.25, 9.0, 123.55, 11.1];
                const lngPad = (negrosBounds[2] - negrosBounds[0]) * 0.08;
                const latPad = (negrosBounds[3] - negrosBounds[1]) * 0.08;
                const paddedBounds = [
                    [negrosBounds[0] - lngPad, negrosBounds[1] - latPad],
                    [negrosBounds[2] + lngPad, negrosBounds[3] + latPad],
                ];

                dashboardVerifiedMap = new maplibregl.Map({
                    container: dashboardVerifiedMapEl,
                    style: "https://basemaps.cartocdn.com/gl/positron-gl-style/style.json",
                    center: [122.9509, 10.6765],
                    zoom: 9,
                    minZoom: 8,
                    maxZoom: 19,
                    maxBounds: paddedBounds,
                    attributionControl: true,
                });

                dashboardVerifiedMap.addControl(new maplibregl.NavigationControl(), "top-right");

                dashboardVerifiedMap.on("load", () => {
                    dashboardVerifiedMapLoaded = true;
                    dashboardVerifiedMap.addSource("dashboard-verified-clients", {
                        type: "geojson",
                        data: buildDashboardVerifiedMapGeoJson(),
                        cluster: true,
                        clusterMaxZoom: 14,
                        clusterRadius: 50,
                    });

                    // Cluster circles
                    dashboardVerifiedMap.addLayer({
                        id: "dashboard-verified-clusters",
                        type: "circle",
                        source: "dashboard-verified-clients",
                        filter: ["has", "point_count"],
                        paint: {
                            "circle-color": [
                                "step", ["get", "point_count"],
                                "#d9f99d",
                                10, "#bef264",
                                50, "#a3e635",
                            ],
                            "circle-radius": [
                                "step", ["get", "point_count"],
                                18,
                                10, 24,
                                50, 32,
                            ],
                            "circle-stroke-width": 3,
                            "circle-stroke-color": "rgba(255,255,255,0.85)",
                        },
                    });

                    // Cluster count labels
                    dashboardVerifiedMap.addLayer({
                        id: "dashboard-verified-cluster-count",
                        type: "symbol",
                        source: "dashboard-verified-clients",
                        filter: ["has", "point_count"],
                        layout: {
                            "text-field": "{point_count_abbreviated}",
                            "text-size": 13,
                            "text-font": ["Open Sans Bold"],
                        },
                        paint: {
                            "text-color": "#365314",
                        },
                    });

                    // Individual point halo
                    dashboardVerifiedMap.addLayer({
                        id: "dashboard-verified-point-halo",
                        type: "circle",
                        source: "dashboard-verified-clients",
                        filter: ["!", ["has", "point_count"]],
                        paint: {
                            "circle-color": "#d9f99d",
                            "circle-radius": 14,
                            "circle-opacity": 0.55,
                        },
                    });

                    // Individual points
                    dashboardVerifiedMap.addLayer({
                        id: "dashboard-verified-point",
                        type: "circle",
                        source: "dashboard-verified-clients",
                        filter: ["!", ["has", "point_count"]],
                        paint: {
                            "circle-color": "#84cc16",
                            "circle-radius": 7,
                            "circle-stroke-width": 2,
                            "circle-stroke-color": "#ffffff",
                        },
                    });

                    // Click cluster to zoom in
                    dashboardVerifiedMap.on("click", "dashboard-verified-clusters", async (event) => {
                        const features = dashboardVerifiedMap.queryRenderedFeatures(event.point, { layers: ["dashboard-verified-clusters"] });
                        const clusterId = features[0].properties.cluster_id;
                        const zoom = await dashboardVerifiedMap.getSource("dashboard-verified-clients").getClusterExpansionZoom(clusterId);
                        dashboardVerifiedMap.easeTo({ center: features[0].geometry.coordinates, zoom });
                    });

                    // Click individual point to show popup
                    dashboardVerifiedMap.on("click", "dashboard-verified-point", (event) => {
                        const coordinates = event.features[0].geometry.coordinates.slice();
                        const props = event.features[0].properties;

                        new maplibregl.Popup({ offset: 12 })
                            .setLngLat(coordinates)
                            .setHTML(`
                                <strong>${escapeHtml(props.name)}</strong>
                                <span>${escapeHtml(props.client_id || "No client ID")}</span><br>
                                <span>${escapeHtml(props.category || "No category")}</span><br>
                                <span>${escapeHtml(props.latitude)}, ${escapeHtml(props.longitude)}</span><br>
                                <span>Status: verified</span>
                            `)
                            .addTo(dashboardVerifiedMap);
                    });

                    // Cursor styles
                    dashboardVerifiedMap.on("mouseenter", "dashboard-verified-clusters", () => {
                        dashboardVerifiedMap.getCanvas().style.cursor = "pointer";
                    });
                    dashboardVerifiedMap.on("mouseleave", "dashboard-verified-clusters", () => {
                        dashboardVerifiedMap.getCanvas().style.cursor = "";
                    });
                    dashboardVerifiedMap.on("mouseenter", "dashboard-verified-point", () => {
                        dashboardVerifiedMap.getCanvas().style.cursor = "pointer";
                    });
                    dashboardVerifiedMap.on("mouseleave", "dashboard-verified-point", () => {
                        dashboardVerifiedMap.getCanvas().style.cursor = "";
                    });

                    fetchDashboardVerifiedLocations({ fit: true });
                });
            }

            async function fetchDashboardVerifiedLocations({ fit = false } = {}) {
                try {
                    const response = await fetch("{{ route('admin.verified-client-locations') }}?ts=" + Date.now(), {
                        headers: { "Accept": "application/json" },
                        cache: "no-store",
                    });

                    if (!response.ok) {
                        throw new Error(`Server responded with ${response.status}`);
                    }

                    dashboardVerifiedMapPoints = await response.json();
                    refreshDashboardVerifiedMapSource({ fit });
                    console.log("[Dashboard Verified Map] Loaded", dashboardVerifiedMapPoints.length, "verified locations");
                } catch (error) {
                    console.error("Failed to load verified client locations:", error);
                }
            }

            dashboardVerifiedMapRefreshBtn?.addEventListener("click", () => fetchDashboardVerifiedLocations({ fit: true }));

            function handleAction(type, name) {
                businessNameSpan.textContent = name;
                modal.classList.remove("hidden");
                modal.classList.add("flex");

                if (type === "approve") {
                    modalTitle.textContent = "Approve Submission";
                    modalIcon.className =
                        "w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700";
                    modalIcon.innerHTML =
                        '<span class="material-symbols-outlined text-[32px]">check_circle</span>';
                    confirmBtn.className =
                        "flex-1 py-3 bg-green-600 text-on-primary font-bold rounded-xl hover:bg-green-700 transition-all";
                    confirmBtn.textContent = "Approve";
                } else if (type === "flag") {
                    modalTitle.textContent = "Flag for Review";
                    modalIcon.className =
                        "w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-700";
                    modalIcon.innerHTML =
                        '<span class="material-symbols-outlined text-[32px]">flag</span>';
                    confirmBtn.className =
                        "flex-1 py-3 bg-amber-600 text-on-primary font-bold rounded-xl hover:bg-amber-700 transition-all";
                    confirmBtn.textContent = "Flag Submission";
                } else if (type === "reject") {
                    modalTitle.textContent = "Reject Submission";
                    modalIcon.className =
                        "w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-700";
                    modalIcon.innerHTML =
                        '<span class="material-symbols-outlined text-[32px]">cancel</span>';
                    confirmBtn.className =
                        "flex-1 py-3 bg-red-600 text-on-primary font-bold rounded-xl hover:bg-red-700 transition-all";
                    confirmBtn.textContent = "Reject";
                }
            }

            function closeModal() {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }

            // Add some micro-interactions
            document.querySelectorAll("tr").forEach((row) => {
                row.addEventListener("click", (e) => {
                    if (
                        e.target.type !== "checkbox" &&
                        !e.target.closest("button")
                    ) {
                        // Logic to select row or show details
                        console.log("Row clicked");
                    }
                });
            });

            const panels = document.querySelectorAll("[data-admin-panel]");
            const navLinks = document.querySelectorAll("[data-admin-view]");
            const activeNavClasses = [
                "bg-secondary-fixed",
                "dark:bg-primary-container",
                "text-on-secondary-fixed",
                "dark:text-on-primary-container",
                "text-primary",
                "translate-x-1",
            ];
            const inactiveNavClasses = [
                "text-on-surface-variant",
                "dark:text-on-tertiary-container",
                "hover:bg-surface-container-high",
                "dark:hover:bg-surface-container",
            ];

            function setAdminView(view) {
                panels.forEach((panel) => {
                    panel.classList.toggle(
                        "hidden",
                        panel.dataset.adminPanel !== view,
                    );
                });

                navLinks.forEach((link) => {
                    const isActive = link.dataset.adminView === view;
                    link.classList.toggle("bg-secondary-fixed", isActive);
                    link.classList.toggle(
                        "dark:bg-primary-container",
                        isActive,
                    );
                    link.classList.toggle(
                        "text-on-secondary-fixed",
                        isActive && !link.classList.contains("flex-col"),
                    );
                    link.classList.toggle(
                        "dark:text-on-primary-container",
                        isActive,
                    );
                    link.classList.toggle("text-primary", isActive);
                    link.classList.toggle(
                        "translate-x-1",
                        isActive && !link.classList.contains("flex-col"),
                    );

                    inactiveNavClasses.forEach((className) => {
                        link.classList.toggle(className, !isActive);
                    });

                    const icon = link.querySelector(
                        ".material-symbols-outlined",
                    );
                    if (icon) {
                        icon.style.fontVariationSettings = isActive
                            ? "'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24"
                            : "";
                    }
                });

                if (modal) {
                    closeModal();
                }

                if (view === "surveyors") {
                    initializeSurveyorMap();
                    requestAnimationFrame(() => adminSurveyorMap?.resize());
                    fetchSurveyorLocations({ fit: true });
                }

                if (view === "verification") {
                    initializeVerificationClientMap();
                    requestAnimationFrame(() => verificationClientMap?.resize());
                    fetchVerificationClientLocations({ fit: true });
                }

                if (view === "dashboard") {
                    initializeDashboardVerifiedMap();
                    requestAnimationFrame(() => dashboardVerifiedMap?.resize());
                    fetchDashboardVerifiedLocations({ fit: true });
                }

                window.location.hash = view;
            }

            navLinks.forEach((link) => {
                link.addEventListener("click", (event) => {
                    event.preventDefault();
                    setAdminView(link.dataset.adminView);
                });
            });

            const initialView = window.location.hash.replace("#", "");
            if (
                ["dashboard", "surveyors", "verification"].includes(initialView)
            ) {
                setAdminView(initialView);
            }

            initializeDashboardVerifiedMap();
            fetchDashboardVerifiedLocations({ fit: true });
            initializeSurveyorMap();
            window.addEventListener("pageshow", () => {
                fetchDashboardVerifiedLocations({ fit: true });
            });
            setInterval(() => {
                if (!window.location.hash || window.location.hash === "#dashboard") {
                    fetchDashboardVerifiedLocations();
                }
                if (window.location.hash === "#surveyors") {
                    fetchSurveyorLocations();
                }
                if (window.location.hash === "#verification") {
                    fetchVerificationClientLocations();
                }
            }, 15000);

            // Micro-interactions and UI Logic
            document.querySelectorAll("button, a").forEach((el) => {
                el.addEventListener("mousedown", () => {
                    el.classList.add("scale-95");
                });
                el.addEventListener("mouseup", () => {
                    el.classList.remove("scale-95");
                });
                el.addEventListener("mouseleave", () => {
                    el.classList.remove("scale-95");
                });
            });

            // Simple Fade In Effect
            window.addEventListener("load", () => {
                document.body.style.opacity = "0";
                document.body.style.transition = "opacity 0.6s ease-in-out";
                requestAnimationFrame(() => {
                    document.body.style.opacity = "1";
                });
            });
        </script>
    </body>
</html>
