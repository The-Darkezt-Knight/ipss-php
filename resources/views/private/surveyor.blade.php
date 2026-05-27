<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Sync Status Dashboard | CivicSurvey Portal</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/surveyor/surveyor.js'])

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
        }

        .zebra-stripe tr:nth-child(even) {
            background-color: #EBF1F5;
        }

        .sync-progress-bar {
            transition: width 0.4s ease-in-out;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-bright": "#f9f9fc",
                        "surface": "#f9f9fc",
                        "on-primary-fixed-variant": "#1f477b",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed-dim": "#c1c7cb",
                        "primary-container": "#003366",
                        "surface-container-lowest": "#ffffff",
                        "outline": "#737780",
                        "secondary-container": "#cbe2fc",
                        "on-error-container": "#93000a",
                        "surface-container-high": "#e8e8ea",
                        "tertiary-container": "#2e3437",
                        "surface-dim": "#dadadc",
                        "on-secondary-fixed": "#041d30",
                        "outline-variant": "#c3c6d1",
                        "error": "#ba1a1a",
                        "on-primary-container": "#799dd6",
                        "on-primary-fixed": "#001b3c",
                        "surface-container-highest": "#e2e2e5",
                        "surface-container": "#eeeef0",
                        "tertiary": "#191f22",
                        "secondary": "#4a6077",
                        "surface-container-low": "#f3f3f6",
                        "primary-fixed-dim": "#a7c8ff",
                        "on-surface": "#1a1c1e",
                        "secondary-fixed-dim": "#b2c9e2",
                        "secondary-fixed": "#cee5ff",
                        "primary": "#001e40",
                        "on-secondary-fixed-variant": "#33495e",
                        "on-secondary-container": "#4f657b",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed": "#161c1f",
                        "on-surface-variant": "#43474f",
                        "background": "#f9f9fc",
                        "tertiary-fixed": "#dde3e7",
                        "surface-variant": "#e2e2e5",
                        "primary-fixed": "#d5e3ff",
                        "on-error": "#ffffff",
                        "on-tertiary-fixed-variant": "#41484b",
                        "surface-tint": "#3a5f94",
                        "on-tertiary-container": "#969ca0",
                        "on-secondary": "#ffffff",
                        "inverse-surface": "#2f3133",
                        "inverse-on-surface": "#f0f0f3",
                        "error-container": "#ffdad6",
                        "on-background": "#1a1c1e",
                        "inverse-primary": "#a7c8ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "unit": "4px",
                        "sm": "8px",
                        "margin-mobile": "16px",
                        "xs": "4px",
                        "md": "16px",
                        "container-max": "1280px",
                        "xl": "32px",
                        "lg": "24px",
                        "gutter": "24px",
                        "xxl": "48px"
                    },
                    "fontFamily": {
                        "body-sm": ["Public Sans"],
                        "label-md": ["Public Sans"],
                        "body-lg": ["Public Sans"],
                        "headline-md": ["Public Sans"],
                        "display-lg": ["Public Sans"],
                        "body-md": ["Public Sans"],
                        "headline-lg": ["Public Sans"],
                        "headline-sm": ["Public Sans"],
                        "label-lg": ["Public Sans"]
                    },
                    "fontSize": {
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "600" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "700" }],
                        "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "label-lg": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-surface text-on-surface">
    <!-- TopAppBar -->
    <header
        class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-md h-16 bg-surface dark:bg-on-surface border-b border-outline-variant dark:border-outline">
        <div class="text-headline-sm font-headline-sm font-bold text-primary dark:text-primary-fixed-dim">CivicSurvey
            Portal</div>
        <div class="flex items-center gap-lg">
            <div class="hidden md:flex gap-md">
                <nav class="flex items-center space-x-md">
                    <a class="text-label-md font-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors px-sm py-xs"
                        href="{{ route('private.surveyor-dashboard') }}">Dashboard</a>
                    <a class="text-label-md font-label-md text-primary dark:text-primary-fixed-dim border-b-2 border-primary px-sm py-xs"
                        href="#">Sync History</a>
                </nav>
            </div>
            <div class="flex items-center gap-sm">
                <span
                    class="material-symbols-outlined text-primary cursor-pointer hover:bg-surface-container-high p-xs rounded-full transition-colors"
                    data-icon="sync">sync</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="ml-md text-label-md font-label-md text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high transition-colors px-sm py-xs">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </header>


    <!-- SideNavBar -->
    <aside
        class="fixed left-0 top-16 h-[calc(100vh-64px)] w-64 z-40 flex flex-col p-md bg-surface-container-low dark:bg-tertiary-container border-r border-outline-variant dark:border-outline hidden md:flex">
        <div class="flex items-center gap-md mb-xl">
            <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center overflow-hidden">
                <!--<img alt="Surveyor Profile" class="w-full h-full object-cover" src=''/>-->
            </div>
            <div>
                <p id='surveyor-name' class="text-label-lg font-label-lg text-primary">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                <p id='surveyor-id' class="text-body-sm font-body-sm text-on-surface-variant">ID: #{{ $employee->govt_id }}</p>
            </div>
        </div>

        <nav class="flex-1 flex flex-col gap-xs">
            <a class="flex items-center gap-md p-md text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-all group"
                href="{{ route('private.surveyor-dashboard') }}">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="text-label-lg font-label-lg">Dashboard</span>
            </a>

            <!-- Active surveys
            <a id="active-survey-button"
                class="flex items-center gap-md p-md text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-all group"
                href="#">
                <span class="material-symbols-outlined" data-icon="assignment">assignment</span>
                <span class="text-label-lg font-label-lg">Active Surveys</span>
            </a>
            -->
            
            <a class="flex items-center gap-md p-md bg-secondary-container text-on-secondary-container rounded-lg font-bold transition-transform duration-100 scale-[0.98]"
                href="#">
                <span class="material-symbols-outlined" data-icon="sync_alt">sync_alt</span>
                <span class="text-label-lg font-label-lg">Sync History</span>
            </a>

            <!-- Settings
            <a class="flex items-center gap-md p-md text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-all group"
                href="#">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="text-label-lg font-label-lg">Settings</span>
            </a>
            -->

        </nav>

        <a href="{{route('private.form')}}" target="_blank">
            <button
                id="add-new-survey-button"
                class="mt-auto w-full py-md bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-sm hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined" data-icon="add">add</span>
            </button>
        </a>


    </aside>
    
    <!-- Main Content Canvas -->
    <main class="md:ml-64 pt-16 min-h-screen bg-surface-bright">
        <div class="max-w-container-max mx-auto p-lg">
            <!-- Breadcrumbs -->

            <nav class="flex items-center gap-xs mb-lg text-on-surface-variant">
                <span class="text-body-sm font-body-sm">Dashboard</span>
                <span class="material-symbols-outlined text-[16px]" data-icon="chevron_right">chevron_right</span>
                <span class="text-body-sm font-body-sm font-bold text-primary">Sync Status</span>
            </nav>
            
            <header class="mb-xl">
                <h1 class="font-headline-lg text-headline-lg text-primary mb-xs">Sync Status Dashboard</h1>
                <p class="text-body-md font-body-md text-on-surface-variant">Manage locally stored records and ensure
                    data integrity for municipal survey operations.</p>
            </header>

            <!-- Status Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-xl">
                <div
                    class="bg-surface-container-low p-lg border border-outline-variant/15 rounded-xl flex flex-col gap-sm">
                    <div class="flex justify-between items-start">
                        <span
                            class="text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Pending
                            Sync</span>
                        <span class="material-symbols-outlined text-primary"
                            data-icon="pending_actions">pending_actions</span>
                    </div>
                    <div id="pending-sync-count" class="text-display-lg font-display-lg text-primary">—</div>
                    <p class="text-body-sm font-body-sm text-on-surface-variant">Records waiting for secure upload</p>
                </div>

                <div
                    class="bg-surface-container-low p-lg border border-outline-variant/15 rounded-xl flex flex-col gap-sm">
                    <div class="flex justify-between items-start">
                        <span class="text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Last
                            Synced Time</span>
                        <span class="material-symbols-outlined text-secondary" data-icon="schedule">schedule</span>
                    </div>
                    <div id="last-synced-time" class="text-headline-lg font-headline-lg text-primary mt-sm">—</div>
                    <p class="text-body-sm font-body-sm text-on-surface-variant">Most recent queued record</p>
                </div>

                <!--
                <div
                    class="bg-surface-container-low p-lg border border-outline-variant/15 rounded-xl flex flex-col gap-sm">
                    <div class="flex justify-between items-start">
                        <span class="text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Sync
                            Health</span>
                        <span class="material-symbols-outlined text-green-600"
                            data-icon="check_circle">check_circle</span>
                    </div>
                    
                    <div class="text-headline-lg font-headline-lg text-primary mt-sm">Optimal</div>
                    <div class="flex items-center gap-xs">
                        <div class="h-2 w-full bg-surface-container-highest rounded-full overflow-hidden">
                            <div class="h-full bg-green-600 w-[98%]"></div>
                        </div>
                        <span class="text-label-md font-label-md text-on-surface-variant">98%</span>
                    </div>  
                </div>
                -->

            </div>


            <!-- Global Action Control
            <div
                class="bg-primary-container p-xl rounded-xl mb-xl text-on-primary-container flex flex-col md:flex-row items-center gap-xl justify-between border border-outline-variant">
                <div class="flex flex-col gap-xs max-w-lg">
                    <h3 class="text-headline-sm font-headline-sm text-white">Bulk Data Transmission</h3>
                    <p class="text-body-sm font-body-sm text-on-primary-container opacity-90">Upload all locally saved
                        census and infrastructure surveys to the central governance database. Ensure stable network
                        connection before starting.</p>
                </div>

                <div class="w-full md:w-auto flex flex-col items-center gap-md">
                    <button
                        class="w-full md:w-64 py-lg bg-on-primary-fixed text-white rounded-lg font-bold flex items-center justify-center gap-sm hover:bg-black transition-all active:scale-[0.98]"
                        id="syncAllBtn">
                        <span class="material-symbols-outlined" data-icon="cloud_upload">cloud_upload</span>
                        Sync All Pending Data
                    </button>
                    <div class="w-full md:w-64 hidden" id="progressContainer">
                        <div class="h-2 bg-on-primary-container/20 rounded-full overflow-hidden mb-xs">
                            <div class="h-full bg-white sync-progress-bar w-0" id="syncProgress"></div>
                        </div>
                        <p class="text-center text-label-md font-label-md text-white" id="progressLabel">Syncing: 0%</p>
                    </div>
                </div>

            </div>
            -->

            <!-- Content Split: Pending vs History -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter items-start">
                <!-- Pending Records Table (2/3) -->
                <section class="lg:col-span-2">
                    <div class="bg-white border border-outline-variant/30 rounded-xl overflow-hidden shadow-sm">
                        <div class="p-lg border-b border-outline-variant/30 flex justify-between items-center">
                            <h2 class="font-headline-sm text-headline-sm text-primary">Pending Records</h2>
                            <div class="flex gap-sm">
                                <button id="sync-all-btn"
                                    class="px-md py-sm text-on-primary bg-primary hover:opacity-90 rounded-lg font-bold flex items-center gap-xs transition-all">
                                    <span class="material-symbols-outlined text-[18px]" data-icon="cloud_upload">cloud_upload</span>
                                    Sync All
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left zebra-stripe">
                                <thead class="bg-surface-container-low">
                                    <tr>
                                        <th class="px-lg py-md text-label-md font-label-md text-on-surface-variant">
                                            Client Name</th>
                                        <th class="px-lg py-md text-label-md font-label-md text-on-surface-variant">Date
                                            Created</th>
                                        <th class="px-lg py-md text-label-md font-label-md text-on-surface-variant">Type
                                        </th>
                                        <th class="px-lg py-md text-label-md font-label-md text-on-surface-variant">
                                            Status</th>
                                        <th
                                            class="px-lg py-md text-label-md font-label-md text-on-surface-variant text-right">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="pending-surveys-tbody" class="text-body-sm font-body-sm">
                                    <!-- Empty state row -->
                                    <tr id="empty-state-row" class="hidden">
                                        <td colspan="5" class="px-lg py-xxl text-center">
                                            <div class="flex flex-col items-center gap-md text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[48px] text-outline" data-icon="cloud_done">cloud_done</span>
                                                <p class="text-body-md font-bold">All caught up!</p>
                                                <p class="text-body-sm">No pending surveys to sync. Submit a new survey to see it here.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Dynamic rows will be injected here by surveyor.js -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </section>


                <!-- Sync History (1/3) -->
                <section class="lg:col-span-1">
                    <div
                        class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl overflow-hidden shadow-sm h-full">
                        <div class="p-lg border-b border-outline-variant/30">
                            <h2 class="font-headline-sm text-headline-sm text-primary">Recent History</h2>
                        </div>
                        <div class="p-md flex flex-col gap-md">
                            <div class="flex gap-md p-md bg-white border border-outline-variant/10 rounded-lg">
                                <span class="material-symbols-outlined text-green-600 mt-xs"
                                    data-icon="check_circle">check_circle</span>
                                <div>
                                    <p class="text-label-lg font-label-lg text-primary">North District Census</p>
                                    <p class="text-body-sm font-body-sm text-on-surface-variant">Today • 10:42 AM</p>
                                    <p class="text-label-md font-label-md text-secondary-fixed-dim mt-xs">24 Records
                                        Uploaded</p>
                                </div>
                            </div>
                            <div
                                class="flex gap-md p-md bg-white border border-outline-variant/10 rounded-lg opacity-80">
                                <span class="material-symbols-outlined text-green-600 mt-xs"
                                    data-icon="check_circle">check_circle</span>
                                <div>
                                    <p class="text-label-lg font-label-lg text-primary">East Ward Infrastructure</p>
                                    <p class="text-body-sm font-body-sm text-on-surface-variant">Today • 08:15 AM</p>
                                    <p class="text-label-md font-label-md text-secondary-fixed-dim mt-xs">12 Records
                                        Uploaded</p>
                                </div>
                            </div>
                            <div
                                class="flex gap-md p-md bg-white border border-outline-variant/10 rounded-lg opacity-60">
                                <span class="material-symbols-outlined text-green-600 mt-xs"
                                    data-icon="check_circle">check_circle</span>
                                <div>
                                    <p class="text-label-lg font-label-lg text-primary">School District B Audit</p>
                                    <p class="text-body-sm font-body-sm text-on-surface-variant">Yesterday • 04:50 PM
                                    </p>
                                    <p class="text-label-md font-label-md text-secondary-fixed-dim mt-xs">5 Records
                                        Uploaded</p>
                                </div>
                            </div>
                            <button
                                class="mt-md text-label-lg font-label-lg text-primary flex items-center justify-center gap-xs hover:underline">
                                View Full History Log
                                <span class="material-symbols-outlined text-[16px]"
                                    data-icon="arrow_forward">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </section>


            </div>

            <!-- Contextual Information Card
            <div
                class="mt-xxl bg-surface-container p-xl rounded-xl flex flex-col md:flex-row items-center gap-xl border border-outline-variant/50">
                <div
                    class="w-24 h-24 shrink-0 bg-white p-sm rounded-full shadow-inner flex items-center justify-center">
                    <span class="material-symbols-outlined text-[48px] text-primary" data-icon="security"
                        style="font-variation-settings: 'FILL' 1;">security</span>
                </div>

                <div class="flex-1">
                    <h4 class="text-headline-sm font-headline-sm text-primary mb-xs">Secured Municipal Transmission</h4>
                    <p class="text-body-md font-body-md text-on-surface-variant">All synchronized data is encrypted
                        using AES-256 standard before being moved from your device's local cache. The CivicSurvey Portal
                        ensures end-to-end security compliance with federal municipal data handling regulations.</p>
                </div>

            </div>
            -->

        </div>


    </main>

    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <!-- Edit Client Modal -->
    <!-- ═══════════════════════════════════════════════════════════════════ -->
    <div id="edit-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col mx-4">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-lg py-md border-b border-outline-variant bg-surface-container-low">
                <div class="flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">edit_note</span>
                    <h2 class="text-headline-sm font-headline-sm text-primary">Edit Client Record</h2>
                </div>
                <button id="edit-modal-close" class="p-xs rounded-full hover:bg-surface-container-high transition-colors">
                    <span class="material-symbols-outlined text-on-surface-variant">close</span>
                </button>
            </div>

            <!-- Modal Body (scrollable) -->
            <div class="overflow-y-auto flex-1 p-lg">
                <form id="edit-client-form" class="flex flex-col gap-xl">
                    <!-- Hidden record ID -->
                    <input type="hidden" id="edit-record-id" />
                    <!-- Surveyor ID (always injected so it survives edits) -->
                    <input type="hidden" id="edit-surveyed_by" value="{{ $employee->id }}" />

                    <!-- Section 1: Client Status & Classification -->
                    <fieldset>
                        <legend class="flex items-center gap-sm mb-md pb-xs border-b border-outline-variant w-full">
                            <span class="material-symbols-outlined text-primary text-[18px]">category</span>
                            <span class="text-label-lg font-label-lg text-primary">Client Status & Classification</span>
                        </legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Status of Client</label>
                                <select id="edit-statusOfClient" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm">
                                    <option value="">Select…</option>
                                    <option value="New Registrant">New Registrant</option>
                                    <option value="Renewal">Renewal</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Category of Client</label>
                                <select id="edit-categoryOfClient" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm">
                                    <option value="">Select…</option>
                                    <option value="Micro">Micro</option>
                                    <option value="Small">Small</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Large">Large</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">MSME Classification</label>
                                <input id="edit-msmeClassification" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Client Designation</label>
                                <input id="edit-clientDesignation" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Social Classification</label>
                                <input id="edit-socialClassification" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Specify Level</label>
                                <input id="edit-specifyLevel" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Differently-abled Type</label>
                                <input id="edit-diffAbledType" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                        </div>
                        <div class="flex gap-lg mt-md">
                            <label class="flex items-center gap-sm text-body-sm cursor-pointer">
                                <input id="edit-isSenior" type="checkbox" class="rounded border-outline text-primary focus:ring-primary" />
                                Senior Citizen
                            </label>
                            <label class="flex items-center gap-sm text-body-sm cursor-pointer">
                                <input id="edit-isIndigeneous" type="checkbox" class="rounded border-outline text-primary focus:ring-primary" />
                                Indigenous People
                            </label>
                        </div>
                    </fieldset>

                    <!-- Section 2: Digitalization -->
                    <fieldset>
                        <legend class="flex items-center gap-sm mb-md pb-xs border-b border-outline-variant w-full">
                            <span class="material-symbols-outlined text-primary text-[18px]">devices</span>
                            <span class="text-label-lg font-label-lg text-primary">Digitalization</span>
                        </legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Level of Digitalization</label>
                                <input id="edit-levelOfDigitalization" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Digital Tools</label>
                                <input id="edit-digitalTools" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 3: Personal Information -->
                    <fieldset>
                        <legend class="flex items-center gap-sm mb-md pb-xs border-b border-outline-variant w-full">
                            <span class="material-symbols-outlined text-primary text-[18px]">person</span>
                            <span class="text-label-lg font-label-lg text-primary">Personal Information</span>
                        </legend>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">First Name</label>
                                <input id="edit-firstName" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Middle Name</label>
                                <input id="edit-middleName" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Last Name</label>
                                <input id="edit-lastName" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Suffix</label>
                                <select id="edit-suffix" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm">
                                    <option value="--N/A--">N/A</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Sex</label>
                                <select id="edit-sex" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm">
                                    <option value="">Select…</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Civil Status</label>
                                <select id="edit-civilStatus" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm">
                                    <option value="">Select…</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Citizenship</label>
                                <input id="edit-citizenship" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 4: Identifiers -->
                    <fieldset>
                        <legend class="flex items-center gap-sm mb-md pb-xs border-b border-outline-variant w-full">
                            <span class="material-symbols-outlined text-primary text-[18px]">badge</span>
                            <span class="text-label-lg font-label-lg text-primary">Identifiers</span>
                        </legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <!-- Client ID — READ ONLY (greyed out) -->
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Client ID <span class="text-outline text-[10px]">(auto-generated)</span></label>
                                <input id="edit-id" type="text" readonly
                                    class="p-md border border-outline-variant rounded-lg bg-surface-container text-body-sm text-on-surface-variant cursor-not-allowed" />
                            </div>

                            <!--
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Old Client ID</label>
                                <input id="edit-oldId" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">DTI Konek ID</label>
                                <input id="edit-dtiKonekId" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            -->
                            
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">PhilSys ID</label>
                                <input id="edit-philippineIdentificationSystem" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 5: Contact Details -->
                    <fieldset>
                        <legend class="flex items-center gap-sm mb-md pb-xs border-b border-outline-variant w-full">
                            <span class="material-symbols-outlined text-primary text-[18px]">call</span>
                            <span class="text-label-lg font-label-lg text-primary">Contact Details</span>
                        </legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Mobile Number</label>
                                <input id="edit-mobileNumber" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm"
                                    placeholder="+63" value="+63" data-locked-prefix="+63" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Email Address</label>
                                <input id="edit-emailAddress" type="email" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Landline Number</label>
                                <input id="edit-landlineNumber" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm"
                                    placeholder="+63" value="+63" data-locked-prefix="+63" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Fax Number</label>
                                <input id="edit-faxNumber" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Social Media</label>
                                <input id="edit-socialMedia" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Website</label>
                                <input id="edit-website" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs md:col-span-2">
                                <label class="text-label-md font-label-md text-on-surface-variant">E-Commerce Platform</label>
                                <input id="edit-eCommercePlatform" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                        </div>
                    </fieldset>

                    <!-- Section 6: Location -->
                    <fieldset>
                        <legend class="flex items-center gap-sm mb-md pb-xs border-b border-outline-variant w-full">
                            <span class="material-symbols-outlined text-primary text-[18px]">location_on</span>
                            <span class="text-label-lg font-label-lg text-primary">Location</span>
                        </legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Region</label>
                                <input id="edit-regionCode" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Province</label>
                                <input id="edit-provinceCode" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">City / Municipality Code</label>
                                <input id="edit-cityMunicipalityCode" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Barangay Code</label>
                                <input id="edit-barangayCode" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">District</label>
                                <input id="edit-district" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Zip Code</label>
                                <input id="edit-zipCode" type="text" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm" />
                            </div>
                            <div class="flex flex-col gap-xs md:col-span-2">
                                <label class="text-label-md font-label-md text-on-surface-variant">Full Address</label>
                                <textarea id="edit-address" rows="2" class="p-md border border-outline rounded-lg bg-surface-bright text-body-sm"></textarea>
                            </div>
                            <!-- Latitude — READ ONLY (greyed out) -->
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Latitude <span class="text-outline text-[10px]">(auto-captured)</span></label>
                                <input id="edit-latitude" type="text" readonly
                                    class="p-md border border-outline-variant rounded-lg bg-surface-container text-body-sm text-on-surface-variant cursor-not-allowed" />
                            </div>
                            <!-- Longitude — READ ONLY (greyed out) -->
                            <div class="flex flex-col gap-xs">
                                <label class="text-label-md font-label-md text-on-surface-variant">Longitude <span class="text-outline text-[10px]">(auto-captured)</span></label>
                                <input id="edit-longitude" type="text" readonly
                                    class="p-md border border-outline-variant rounded-lg bg-surface-container text-body-sm text-on-surface-variant cursor-not-allowed" />
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-md px-lg py-md border-t border-outline-variant bg-surface-container-lowest">
                <button id="edit-modal-cancel"
                    class="px-lg py-sm text-on-surface-variant border border-outline-variant rounded-lg hover:bg-surface-container-high transition-colors font-bold text-label-lg">
                    Cancel
                </button>
                <button id="edit-modal-save"
                    class="px-lg py-sm bg-primary text-on-primary rounded-lg hover:opacity-90 transition-all font-bold text-label-lg flex items-center gap-xs">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="md:ml-64 bg-surface-container-lowest border-t border-outline-variant dark:border-outline">
        <div
            class="w-full py-lg px-xl flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto">
            <p
                class="text-body-sm font-body-sm text-on-surface-variant dark:text-surface-variant text-center md:text-left mb-md md:mb-0">
                © 2024 Municipal Governance Authority. All data is encrypted and official.
            </p>
            <div class="flex items-center gap-xl">
                <a class="text-label-md font-label-md text-on-surface-variant dark:text-surface-variant hover:text-primary transition-colors"
                    href="#">Privacy Policy</a>
                <a class="text-label-md font-label-md text-on-surface-variant dark:text-surface-variant hover:text-primary transition-colors"
                    href="#">Terms of Service</a>
                <a class="text-label-md font-label-md text-on-surface-variant dark:text-surface-variant hover:text-primary transition-colors"
                    href="#">Help Desk</a>
            </div>
        </div>

    </footer>

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('[App] Service Worker registered with scope:', registration.scope);
                    })
                    .catch((error) => {
                        console.error('[App] Service Worker registration failed:', error);
                    });
            });
        }
    </script>

</body>

</html>
