<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>CityGov Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f9f9fc;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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
              "colors": {
                      "on-error-container": "#93000a",
                      "surface-container-highest": "#e2e2e5",
                      "primary": "#001e40",
                      "on-background": "#1a1c1e",
                      "surface": "#f9f9fc",
                      "surface-container-low": "#f3f3f6",
                      "error-container": "#ffdad6",
                      "error": "#ba1a1a",
                      "secondary-fixed": "#cee5ff",
                      "surface-container-lowest": "#ffffff",
                      "on-tertiary-container": "#969ca0",
                      "on-tertiary-fixed": "#161c1f",
                      "surface-tint": "#3a5f94",
                      "tertiary-fixed-dim": "#c1c7cb",
                      "outline": "#737780",
                      "on-primary-fixed": "#001b3c",
                      "on-primary-container": "#799dd6",
                      "surface-container-high": "#e8e8ea",
                      "on-tertiary": "#ffffff",
                      "tertiary-container": "#2e3437",
                      "tertiary": "#191f22",
                      "on-primary": "#ffffff",
                      "inverse-primary": "#a7c8ff",
                      "secondary": "#4a6077",
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
                      "background": "#f9f9fc",
                      "inverse-on-surface": "#f0f0f3",
                      "on-error": "#ffffff",
                      "inverse-surface": "#2f3133",
                      "surface-variant": "#e2e2e5",
                      "primary-fixed": "#d5e3ff",
                      "on-surface-variant": "#43474f",
                      "on-secondary-fixed-variant": "#33495e",
                      "primary-fixed-dim": "#a7c8ff"
              },
              "borderRadius": {
                      "DEFAULT": "0.125rem",
                      "lg": "0.25rem",
                      "xl": "0.5rem",
                      "full": "0.75rem"
              },
              "spacing": {
                      "xxl": "48px",
                      "sm": "8px",
                      "xs": "4px",
                      "xl": "32px",
                      "lg": "24px",
                      "gutter": "24px",
                      "md": "16px",
                      "margin-mobile": "16px",
                      "container-max": "1280px",
                      "unit": "4px"
              },
              "fontFamily": {
                      "headline-md": ["Public Sans"],
                      "label-md": ["Public Sans"],
                      "headline-lg-mobile": ["Public Sans"],
                      "body-sm": ["Public Sans"],
                      "label-lg": ["Public Sans"],
                      "headline-lg": ["Public Sans"],
                      "body-lg": ["Public Sans"],
                      "headline-sm": ["Public Sans"],
                      "display-lg": ["Public Sans"],
                      "body-md": ["Public Sans"]
              },
              "fontSize": {
                      "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                      "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "600"}],
                      "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "700"}],
                      "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                      "label-lg": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                      "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "700"}],
                      "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                      "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                      "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
              }
            },
          },
        }
    </script>
</head>
<body class="bg-background text-on-surface">
<div class="flex h-screen overflow-hidden">
<!-- SideNavBar Component -->
<aside class="hidden md:flex flex-col h-full border-r border-outline-variant/15 py-md bg-surface dark:bg-surface-dim docked left-0 w-64">
<div class="px-lg pb-xl">
<div class="flex items-center gap-md">
<img alt="City Seal" class="w-10 h-10" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAcG6f6ozFIMiJQ9ur28QaRkgZQ12cR4J-7giUJt7UIXBAu1tp8Q0GLPY610tlEf-QJ9tdX9XCe5ASAdl_H0m3Cd0pbxdR0T-7flfL1SkF-TwASv-9nvcVNTkj5NMIG67Ryaloou8vG8L35COC__UTQGuixrjMR_9foLRUjTKHh2tbx5MXwW-nH3lG_z4iBr92TduOL9r5O4AJ-kcdkV_9wZivg0fLuADAUDLffQ-K3WCpl1xwa-vGlZ2LpVEIeY0qkDPKVajq8_qxK"/>
<div>
<h1 class="font-headline-sm text-headline-sm font-bold text-primary">Municipal Oversight</h1>
<p class="font-label-md text-label-md text-on-surface-variant">Governance Portal</p>
</div>
</div>
</div>
<nav class="flex-1 space-y-1">
<!-- Dashboard (Active) -->
<button class="admin-nav-link flex w-[calc(100%-16px)] items-center px-lg py-md bg-secondary-fixed dark:bg-primary-container text-on-secondary-fixed dark:text-on-primary-container rounded-xl mx-2 my-1 transition-all translate-x-1 duration-200" type="button" data-admin-view="dashboard">
<span class="material-symbols-outlined mr-md" data-icon="dashboard">dashboard</span>
<span class="font-label-lg text-label-lg">Dashboard</span>
</button>
<a class="flex items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" href="#">
<span class="material-symbols-outlined mr-md" data-icon="analytics">analytics</span>
<span class="font-label-lg text-label-lg">Analytics</span>
</a>
<button class="admin-nav-link flex w-[calc(100%-16px)] items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" type="button" data-admin-view="surveyors">
<span class="material-symbols-outlined mr-md" data-icon="group">group</span>
<span class="font-label-lg text-label-lg">Surveyors</span>
</button>
<button class="admin-nav-link flex w-[calc(100%-16px)] items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" type="button" data-admin-view="verification">
<span class="material-symbols-outlined mr-md" data-icon="fact_check">fact_check</span>
<span class="font-label-lg text-label-lg">Verification Queue</span>
</button>
</nav>
<div class="mt-auto pt-md border-t border-outline-variant/15">
<a class="flex items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" href="#">
<span class="material-symbols-outlined mr-md" data-icon="help">help</span>
<span class="font-label-lg text-label-lg">Support</span>
</a>
<a class="flex items-center px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" href="#">
<span class="material-symbols-outlined mr-md" data-icon="history">history</span>
<span class="font-label-lg text-label-lg">Archive</span>
</a>
</div>
</aside>
<!-- Main Content Area -->
<div class="flex-1 flex flex-col h-full overflow-y-auto custom-scrollbar">
<!-- TopNavBar Component -->
<header class="flex justify-between items-center w-full px-lg h-16 sticky top-0 z-50 bg-surface-container-lowest dark:bg-surface-dim border-b border-outline-variant/15 flat no shadows docked full-width">
<div class="flex items-center gap-xl">
<span class="md:hidden material-symbols-outlined cursor-pointer" data-icon="menu">menu</span>
<span class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed">CityGov Admin</span>
<div class="hidden md:flex gap-lg">
<a class="font-label-lg text-label-lg text-primary dark:text-primary-fixed font-bold border-b-2 border-primary py-xs" href="#">Overview</a>
<a class="font-label-lg text-label-lg text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-low dark:hover:bg-surface-container-high transition-colors py-xs" href="#">Reports</a>
<a class="font-label-lg text-label-lg text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-low dark:hover:bg-surface-container-high transition-colors py-xs" href="#">Regions</a>
</div>
</div>
<div class="flex items-center gap-md">
<div class="hidden sm:flex bg-surface-container-low dark:bg-surface-container px-md py-xs rounded-full items-center gap-sm">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="search">search</span>
<input class="bg-transparent border-none focus:ring-0 text-body-sm w-48" placeholder="Search records..." type="text"/>
</div>
<div class="flex items-center gap-sm">
<button class="p-sm text-on-surface-variant hover:bg-surface-container-low dark:hover:bg-surface-container-high rounded-full transition-colors active:scale-95 duration-100">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="p-sm text-on-surface-variant hover:bg-surface-container-low dark:hover:bg-surface-container-high rounded-full transition-colors active:scale-95 duration-100">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</button>
<div class="ml-sm w-8 h-8 rounded-full bg-primary-container overflow-hidden">
<img alt="Administrator Profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBSEwc6DEZIp456ebpLRRkaOKaruefv5S4W_nkm-ouDKfPeDSxwvHFNJC90gngZFe4NMbX4_5QdRLMbhMzY5-dUgT--zgTi9-V8Grm7m211y3Pa91BJrAL_qmXZU-r_6zd5YtyRxC7rvnK88oKaxeGPbezmN0MPDSRV2Or1pO_VFC_ETW5lunQ5NVaTq-Bl0BH7Pz9vg6fg4C-AIrY2nRb7F6A0IU2xza-EYANhQyyhF_diLVnEnE9QvnqSzMwAw5T7pBTCnPQ7q6rY"/>
</div>
</div>
</div>
</header>
<!-- Dashboard Content -->
<main class="p-lg md:p-xxl max-w-container-max mx-auto w-full space-y-lg">
<section id="admin-dashboard-panel" data-admin-panel="dashboard" class="admin-panel space-y-lg">
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-md">
<div>
<h2 class="font-headline-lg text-headline-lg text-primary">System Overview</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Real-time status of the Civic Trust ecosystem across all administrative regions.</p>
</div>
<button class="flex items-center gap-sm bg-primary text-on-primary px-lg py-md rounded-xl font-label-lg text-label-lg hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined" data-icon="download">download</span>
                        Export System Report
                    </button>
</div>
<!-- KPI Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-lg">
<div class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl flex flex-col gap-sm">
<div class="flex justify-between items-start">
<span class="material-symbols-outlined text-primary-container p-sm bg-secondary-fixed rounded-lg" data-icon="person_add">person_add</span>
<span class="text-green-600 font-label-md text-label-md flex items-center">+12.5% <span class="material-symbols-outlined text-sm" data-icon="trending_up">trending_up</span></span>
</div>
<p class="font-label-lg text-label-lg text-on-surface-variant">Total Registrations</p>
<p class="font-headline-md text-headline-md text-on-surface">1,284,392</p>
</div>
<div class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl flex flex-col gap-sm">
<div class="flex justify-between items-start">
<span class="material-symbols-outlined text-primary-container p-sm bg-secondary-fixed rounded-lg" data-icon="engineering">engineering</span>
<span class="text-primary font-label-md text-label-md flex items-center">Active</span>
</div>
<p class="font-label-lg text-label-lg text-on-surface-variant">Active Surveyors</p>
<p class="font-headline-md text-headline-md text-on-surface">4,812</p>
</div>
<div class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl flex flex-col gap-sm">
<div class="flex justify-between items-start">
<span class="material-symbols-outlined text-error p-sm bg-error-container rounded-lg" data-icon="pending_actions">pending_actions</span>
<span class="text-error font-label-md text-label-md flex items-center">Priority</span>
</div>
<p class="font-label-lg text-label-lg text-on-surface-variant">Pending Verifications</p>
<p class="font-headline-md text-headline-md text-on-surface">642</p>
</div>
<div class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl flex flex-col gap-sm">
<div class="flex justify-between items-start">
<span class="material-symbols-outlined text-primary-container p-sm bg-secondary-fixed rounded-lg" data-icon="verified_user">verified_user</span>
<span class="text-green-600 font-label-md text-label-md flex items-center">Target: 98%</span>
</div>
<p class="font-label-lg text-label-lg text-on-surface-variant">Regional Compliance</p>
<p class="font-headline-md text-headline-md text-on-surface">94.2%</p>
</div>
</div>
<!-- Bento Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
<!-- Density Map Section -->
<div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant/15 rounded-xl overflow-hidden flex flex-col">
<div class="p-lg border-b border-outline-variant/15 flex justify-between items-center">
<div>
<h3 class="font-headline-sm text-headline-sm text-primary">Registration Density</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Heatmap of citizen engagement across metropolitan districts.</p>
</div>
<div class="flex gap-xs bg-surface-container-low p-xs rounded-lg">
<button class="px-md py-xs bg-surface-container-lowest text-label-md font-label-md rounded-md shadow-sm">Map</button>
<button class="px-md py-xs text-on-surface-variant text-label-md font-label-md">Chart</button>
</div>
</div>
<div class="relative h-[400px] bg-slate-100">
<!-- Placeholder for Map -->
<div class="absolute inset-0 grayscale opacity-40 bg-[url('https://images.unsplash.com/photo-1524661135-423995f22d0b?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1200&amp;q=80')]" data-alt="A clean, minimalist high-contrast satellite view of a metropolitan city layout in shades of institutional blue and grey. The map features subtle glowing data points in specific residential districts to represent registration density. The lighting is bright and modern, suggesting a high-tech government operations center with a professional and organized aesthetic."></div>
<div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest/80 to-transparent flex items-center justify-center">
<div class="bg-white/80 backdrop-blur-md p-lg border border-outline-variant/20 rounded-xl shadow-xl max-w-sm text-center">
<span class="material-symbols-outlined text-primary text-4xl mb-sm" data-icon="location_on">location_on</span>
<h4 class="font-headline-sm text-headline-sm">Interactive Map Active</h4>
<p class="font-body-sm text-body-sm text-on-surface-variant">Showing active data points for Central, North, and West sectors. Filter by demographics in settings.</p>
</div>
</div>
<!-- Legend -->
<div class="absolute bottom-md left-md bg-white/90 backdrop-blur-sm p-md rounded-lg border border-outline-variant/15 space-y-sm">
<p class="font-label-md text-label-md text-on-surface">Density Level</p>
<div class="flex items-center gap-md">
<div class="h-2 w-24 rounded-full bg-gradient-to-r from-blue-100 to-primary"></div>
<span class="text-[10px] text-on-surface-variant">Low to High</span>
</div>
</div>
</div>
</div>
<!-- Activity Feed Section -->
<div class="bg-surface-container-lowest border border-outline-variant/15 rounded-xl flex flex-col">
<div class="p-lg border-b border-outline-variant/15 flex justify-between items-center">
<h3 class="font-headline-sm text-headline-sm text-primary">System Activity</h3>
<button class="text-primary font-label-md text-label-md hover:underline">View All</button>
</div>
<div class="flex-1 overflow-y-auto custom-scrollbar p-lg space-y-lg">
<!-- Activity Item 1 -->
<div class="flex gap-md group">
<div class="relative flex flex-col items-center">
<div class="w-2 h-2 rounded-full bg-green-500 ring-4 ring-green-100"></div>
<div class="w-px h-full bg-outline-variant/20 mt-1"></div>
</div>
<div class="pb-md">
<p class="font-label-lg text-label-lg text-on-surface">Batch verification completed</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Zone 4 (North Central) records cleared by Admin-02.</p>
<span class="text-xs text-on-tertiary-container mt-xs block">12 mins ago</span>
</div>
</div>
<!-- Activity Item 2 -->
<div class="flex gap-md group">
<div class="relative flex flex-col items-center">
<div class="w-2 h-2 rounded-full bg-primary ring-4 ring-secondary-fixed"></div>
<div class="w-px h-full bg-outline-variant/20 mt-1"></div>
</div>
<div class="pb-md">
<p class="font-label-lg text-label-lg text-on-surface">New Surveyor Credentials Issued</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Surveyor ID #8829 activated for the Riverside district.</p>
<span class="text-xs text-on-tertiary-container mt-xs block">45 mins ago</span>
</div>
</div>
<!-- Activity Item 3 -->
<div class="flex gap-md group">
<div class="relative flex flex-col items-center">
<div class="w-2 h-2 rounded-full bg-error ring-4 ring-error-container"></div>
<div class="w-px h-full bg-outline-variant/20 mt-1"></div>
</div>
<div class="pb-md">
<p class="font-label-lg text-label-lg text-on-surface">Discrepancy Detected</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Regional compliance dip in East Ward. Automated alert sent.</p>
<span class="text-xs text-on-tertiary-container mt-xs block">2 hours ago</span>
</div>
</div>
<!-- Activity Item 4 -->
<div class="flex gap-md group">
<div class="relative flex flex-col items-center">
<div class="w-2 h-2 rounded-full bg-on-tertiary-container ring-4 ring-tertiary-fixed"></div>
</div>
<div class="pb-md">
<p class="font-label-lg text-label-lg text-on-surface">System Maintenance</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Nightly backup and encryption verification scheduled for 01:00.</p>
<span class="text-xs text-on-tertiary-container mt-xs block">4 hours ago</span>
</div>
</div>
</div>
</div>
</div>
<!-- Secondary Data Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
<!-- Regional Progress Cards -->
<div class="bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl space-y-md">
<h4 class="font-label-lg text-label-lg text-on-surface-variant uppercase tracking-wider">Top Performing Regions</h4>
<div class="space-y-lg">
<div class="space-y-xs">
<div class="flex justify-between font-label-md text-label-md">
<span>West District</span>
<span>98.2%</span>
</div>
<div class="h-2 bg-surface-container-low rounded-full overflow-hidden">
<div class="h-full bg-primary w-[98%]"></div>
</div>
</div>
<div class="space-y-xs">
<div class="flex justify-between font-label-md text-label-md">
<span>Central Plaza</span>
<span>92.5%</span>
</div>
<div class="h-2 bg-surface-container-low rounded-full overflow-hidden">
<div class="h-full bg-primary w-[92%]"></div>
</div>
</div>
<div class="space-y-xs">
<div class="flex justify-between font-label-md text-label-md">
<span>South Harbour</span>
<span>88.7%</span>
</div>
<div class="h-2 bg-surface-container-low rounded-full overflow-hidden">
<div class="h-full bg-primary w-[88%]"></div>
</div>
</div>
</div>
</div>
<!-- Quick Actions -->
<div class="bg-primary-container text-on-primary-container p-lg rounded-xl flex flex-col justify-between">
<div>
<h4 class="font-headline-sm text-headline-sm">Verification Needed</h4>
<p class="font-body-sm text-body-sm text-on-primary-container/80 mt-xs">642 applications are waiting for manual review. Target completion by Friday.</p>
</div>
<div class="flex gap-md mt-lg">
<button class="flex-1 bg-on-primary text-primary px-md py-sm rounded-lg font-label-lg text-label-lg hover:bg-surface-bright transition-colors">Start Review</button>
<button class="flex-1 border border-on-primary/30 text-on-primary px-md py-sm rounded-lg font-label-lg text-label-lg hover:bg-on-primary/10 transition-colors">View Queue</button>
</div>
</div>
<!-- Small Stat Cards Stack -->
<div class="flex flex-col gap-lg">
<div class="flex-1 bg-surface-container-high/30 border border-outline-variant/15 p-lg rounded-xl flex items-center justify-between">
<div>
<p class="font-label-md text-label-md text-on-surface-variant">Server Status</p>
<p class="font-headline-sm text-headline-sm text-primary">Operational</p>
</div>
<div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
</div>
<div class="flex-1 bg-surface-container-high/30 border border-outline-variant/15 p-lg rounded-xl flex items-center justify-between">
<div>
<p class="font-label-md text-label-md text-on-surface-variant">API Latency</p>
<p class="font-headline-sm text-headline-sm text-primary">24ms</p>
</div>
<span class="material-symbols-outlined text-green-600" data-icon="bolt">bolt</span>
</div>
</div>
</div>
</section>
<section id="surveyor-management-panel" data-admin-panel="surveyors" class="admin-panel hidden space-y-xl">
<div class="max-w-container-max mx-auto space-y-xl">
<!-- Page Header & Stats Bento -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-lg">
<div class="md:col-span-2 space-y-sm">
<h2 class="font-headline-lg text-headline-lg text-primary">Surveyor Force Management</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant">Monitor, deploy, and analyze the performance of municipal field surveyors across all active districts.</p>
<div class="flex gap-md pt-md">
<button class="px-lg h-12 bg-primary text-on-primary rounded-xl font-label-lg flex items-center gap-sm hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined" data-icon="person_add">person_add</span>
                                Add New Surveyor
                            </button>
<button class="px-lg h-12 border border-outline text-on-surface rounded-xl font-label-lg flex items-center gap-sm hover:bg-surface-container-low transition-colors">
<span class="material-symbols-outlined" data-icon="file_download">file_download</span>
                                Export Report
                            </button>
</div>
</div>
<div class="bg-secondary-container p-lg rounded-xl flex flex-col justify-between">
<span class="material-symbols-outlined text-on-secondary-container" data-icon="how_to_reg">how_to_reg</span>
<div>
<p class="font-headline-md text-headline-md text-on-secondary-fixed">124</p>
<p class="font-label-md text-label-md text-on-secondary-container">Active Surveyors</p>
</div>
</div>
<div class="bg-surface-container-high p-lg rounded-xl flex flex-col justify-between border border-outline-variant/30">
<span class="material-symbols-outlined text-primary" data-icon="map">map</span>
<div>
<p class="font-headline-md text-headline-md text-primary">18</p>
<p class="font-label-md text-label-md text-on-surface-variant">Unassigned Regions</p>
</div>
</div>
</div>
<!-- Main Data Table Section -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant/15 shadow-sm overflow-hidden">
<!-- Table Header/Filters -->
<div class="p-lg flex flex-col md:flex-row md:items-center justify-between gap-md border-b border-outline-variant/15">
<div class="relative w-full md:w-96">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline" data-icon="search">search</span>
<input class="w-full pl-10 pr-4 py-2 border border-outline-variant rounded-lg text-body-sm focus:border-primary focus:ring-0" placeholder="Search by ID, Name, or Region..." type="text"/>
</div>
<div class="flex items-center gap-sm">
<button class="flex items-center gap-xs px-md py-2 bg-surface-container-low text-on-surface-variant rounded-lg font-label-md border border-outline-variant/20">
<span class="material-symbols-outlined text-base" data-icon="filter_list">filter_list</span>
                                Filter
                            </button>
<button class="flex items-center gap-xs px-md py-2 bg-surface-container-low text-on-surface-variant rounded-lg font-label-md border border-outline-variant/20">
<span class="material-symbols-outlined text-base" data-icon="sort">sort</span>
                                Sort
                            </button>
</div>
</div>
<!-- Table -->
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant/15">
<th class="px-lg py-4 font-label-lg text-label-lg text-on-surface-variant">Surveyor</th>
<th class="px-lg py-4 font-label-lg text-label-lg text-on-surface-variant">ID / Region</th>
<th class="px-lg py-4 font-label-lg text-label-lg text-on-surface-variant">Status</th>
<th class="px-lg py-4 font-label-lg text-label-lg text-on-surface-variant">Metrics (CM)</th>
<th class="px-lg py-4 font-label-lg text-label-lg text-on-surface-variant">Performance</th>
<th class="px-lg py-4 font-label-lg text-label-lg text-on-surface-variant text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/10">
<!-- Row 1 -->
<tr class="hover:bg-surface-container-low/50 transition-colors">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center font-bold text-on-primary-fixed">JD</div>
<div>
<p class="font-label-lg text-label-lg text-on-surface">Julianne Davis</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Field Lead</p>
</div>
</div>
</td>
<td class="px-lg py-4">
<p class="font-label-md text-label-md text-on-surface">#SRV-4092</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">North Riverside</p>
</td>
<td class="px-lg py-4">
<span class="inline-flex items-center px-sm py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-bold uppercase tracking-wider">
<span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-1.5"></span>
                                            Active
                                        </span>
</td>
<td class="px-lg py-4">
<p class="font-label-lg text-label-lg text-on-surface">452 <span class="text-xs font-normal text-on-surface-variant">Surveys</span></p>
</td>
<td class="px-lg py-4">
<div class="w-32 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-primary h-full w-[92%]"></div>
</div>
<p class="mt-1 text-[10px] text-on-surface-variant font-bold uppercase">92% Compliance</p>
</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm">
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/10 rounded-lg transition-all" title="Assign Region">
<span class="material-symbols-outlined" data-icon="location_on">location_on</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/10 rounded-lg transition-all" title="View Profile">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
</button>
</div>
</td>
</tr>
<!-- Row 2 -->
<tr class="bg-tertiary-fixed/10 hover:bg-surface-container-low/50 transition-colors">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded-full bg-secondary-fixed flex items-center justify-center font-bold text-on-secondary-fixed">MB</div>
<div>
<p class="font-label-lg text-label-lg text-on-surface">Marcus Bennett</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Senior Surveyor</p>
</div>
</div>
</td>
<td class="px-lg py-4">
<p class="font-label-md text-label-md text-on-surface">#SRV-3811</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">East District (B)</p>
</td>
<td class="px-lg py-4">
<span class="inline-flex items-center px-sm py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-bold uppercase tracking-wider">
<span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-1.5"></span>
                                            Active
                                        </span>
</td>
<td class="px-lg py-4">
<p class="font-label-lg text-label-lg text-on-surface">389 <span class="text-xs font-normal text-on-surface-variant">Surveys</span></p>
</td>
<td class="px-lg py-4">
<div class="w-32 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-primary h-full w-[84%]"></div>
</div>
<p class="mt-1 text-[10px] text-on-surface-variant font-bold uppercase">84% Compliance</p>
</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm">
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/10 rounded-lg transition-all">
<span class="material-symbols-outlined" data-icon="location_on">location_on</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/10 rounded-lg transition-all">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
</button>
</div>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-surface-container-low/50 transition-colors">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center font-bold text-on-surface">AL</div>
<div>
<p class="font-label-lg text-label-lg text-on-surface">Alisha Lin</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Junior Surveyor</p>
</div>
</div>
</td>
<td class="px-lg py-4">
<p class="font-label-md text-label-md text-on-surface">#SRV-5210</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">West Hills Sector</p>
</td>
<td class="px-lg py-4">
<span class="inline-flex items-center px-sm py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold uppercase tracking-wider">
<span class="w-1.5 h-1.5 rounded-full bg-amber-600 mr-1.5"></span>
                                            On Leave
                                        </span>
</td>
<td class="px-lg py-4">
<p class="font-label-lg text-label-lg text-on-surface">112 <span class="text-xs font-normal text-on-surface-variant">Surveys</span></p>
</td>
<td class="px-lg py-4">
<div class="w-32 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-primary h-full w-[78%]"></div>
</div>
<p class="mt-1 text-[10px] text-on-surface-variant font-bold uppercase">78% Compliance</p>
</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm">
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/10 rounded-lg transition-all">
<span class="material-symbols-outlined" data-icon="location_on">location_on</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/10 rounded-lg transition-all">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
</button>
</div>
</td>
</tr>
<!-- Row 4 -->
<tr class="bg-tertiary-fixed/10 hover:bg-surface-container-low/50 transition-colors">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded-full bg-error-container flex items-center justify-center font-bold text-on-error-container">RS</div>
<div>
<p class="font-label-lg text-label-lg text-on-surface">Robert Sanchez</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">Field Technician</p>
</div>
</div>
</td>
<td class="px-lg py-4">
<p class="font-label-md text-label-md text-on-surface">#SRV-2900</p>
<p class="font-body-sm text-body-sm text-on-surface-variant">South Pier Area</p>
</td>
<td class="px-lg py-4">
<span class="inline-flex items-center px-sm py-1 rounded-full bg-red-100 text-red-800 text-[10px] font-bold uppercase tracking-wider">
<span class="w-1.5 h-1.5 rounded-full bg-red-600 mr-1.5"></span>
                                            Suspended
                                        </span>
</td>
<td class="px-lg py-4">
<p class="font-label-lg text-label-lg text-on-surface">54 <span class="text-xs font-normal text-on-surface-variant">Surveys</span></p>
</td>
<td class="px-lg py-4">
<div class="w-32 h-1.5 bg-surface-container-high rounded-full overflow-hidden">
<div class="bg-error h-full w-[45%]"></div>
</div>
<p class="mt-1 text-[10px] text-error font-bold uppercase">45% Compliance</p>
</td>
<td class="px-lg py-4 text-right">
<div class="flex justify-end gap-sm">
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/10 rounded-lg transition-all">
<span class="material-symbols-outlined" data-icon="location_on">location_on</span>
</button>
<button class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/10 rounded-lg transition-all">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
</button>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Pagination -->
<div class="p-lg flex items-center justify-between border-t border-outline-variant/15">
<p class="font-body-sm text-body-sm text-on-surface-variant">Showing <span class="font-semibold text-on-surface">1 - 4</span> of 124 surveyors</p>
<div class="flex items-center gap-sm">
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container-low disabled:opacity-30" disabled="">
<span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
</button>
<button class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-on-primary font-label-md">1</button>
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container-low font-label-md">2</button>
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container-low font-label-md">3</button>
<span class="px-2 text-on-surface-variant">...</span>
<button class="w-10 h-10 flex items-center justify-center rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container-low">
<span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- Featured Analytics Cards -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
<div class="lg:col-span-2 bg-surface-container-low rounded-xl p-lg border border-outline-variant/15">
<div class="flex justify-between items-start mb-xl">
<div>
<h3 class="font-headline-sm text-headline-sm text-primary">Regional Distribution</h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Surveyor coverage density across municipal zones.</p>
</div>
<button class="p-2 bg-surface-container-lowest border border-outline-variant/20 rounded-lg">
<span class="material-symbols-outlined" data-icon="fullscreen">fullscreen</span>
</button>
</div>
<div class="aspect-[21/9] w-full bg-surface-container-highest rounded-lg overflow-hidden relative group">
<img alt="Municipal Map" class="w-full h-full object-cover grayscale opacity-60 group-hover:grayscale-0 transition-all duration-700" data-location="Chicago" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCWdGD7ZDna6t4C-jdO8_CH45PuV4GZoWEuJub55G_AnGESb_M6JMzOs7fjl3wbYKJgfJPukXIlwcAC2R6fO2pW3YHhSmcCdAyDo-NmpqCScUQxsBtUtxbCmBjOmlZqFB6uztIytjjhGR-ZnqNdsVys5yPpwA3CcfudSI1TXhHOB7G9y136K5fSv4F7h2zXrkb8obP7mEjW4oZXVDPzpCr0wMCN_78yExys92eoXR-7A5lndjduB2Y_yhhwqSI9OzqjK68VxclcIsSj"/>
<div class="absolute inset-0 bg-primary/10 mix-blend-overlay"></div>
<!-- Mock Data Visualization Overlay -->
<div class="absolute top-1/4 left-1/3 w-8 h-8 bg-primary/30 border-2 border-primary rounded-full animate-pulse flex items-center justify-center">
<div class="w-2 h-2 bg-primary rounded-full"></div>
</div>
<div class="absolute bottom-1/3 right-1/4 w-12 h-12 bg-secondary/30 border-2 border-secondary rounded-full flex items-center justify-center">
<div class="w-3 h-3 bg-secondary rounded-full"></div>
</div>
</div>
</div>
<div class="bg-surface-container-lowest border border-outline-variant/15 rounded-xl p-lg flex flex-col">
<h3 class="font-headline-sm text-headline-sm text-primary mb-md">Quick Actions</h3>
<div class="space-y-sm flex-1">
<button class="w-full flex items-center justify-between p-md bg-surface hover:bg-surface-container-low rounded-lg border border-outline-variant/10 transition-all group">
<div class="flex items-center gap-md">
<span class="material-symbols-outlined text-primary" data-icon="add_location">add_location</span>
<span class="font-label-lg text-label-lg">New Assignment</span>
</div>
<span class="material-symbols-outlined opacity-0 group-hover:opacity-100 transition-opacity" data-icon="arrow_forward">arrow_forward</span>
</button>
<button class="w-full flex items-center justify-between p-md bg-surface hover:bg-surface-container-low rounded-lg border border-outline-variant/10 transition-all group">
<div class="flex items-center gap-md">
<span class="material-symbols-outlined text-primary" data-icon="assignment_late">assignment_late</span>
<span class="font-label-lg text-label-lg">Review Flagged Data</span>
</div>
<span class="material-symbols-outlined opacity-0 group-hover:opacity-100 transition-opacity" data-icon="arrow_forward">arrow_forward</span>
</button>
<button class="w-full flex items-center justify-between p-md bg-surface hover:bg-surface-container-low rounded-lg border border-outline-variant/10 transition-all group">
<div class="flex items-center gap-md">
<span class="material-symbols-outlined text-primary" data-icon="rate_review">rate_review</span>
<span class="font-label-lg text-label-lg">Performance Reviews</span>
</div>
<span class="material-symbols-outlined opacity-0 group-hover:opacity-100 transition-opacity" data-icon="arrow_forward">arrow_forward</span>
</button>
</div>
<div class="mt-xl p-md bg-primary-container/10 rounded-xl border border-primary-container/20">
<p class="font-label-md text-label-md text-primary font-bold mb-xs">System Status</p>
<div class="flex items-center gap-sm">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
<span class="font-body-sm text-body-sm text-on-surface">GPS Feed: Operational</span>
</div>
</div>
</div>
</div>
</div>
</section>
<section id="verification-queue-panel" data-admin-panel="verification" class="admin-panel hidden space-y-lg">
<div class="max-w-container-max mx-auto space-y-lg">
<!-- Page Header & Stats -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-md">
<div>
<nav class="flex items-center gap-xs text-on-surface-variant mb-2">
<span class="font-body-sm text-body-sm">Admin</span>
<span class="material-symbols-outlined text-[14px]">chevron_right</span>
<span class="font-body-sm text-body-sm font-semibold text-primary">Verification Queue</span>
</nav>
<h2 class="font-headline-lg text-headline-lg text-primary">Verification Queue</h2>
<p class="text-on-surface-variant font-body-md mt-1">Efficiently process and validate pending municipal survey requests.</p>
</div>
<!-- Quick Stats Chips -->
<div class="flex gap-sm">
<div class="bg-surface-container rounded-xl px-md py-2 border border-outline-variant/10 flex items-center gap-sm">
<span class="material-symbols-outlined text-secondary text-[20px]">pending_actions</span>
<span class="text-body-sm font-semibold">24 Pending</span>
</div>
<div class="bg-surface-container rounded-xl px-md py-2 border border-outline-variant/10 flex items-center gap-sm">
<span class="material-symbols-outlined text-error text-[20px]">priority_high</span>
<span class="text-body-sm font-semibold">5 Urgent</span>
</div>
</div>
</div>
<!-- Filter Bar -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant/15 p-md flex flex-wrap gap-md items-center">
<div class="flex items-center gap-sm flex-grow">
<span class="text-label-lg font-label-lg text-on-surface-variant">Filter by:</span>
<select class="bg-surface-container-low border border-outline-variant rounded-lg px-md py-1.5 text-body-sm focus:ring-2 focus:ring-primary/20">
<option>Status: All Pending</option>
<option>Urgent Only</option>
<option>Awaiting Review</option>
</select>
<select class="bg-surface-container-low border border-outline-variant rounded-lg px-md py-1.5 text-body-sm focus:ring-2 focus:ring-primary/20">
<option>Date: Newest First</option>
<option>Date: Oldest First</option>
</select>
</div>
<div class="flex items-center gap-sm">
<button class="flex items-center gap-xs px-md py-2 border border-outline text-on-surface rounded-lg hover:bg-surface-container-low transition-all text-label-lg font-label-lg">
<span class="material-symbols-outlined text-[18px]">download</span>
                                Export
                            </button>
<button class="flex items-center gap-xs px-md py-2 bg-primary text-on-primary rounded-lg hover:brightness-110 transition-all text-label-lg font-label-lg">
<span class="material-symbols-outlined text-[18px]">bolt</span>
                                Bulk Process
                            </button>
</div>
</div>
<!-- High-Density Queue List -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant/15 overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full border-collapse text-left">
<thead class="bg-surface-container-low border-b border-outline-variant/20">
<tr>
<th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider w-12">
<input class="rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/>
</th>
<th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Business / Client</th>
<th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Owner</th>
<th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Surveyor</th>
<th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Submission Date</th>
<th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Status</th>
<th class="px-md py-3 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody>
<!-- Row 1 -->
<tr class="zebra-stripe hover:bg-surface-container transition-colors group">
<td class="px-md py-4"><input class="rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/></td>
<td class="px-md py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary">store</span>
</div>
<div>
<div class="font-semibold text-primary">Riverside Bakery &amp; Café</div>
<div class="text-body-sm text-on-surface-variant">Ref: #SRV-9021</div>
</div>
</div>
</td>
<td class="px-md py-4 text-body-md">Elena Rodriguez</td>
<td class="px-md py-4">
<div class="flex items-center gap-xs">
<span class="material-symbols-outlined text-[16px] text-on-surface-variant">person</span>
<span class="text-body-sm">Mark Thompson</span>
</div>
</td>
<td class="px-md py-4 text-body-sm text-on-surface-variant">Oct 12, 2023 · 09:45 AM</td>
<td class="px-md py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase">
                                                Pending Review
                                            </span>
</td>
<td class="px-md py-4">
<div class="flex justify-end gap-sm">
<button class="p-1.5 text-success hover:bg-green-100 rounded transition-colors" onclick="handleAction('approve', 'Riverside Bakery')" title="Approve">
<span class="material-symbols-outlined text-green-600">check_circle</span>
</button>
<button class="p-1.5 text-warning hover:bg-amber-100 rounded transition-colors" onclick="handleAction('flag', 'Riverside Bakery')" title="Flag for Review">
<span class="material-symbols-outlined text-amber-600">flag</span>
</button>
<button class="p-1.5 text-error hover:bg-red-100 rounded transition-colors" onclick="handleAction('reject', 'Riverside Bakery')" title="Reject">
<span class="material-symbols-outlined">cancel</span>
</button>
</div>
</td>
</tr>
<!-- Row 2 -->
<tr class="zebra-stripe hover:bg-surface-container transition-colors group">
<td class="px-md py-4"><input class="rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/></td>
<td class="px-md py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary">apartment</span>
</div>
<div>
<div class="font-semibold text-primary">Apex Logistics Hub</div>
<div class="text-body-sm text-on-surface-variant">Ref: #SRV-8842</div>
</div>
</div>
</td>
<td class="px-md py-4 text-body-md">Sanjay Gupta</td>
<td class="px-md py-4">
<div class="flex items-center gap-xs">
<span class="material-symbols-outlined text-[16px] text-on-surface-variant">person</span>
<span class="text-body-sm">Sarah Jenkins</span>
</div>
</td>
<td class="px-md py-4 text-body-sm text-on-surface-variant">Oct 11, 2023 · 04:20 PM</td>
<td class="px-md py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-error-container text-error uppercase">
                                                Urgent
                                            </span>
</td>
<td class="px-md py-4">
<div class="flex justify-end gap-sm">
<button class="p-1.5 hover:bg-green-100 rounded transition-colors" title="Approve">
<span class="material-symbols-outlined text-green-600">check_circle</span>
</button>
<button class="p-1.5 hover:bg-amber-100 rounded transition-colors" title="Flag for Review">
<span class="material-symbols-outlined text-amber-600">flag</span>
</button>
<button class="p-1.5 hover:bg-red-100 rounded transition-colors" title="Reject">
<span class="material-symbols-outlined text-error">cancel</span>
</button>
</div>
</td>
</tr>
<!-- Row 3 -->
<tr class="zebra-stripe hover:bg-surface-container transition-colors group">
<td class="px-md py-4"><input class="rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/></td>
<td class="px-md py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary">medical_services</span>
</div>
<div>
<div class="font-semibold text-primary">Summit Health Center</div>
<div class="text-body-sm text-on-surface-variant">Ref: #SRV-9104</div>
</div>
</div>
</td>
<td class="px-md py-4 text-body-md">Linda Chen</td>
<td class="px-md py-4">
<div class="flex items-center gap-xs">
<span class="material-symbols-outlined text-[16px] text-on-surface-variant">person</span>
<span class="text-body-sm">Mark Thompson</span>
</div>
</td>
<td class="px-md py-4 text-body-sm text-on-surface-variant">Oct 11, 2023 · 11:15 AM</td>
<td class="px-md py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase">
                                                Pending Review
                                            </span>
</td>
<td class="px-md py-4">
<div class="flex justify-end gap-sm">
<button class="p-1.5 hover:bg-green-100 rounded transition-colors">
<span class="material-symbols-outlined text-green-600">check_circle</span>
</button>
<button class="p-1.5 hover:bg-amber-100 rounded transition-colors">
<span class="material-symbols-outlined text-amber-600">flag</span>
</button>
<button class="p-1.5 hover:bg-red-100 rounded transition-colors">
<span class="material-symbols-outlined text-error">cancel</span>
</button>
</div>
</td>
</tr>
<!-- Row 4 -->
<tr class="zebra-stripe hover:bg-surface-container transition-colors group">
<td class="px-md py-4"><input class="rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/></td>
<td class="px-md py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary">construction</span>
</div>
<div>
<div class="font-semibold text-primary">Northside Dev Group</div>
<div class="text-body-sm text-on-surface-variant">Ref: #SRV-8752</div>
</div>
</div>
</td>
<td class="px-md py-4 text-body-md">David Miller</td>
<td class="px-md py-4">
<div class="flex items-center gap-xs">
<span class="material-symbols-outlined text-[16px] text-on-surface-variant">person</span>
<span class="text-body-sm">Amara Okafor</span>
</div>
</td>
<td class="px-md py-4 text-body-sm text-on-surface-variant">Oct 10, 2023 · 02:30 PM</td>
<td class="px-md py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase">
                                                Pending Review
                                            </span>
</td>
<td class="px-md py-4">
<div class="flex justify-end gap-sm">
<button class="p-1.5 hover:bg-green-100 rounded transition-colors">
<span class="material-symbols-outlined text-green-600">check_circle</span>
</button>
<button class="p-1.5 hover:bg-amber-100 rounded transition-colors">
<span class="material-symbols-outlined text-amber-600">flag</span>
</button>
<button class="p-1.5 hover:bg-red-100 rounded transition-colors">
<span class="material-symbols-outlined text-error">cancel</span>
</button>
</div>
</td>
</tr>
<!-- Row 5 -->
<tr class="zebra-stripe hover:bg-surface-container transition-colors group">
<td class="px-md py-4"><input class="rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/></td>
<td class="px-md py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary">local_florist</span>
</div>
<div>
<div class="font-semibold text-primary">Bloom &amp; Ivy Florals</div>
<div class="text-body-sm text-on-surface-variant">Ref: #SRV-9231</div>
</div>
</div>
</td>
<td class="px-md py-4 text-body-md">Isabella Rossi</td>
<td class="px-md py-4">
<div class="flex items-center gap-xs">
<span class="material-symbols-outlined text-[16px] text-on-surface-variant">person</span>
<span class="text-body-sm">Sarah Jenkins</span>
</div>
</td>
<td class="px-md py-4 text-body-sm text-on-surface-variant">Oct 10, 2023 · 09:10 AM</td>
<td class="px-md py-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase">
                                                Pending Review
                                            </span>
</td>
<td class="px-md py-4">
<div class="flex justify-end gap-sm">
<button class="p-1.5 hover:bg-green-100 rounded transition-colors">
<span class="material-symbols-outlined text-green-600">check_circle</span>
</button>
<button class="p-1.5 hover:bg-amber-100 rounded transition-colors">
<span class="material-symbols-outlined text-amber-600">flag</span>
</button>
<button class="p-1.5 hover:bg-red-100 rounded transition-colors">
<span class="material-symbols-outlined text-error">cancel</span>
</button>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Pagination -->
<div class="flex flex-col sm:flex-row items-center justify-between px-lg py-4 bg-surface-container-low border-t border-outline-variant/15 gap-md">
<span class="text-body-sm text-on-surface-variant">Showing <span class="font-bold text-on-surface">1 - 5</span> of 24 submissions</span>
<div class="flex items-center gap-sm">
<button class="p-2 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high disabled:opacity-30" disabled="">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="px-3 py-1 border border-primary bg-primary text-on-primary rounded-lg text-body-sm font-bold">1</button>
<button class="px-3 py-1 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high text-body-sm">2</button>
<button class="px-3 py-1 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high text-body-sm">3</button>
<button class="p-2 border border-outline-variant rounded-lg text-on-surface-variant hover:bg-surface-container-high">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- Details Panel (Asymmetric Layout Hint) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-lg mt-xl">
<div class="lg:col-span-2 bg-surface-container-low rounded-2xl p-xl border border-outline-variant/10 relative overflow-hidden group">
<div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform"></div>
<h3 class="font-headline-sm text-headline-sm text-primary mb-md">Submission Intelligence</h3>
<p class="text-body-md text-on-surface-variant mb-lg leading-relaxed">Select a row to view comprehensive survey documentation, site photographs, and surveyor telemetry data. Use the quick actions for rapid throughput, or open full review for complex cases requiring multi-departmental sign-off.</p>
<div class="flex gap-md">
<div class="flex-1 p-md bg-surface-container-lowest rounded-xl border border-outline-variant/10">
<div class="text-label-md text-on-surface-variant uppercase mb-2">Avg. Processing Time</div>
<div class="text-headline-md font-bold text-primary">14.2m</div>
</div>
<div class="flex-1 p-md bg-surface-container-lowest rounded-xl border border-outline-variant/10">
<div class="text-label-md text-on-surface-variant uppercase mb-2">Approval Rate</div>
<div class="text-headline-md font-bold text-primary">88%</div>
</div>
</div>
</div>
<div class="bg-primary text-on-primary rounded-2xl p-xl flex flex-col justify-between shadow-lg relative overflow-hidden">
<div class="absolute -bottom-8 -right-8 opacity-10">
<span class="material-symbols-outlined text-[120px]">fact_check</span>
</div>
<div>
<h3 class="font-headline-sm text-headline-sm mb-sm">Verification Summary</h3>
<p class="opacity-80 text-body-sm">You have processed 12 requests today. You are 3 submissions away from your daily optimization target.</p>
</div>
<button class="mt-lg w-full py-3 bg-on-primary text-primary font-bold rounded-xl hover:bg-surface-container-lowest transition-colors flex items-center justify-center gap-sm">
                                View Daily Report
                                <span class="material-symbols-outlined">arrow_forward</span>
</button>
</div>
</div>
</div>
</section>
</main>
</div>
</div>
<!-- Modal Placeholder (Reject Action) -->
<div class="fixed inset-0 bg-on-background/40 backdrop-blur-sm z-[100] hidden items-center justify-center p-md" id="actionModal">
<div class="bg-surface-container-lowest rounded-2xl w-full max-w-md p-xl shadow-2xl border border-outline-variant/20">
<div class="flex items-center gap-md mb-lg">
<div class="w-12 h-12 rounded-full flex items-center justify-center" id="modalIcon"></div>
<h4 class="font-headline-sm text-headline-sm" id="modalTitle">Action Required</h4>
</div>
<div class="space-y-md">
<p class="text-body-md text-on-surface-variant" id="modalDescription">Are you sure you want to perform this action for <span class="font-bold text-on-surface" id="businessName"></span>?</p>
<div>
<label class="block font-label-lg text-label-lg mb-2">Internal Comments (Mandatory)</label>
<textarea class="w-full bg-surface-container-low border border-outline-variant rounded-xl p-md text-body-sm focus:ring-2 focus:ring-primary/20" placeholder="Enter reason for this action..." rows="3"></textarea>
</div>
</div>
<div class="flex gap-md mt-xl">
<button class="flex-1 py-3 border border-outline text-on-surface font-bold rounded-xl hover:bg-surface-container-low transition-colors" onclick="closeModal()">Cancel</button>
<button class="flex-1 py-3 text-on-primary font-bold rounded-xl transition-all" id="confirmBtn">Confirm Action</button>
</div>
</div>
</div>
<!-- Mobile Navigation Shell (Bottom Bar) -->
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-surface-container-lowest border-t border-outline-variant/15 flex justify-around py-sm z-50">
<button class="admin-nav-link flex flex-col items-center gap-xs text-primary" type="button" data-admin-view="dashboard">
<span class="material-symbols-outlined" data-icon="dashboard" style="font-variation-settings: 'FILL' 1;">dashboard</span>
<span class="text-[10px] font-label-md">Home</span>
</button>
<a class="flex flex-col items-center gap-xs text-on-surface-variant" href="#">
<span class="material-symbols-outlined" data-icon="analytics">analytics</span>
<span class="text-[10px] font-label-md">Data</span>
</a>
<button class="admin-nav-link flex flex-col items-center gap-xs text-on-surface-variant" type="button" data-admin-view="surveyors">
<span class="material-symbols-outlined" data-icon="group">group</span>
<span class="text-[10px] font-label-md">Surveyors</span>
</button>
<button class="admin-nav-link flex flex-col items-center gap-xs text-on-surface-variant" type="button" data-admin-view="verification">
<span class="material-symbols-outlined" data-icon="fact_check">fact_check</span>
<span class="text-[10px] font-label-md">Queue</span>
</button>
</div>
<script>
const modal = document.getElementById('actionModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalIcon = document.getElementById('modalIcon');
        const confirmBtn = document.getElementById('confirmBtn');
        const businessNameSpan = document.getElementById('businessName');

        function handleAction(type, name) {
            businessNameSpan.textContent = name;
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            if (type === 'approve') {
                modalTitle.textContent = "Approve Submission";
                modalIcon.className = "w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700";
                modalIcon.innerHTML = '<span class="material-symbols-outlined text-[32px]">check_circle</span>';
                confirmBtn.className = "flex-1 py-3 bg-green-600 text-on-primary font-bold rounded-xl hover:bg-green-700 transition-all";
                confirmBtn.textContent = "Approve";
            } else if (type === 'flag') {
                modalTitle.textContent = "Flag for Review";
                modalIcon.className = "w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-700";
                modalIcon.innerHTML = '<span class="material-symbols-outlined text-[32px]">flag</span>';
                confirmBtn.className = "flex-1 py-3 bg-amber-600 text-on-primary font-bold rounded-xl hover:bg-amber-700 transition-all";
                confirmBtn.textContent = "Flag Submission";
            } else if (type === 'reject') {
                modalTitle.textContent = "Reject Submission";
                modalIcon.className = "w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-700";
                modalIcon.innerHTML = '<span class="material-symbols-outlined text-[32px]">cancel</span>';
                confirmBtn.className = "flex-1 py-3 bg-red-600 text-on-primary font-bold rounded-xl hover:bg-red-700 transition-all";
                confirmBtn.textContent = "Reject";
            }
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Add some micro-interactions
        document.querySelectorAll('tr').forEach(row => {
            row.addEventListener('click', (e) => {
                if (e.target.type !== 'checkbox' && !e.target.closest('button')) {
                    // Logic to select row or show details
                    console.log('Row clicked');
                }
            });
        });

        const panels = document.querySelectorAll('[data-admin-panel]');
        const navLinks = document.querySelectorAll('[data-admin-view]');
        const activeNavClasses = [
            'bg-secondary-fixed',
            'dark:bg-primary-container',
            'text-on-secondary-fixed',
            'dark:text-on-primary-container',
            'text-primary',
            'translate-x-1',
        ];
        const inactiveNavClasses = [
            'text-on-surface-variant',
            'dark:text-on-tertiary-container',
            'hover:bg-surface-container-high',
            'dark:hover:bg-surface-container',
        ];

        function setAdminView(view) {
            panels.forEach(panel => {
                panel.classList.toggle('hidden', panel.dataset.adminPanel !== view);
            });

            navLinks.forEach(link => {
                const isActive = link.dataset.adminView === view;
                link.classList.toggle('bg-secondary-fixed', isActive);
                link.classList.toggle('dark:bg-primary-container', isActive);
                link.classList.toggle('text-on-secondary-fixed', isActive && !link.classList.contains('flex-col'));
                link.classList.toggle('dark:text-on-primary-container', isActive);
                link.classList.toggle('text-primary', isActive);
                link.classList.toggle('translate-x-1', isActive && !link.classList.contains('flex-col'));

                inactiveNavClasses.forEach(className => {
                    link.classList.toggle(className, !isActive);
                });

                const icon = link.querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.style.fontVariationSettings = isActive ? "'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24" : '';
                }
            });

            if (modal) {
                closeModal();
            }

            window.location.hash = view;
        }

        navLinks.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                setAdminView(link.dataset.adminView);
            });
        });

        const initialView = window.location.hash.replace('#', '');
        if (['dashboard', 'surveyors', 'verification'].includes(initialView)) {
            setAdminView(initialView);
        }

        // Micro-interactions and UI Logic
        document.querySelectorAll('button, a').forEach(el => {
            el.addEventListener('mousedown', () => {
                el.classList.add('scale-95');
            });
            el.addEventListener('mouseup', () => {
                el.classList.remove('scale-95');
            });
            el.addEventListener('mouseleave', () => {
                el.classList.remove('scale-95');
            });
        });

        // Simple Fade In Effect
        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.6s ease-in-out';
            requestAnimationFrame(() => {
                document.body.style.opacity = '1';
            });
        });
    </script>
</body></html>
