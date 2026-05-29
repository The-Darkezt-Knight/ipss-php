<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>IPSS Admin Dashboard</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            href="{{ asset('css/maplibre-map.css') }}?v=20260529-2"
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
            .chart-container {
                position: relative;
                height: 300px;
                width: 100%;
            }
            .analytics-map-bg {
                background:
                    linear-gradient(
                        rgba(255, 255, 255, 0.9),
                        rgba(255, 255, 255, 0.9)
                    ),
                    url("https://images.unsplash.com/photo-1518107616985-bd48230d3b20?auto=format&fit=crop&q=80&w=1000");
                background-size: cover;
                background-position: center;
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
                            "accent-orange": "#F97316",
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
                    <button
                        class="admin-nav-link flex w-[calc(100%-16px)] items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all"
                        type="button"
                        data-admin-view="analytics"
                    >
                        <span
                            class="material-symbols-outlined mr-md"
                            data-icon="analytics"
                            >analytics</span
                        >
                        <span class="font-label-lg text-label-lg"
                            >Analytics</span
                        >
                    </button>
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
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="flex w-[calc(100%-16px)] items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all"
                            type="submit"
                        >
                            <span
                                class="material-symbols-outlined mr-md"
                                data-icon="logout"
                                >logout</span
                            >
                            <span class="font-label-lg text-label-lg">Log out</span>
                        </button>
                    </form>
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
                            @php
                                $dashboardVerifiedCategories = $dashboardVerifiedClients
                                    ->pluck('category_of_client')
                                    ->filter()
                                    ->unique()
                                    ->sort()
                                    ->values();
                                $dashboardVerifiedSurveyors = $dashboardVerifiedClients
                                    ->pluck('surveyed_by')
                                    ->filter()
                                    ->unique()
                                    ->mapWithKeys(fn ($surveyorId) => [$surveyorId => $surveyorNames[$surveyorId] ?? 'Unknown Surveyor'])
                                    ->sort()
                                    ->all();
                            @endphp
                            <div
                                id="admin-dashboard-filter-bar"
                                class="px-lg py-md border-b border-outline-variant/15 bg-surface-container-low flex flex-wrap items-end gap-md"
                            >
                                <div class="flex-1 min-w-[240px]">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="admin-dashboard-search">Search</label>
                                    <div class="flex items-center border border-outline-variant rounded-lg px-md bg-surface-container-lowest focus-within:border-primary focus-within:ring-1 focus-within:ring-primary">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">search</span>
                                        <input
                                            id="admin-dashboard-search"
                                            type="text"
                                            class="w-full py-2 px-sm border-none bg-transparent focus:ring-0 text-body-sm"
                                            placeholder="Name, client ID, surveyor, or category"
                                        />
                                    </div>
                                </div>
                                <div class="w-56">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="admin-dashboard-category-filter">Category</label>
                                    <select id="admin-dashboard-category-filter" class="w-full border border-outline-variant rounded-lg px-md py-2 text-body-sm bg-surface-container-lowest focus:ring-primary focus:border-primary">
                                        <option value="">All Categories</option>
                                        @foreach ($dashboardVerifiedCategories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-56">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="admin-dashboard-surveyor-filter">Surveyor</label>
                                    <select id="admin-dashboard-surveyor-filter" class="w-full border border-outline-variant rounded-lg px-md py-2 text-body-sm bg-surface-container-lowest focus:ring-primary focus:border-primary">
                                        <option value="">All Surveyors</option>
                                        @foreach ($dashboardVerifiedSurveyors as $surveyorId => $surveyorName)
                                            <option value="{{ $surveyorId }}">{{ $surveyorName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-48">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="admin-dashboard-sort">Sort</label>
                                    <select id="admin-dashboard-sort" class="w-full border border-outline-variant rounded-lg px-md py-2 text-body-sm bg-surface-container-lowest focus:ring-primary focus:border-primary">
                                        <option value="newest">Newest First</option>
                                        <option value="oldest">Oldest First</option>
                                    </select>
                                </div>
                                <span id="admin-dashboard-filter-count" class="text-body-sm text-on-surface-variant ml-auto py-2"></span>
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
                                            <tr class="zebra-stripe hover:bg-surface-container transition-colors cursor-pointer"
                                                data-admin-client-id="{{ $client->id }}"
                                                data-admin-client-mode="edit"
                                                data-admin-client-url="{{ route('admin.clients.show', $client) }}"
                                                data-admin-filter-row="dashboard"
                                                data-filter-search="{{ $clientName }} {{ $client->client_id }} {{ $surveyorName }} {{ $client->category_of_client }} verified"
                                                data-filter-category="{{ $client->category_of_client }}"
                                                data-filter-status="verified"
                                                data-filter-surveyor="{{ $client->surveyed_by }}"
                                                data-filter-date="{{ optional($client->updated_at)->timestamp ?? 0 }}">
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
                                        <tr class="hidden" data-admin-filter-empty="dashboard">
                                            <td class="px-lg py-xxl text-center text-on-surface-variant" colspan="5">
                                                No verified clients match the selected filters.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <section
                        id="admin-analytics-panel"
                        data-admin-panel="analytics"
                        class="admin-panel hidden"
                    >
                                    <div class="flex-1 overflow-y-auto p-lg space-y-lg">
                                        <!-- Page Header -->
                                        <div class="flex justify-between items-end">
                                            <div>
                                                <h2
                                                    class="font-headline-lg text-headline-lg text-primary"
                                                >
                                                    Negros Occidental MSME Registry
                                                </h2>
                                                <p
                                                    class="font-body-md text-body-md text-on-surface-variant"
                                                >
                                                    Provincial-level MSME registry data and demographic
                                                    insights for Negros Occidental.
                                                </p>
                                            </div>
                                            <div class="flex gap-md">
                                                <button
                                                    class="flex items-center gap-sm px-md py-2 border border-outline rounded-lg font-label-lg text-label-lg hover:bg-surface-container transition-colors"
                                                >
                                                    <span class="material-symbols-outlined"
                                                        >download</span
                                                    >
                                                    Export PDF
                                                </button>
                                                <button
                                                    class="flex items-center gap-sm px-md py-2 bg-accent-orange text-white rounded-lg font-label-lg text-label-lg hover:brightness-110 transition-colors shadow-sm"
                                                >
                                                    <span class="material-symbols-outlined"
                                                        >filter_list</span
                                                    >
                                                    Advanced Filters
                                                </button>
                                            </div>
                                        </div>
                                        <!-- 1. Overview KPI Cards (Bento Style) -->
                                        <div
                                            class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-md"
                                        >
                                            <div
                                                class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 flex flex-col justify-between"
                                            >
                                                <p
                                                    class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Total Clients
                                                </p>
                                                <h3
                                                    class="font-display-lg text-display-lg text-primary mt-sm"
                                                >
                                                    58.4k
                                                </h3>
                                                <div
                                                    class="flex items-center text-emerald-600 font-label-md mt-xs"
                                                >
                                                    <span class="material-symbols-outlined text-[16px]"
                                                        >trending_up</span
                                                    >
                                                    +4.2%
                                                </div>
                                            </div>
                                            <div
                                                class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 flex flex-col justify-between"
                                            >
                                                <p
                                                    class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Active Clients
                                                </p>
                                                <h3
                                                    class="font-headline-lg text-headline-lg text-primary mt-sm"
                                                >
                                                    42.2k
                                                </h3>
                                                <div
                                                    class="w-full bg-surface-container-high h-1.5 rounded-full mt-md"
                                                >
                                                    <div
                                                        class="bg-primary h-1.5 rounded-full"
                                                        style="width: 81%"
                                                    ></div>
                                                </div>
                                            </div>
                                            <div
                                                class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30"
                                            >
                                                <p
                                                    class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Senior Citizens
                                                </p>
                                                <h3
                                                    class="font-headline-md text-headline-md text-primary mt-sm"
                                                >
                                                    7.2k
                                                </h3>
                                                <p
                                                    class="font-body-sm text-body-sm text-on-surface-variant"
                                                >
                                                    12.5% of total
                                                </p>
                                            </div>
                                            <div
                                                class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30"
                                            >
                                                <p
                                                    class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    PWDs
                                                </p>
                                                <h3
                                                    class="font-headline-md text-headline-md text-primary mt-sm"
                                                >
                                                    2.1k
                                                </h3>
                                                <p
                                                    class="font-body-sm text-body-sm text-on-surface-variant"
                                                >
                                                    Inclusion Index: 3.8%
                                                </p>
                                            </div>
                                            <div
                                                class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30"
                                            >
                                                <p
                                                    class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider"
                                                >
                                                    Indigenous
                                                </p>
                                                <h3
                                                    class="font-headline-md text-headline-md text-primary mt-sm"
                                                >
                                                    1.4k
                                                </h3>
                                                <p
                                                    class="font-body-sm text-body-sm text-on-surface-variant"
                                                >
                                                    IP Communities
                                                </p>
                                            </div>
                                            <div
                                                class="bg-primary p-md rounded-xl border border-primary text-white"
                                            >
                                                <p
                                                    class="font-label-md text-label-md text-on-primary/70 uppercase tracking-wider"
                                                >
                                                    MSME Count
                                                </p>
                                                <h3 class="font-headline-lg text-headline-lg mt-sm">
                                                    53.1k
                                                </h3>
                                                <p class="font-body-sm text-body-sm mt-xs opacity-80">
                                                    91% Compliance
                                                </p>
                                            </div>
                                        </div>
                                        <!-- 2. Demographics Panel -->
                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
                                            <div
                                                class="lg:col-span-8 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm"
                                            >
                                                <h3
                                                    class="font-headline-sm text-headline-sm text-primary mb-xl flex items-center gap-sm"
                                                >
                                                    <span
                                                        class="material-symbols-outlined text-accent-orange"
                                                        >diversity_3</span
                                                    >
                                                    Demographics Analysis
                                                </h3>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-xl">
                                                    <div>
                                                        <p
                                                            class="font-label-lg text-label-lg mb-md text-on-surface-variant"
                                                        >
                                                            Age Groups Distribution
                                                        </p>
                                                        <div class="chart-container">
                                                            <canvas
                                                                id="ageChart"
                                                                width="340"
                                                                height="375"
                                                                style="
                                                                    display: block;
                                                                    box-sizing: border-box;
                                                                    height: 300px;
                                                                    width: 272.5px;
                                                                "
                                                            ></canvas>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p
                                                            class="font-label-lg text-label-lg mb-md text-on-surface-variant"
                                                        >
                                                            Civil Status Breakout
                                                        </p>
                                                        <div class="chart-container">
                                                            <canvas
                                                                id="civilStatusChart"
                                                                width="340"
                                                                height="375"
                                                                style="
                                                                    display: block;
                                                                    box-sizing: border-box;
                                                                    height: 300px;
                                                                    width: 272.5px;
                                                                "
                                                            ></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="lg:col-span-4 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm flex flex-col items-center justify-center"
                                            >
                                                <p
                                                    class="font-label-lg text-label-lg mb-xl text-on-surface-variant w-full text-left"
                                                >
                                                    Sex Distribution
                                                </p>
                                                <div class="relative w-full max-w-[240px]">
                                                    <canvas
                                                        id="sexChart"
                                                        width="300"
                                                        height="375"
                                                        style="
                                                            display: block;
                                                            box-sizing: border-box;
                                                            height: 300px;
                                                            width: 240px;
                                                        "
                                                    ></canvas>
                                                    <div
                                                        class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none"
                                                    >
                                                        <span
                                                            class="font-headline-md text-headline-md text-primary"
                                                            >Gender</span
                                                        >
                                                        <span
                                                            class="font-label-md text-label-md text-on-surface-variant"
                                                            >Parity Ratio</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 3. MSME & Business Profile Panel -->
                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
                                            <div
                                                class="lg:col-span-4 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm"
                                            >
                                                <h3
                                                    class="font-label-lg text-label-lg mb-xl text-on-surface-variant"
                                                >
                                                    MSME Classification
                                                </h3>
                                                <div class="chart-container">
                                                    <canvas
                                                        id="msmeClassChart"
                                                        width="304"
                                                        height="375"
                                                        style="
                                                            display: block;
                                                            box-sizing: border-box;
                                                            height: 300px;
                                                            width: 243.7px;
                                                        "
                                                    ></canvas>
                                                </div>
                                            </div>
                                            <div
                                                class="lg:col-span-8 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm"
                                            >
                                                <div class="flex justify-between mb-xl">
                                                    <h3
                                                        class="font-headline-sm text-headline-sm text-primary flex items-center gap-sm"
                                                    >
                                                        <span
                                                            class="material-symbols-outlined text-accent-orange"
                                                            >business_center</span
                                                        >
                                                        Sector &amp; Designation
                                                    </h3>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-xl">
                                                    <div class="chart-container">
                                                        <canvas
                                                            id="sectorChart"
                                                            width="340"
                                                            height="375"
                                                            style="
                                                                display: block;
                                                                box-sizing: border-box;
                                                                height: 300px;
                                                                width: 272.5px;
                                                            "
                                                        ></canvas>
                                                    </div>
                                                    <div class="chart-container">
                                                        <canvas
                                                            id="designationChart"
                                                            width="340"
                                                            height="375"
                                                            style="
                                                                display: block;
                                                                box-sizing: border-box;
                                                                height: 300px;
                                                                width: 272.5px;
                                                            "
                                                        ></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 4. Geographic Distribution Panel -->
                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
                                            <div
                                                class="lg:col-span-5 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm"
                                            >
                                                <h3
                                                    class="font-headline-sm text-headline-sm text-primary mb-xl"
                                                >
                                                    Top Cities &amp; Municipalities
                                                </h3>
                                                <div class="overflow-x-auto">
                                                    <table class="w-full text-left border-collapse">
                                                        <thead>
                                                            <tr
                                                                class="border-b border-outline-variant/30"
                                                            >
                                                                <th
                                                                    class="py-sm font-label-md text-label-md text-on-surface-variant uppercase"
                                                                >
                                                                    City / Municipality
                                                                </th>
                                                                <th
                                                                    class="py-sm font-label-md text-label-md text-on-surface-variant uppercase text-right"
                                                                >
                                                                    Count
                                                                </th>
                                                                <th
                                                                    class="py-sm font-label-md text-label-md text-on-surface-variant uppercase text-right"
                                                                >
                                                                    Growth
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr
                                                                class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors"
                                                            >
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm font-medium"
                                                                >
                                                                    Bacolod City
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right"
                                                                >
                                                                    18,200
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right text-emerald-600"
                                                                >
                                                                    +4.2%
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors"
                                                            >
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm font-medium"
                                                                >
                                                                    Silay City
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right"
                                                                >
                                                                    5,400
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right text-emerald-600"
                                                                >
                                                                    +3.1%
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors"
                                                            >
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm font-medium"
                                                                >
                                                                    Talisay City
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right"
                                                                >
                                                                    4,800
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right text-emerald-600"
                                                                >
                                                                    +2.8%
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors"
                                                            >
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm font-medium"
                                                                >
                                                                    Bago City
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right"
                                                                >
                                                                    4,100
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right text-accent-orange"
                                                                >
                                                                    +0.5%
                                                                </td>
                                                            </tr>
                                                            <tr
                                                                class="hover:bg-surface-container-low transition-colors"
                                                            >
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm font-medium"
                                                                >
                                                                    Victorias City
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right"
                                                                >
                                                                    3,200
                                                                </td>
                                                                <td
                                                                    class="py-md font-body-sm text-body-sm text-right text-emerald-600"
                                                                >
                                                                    +1.9%
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div
                                                class="lg:col-span-7 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm analytics-map-bg min-h-[400px] flex items-center justify-center overflow-hidden relative"
                                                data-location="Negros Occidental, Philippines"
                                            >
                                                <div
                                                    class="absolute inset-0 bg-primary/5 pointer-events-none"
                                                ></div>
                                                <div
                                                    class="bg-surface-container-lowest/90 backdrop-blur-md p-md rounded-lg shadow-xl border border-white max-w-xs"
                                                >
                                                    <h4
                                                        class="font-headline-sm text-headline-sm text-primary mb-xs"
                                                    >
                                                        Provincial Density
                                                    </h4>
                                                    <p
                                                        class="font-body-sm text-body-sm text-on-surface-variant"
                                                    >
                                                        Concentration of MSMEs by District across Negros
                                                        Occidental.
                                                    </p>
                                                    <div class="mt-md space-y-2">
                                                        <div
                                                            class="flex justify-between items-center text-body-sm"
                                                        >
                                                            <span class="">District 1-3 (North)</span
                                                            ><span class="font-bold">48%</span>
                                                        </div>
                                                        <div
                                                            class="w-full bg-surface-container-high h-1 rounded-full"
                                                        >
                                                            <div
                                                                class="bg-primary h-1 rounded-full"
                                                                style="width: 48%"
                                                            ></div>
                                                        </div>
                                                        <div
                                                            class="flex justify-between items-center text-body-sm"
                                                        >
                                                            <span class="">District 4-6 (South)</span
                                                            ><span class="font-bold">32%</span>
                                                        </div>
                                                        <div
                                                            class="w-full bg-surface-container-high h-1 rounded-full"
                                                        >
                                                            <div
                                                                class="bg-accent-orange h-1 rounded-full"
                                                                style="width: 32%"
                                                            ></div>
                                                        </div>
                                                        <div
                                                            class="flex justify-between items-center text-body-sm"
                                                        >
                                                            <span class="">Bacolod (HUC)</span
                                                            ><span class="font-bold">20%</span>
                                                        </div>
                                                        <div
                                                            class="w-full bg-surface-container-high h-1 rounded-full"
                                                        >
                                                            <div
                                                                class="bg-secondary h-1 rounded-full"
                                                                style="width: 20%"
                                                            ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 5. Digitalization Panel -->
                                        <div class="space-y-lg">
                                            <h3
                                                class="font-headline-sm text-headline-sm text-primary flex items-center gap-sm"
                                            >
                                                <span
                                                    class="material-symbols-outlined text-accent-orange"
                                                    >bolt</span
                                                >
                                                Digitalization Readiness
                                            </h3>
                                            <div
                                                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-md"
                                            >
                                                <div
                                                    class="bg-surface-container p-md rounded-xl border border-outline-variant/20"
                                                >
                                                    <p
                                                        class="font-label-md text-label-md text-on-surface-variant"
                                                    >
                                                        Email
                                                    </p>
                                                    <div class="flex items-end justify-between mt-sm">
                                                        <span
                                                            class="font-headline-md text-headline-md text-primary"
                                                            >82%</span
                                                        >
                                                        <span
                                                            class="material-symbols-outlined text-primary/40"
                                                            >mail</span
                                                        >
                                                    </div>
                                                </div>
                                                <div
                                                    class="bg-surface-container p-md rounded-xl border border-outline-variant/20"
                                                >
                                                    <p
                                                        class="font-label-md text-label-md text-on-surface-variant"
                                                    >
                                                        Mobile
                                                    </p>
                                                    <div class="flex items-end justify-between mt-sm">
                                                        <span
                                                            class="font-headline-md text-headline-md text-primary"
                                                            >95%</span
                                                        >
                                                        <span
                                                            class="material-symbols-outlined text-primary/40"
                                                            >smartphone</span
                                                        >
                                                    </div>
                                                </div>
                                                <div
                                                    class="bg-surface-container p-md rounded-xl border border-outline-variant/20"
                                                >
                                                    <p
                                                        class="font-label-md text-label-md text-on-surface-variant"
                                                    >
                                                        Website
                                                    </p>
                                                    <div class="flex items-end justify-between mt-sm">
                                                        <span
                                                            class="font-headline-md text-headline-md text-primary"
                                                            >40%</span
                                                        >
                                                        <span
                                                            class="material-symbols-outlined text-primary/40"
                                                            >language</span
                                                        >
                                                    </div>
                                                </div>
                                                <div
                                                    class="bg-surface-container p-md rounded-xl border border-outline-variant/20"
                                                >
                                                    <p
                                                        class="font-label-md text-label-md text-on-surface-variant"
                                                    >
                                                        Social Media
                                                    </p>
                                                    <div class="flex items-end justify-between mt-sm">
                                                        <span
                                                            class="font-headline-md text-headline-md text-primary"
                                                            >75%</span
                                                        >
                                                        <span
                                                            class="material-symbols-outlined text-primary/40"
                                                            >share</span
                                                        >
                                                    </div>
                                                </div>
                                                <div
                                                    class="bg-surface-container p-md rounded-xl border border-outline-variant/20"
                                                >
                                                    <p
                                                        class="font-label-md text-label-md text-on-surface-variant"
                                                    >
                                                        E-Commerce
                                                    </p>
                                                    <div class="flex items-end justify-between mt-sm">
                                                        <span
                                                            class="font-headline-md text-headline-md text-primary"
                                                            >35%</span
                                                        >
                                                        <span
                                                            class="material-symbols-outlined text-primary/40"
                                                            >shopping_cart</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
                                                <div
                                                    class="lg:col-span-4 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm"
                                                >
                                                    <p
                                                        class="font-label-lg text-label-lg mb-xl text-on-surface-variant"
                                                    >
                                                        Digitalization Level
                                                    </p>
                                                    <div class="space-y-xl">
                                                        <div>
                                                            <div
                                                                class="flex justify-between mb-xs text-body-sm"
                                                            >
                                                                <span class="">High Adoption</span>
                                                                <span class="font-bold">22%</span>
                                                            </div>
                                                            <div
                                                                class="w-full bg-surface-container-high h-3 rounded-full overflow-hidden"
                                                            >
                                                                <div
                                                                    class="bg-emerald-600 h-full"
                                                                    style="width: 22%"
                                                                ></div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div
                                                                class="flex justify-between mb-xs text-body-sm"
                                                            >
                                                                <span class="">Medium Adoption</span>
                                                                <span class="font-bold">48%</span>
                                                            </div>
                                                            <div
                                                                class="w-full bg-surface-container-high h-3 rounded-full overflow-hidden"
                                                            >
                                                                <div
                                                                    class="bg-primary h-full"
                                                                    style="width: 48%"
                                                                ></div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div
                                                                class="flex justify-between mb-xs text-body-sm"
                                                            >
                                                                <span class="">Low Adoption</span>
                                                                <span class="font-bold">30%</span>
                                                            </div>
                                                            <div
                                                                class="w-full bg-surface-container-high h-3 rounded-full overflow-hidden"
                                                            >
                                                                <div
                                                                    class="bg-accent-orange h-full"
                                                                    style="width: 30%"
                                                                ></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="lg:col-span-8 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm"
                                                >
                                                    <p
                                                        class="font-label-lg text-label-lg mb-xl text-on-surface-variant"
                                                    >
                                                        Digital Tool Adoption Rate
                                                    </p>
                                                    <div class="chart-container">
                                                        <canvas
                                                            id="digitalToolChart"
                                                            width="721"
                                                            height="375"
                                                            style="
                                                                display: block;
                                                                box-sizing: border-box;
                                                                height: 300px;
                                                                width: 577.1px;
                                                            "
                                                        ></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 6. Client Growth Over Time -->
                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
                                            <div
                                                class="lg:col-span-12 bg-surface-container-lowest p-xl rounded-xl border border-outline-variant/30 shadow-sm"
                                            >
                                                <h3
                                                    class="font-headline-sm text-headline-sm text-primary mb-xl flex items-center gap-sm"
                                                >
                                                    <span
                                                        class="material-symbols-outlined text-accent-orange"
                                                        >timeline</span
                                                    >
                                                    Registration &amp; Activity Trends
                                                </h3>
                                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl">
                                                    <div class="chart-container">
                                                        <canvas
                                                            id="growthChart"
                                                            width="549"
                                                            height="375"
                                                            style="
                                                                display: block;
                                                                box-sizing: border-box;
                                                                height: 300px;
                                                                width: 439.2px;
                                                            "
                                                        ></canvas>
                                                    </div>
                                                    <div class="chart-container">
                                                        <canvas
                                                            id="activityChart"
                                                            width="549"
                                                            height="375"
                                                            style="
                                                                display: block;
                                                                box-sizing: border-box;
                                                                height: 300px;
                                                                width: 439.2px;
                                                            "
                                                        ></canvas>
                                                    </div>
                                                </div>
                                            </div>
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
                            @endif
                            @php
                                $verificationFilterClients = $verificationClients->getCollection()->merge($returnedClients->getCollection());
                                $verificationCategories = $verificationFilterClients
                                    ->pluck('category_of_client')
                                    ->filter()
                                    ->unique()
                                    ->sort()
                                    ->values();
                                $verificationSurveyors = $verificationFilterClients
                                    ->pluck('surveyed_by')
                                    ->filter()
                                    ->unique()
                                    ->mapWithKeys(fn ($surveyorId) => [$surveyorId => $surveyorNames[$surveyorId] ?? 'Unknown Surveyor'])
                                    ->sort()
                                    ->all();
                            @endphp
                            <!-- Filter Bar -->
                            <div
                                class="bg-surface-container-lowest rounded-xl border border-outline-variant/15 p-md flex flex-wrap gap-md items-center"
                            >
                                <div class="flex-1 min-w-[260px]">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="verification-search-filter">Search</label>
                                    <div class="flex items-center border border-outline-variant rounded-lg px-md bg-surface-container-low focus-within:border-primary focus-within:ring-1 focus-within:ring-primary">
                                        <span class="material-symbols-outlined text-on-surface-variant text-[20px]">search</span>
                                        <input
                                            id="verification-search-filter"
                                            type="text"
                                            class="w-full py-2 px-sm border-none bg-transparent focus:ring-0 text-body-sm"
                                            placeholder="Name, client ID, surveyor, category, or status"
                                        />
                                    </div>
                                </div>
                                <div class="w-44">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="verification-status-filter">Status</label>
                                    <select
                                        id="verification-status-filter"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-2 text-body-sm focus:ring-2 focus:ring-primary/20"
                                    >
                                        <option value="">All Statuses</option>
                                        <option value="pending">Pending</option>
                                        <option value="returned">Returned</option>
                                    </select>
                                </div>
                                <div class="w-56">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="verification-category-filter">Category</label>
                                    <select
                                        id="verification-category-filter"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-2 text-body-sm focus:ring-2 focus:ring-primary/20"
                                    >
                                        <option value="">All Categories</option>
                                        @foreach ($verificationCategories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-56">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="verification-surveyor-filter">Surveyor</label>
                                    <select
                                        id="verification-surveyor-filter"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-2 text-body-sm focus:ring-2 focus:ring-primary/20"
                                    >
                                        <option value="">All Surveyors</option>
                                        @foreach ($verificationSurveyors as $surveyorId => $surveyorName)
                                            <option value="{{ $surveyorId }}">{{ $surveyorName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-44">
                                    <label class="block text-label-md font-label-md text-on-surface-variant mb-xs" for="verification-date-sort">Sort</label>
                                    <select
                                        id="verification-date-sort"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-md py-2 text-body-sm focus:ring-2 focus:ring-primary/20"
                                    >
                                        <option value="newest">Newest First</option>
                                        <option value="oldest">Oldest First</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-sm">
                                    <button
                                        type="button"
                                        class="flex items-center gap-xs px-md py-2 border border-outline text-on-surface rounded-lg hover:bg-surface-container-low transition-all text-label-lg font-label-lg"
                                    >
                                        <span
                                            class="material-symbols-outlined text-[18px]"
                                            >download</span
                                        >
                                        Export
                                    </button>
                                </div>
                                <span id="verification-filter-count" class="text-body-sm text-on-surface-variant ml-auto"></span>
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
                                                <tr class="zebra-stripe hover:bg-surface-container transition-colors group cursor-pointer"
                                                    data-admin-client-id="{{ $client->id }}"
                                                    data-admin-client-mode="view"
                                                    data-admin-client-url="{{ route('admin.clients.show', $client) }}"
                                                    data-admin-filter-row="verification"
                                                    data-filter-search="{{ $clientName }} {{ $client->client_id }} {{ $surveyorName }} {{ $client->category_of_client }} {{ $status }}"
                                                    data-filter-category="{{ $client->category_of_client }}"
                                                    data-filter-status="{{ $status }}"
                                                    data-filter-surveyor="{{ $client->surveyed_by }}"
                                                    data-filter-date="{{ optional($client->created_at)->timestamp ?? 0 }}">
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
                                            <tr class="hidden" data-admin-filter-empty="verification">
                                                <td class="px-lg py-xxl text-center text-on-surface-variant" colspan="7">
                                                    No pending clients match the selected filters.
                                                </td>
                                            </tr>
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
                                                <tr class="zebra-stripe hover:bg-surface-container transition-colors group cursor-pointer"
                                                    data-admin-client-id="{{ $client->id }}"
                                                    data-admin-client-mode="view"
                                                    data-admin-client-url="{{ route('admin.clients.show', $client) }}"
                                                    data-admin-filter-row="verification"
                                                    data-filter-search="{{ $clientName }} {{ $client->client_id }} {{ $surveyorName }} {{ $client->category_of_client }} returned"
                                                    data-filter-category="{{ $client->category_of_client }}"
                                                    data-filter-status="returned"
                                                    data-filter-surveyor="{{ $client->surveyed_by }}"
                                                    data-filter-date="{{ optional($client->updated_at)->timestamp ?? 0 }}">
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
                                            <tr class="hidden" data-admin-filter-empty="verification">
                                                <td class="px-lg py-xxl text-center text-on-surface-variant" colspan="5">
                                                    No returned clients match the selected filters.
                                                </td>
                                            </tr>
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
        <!-- Reusable Client Details Modal -->
        <div
            id="admin-client-modal"
            class="fixed inset-0 bg-on-background/50 backdrop-blur-sm z-[110] hidden items-center justify-center p-md"
        >
            <div class="bg-surface-container-lowest rounded-xl w-full max-w-5xl max-h-[92vh] shadow-2xl border border-outline-variant/20 flex flex-col overflow-hidden">
                <div class="flex items-start justify-between gap-lg px-lg py-md border-b border-outline-variant bg-surface-container-low">
                    <div>
                        <div class="flex items-center gap-sm">
                            <span id="admin-client-modal-icon" class="material-symbols-outlined text-primary">person_search</span>
                            <h3 id="admin-client-modal-title" class="font-headline-sm text-headline-sm text-primary">Client Record</h3>
                        </div>
                        <p id="admin-client-modal-subtitle" class="text-body-sm text-on-surface-variant mt-xs">Loading client details...</p>
                    </div>
                    <button id="admin-client-modal-close" type="button" class="p-xs rounded-full hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant">close</span>
                    </button>
                </div>
                <div id="admin-client-modal-status" class="hidden mx-lg mt-md rounded-lg border px-md py-sm text-body-sm font-bold"></div>
                <div class="overflow-y-auto flex-1 p-lg">
                    <form id="admin-client-form" class="space-y-xl"></form>
                </div>
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-md px-lg py-md border-t border-outline-variant bg-surface-container-lowest">
                    <div id="admin-client-modal-mode" class="text-body-sm text-on-surface-variant">Read-only</div>
                    <div class="flex flex-wrap justify-end gap-sm">
                        <div id="admin-client-status-actions" class="hidden flex flex-wrap justify-end gap-sm"></div>
                        <button id="admin-client-modal-cancel" type="button" class="px-lg py-sm border border-outline-variant text-on-surface-variant rounded-lg hover:bg-surface-container-high font-bold">
                            Close
                        </button>
                        <button id="admin-client-modal-save" type="button" class="hidden px-lg py-sm bg-primary text-on-primary rounded-lg hover:opacity-90 font-bold">
                            Save Changes
                        </button>
                    </div>
                </div>
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
            <button
                class="admin-nav-link flex flex-col items-center gap-xs text-on-surface-variant"
                type="button"
                data-admin-view="analytics"
            >
                <span class="material-symbols-outlined" data-icon="analytics"
                    >analytics</span
                >
                <span class="text-[10px] font-label-md">Data</span>
            </button>
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
        <script src="{{ asset('js/map-style-control.js') }}?v=20260529-2"></script>
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

            function normalizeAdminFilterText(value) {
                return String(value ?? "").trim().toLowerCase();
            }

            function bindAdminClientTableFilters() {
                const configs = [
                    {
                        scope: "dashboard",
                        search: document.getElementById("admin-dashboard-search"),
                        category: document.getElementById("admin-dashboard-category-filter"),
                        surveyor: document.getElementById("admin-dashboard-surveyor-filter"),
                        sort: document.getElementById("admin-dashboard-sort"),
                        count: document.getElementById("admin-dashboard-filter-count"),
                        label: "verified clients",
                    },
                    {
                        scope: "verification",
                        search: document.getElementById("verification-search-filter"),
                        category: document.getElementById("verification-category-filter"),
                        status: document.getElementById("verification-status-filter"),
                        surveyor: document.getElementById("verification-surveyor-filter"),
                        sort: document.getElementById("verification-date-sort"),
                        count: document.getElementById("verification-filter-count"),
                        label: "submissions",
                    },
                ];

                const rowsForScope = (scope) => Array.from(document.querySelectorAll(`[data-admin-filter-row="${scope}"]`));

                function sortRows(rows, direction) {
                    const groupedRows = new Map();
                    rows.forEach((row) => {
                        const tbody = row.parentElement;
                        if (!tbody) return;
                        if (!groupedRows.has(tbody)) groupedRows.set(tbody, []);
                        groupedRows.get(tbody).push(row);
                    });

                    groupedRows.forEach((tbodyRows, tbody) => {
                        tbodyRows
                            .sort((a, b) => {
                                const aDate = Number(a.dataset.filterDate || 0);
                                const bDate = Number(b.dataset.filterDate || 0);
                                return direction === "oldest" ? aDate - bDate : bDate - aDate;
                            })
                            .forEach((row) => tbody.appendChild(row));
                    });
                }

                function rowMatches(row, config) {
                    const searchTerm = normalizeAdminFilterText(config.search?.value);
                    const category = normalizeAdminFilterText(config.category?.value);
                    const status = normalizeAdminFilterText(config.status?.value);
                    const surveyor = normalizeAdminFilterText(config.surveyor?.value);

                    if (searchTerm && !normalizeAdminFilterText(row.dataset.filterSearch).includes(searchTerm)) return false;
                    if (category && normalizeAdminFilterText(row.dataset.filterCategory) !== category) return false;
                    if (status && normalizeAdminFilterText(row.dataset.filterStatus) !== status) return false;
                    if (surveyor && normalizeAdminFilterText(row.dataset.filterSurveyor) !== surveyor) return false;

                    return true;
                }

                function updateEmptyRows(rows, config) {
                    const tbodies = [...new Set(rows.map((row) => row.parentElement).filter(Boolean))];
                    tbodies.forEach((tbody) => {
                        const bodyRows = rows.filter((row) => row.parentElement === tbody);
                        const visibleRows = bodyRows.filter((row) => !row.classList.contains("hidden"));
                        const emptyRow = tbody.querySelector(`[data-admin-filter-empty="${config.scope}"]`);
                        emptyRow?.classList.toggle("hidden", !(bodyRows.length > 0 && visibleRows.length === 0));
                    });
                }

                function applyFilters(config) {
                    const rows = rowsForScope(config.scope);
                    const sortDirection = config.sort?.value || "newest";
                    let visibleCount = 0;

                    sortRows(rows, sortDirection);

                    rows.forEach((row) => {
                        const matches = rowMatches(row, config);
                        row.classList.toggle("hidden", !matches);
                        if (matches) visibleCount += 1;
                    });

                    updateEmptyRows(rows, config);

                    if (config.count) {
                        config.count.textContent = `Showing ${visibleCount.toLocaleString()} of ${rows.length.toLocaleString()} ${config.label}`;
                    }
                }

                configs.forEach((config) => {
                    if (!config.search && !config.category && !config.status && !config.surveyor && !config.sort) return;

                    [config.search, config.category, config.status, config.surveyor, config.sort]
                        .filter(Boolean)
                        .forEach((control) => {
                            const eventName = control.tagName === "INPUT" ? "input" : "change";
                            control.addEventListener(eventName, () => applyFilters(config));
                        });

                    applyFilters(config);
                });
            }

            const fallbackMapStyle = "https://basemaps.cartocdn.com/gl/positron-gl-style/style.json";

            function getInitialMapStyle() {
                return window.IpssMapStyles?.getStyle() || fallbackMapStyle;
            }

            function addMapStyleChooser(map, restoreLayers) {
                if (!window.IpssMapStyles) return;

                map.addControl(window.IpssMapStyles.createControl({
                    initialStyle: window.IpssMapStyles.getPreference(),
                    onChange: (styleKey, activeMap) => {
                        restoreMapLayersAfterStyleChange(activeMap, restoreLayers);
                        activeMap.setStyle(window.IpssMapStyles.getStyle(styleKey));
                    },
                }), "top-right");
            }

            function restoreMapLayersAfterStyleChange(map, restoreLayers) {
                if (typeof restoreLayers !== "function") return;

                let restored = false;
                const restore = () => {
                    if (restored) return;
                    if (typeof map.isStyleLoaded === "function" && !map.isStyleLoaded()) return;

                    restored = true;
                    requestAnimationFrame(() => restoreLayers());
                };

                map.once("style.load", restore);
                map.once("idle", restore);
                setTimeout(restore, 300);
                [900, 1800, 3000].forEach((delay) => {
                    setTimeout(() => restoreLayers(), delay);
                });
            }

            function addMapSourceIfMissing(map, sourceId, source) {
                if (map.getSource(sourceId)) return true;

                try {
                    map.addSource(sourceId, source);
                    return true;
                } catch (error) {
                    console.warn(`Unable to add map source: ${sourceId}`, error);
                    return false;
                }
            }

            function addMapLayerIfMissing(map, layer) {
                if (map.getLayer(layer.id)) return;

                try {
                    map.addLayer(layer);
                } catch (error) {
                    console.warn(`Unable to add map layer: ${layer.id}`, error);
                }
            }

            const adminClientModal = document.getElementById("admin-client-modal");
            const adminClientForm = document.getElementById("admin-client-form");
            const adminClientModalTitle = document.getElementById("admin-client-modal-title");
            const adminClientModalSubtitle = document.getElementById("admin-client-modal-subtitle");
            const adminClientModalIcon = document.getElementById("admin-client-modal-icon");
            const adminClientModalStatus = document.getElementById("admin-client-modal-status");
            const adminClientModalMode = document.getElementById("admin-client-modal-mode");
            const adminClientStatusActions = document.getElementById("admin-client-status-actions");
            const adminClientModalSave = document.getElementById("admin-client-modal-save");
            const adminClientModalClose = document.getElementById("admin-client-modal-close");
            const adminClientModalCancel = document.getElementById("admin-client-modal-cancel");
            let activeAdminClient = null;
            let activeAdminClientMode = "view";

            const adminClientSections = [
                {
                    title: "Client Status & Classification",
                    icon: "category",
                    fields: [
                        ["statusOfClient", "Status of Client", "select", ["Level 0 - Would be or Potential Entrepreneurs", "New Registrant", "Renewal"]],
                        ["specifyLevel", "Specify Level", "select", ["Potential", "Other Clients Assisted"]],
                        ["categoryOfClient", "Category of Client", "text"],
                        ["socialClassification", "Social Classification", "select", ["Abled", "Person with Disabilities"]],
                        ["diffAbledType", "Differently-abled Type", "text"],
                        ["isSenior", "Senior Citizen", "select", ["No", "Yes"]],
                        ["isIndigeneous", "Indigenous People", "select", ["No", "Yes"]],
                        ["msmeClassification", "MSME Classification", "select", ["Large - More than Php 100,000,000", "Medium - Php 15,000,001 to Php 100,000,000", "Micro - Up to Php 3,000,000", "Not Applicable - Would-be/Potential Entrepreneur", "Small - Php 3,000,001 to Php 15,000,000"]],
                        ["clientDesignation", "Client Designation", "select", ["Owner", "Representative"]],
                    ],
                },
                {
                    title: "Digitalization",
                    icon: "devices",
                    fields: [
                        ["levelOfDigitalization", "Level of Digitalization", "select", ["Level 0 - No use of digital tools", "Level 1 (Basic) - MSMEs that use basic digital tools for business", "Level 2 (Intermediate) - MSMEs that have an online presence", "Level 3 (Advanced) - Use of advanced digital tools"]],
                        ["digitalTools", "Digital Tools", "text"],
                    ],
                },
                {
                    title: "Personal Information",
                    icon: "person",
                    fields: [
                        ["firstName", "First Name", "text"],
                        ["middleName", "Middle Name", "text"],
                        ["lastName", "Last Name", "text"],
                        ["suffix", "Suffix", "select", ["--N/A--", "SR", "JR", "I", "II", "III", "IV", "V"]],
                        ["sex", "Sex", "select", ["Male", "Female"]],
                        ["civilStatus", "Civil Status", "select", ["Legally Separated", "Married", "Single", "Widowed"]],
                        ["birthdate", "Birthdate", "date"],
                        ["citizenship", "Citizenship", "text"],
                    ],
                },
                {
                    title: "Identifiers",
                    icon: "badge",
                    fields: [
                        ["philippineIdentificationSystem", "PhilSys ID", "text"],
                    ],
                },
                {
                    title: "Contact Details",
                    icon: "call",
                    fields: [
                        ["mobileNumber", "Mobile Number", "text"],
                        ["emailAddress", "Email Address", "email"],
                        ["landlineNumber", "Landline Number", "text"],
                        ["faxNumber", "Fax Number", "text"],
                        ["socialMedia", "Social Media", "text"],
                        ["website", "Website", "text"],
                        ["eCommercePlatform", "E-Commerce Platform", "text"],
                    ],
                },
                {
                    title: "Location",
                    icon: "location_on",
                    fields: [
                        ["regionCode", "Region", "text"],
                        ["provinceCode", "Province", "text"],
                        ["cityMunicipalityCode", "City / Municipality Code", "text"],
                        ["barangayCode", "Barangay Code", "text"],
                        ["district", "District", "text"],
                        ["zipCode", "Zip Code", "text"],
                        ["address", "Full Address", "textarea"],
                        ["latitude", "Latitude", "text"],
                        ["longitude", "Longitude", "text"],
                    ],
                },
            ];

            function adminClientInput(name, label, type, options, value, readonly) {
                const disabled = readonly ? "disabled" : "";
                const baseClass = readonly
                    ? "p-md border border-outline-variant rounded-lg bg-surface-container text-body-sm text-on-surface-variant"
                    : "p-md border border-outline rounded-lg bg-surface-bright text-body-sm focus:border-primary focus:ring-primary";

                if (type === "textarea") {
                    return `
                        <div class="flex flex-col gap-xs md:col-span-2">
                            <label class="text-label-md font-label-md text-on-surface-variant">${label}</label>
                            <textarea data-admin-client-field="${name}" rows="2" ${disabled} class="${baseClass}">${escapeHtml(value)}</textarea>
                        </div>
                    `;
                }

                if (type === "select") {
                    const values = Array.isArray(options) ? options : [];
                    const selectedValue = String(value ?? "");
                    const optionMarkup = ["", ...values]
                        .filter((option, index, arr) => arr.indexOf(option) === index)
                        .map((option) => `<option value="${escapeHtml(option)}" ${String(option) === selectedValue ? "selected" : ""}>${escapeHtml(option || "Select...")}</option>`)
                        .join("");

                    return `
                        <div class="flex flex-col gap-xs">
                            <label class="text-label-md font-label-md text-on-surface-variant">${label}</label>
                            <select data-admin-client-field="${name}" ${disabled} class="${baseClass}">${optionMarkup}</select>
                        </div>
                    `;
                }

                return `
                    <div class="flex flex-col gap-xs">
                        <label class="text-label-md font-label-md text-on-surface-variant">${label}</label>
                        <input data-admin-client-field="${name}" type="${type}" value="${escapeHtml(value)}" ${disabled} class="${baseClass}" />
                    </div>
                `;
            }

            function renderAdminClientForm(client, mode) {
                const readonly = mode !== "edit";
                const data = client.data || {};
                adminClientForm.innerHTML = adminClientSections.map((section) => `
                    <fieldset>
                        <legend class="flex items-center gap-sm mb-md pb-xs border-b border-outline-variant w-full">
                            <span class="material-symbols-outlined text-primary text-[18px]">${section.icon}</span>
                            <span class="text-label-lg font-label-lg text-primary">${section.title}</span>
                        </legend>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                            ${section.fields.map(([name, label, type, options]) => adminClientInput(name, label, type, options, data[name] ?? "", readonly)).join("")}
                        </div>
                    </fieldset>
                `).join("");
            }

            function setAdminClientModalStatus(message, type = "info") {
                adminClientModalStatus.textContent = message || "";
                adminClientModalStatus.className = "hidden mx-lg mt-md rounded-lg border px-md py-sm text-body-sm font-bold";
                if (!message) return;

                adminClientModalStatus.classList.remove("hidden");
                if (type === "error") {
                    adminClientModalStatus.classList.add("border-red-300", "bg-red-50", "text-red-700");
                } else if (type === "success") {
                    adminClientModalStatus.classList.add("border-green-300", "bg-green-50", "text-green-700");
                } else {
                    adminClientModalStatus.classList.add("border-blue-300", "bg-blue-50", "text-blue-700");
                }
            }

            function renderAdminClientStatusActions(client, mode) {
                adminClientStatusActions.innerHTML = "";
                adminClientStatusActions.classList.add("hidden");
                if (mode === "edit") return;

                const status = client.survey_status || "pending";
                const actions = [];
                if (status === "pending") {
                    actions.push(["verified", "Verify", "verified", "bg-green-700"]);
                    actions.push(["returned", "Return", "assignment_return", "bg-primary"]);
                    actions.push(["rejected", "Reject", "cancel", "bg-red-700"]);
                } else if (status === "returned") {
                    actions.push(["pending", "Set Pending", "pending_actions", "bg-amber-700"]);
                    actions.push(["rejected", "Reject", "cancel", "bg-red-700"]);
                }

                if (actions.length === 0) return;

                adminClientStatusActions.classList.remove("hidden");
                actions.forEach(([statusValue, label, icon, colorClass]) => {
                    const button = document.createElement("button");
                    button.type = "button";
                    button.className = `inline-flex items-center gap-xs px-md py-sm ${colorClass} text-white rounded-lg font-bold hover:opacity-90`;
                    button.innerHTML = `<span class="material-symbols-outlined text-[18px]">${icon}</span>${label}`;
                    button.addEventListener("click", () => updateAdminClientStatus(client, statusValue, button));
                    adminClientStatusActions.appendChild(button);
                });
            }

            async function openAdminClientModal(url, mode = "view") {
                activeAdminClient = null;
                activeAdminClientMode = mode;
                adminClientModal.classList.remove("hidden");
                adminClientModal.classList.add("flex");
                adminClientModalSave.classList.toggle("hidden", mode !== "edit");
                adminClientModalMode.textContent = mode === "edit"
                    ? "Editable from Dashboard"
                    : "Read-only in Verification Queue";
                adminClientModalTitle.textContent = "Client Record";
                adminClientModalSubtitle.textContent = "Loading client details...";
                adminClientModalIcon.textContent = mode === "edit" ? "edit_note" : "visibility";
                adminClientForm.innerHTML = "";
                renderAdminClientStatusActions({ survey_status: "loading" }, mode);
                setAdminClientModalStatus("");

                try {
                    const response = await fetch(`${url}${url.includes("?") ? "&" : "?"}ts=${Date.now()}`, {
                        headers: { "Accept": "application/json" },
                        cache: "no-store",
                    });
                    if (!response.ok) throw new Error(`Server responded with ${response.status}`);

                    const payload = await response.json();
                    activeAdminClient = payload.client;
                    adminClientModalTitle.textContent = activeAdminClient.name;
                    adminClientModalSubtitle.textContent = `Ref: ${activeAdminClient.client_id || "Auto-generated"} | Status: ${activeAdminClient.survey_status || "pending"}`;
                    renderAdminClientForm(activeAdminClient, mode);
                    renderAdminClientStatusActions(activeAdminClient, mode);
                } catch (error) {
                    console.error("Failed to load client:", error);
                    setAdminClientModalStatus("Unable to load this client record.", "error");
                }
            }

            function closeAdminClientModal() {
                adminClientModal.classList.add("hidden");
                adminClientModal.classList.remove("flex");
                activeAdminClient = null;
            }

            function collectAdminClientFormData() {
                const data = {};
                adminClientForm.querySelectorAll("[data-admin-client-field]").forEach((field) => {
                    data[field.dataset.adminClientField] = field.value;
                });
                return data;
            }

            async function saveAdminClient() {
                if (!activeAdminClient || activeAdminClientMode !== "edit") return;

                const originalText = adminClientModalSave.textContent;
                adminClientModalSave.disabled = true;
                adminClientModalSave.textContent = "Saving...";
                setAdminClientModalStatus("");

                try {
                    const response = await fetch(activeAdminClient.urls.update, {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content"),
                        },
                        body: JSON.stringify(collectAdminClientFormData()),
                    });
                    if (!response.ok) throw new Error(`Server responded with ${response.status}`);

                    const payload = await response.json();
                    activeAdminClient = payload.client;
                    adminClientModalTitle.textContent = activeAdminClient.name;
                    adminClientModalSubtitle.textContent = `Ref: ${activeAdminClient.client_id || "Auto-generated"} | Status: ${activeAdminClient.survey_status || "pending"}`;
                    setAdminClientModalStatus("Client record updated.", "success");
                    fetchDashboardVerifiedLocations();
                } catch (error) {
                    console.error("Failed to update client:", error);
                    setAdminClientModalStatus("Unable to save changes. Please try again.", "error");
                } finally {
                    adminClientModalSave.disabled = false;
                    adminClientModalSave.textContent = originalText;
                }
            }

            async function updateAdminClientStatus(client, statusValue, button = null) {
                if (!client?.urls?.status) return;
                if (!confirm(`Set this client to ${statusValue}?`)) return;

                const buttons = Array.from(adminClientStatusActions.querySelectorAll("button"));
                const originalLabel = button?.innerHTML;
                buttons.forEach((actionButton) => {
                    actionButton.disabled = true;
                    actionButton.classList.add("opacity-60", "cursor-not-allowed");
                });
                if (button) {
                    button.innerHTML = `<span class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>Saving`;
                }
                setAdminClientModalStatus("");

                try {
                    const response = await fetch(client.urls.status, {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content"),
                        },
                        body: JSON.stringify({ survey_status: statusValue }),
                    });
                    const payload = await response.json().catch(() => ({}));
                    if (!response.ok) throw new Error(payload.message || `Server responded with ${response.status}`);

                    activeAdminClient = payload.client || activeAdminClient;
                    setAdminClientModalStatus(payload.message || "Verification status updated.", "success");
                    renderAdminClientStatusActions(activeAdminClient, activeAdminClientMode);

                    setTimeout(() => {
                        const verificationUrl = "{{ route('admin') }}#verification";
                        if (window.location.href === verificationUrl) {
                            window.location.reload();
                        } else {
                            window.location.href = verificationUrl;
                        }
                    }, 350);
                } catch (error) {
                    console.error("Failed to update client status:", error);
                    setAdminClientModalStatus(error.message || "Unable to update verification status.", "error");
                    buttons.forEach((actionButton) => {
                        actionButton.disabled = false;
                        actionButton.classList.remove("opacity-60", "cursor-not-allowed");
                    });
                    if (button && originalLabel) {
                        button.innerHTML = originalLabel;
                    }
                }
            }

            adminClientModalClose?.addEventListener("click", closeAdminClientModal);
            adminClientModalCancel?.addEventListener("click", closeAdminClientModal);
            adminClientModalSave?.addEventListener("click", saveAdminClient);
            adminClientModal?.addEventListener("click", (event) => {
                if (event.target === adminClientModal) closeAdminClientModal();
            });

            document.addEventListener("click", (event) => {
                const row = event.target.closest("[data-admin-client-id]");
                if (!row) return;
                if (event.target.closest("button, a, input, select, textarea, label, form")) return;

                const panel = row.closest("[data-admin-panel]");
                const mode = row.dataset.adminClientMode === "edit" && panel?.dataset.adminPanel === "dashboard" ? "edit" : "view";
                openAdminClientModal(row.dataset.adminClientUrl, mode);
            });

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
                    style: getInitialMapStyle(),
                    center: [122.9509, 10.6765],
                    zoom: 9,
                    minZoom: 8,
                    maxZoom: 19,
                    maxBounds: paddedBounds,
                    attributionControl: true,
                });

                adminSurveyorMap.addControl(new maplibregl.NavigationControl(), "top-right");

                const setupSurveyorMapLayers = ({ fit = false } = {}) => {
                    adminSurveyorMapLoaded = true;

                    const sourceReady = addMapSourceIfMissing(adminSurveyorMap, "surveyors", {
                        type: "geojson",
                        data: buildSurveyorLocationGeoJson(),
                    });
                    if (!sourceReady) return;

                    if (!adminSurveyorMap.getLayer("surveyor-presence-halo")) {
                        addMapLayerIfMissing(adminSurveyorMap, {
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
                    }

                    if (!adminSurveyorMap.getLayer("surveyor-presence-point")) {
                        addMapLayerIfMissing(adminSurveyorMap, {
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
                    }

                    refreshSurveyorMapSource({ fit });
                };

                addMapStyleChooser(adminSurveyorMap, setupSurveyorMapLayers);

                let surveyorMapEventsBound = false;
                const bindSurveyorMapEvents = () => {
                    if (surveyorMapEventsBound) return;
                    surveyorMapEventsBound = true;

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
                };

                adminSurveyorMap.on("style.load", () => setupSurveyorMapLayers());
                adminSurveyorMap.on("load", () => {
                    setupSurveyorMapLayers({ fit: true });
                    bindSurveyorMapEvents();
                });
            }

            async function fetchSurveyorLocations({ fit = false } = {}) {
                try {
                    const response = await fetch("{{ route('admin.surveyor-locations') }}?ts=" + Date.now(), {
                        headers: { "Accept": "application/json" },
                        cache: "no-store",
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
                    style: getInitialMapStyle(),
                    center: [122.9509, 10.6765],
                    zoom: 9,
                    minZoom: 8,
                    maxZoom: 19,
                    maxBounds: paddedBounds,
                    attributionControl: true,
                });

                verificationClientMap.addControl(new maplibregl.NavigationControl(), "top-right");

                const setupVerificationClientMapLayers = ({ fit = false } = {}) => {
                    verificationClientMapLoaded = true;

                    const sourceReady = addMapSourceIfMissing(verificationClientMap, "verification-clients", {
                        type: "geojson",
                        data: buildVerificationClientMapGeoJson(),
                        cluster: true,
                        clusterMaxZoom: 14,
                        clusterRadius: 50,
                    });
                    if (!sourceReady) return;

                    if (!verificationClientMap.getLayer("verification-client-clusters")) {
                        addMapLayerIfMissing(verificationClientMap, {
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
                    }

                    if (!verificationClientMap.getLayer("verification-client-cluster-count")) {
                        addMapLayerIfMissing(verificationClientMap, {
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
                    }

                    if (!verificationClientMap.getLayer("verification-client-point")) {
                        addMapLayerIfMissing(verificationClientMap, {
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
                    }

                    refreshVerificationClientMapSource({ fit });
                };

                addMapStyleChooser(verificationClientMap, setupVerificationClientMapLayers);

                let verificationClientMapEventsBound = false;
                const bindVerificationClientMapEvents = () => {
                    if (verificationClientMapEventsBound) return;
                    verificationClientMapEventsBound = true;

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

                        if (props.id) {
                            openAdminClientModal(`/admin/clients/${props.id}`, "view");
                        }
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
                };

                verificationClientMap.on("style.load", () => setupVerificationClientMapLayers());
                verificationClientMap.on("load", () => {
                    setupVerificationClientMapLayers({ fit: true });
                    bindVerificationClientMapEvents();
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
                    style: getInitialMapStyle(),
                    center: [122.9509, 10.6765],
                    zoom: 9,
                    minZoom: 8,
                    maxZoom: 19,
                    maxBounds: paddedBounds,
                    attributionControl: true,
                });

                dashboardVerifiedMap.addControl(new maplibregl.NavigationControl(), "top-right");

                const setupDashboardVerifiedMapLayers = ({ fit = false } = {}) => {
                    dashboardVerifiedMapLoaded = true;

                    const sourceReady = addMapSourceIfMissing(dashboardVerifiedMap, "dashboard-verified-clients", {
                        type: "geojson",
                        data: buildDashboardVerifiedMapGeoJson(),
                        cluster: true,
                        clusterMaxZoom: 14,
                        clusterRadius: 50,
                    });
                    if (!sourceReady) return;

                    if (!dashboardVerifiedMap.getLayer("dashboard-verified-clusters")) {
                        addMapLayerIfMissing(dashboardVerifiedMap, {
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
                    }

                    if (!dashboardVerifiedMap.getLayer("dashboard-verified-cluster-count")) {
                        addMapLayerIfMissing(dashboardVerifiedMap, {
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
                    }

                    if (!dashboardVerifiedMap.getLayer("dashboard-verified-point-halo")) {
                        addMapLayerIfMissing(dashboardVerifiedMap, {
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
                    }

                    if (!dashboardVerifiedMap.getLayer("dashboard-verified-point")) {
                        addMapLayerIfMissing(dashboardVerifiedMap, {
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
                    }

                    refreshDashboardVerifiedMapSource({ fit });
                };

                addMapStyleChooser(dashboardVerifiedMap, setupDashboardVerifiedMapLayers);

                let dashboardVerifiedMapEventsBound = false;
                const bindDashboardVerifiedMapEvents = () => {
                    if (dashboardVerifiedMapEventsBound) return;
                    dashboardVerifiedMapEventsBound = true;

                    dashboardVerifiedMap.on("click", "dashboard-verified-clusters", async (event) => {
                        const features = dashboardVerifiedMap.queryRenderedFeatures(event.point, { layers: ["dashboard-verified-clusters"] });
                        const clusterId = features[0].properties.cluster_id;
                        const zoom = await dashboardVerifiedMap.getSource("dashboard-verified-clients").getClusterExpansionZoom(clusterId);
                        dashboardVerifiedMap.easeTo({ center: features[0].geometry.coordinates, zoom });
                    });

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

                        if (props.id) {
                            openAdminClientModal(`/admin/clients/${props.id}`, "edit");
                        }
                    });

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
                };

                dashboardVerifiedMap.on("style.load", () => setupDashboardVerifiedMapLayers());
                dashboardVerifiedMap.on("load", () => {
                    setupDashboardVerifiedMapLayers({ fit: true });
                    bindDashboardVerifiedMapEvents();
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

            let adminAnalyticsChartsInitialized = false;
            function initializeAnalyticsCharts() {
                if (adminAnalyticsChartsInitialized || typeof Chart === "undefined") {
                    return;
                }
                if (!document.getElementById("ageChart")) {
                    return;
                }
                adminAnalyticsChartsInitialized = true;
                const fontSettings = { family: "Public Sans", size: 12 };
                const primaryColor = "#001e40";
                const accentOrange = "#F97316";
                const secondaryColor = "#4a6077";
                const lightGray = "#e2e2e5";

                // Age Chart
                new Chart(document.getElementById("ageChart"), {
                    type: "bar",
                    data: {
                        labels: ["Below 18", "18–35", "36–60", "60+"],
                        datasets: [
                            {
                                label: "Clients",
                                data: [12000, 480000, 560000, 150000],
                                backgroundColor: [
                                    lightGray,
                                    primaryColor,
                                    secondaryColor,
                                    accentOrange,
                                ],
                                borderRadius: 4,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                    },
                });

                // Civil Status Chart
                new Chart(document.getElementById("civilStatusChart"), {
                    type: "bar",
                    data: {
                        labels: ["Single", "Married", "Widowed", "Separated"],
                        datasets: [
                            {
                                label: "Percentage",
                                data: [35, 52, 8, 5],
                                backgroundColor: primaryColor,
                                borderRadius: 4,
                            },
                        ],
                    },
                    options: {
                        indexAxis: "y",
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                    },
                });

                // Sex Donut Chart
                new Chart(document.getElementById("sexChart"), {
                    type: "doughnut",
                    data: {
                        labels: ["Male", "Female"],
                        datasets: [
                            {
                                data: [42, 58],
                                backgroundColor: [primaryColor, accentOrange],
                                borderWidth: 0,
                                hoverOffset: 10,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: "80%",
                        plugins: {
                            legend: {
                                position: "bottom",
                                labels: { boxWidth: 12, font: fontSettings },
                            },
                        },
                    },
                });

                // MSME Classification Chart
                new Chart(document.getElementById("msmeClassChart"), {
                    type: "doughnut",
                    data: {
                        labels: ["Micro", "Small", "Medium", "Large"],
                        datasets: [
                            {
                                data: [88, 8, 3, 1],
                                backgroundColor: [
                                    primaryColor,
                                    accentOrange,
                                    secondaryColor,
                                    lightGray,
                                ],
                                borderWidth: 0,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: "bottom",
                                labels: { boxWidth: 12 },
                            },
                        },
                    },
                });

                // Sector Chart
                new Chart(document.getElementById("sectorChart"), {
                    type: "bar",
                    data: {
                        labels: [
                            "Agriculture",
                            "Retail",
                            "Service",
                            "Manufacturing",
                        ],
                        datasets: [
                            {
                                label: "Industry Sectors",
                                data: [15, 45, 30, 10],
                                backgroundColor: primaryColor,
                                borderRadius: 4,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                    },
                });

                // Designation Chart
                new Chart(document.getElementById("designationChart"), {
                    type: "bar",
                    data: {
                        labels: ["Owner", "Manager", "Representative"],
                        datasets: [
                            {
                                label: "Roles",
                                data: [72, 18, 10],
                                backgroundColor: accentOrange,
                                borderRadius: 4,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                    },
                });

                // Digital Tool Adoption
                new Chart(document.getElementById("digitalToolChart"), {
                    type: "bar",
                    data: {
                        labels: [
                            "POS System",
                            "Social Media Marketing",
                            "Cloud Storage",
                            "E-Payment Solutions",
                        ],
                        datasets: [
                            {
                                label: "Adoption Rate (%)",
                                data: [28, 75, 12, 58],
                                backgroundColor: primaryColor,
                                borderRadius: 6,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                    },
                });

                // Growth Chart (Line)
                new Chart(document.getElementById("growthChart"), {
                    type: "line",
                    data: {
                        labels: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec",
                        ],
                        datasets: [
                            {
                                label: "New Registrations",
                                data: [
                                    1200, 1500, 1100, 2400, 3200, 4100, 3800, 4500,
                                    5200, 6100, 6800, 7500,
                                ],
                                borderColor: primaryColor,
                                tension: 0.4,
                                fill: false,
                                pointRadius: 4,
                                pointBackgroundColor: accentOrange,
                            },
                        ],
                    },
                    options: { responsive: true, maintainAspectRatio: false },
                });

                // Activity Area Chart
                new Chart(document.getElementById("activityChart"), {
                    type: "line",
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                        datasets: [
                            {
                                label: "Active",
                                data: [900, 920, 940, 960, 975, 980],
                                borderColor: primaryColor,
                                backgroundColor: "rgba(0, 30, 64, 0.1)",
                                fill: true,
                                tension: 0.4,
                            },
                            {
                                label: "Inactive",
                                data: [200, 180, 210, 220, 215, 220],
                                borderColor: accentOrange,
                                backgroundColor: "rgba(249, 115, 22, 0.1)",
                                fill: true,
                                tension: 0.4,
                            },
                        ],
                    },
                    options: { responsive: true, maintainAspectRatio: false },
                });
            }
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

                if (view === "analytics") {
                    initializeAnalyticsCharts();
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
                ["dashboard", "analytics", "surveyors", "verification"].includes(initialView)
            ) {
                setAdminView(initialView);
            }

            bindAdminClientTableFilters();
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
