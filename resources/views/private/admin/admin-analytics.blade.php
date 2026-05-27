<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>CityGov Admin - Governance Analytics</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@100..900&amp;display=swap" rel="stylesheet"/>
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
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f9f9fc;
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        .zebra-stripe tr:nth-child(even) {
            background-color: #EBF1F5;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(115, 119, 128, 0.15);
        }
    </style>
</head>
<body class="bg-background text-on-surface">
<!-- TopNavBar -->
<header class="flex justify-between items-center w-full px-lg h-16 sticky top-0 z-50 bg-surface-container-lowest dark:bg-surface-dim border-b border-outline-variant/15 flat no shadows">
<div class="flex items-center gap-md">
<span class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed">CityGov Admin</span>
</div>
<div class="flex items-center gap-lg">
<div class="hidden md:flex items-center bg-surface-container-low px-md py-xs rounded-full border border-outline-variant/30">
<span class="material-symbols-outlined text-on-surface-variant pr-xs">search</span>
<input class="bg-transparent border-none focus:ring-0 text-label-md w-64" placeholder="Global search..." type="text"/>
</div>
<div class="flex items-center gap-md">
<button class="material-symbols-outlined text-primary dark:text-primary-fixed hover:bg-surface-container-low p-xs rounded-full transition-colors">notifications</button>
<button class="material-symbols-outlined text-primary dark:text-primary-fixed hover:bg-surface-container-low p-xs rounded-full transition-colors">settings</button>
<div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center overflow-hidden">
<img alt="Administrator Profile" data-alt="A professional portrait of a senior municipal administrator in a bright, modern corporate office. The lighting is soft and natural, coming from a large window overlooking a clean city landscape. The individual is wearing a sharp, professional navy blue suit, projecting an aura of reliable authority and modern governance. The overall image style is clean, high-resolution, and perfectly aligned with a light-mode institutional aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBzGMuagc9Z4r5GLVe-BDoFqSpHAfSPTqdC8VFWedASaZcW0blXGqRTp4AakWSzSQYB8H0aF_KYYrng2dCdfNLDPL1GMPC2eKjHYPSxRo_qF48BNFlYGmi2zzXqmKO4MFn1kX8wr9YPKp7D3xlzc847xXzzZT6CRL5tqJIlb7V1fDzz4z8UHnyVGBJmqZHrgG902t2XTP2SKBwiJ62Nuhs2zLD4_XvvGwT8NrN5fGNaT763TDQCimLWb64rfMaOwLl2PP7ckPV89XHs"/>
</div>
</div>
</div>
</header>
<div class="flex h-[calc(100vh-64px)] overflow-hidden">
<!-- SideNavBar -->
<nav class="flex flex-col h-full border-r border-outline-variant/15 py-md bg-surface dark:bg-surface-dim docked left-0 h-screen w-64">
<div class="px-lg mb-xl">
<div class="flex items-center gap-sm">
<div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">account_balance</span>
</div>
<div>
<div class="font-headline-sm text-headline-sm font-bold text-primary">Municipal Oversight</div>
<div class="text-label-md text-on-surface-variant">Governance Portal</div>
</div>
</div>
</div>
<div class="flex-grow flex flex-col gap-1">
<a class="flex items-center gap-md px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" href="#">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-label-lg text-label-lg">Dashboard</span>
</a>
<a class="flex items-center gap-md px-lg py-md bg-secondary-fixed dark:bg-primary-container text-on-secondary-fixed dark:text-on-primary-container rounded-xl mx-2 my-1 transition-all translate-x-1 duration-200" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">analytics</span>
<span class="font-label-lg text-label-lg">Analytics</span>
</a>
<a class="flex items-center gap-md px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" href="#">
<span class="material-symbols-outlined">group</span>
<span class="font-label-lg text-label-lg">Surveyors</span>
</a>
<a class="flex items-center gap-md px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" href="#">
<span class="material-symbols-outlined">fact_check</span>
<span class="font-label-lg text-label-lg">Verification Queue</span>
</a>
</div>
<div class="mt-auto flex flex-col gap-1 pt-md border-t border-outline-variant/10">
<a class="flex items-center gap-md px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" href="#">
<span class="material-symbols-outlined">help</span>
<span class="font-label-lg text-label-lg">Support</span>
</a>
<a class="flex items-center gap-md px-lg py-md text-on-surface-variant dark:text-on-tertiary-container hover:bg-surface-container-high dark:hover:bg-surface-container rounded-xl mx-2 my-1 transition-all" href="#">
<span class="material-symbols-outlined">history</span>
<span class="font-label-lg text-label-lg">Archive</span>
</a>
</div>
</nav>
<!-- Main Content Area -->
<main class="flex-grow overflow-y-auto p-lg">
<div class="max-w-container-max mx-auto">
<!-- Header & Controls -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-xl gap-md">
<div>
<h1 class="font-headline-lg text-headline-lg text-primary">Governance Analytics &amp; Trends</h1>
<p class="font-body-md text-body-md text-on-surface-variant mt-xs">Comprehensive MSME growth and digitalization metrics across municipal sectors.</p>
</div>
<div class="flex items-center gap-md w-full md:w-auto">
<div class="flex bg-surface-container rounded-xl p-xs border border-outline-variant/30">
<input class="bg-transparent border-none text-label-md focus:ring-0 p-xs" type="date" value="2023-01-01"/>
<span class="flex items-center px-xs text-outline">—</span>
<input class="bg-transparent border-none text-label-md focus:ring-0 p-xs" type="date" value="2023-12-31"/>
</div>
<button class="bg-primary text-white font-label-lg px-lg h-[48px] rounded-xl flex items-center gap-sm hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined">download</span>
                            Export Report
                        </button>
</div>
</div>
<!-- KPI Bento Grid -->
<div class="bento-grid mb-xl">
<!-- Total Growth -->
<div class="col-span-12 md:col-span-4 glass-card p-lg rounded-xl flex flex-col justify-between">
<div class="flex justify-between items-start">
<div class="w-12 h-12 rounded-full bg-secondary-fixed flex items-center justify-center">
<span class="material-symbols-outlined text-on-secondary-fixed">trending_up</span>
</div>
<span class="text-label-md text-primary bg-secondary-fixed px-sm py-xs rounded-full">+12.4% vs LY</span>
</div>
<div class="mt-md">
<div class="text-label-lg text-on-surface-variant">Total MSME Growth</div>
<div class="font-display-lg text-display-lg text-primary">14,892</div>
<div class="text-body-sm text-on-tertiary-container mt-xs">Active registered enterprises city-wide</div>
</div>
</div>
<!-- Digital Adoption -->
<div class="col-span-12 md:col-span-4 glass-card p-lg rounded-xl flex flex-col justify-between">
<div class="flex justify-between items-start">
<div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center">
<span class="material-symbols-outlined text-on-tertiary-fixed">devices</span>
</div>
<span class="text-label-md text-on-primary-container bg-primary-fixed px-sm py-xs rounded-full">High Level</span>
</div>
<div class="mt-md">
<div class="text-label-lg text-on-surface-variant">Digitalization Level</div>
<div class="font-display-lg text-display-lg text-primary">68%</div>
<div class="text-body-sm text-on-tertiary-container mt-xs">Enterprises with active online presence</div>
</div>
</div>
<!-- Regional Compliance -->
<div class="col-span-12 md:col-span-4 glass-card p-lg rounded-xl flex flex-col justify-between">
<div class="flex justify-between items-start">
<div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center">
<span class="material-symbols-outlined text-on-primary-fixed">verified</span>
</div>
<span class="text-label-md text-on-surface-variant bg-surface-container-high px-sm py-xs rounded-full">Target: 95%</span>
</div>
<div class="mt-md">
<div class="text-label-lg text-on-surface-variant">Verification Status</div>
<div class="font-display-lg text-display-lg text-primary">91.2%</div>
<div class="text-body-sm text-on-tertiary-container mt-xs">Compliance with municipal audit standards</div>
</div>
</div>
<!-- Main Chart: Growth Over Time -->
<div class="col-span-12 lg:col-span-8 bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl">
<div class="flex justify-between items-center mb-lg">
<h3 class="font-headline-sm text-headline-sm text-primary">MSME Registration Trends</h3>
<div class="flex gap-sm">
<button class="px-sm py-xs text-label-md bg-secondary-container text-on-secondary-container rounded-lg">Month</button>
<button class="px-sm py-xs text-label-md hover:bg-surface-container-high rounded-lg">Quarter</button>
<button class="px-sm py-xs text-label-md hover:bg-surface-container-high rounded-lg">Year</button>
</div>
</div>
<div class="h-64 flex items-end justify-between gap-sm pt-md">
<!-- Faux Bar Chart -->
<div class="flex-1 bg-primary-container/20 rounded-t-lg relative group" style="height: 40%;">
<div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-t-lg"></div>
<div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-label-md">Jan</div>
</div>
<div class="flex-1 bg-primary-container/20 rounded-t-lg relative group" style="height: 55%;">
<div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-t-lg"></div>
<div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-label-md">Feb</div>
</div>
<div class="flex-1 bg-primary-container/20 rounded-t-lg relative group" style="height: 45%;">
<div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-t-lg"></div>
<div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-label-md">Mar</div>
</div>
<div class="flex-1 bg-primary-container/20 rounded-t-lg relative group" style="height: 70%;">
<div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-t-lg"></div>
<div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-label-md">Apr</div>
</div>
<div class="flex-1 bg-primary-container/20 rounded-t-lg relative group" style="height: 85%;">
<div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-t-lg"></div>
<div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-label-md">May</div>
</div>
<div class="flex-1 bg-primary-container/20 rounded-t-lg relative group" style="height: 95%;">
<div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-t-lg"></div>
<div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-label-md">Jun</div>
</div>
<div class="flex-1 bg-primary-container/20 rounded-t-lg relative group" style="height: 75%;">
<div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-t-lg"></div>
<div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-label-md">Jul</div>
</div>
<div class="flex-1 bg-primary-container/20 rounded-t-lg relative group" style="height: 60%;">
<div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-100 transition-opacity rounded-t-lg"></div>
<div class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-label-md">Aug</div>
</div>
</div>
<div class="mt-12 flex items-center justify-center gap-xl border-t border-outline-variant/10 pt-md">
<div class="flex items-center gap-xs">
<span class="w-3 h-3 bg-primary rounded-full"></span>
<span class="text-label-md">Current Year</span>
</div>
<div class="flex items-center gap-xs">
<span class="w-3 h-3 bg-primary-container/20 rounded-full border border-primary/20"></span>
<span class="text-label-md">Previous Year</span>
</div>
</div>
</div>
<!-- Side Card: Category Distribution -->
<div class="col-span-12 lg:col-span-4 bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl">
<h3 class="font-headline-sm text-headline-sm text-primary mb-lg">Sector Distribution</h3>
<div class="flex flex-col gap-md">
<div class="space-y-xs">
<div class="flex justify-between text-label-lg">
<span>Retail &amp; Commerce</span>
<span class="font-bold">42%</span>
</div>
<div class="w-full bg-surface-container h-3 rounded-full overflow-hidden">
<div class="bg-primary h-full" style="width: 42%;"></div>
</div>
</div>
<div class="space-y-xs">
<div class="flex justify-between text-label-lg">
<span>Professional Services</span>
<span class="font-bold">28%</span>
</div>
<div class="w-full bg-surface-container h-3 rounded-full overflow-hidden">
<div class="bg-primary-container h-full" style="width: 28%;"></div>
</div>
</div>
<div class="space-y-xs">
<div class="flex justify-between text-label-lg">
<span>Manufacturing</span>
<span class="font-bold">15%</span>
</div>
<div class="w-full bg-surface-container h-3 rounded-full overflow-hidden">
<div class="bg-secondary h-full" style="width: 15%;"></div>
</div>
</div>
<div class="space-y-xs">
<div class="flex justify-between text-label-lg">
<span>Tech &amp; Creative</span>
<span class="font-bold">10%</span>
</div>
<div class="w-full bg-surface-container h-3 rounded-full overflow-hidden">
<div class="bg-outline h-full" style="width: 10%;"></div>
</div>
</div>
<div class="space-y-xs">
<div class="flex justify-between text-label-lg">
<span>Others</span>
<span class="font-bold">5%</span>
</div>
<div class="w-full bg-surface-container h-3 rounded-full overflow-hidden">
<div class="bg-outline-variant h-full" style="width: 5%;"></div>
</div>
</div>
</div>
<button class="w-full mt-lg py-md border border-primary text-primary font-label-lg rounded-xl hover:bg-primary-container/5 transition-colors">
                            View Detailed Breakdown
                        </button>
</div>
<!-- Map/Regional View -->
<div class="col-span-12 bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl">
<div class="flex justify-between items-center mb-lg">
<div>
<h3 class="font-headline-sm text-headline-sm text-primary">Regional Digitalization Distribution</h3>
<p class="text-body-sm text-on-surface-variant">Comparative analysis of infrastructure levels across city districts.</p>
</div>
<div class="flex gap-sm">
<select class="bg-surface-container border-none text-label-md rounded-lg focus:ring-0">
<option>Select Metropolitan District</option>
<option>Central Business District</option>
<option>Northern Industrial Hub</option>
<option>Eastern Innovation Zone</option>
</select>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-lg h-[400px]">
<div class="md:col-span-2 relative bg-surface-container rounded-xl overflow-hidden">
<img alt="Regional Digitalization Map" data-alt="A highly detailed 3D isometric heat map of a modern metropolitan city, highlighting different districts with varying shades of deep blue and bright gold to represent digitalization levels. The map is clean and professional, with sharp street grids and minimal architectural icons. The visual style is institutional and analytical, set against a pristine white background for a light-mode aesthetic, projecting a sense of advanced data-driven governance." data-location="New York" src="https://lh3.googleusercontent.com/aida-public/AB6AXuABgQXMsOg_bkBK2aWbAwm92mjnGJgfRfQbjosjQKXunZu8bjNS6C0g-iDnuq79JoesninwW9pcFolKaPKAJRXXk6D-dAMOtyJiVVE7w63U9Jgmd1t167X6ut2Z0ey7cVFb1qrsRG4kBa8ctMctf7SD8zWstxaD3pF7KhwMNw9I7znwbhlib00sS3WUAlRPuYpM8mQfCK-YpyvzmjTNBiA-ldJnETNcImiQOzvy7RNXFh_C9pVvpNSKJLoW1D0QLQz3f-fJ-bxNIjye"/>
<!-- Faux Map Hotspots -->
<div class="absolute top-1/4 left-1/3 w-8 h-8 bg-primary/40 rounded-full border-2 border-primary animate-pulse flex items-center justify-center">
<div class="w-2 h-2 bg-primary rounded-full"></div>
</div>
<div class="absolute bottom-1/3 right-1/4 w-8 h-8 bg-primary/40 rounded-full border-2 border-primary animate-pulse flex items-center justify-center">
<div class="w-2 h-2 bg-primary rounded-full"></div>
</div>
</div>
<div class="flex flex-col gap-md">
<div class="p-md bg-surface-container rounded-xl border border-outline-variant/20">
<div class="text-label-md text-on-surface-variant uppercase tracking-wider">Top Performing Region</div>
<div class="font-headline-sm text-headline-sm text-primary mt-xs">Central District</div>
<div class="flex items-center gap-sm text-body-sm text-primary mt-sm">
<span class="material-symbols-outlined text-[18px]">verified_user</span>
                                        84% Digital Adoption Rate
                                    </div>
</div>
<div class="p-md bg-surface-container rounded-xl border border-outline-variant/20">
<div class="text-label-md text-on-surface-variant uppercase tracking-wider">Fastest Growing Region</div>
<div class="font-headline-sm text-headline-sm text-primary mt-xs">East Riverside</div>
<div class="flex items-center gap-sm text-body-sm text-primary mt-sm">
<span class="material-symbols-outlined text-[18px]">trending_up</span>
                                        +18.5% YoY MSME Count
                                    </div>
</div>
<div class="p-md bg-surface-container rounded-xl border border-outline-variant/20">
<div class="text-label-md text-on-surface-variant uppercase tracking-wider">Area for Support</div>
<div class="font-headline-sm text-headline-sm text-error mt-xs">Western Periphery</div>
<div class="flex items-center gap-sm text-body-sm text-on-surface-variant mt-sm">
<span class="material-symbols-outlined text-[18px]">info</span>
                                        Requires Infrastructure Subsidy
                                    </div>
</div>
</div>
</div>
</div>
<!-- Data List: Recent Verification Audits -->
<div class="col-span-12 bg-surface-container-lowest border border-outline-variant/15 p-lg rounded-xl overflow-hidden">
<div class="flex justify-between items-center mb-lg">
<h3 class="font-headline-sm text-headline-sm text-primary">Recent Verification Audits</h3>
<button class="text-primary font-label-lg hover:underline">View All Records</button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse zebra-stripe">
<thead>
<tr class="border-b border-outline-variant/30 text-label-lg text-on-surface-variant">
<th class="py-md px-lg">Entity Name</th>
<th class="py-md px-lg">Sector</th>
<th class="py-md px-lg">Audit Date</th>
<th class="py-md px-lg">Score</th>
<th class="py-md px-lg">Status</th>
<th class="py-md px-lg text-right">Action</th>
</tr>
</thead>
<tbody class="text-body-md">
<tr>
<td class="py-md px-lg font-medium">Lumina Tech Solutions</td>
<td class="py-md px-lg">Technology</td>
<td class="py-md px-lg">Oct 12, 2023</td>
<td class="py-md px-lg">98/100</td>
<td class="py-md px-lg">
<span class="px-sm py-xs bg-secondary-fixed text-on-secondary-fixed text-label-md rounded-lg">Verified</span>
</td>
<td class="py-md px-lg text-right">
<button class="material-symbols-outlined text-outline hover:text-primary">visibility</button>
</td>
</tr>
<tr>
<td class="py-md px-lg font-medium">Green Leaf Organics</td>
<td class="py-md px-lg">Agriculture</td>
<td class="py-md px-lg">Oct 11, 2023</td>
<td class="py-md px-lg">82/100</td>
<td class="py-md px-lg">
<span class="px-sm py-xs bg-secondary-fixed text-on-secondary-fixed text-label-md rounded-lg">Verified</span>
</td>
<td class="py-md px-lg text-right">
<button class="material-symbols-outlined text-outline hover:text-primary">visibility</button>
</td>
</tr>
<tr>
<td class="py-md px-lg font-medium">Urban Spices Bistro</td>
<td class="py-md px-lg">Hospitality</td>
<td class="py-md px-lg">Oct 10, 2023</td>
<td class="py-md px-lg">64/100</td>
<td class="py-md px-lg">
<span class="px-sm py-xs bg-error-container text-on-error-container text-label-md rounded-lg">Pending Review</span>
</td>
<td class="py-md px-lg text-right">
<button class="material-symbols-outlined text-outline hover:text-primary">visibility</button>
</td>
</tr>
<tr>
<td class="py-md px-lg font-medium">Precision Craft Tools</td>
<td class="py-md px-lg">Manufacturing</td>
<td class="py-md px-lg">Oct 09, 2023</td>
<td class="py-md px-lg">91/100</td>
<td class="py-md px-lg">
<span class="px-sm py-xs bg-secondary-fixed text-on-secondary-fixed text-label-md rounded-lg">Verified</span>
</td>
<td class="py-md px-lg text-right">
<button class="material-symbols-outlined text-outline hover:text-primary">visibility</button>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</main>
</div>
<!-- Floating Action Button - Only for Primary Actions on Home/Dashboard screens -->
<button class="fixed bottom-lg right-lg w-14 h-14 bg-primary text-white rounded-full shadow-lg flex items-center justify-center hover:scale-105 transition-transform z-40">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add</span>
</button>
<script>
        // Micro-interactions for dashboard hover states
        document.querySelectorAll('.glass-card, .col-span-12').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transition = 'all 0.3s ease';
                card.style.transform = 'translateY(-2px)';
                card.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.05)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = 'none';
            });
        });
    </script>
</body></html>