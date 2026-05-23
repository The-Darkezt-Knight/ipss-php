<!DOCTYPE html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Surveyor Intake Form | CivicSurvey Portal</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @vite(['resources/js/surveyor/form.js', 'resources/js/surveyor/offline-db.js'])

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
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
            "headline-lg-mobile": ["Public Sans"],
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
            "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "700" }],
            "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "700" }],
            "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
            "label-lg": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }]
          }
        },
      },
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    input:focus,
    select:focus,
    textarea:focus {
      outline: none;
      border-color: #001e40 !important;
      box-shadow: 0 0 0 2px #d5e3ff !important;
    }

    .custom-scrollbar::-webkit-scrollbar {
      width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
      background: #f3f3f6;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #c3c6d1;
      border-radius: 10px;
    }

    .error-border {
      border-color: #ba1a1a !important;
      border-width: 2px !important;
    }

    /* Offline-first status animations */
    @keyframes pulse-dot {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.4; }
    }
    .animate-pulse-dot {
      animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .animate-spin {
      animation: spin 1s linear infinite;
    }
  </style>
</head>

<body class="bg-background text-on-background font-body-md overflow-x-hidden">
  <!-- TopAppBar -->
  <header
    class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-md h-16 bg-surface border-b border-outline-variant">
    <div class="text-headline-sm font-headline-sm font-bold text-primary">MSME Survey portal  </div>
    <div class="flex items-center gap-md">
      <!-- Connection Status Pill -->
      <div id="connection-status-pill" class="flex items-center gap-2 px-3 py-1.5 rounded-full border border-green-200 bg-green-50 transition-all duration-500">
        <span id="status-dot" class="h-2.5 w-2.5 rounded-full bg-green-500 animate-pulse-dot"></span>
        <span id="status-label" class="text-xs font-semibold text-gray-700">Online</span>
      </div>

      <!-- Manual Sync Button -->
      <button id="manual-sync-btn" class="relative p-sm hover:bg-surface-container-high transition-colors rounded-full" title="Sync pending surveys">
        <span id="sync-indicator-icon" class="material-symbols-outlined" data-icon="sync">sync</span>
        <!-- Pending Count Badge -->
        <div id="pending-count-badge" class="hidden absolute -top-1 -right-1 h-5 min-w-[20px] items-center justify-center rounded-full bg-red-500 px-1">
          <span id="pending-count" class="text-[10px] font-bold text-white leading-none">0</span>
        </div>
      </button>

      <div class="h-8 w-8 rounded-full bg-primary-fixed-dim flex items-center justify-center">
        <span class="material-symbols-outlined text-primary" data-icon="account_circle">account_circle</span>
      </div>
    </div>
  </header>

  <!-- SideNavBar
  <aside
    class="fixed left-0 top-16 h-[calc(100vh-64px)] w-64 z-40 flex flex-col p-md bg-surface-container-low border-r border-outline-variant hidden md:flex">
    <div class="flex items-center gap-md mb-xl">
      <div class="h-10 w-10 rounded-full bg-secondary-container flex items-center justify-center">
        <span class="material-symbols-outlined text-on-secondary-container"
          data-icon="shield_person">shield_person</span>
      </div>
      <div>
        <p class="text-label-lg font-label-lg text-primary">Official Surveyor</p>
        <p class="text-body-sm font-body-sm text-on-surface-variant">ID: #88291-MSME</p>
      </div>
    </div>
    <nav class="flex flex-col gap-xs grow">
      <a class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg"
        href="#">
        <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
        <span class="text-label-lg font-label-lg">Dashboard</span>
      </a>
      <a class="flex items-center gap-md px-md py-sm bg-secondary-container text-on-secondary-container rounded-lg font-bold"
        href="#">
        <span class="material-symbols-outlined" data-icon="assignment">assignment</span>
        <span class="text-label-lg font-label-lg">Active Surveys</span>
      </a>
      <a id="sync-history-button"
        class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg"
        href="#">
        <span class="material-symbols-outlined" data-icon="sync_alt">sync_alt</span>
        <span class="text-label-lg font-label-lg">Sync History</span>
      </a>
      <a class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:bg-surface-container-high transition-all rounded-lg"
        href="#">
        <span class="material-symbols-outlined" data-icon="settings">settings</span>
        <span class="text-label-lg font-label-lg">Settings</span>
      </a>
    </nav>
    <button
      class="mt-auto bg-primary text-on-primary font-label-lg py-md rounded-xl flex items-center justify-center gap-sm hover:opacity-90 transition-opacity">
      <span class="material-symbols-outlined" data-icon="add">add</span>
      New Survey
    </button>
  </aside>
  -->

  <!-- Main Content -->
  <main class="pt-24 pb-12 px-4 md:pl-72 md:pr-8 max-w-container-max mx-auto">
    <header class="mb-lg">
      <nav class="mb-sm flex items-center gap-xs text-on-surface-variant text-body-sm">
        <span>Portal</span>
        <span class="material-symbols-outlined text-[16px]" data-icon="chevron_right">chevron_right</span>
        <span>Surveys</span>
        <span class="material-symbols-outlined text-[16px]" data-icon="chevron_right">chevron_right</span>
        <span class="text-primary font-bold">Intake Form</span>
      </nav>
      <h1 class="font-headline-lg text-headline-lg text-primary">Surveyor Intake Form</h1>
      <p class="text-on-surface-variant text-body-md">Fill out the MSME data profile below. All fields marked with an
        asterisk are required for official registration.</p>
    </header>

    <form method="post" action="{{ route('surveyor.merge') }}" id="survey-form" class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
      @csrf
      <!-- SECTION 1: Client Classification -->
      <div class="lg:col-span-8 space-y-lg">
        <section class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant">
          <div class="flex items-center gap-sm mb-lg">
            <span class="material-symbols-outlined text-primary" data-icon="category">category</span>
            <h2 class="text-headline-sm font-headline-sm text-primary">1. Client Classification</h2>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Status</label>

              <select id="statusOfClient" name="statusOfClient"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Level 0 - Would be or Potential Entrepreneurs" selected>Level 0 - Would be or Potential Entrepreneurs</option>
              </select>

            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Level</label>

              <select id="specifyLevel" name="specifyLevel"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Potential">Potential</option>
                <option value="Other Clients Assisted">Other Clients Assisted</option>
              </select>
            </div>

            <div class="flex flex-col gap-xs">

              <label class="text-label-md font-label-md text-on-surface-variant">Category</label>

              <select id="categoryOfClient" name="categoryOfClient"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="4Ps Beneficiary">4Ps Beneficiary</option>
                <option value="Agrarian Reform Beneficiary">Agrarian Reform Beneficiary</option>
                <option value="Alien/Foreigner">Alien/Foreigner</option>
                <option value="Balik Probinsya Bagong Pag-asa (BP2)">Balik Probinsya Bagong Pag-asa (BP2)</option>
                <option value="Drug Surrenderee">Drug Surrenderee</option>
                <option value="Ex-convict">Ex-convict</option>
                <option value="Farmer">Farmer</option>
                <option value="Former Rebel">Former Rebel</option>
                <option value="Government Employee">Government Employee</option>
                <option value="Housewife/Husband">Housewife/Husband</option>
                <option value="KIA/WIA/KIPO/WIPO">KIA/WIA/KIPO/WIPO</option>
                <option value="Military/Police">Military/Police</option>
                <option value="OFW">OFW</option>
                <option value="Out-of-School-Youth">Out-of-School-Youth</option>
                <option value="Person Deprived of Liberty">Person Deprived of Liberty</option>
                <option value="Persons of Concern (Stateless Person, Internally-Displaced Person, Refugee)">Persons of Concern (Stateless Person, Internally-Displaced Person, Refugee)</option>
                <option value="Private Employee">Private Employee</option>
                <option value="Professional">Professional</option>
                <option value="PWD">PWD</option>
                <option value="Retiree">Retiree</option>
                <option value="Self-Employed">Self-Employed</option>
                <option value="Senior Citizen">Senior Citizen</option>
                <option value="Student">Student</option>
                <option value="Unemployed">Unemployed</option>
                <option value="Urban Poor">Urban Poor</option>
                <option value="Youth">Youth</option>
              </select>

            </div>

            <div class="flex flex-col gap-xs">

              <label class="text-label-md font-label-md text-on-surface-variant">Social Classification</label>
              <select id="socialClassification" name="socialClassification"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Abled">Abled</option>
                <option value="Person with Disabilities">Person with Disabilities</option>
              </select>

            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Disability Type</label>
              <select id="diffAbledType" name="diffAbledType"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="">-- Select if applicable --</option>
                <option value="Autism">Autism</option>
                <option value="Breast Cancer">Breast Cancer</option>
                <option value="Cervical Cancer Survivor">Cervical Cancer Survivor</option>
                <option value="Chronic Illness">Chronic Illness</option>
                <option value="Deaf/Hard of Hearing">Deaf/Hard of Hearing</option>
                <option value="Heart Disease">Heart Disease</option>
                <option value="Learning Disability">Learning Disability</option>
                <option value="Mastectomy">Mastectomy</option>
                <option value="Nephrectomy">Nephrectomy</option>
                <option value="Orthopedic">Orthopedic</option>
                <option value="Physical">Physical</option>
                <option value="Psychological">Psychological</option>
                <option value="Speech and Language Impairment">Speech and Language Impairment</option>
                <option value="Visual Impairment/One Eye">Visual Impairment/One Eye</option>
              </select>
            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Client is Senior</label>
              <select id="isSenior" name="isSenior"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              </select>
            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Client is Indigenous</label>
              <select id="isIndigeneous" name="isIndigeneous"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
              </select>
            </div>

          </div>


        </section>
        <!-- SECTION 2: MSME & Digitalization -->
        <section class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant">
          <div class="flex items-center gap-sm mb-lg">
            <span class="material-symbols-outlined text-primary" data-icon="devices">devices</span>
            <h2 class="text-headline-sm font-headline-sm text-primary">2. MSME &amp; Digitalization</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Level of Digitalization</label>
              <select id="levelOfDigitalization" name="levelOfDigitalization"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Level 0 - No use of digital tools">Level 0 - No use of digital tools</option>
                <option value="Level 1 (Basic) - MSMEs that use basic digital tools for business">Level 1 (Basic) - MSMEs that use basic digital tools for business</option>
                <option value="Level 2 (Intermediate) - MSMEs that have an online presence">Level 2 (Intermediate) - MSMEs that have an online presence</option>
                <option value="Level 3 (Advanced) - Use of advanced digital tools">Level 3 (Advanced) - Use of advanced digital tools</option>
              </select>
            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Digital Tools Used</label>
              <select id="digitalTools" name="digitalTools"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="">-- Select Tool --</option>
                <option value="Bank Account">Bank Account</option>
                <option value="Big data, automation tools i.e. chatbots">Big data, automation tools i.e. chatbots</option>
                <option value="Business process management software">Business process management software</option>
                <option value="Business Website">Business Website</option>
                <option value="Chat apps i.e. Messenger, Viber">Chat apps i.e. Messenger, Viber</option>
                <option value="Creative Tools (e.g. Photoshop, Canva, Illustrator)">Creative Tools (e.g. Photoshop, Canva, Illustrator)</option>
                <option value="Customer Relationship Management (CRM)">Customer Relationship Management (CRM)</option>
                <option value="Cybersecurity Risk Tools">Cybersecurity Risk Tools</option>
                <option value="E-commerce i.e. Shopee, Lazada">E-commerce i.e. Shopee, Lazada</option>
                <option value="Email">Email</option>
                <option value="ERP">ERP</option>
                <option value="Fintech i.e. GCash, PayMaya">Fintech i.e. GCash, PayMaya</option>
                <option value="Internet connection for business">Internet connection for business</option>
                <option value="Laptop">Laptop</option>
                <option value="Microsoft Office i.e. Excel, Word">Microsoft Office i.e. Excel, Word</option>
                <option value="Online Banking">Online Banking</option>
                <option value="Platforms">Platforms</option>
                <option value="Printer">Printer</option>
                <option value="Smartphone">Smartphone</option>
                <option value="Smartphones, tablets, desktop computers">Smartphones, tablets, desktop computers</option>
                <option value="Tablet">Tablet</option>
              </select>
            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">MSME Classification</label>
              <select id="msmeClassification" name="msmeClassification"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Large - More than Php 100,000,000">Large - More than Php 100,000,000</option>
                <option value="Medium - Php 15,000,001 to Php 100,000,000">Medium - Php 15,000,001 to Php 100,000,000</option>
                <option value="Micro - Up to Php 3,000,000">Micro - Up to Php 3,000,000</option>
                <option value="Not Applicable - Would-be/Potential Entrepreneur">Not Applicable - Would-be/Potential Entrepreneur</option>
                <option value="Small - Php 3,000,001 to Php 15,000,000">Small - Php 3,000,001 to Php 15,000,000</option>
              </select>
            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Client Designation</label>
              <select id="clientDesignation" name="clientDesignation"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Owner">Owner</option>
                <option value="Representative">Representative</option>
              </select>
            </div>
          </div>
        </section>


        <!-- SECTION 3: Personal Information -->
        <section class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant">
          <div class="flex items-center gap-sm mb-lg">
            <span class="material-symbols-outlined text-primary" data-icon="person">person</span>
            <h2 class="text-headline-sm font-headline-sm text-primary">3. Personal Information</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-4 gap-lg">
            <div class="md:col-span-1 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">First Name</label>
              <input id="firstName" name="firstName"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" type="text" />
            </div>
            <div class="md:col-span-1 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Middle Name</label>
              <input id="middleName" name="middleName"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" type="text" />
            </div>
            <div class="md:col-span-1 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Last Name</label>
              <input id="lastName" name="lastName"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" type="text" />
            </div>
            <div class="md:col-span-1 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Suffix</label>
              <select id="suffix" name="suffix"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="--N/A--">--N/A--</option>
                <option value="SR">SR</option>
                <option value="JR">JR</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
                <option value="IV">IV</option>
                <option value="V">V</option>
                <option value="VI">VI</option>
                <option value="VII">VII</option>
                <option value="VIII">VIII</option>
                <option value="IX">IX</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
                <option value="XIII">XIII</option>
                <option value="XIV">XIV</option>
                <option value="XV">XV</option>
                <option value="XVI">XVI</option>
                <option value="XVII">XVII</option>
                <option value="XVIII">XVIII</option>
                <option value="XIX">XIX</option>
                <option value="XX">XX</option>
              </select>
            </div>
            <div class="md:col-span-2 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Civil Status</label>
              <select id="civilStatus" name="civilStatus"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Legally Separated">Legally Separated</option>
                <option value="Married">Married</option>
                <option value="Single">Single</option>
                <option value="Widowed">Widowed</option>
              </select>
            </div>
            <div class="md:col-span-2 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Sex</label>
              <select id="sex" name="sex"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="md:col-span-2 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Birthdate</label>
              <input id="birthdate" name="birthdate"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" type="date" />
            </div>
            <div class="md:col-span-1 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Birth Year</label>
              <select id="birthYear" name="birthYear"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="">Select Year</option>
                @for($i = date('Y'); $i >= date('Y') - 124; $i--)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select>
            </div>
            <div class="md:col-span-1 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Citizenship</label>
              <select id="citizenship" name="citizenship"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Filipino">Filipino</option>
                @php
                  $countries = [
                      "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo (Congo-Brazzaville)", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine State", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
                  ];
                @endphp
                @foreach(array_merge(['Filipino'], array_diff($countries, ['Philippines', 'Filipino'])) as $c)
                  <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </section>

      </div>


      <!-- Side Cards: Identifiers & Location -->
      <div class="lg:col-span-4 space-y-lg">
        <!-- SECTION 4: Identifiers -->
        <section class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant">
          <div class="flex items-center gap-sm mb-lg">
            <span class="material-symbols-outlined text-primary" data-icon="fingerprint">fingerprint</span>
            <h2 class="text-headline-sm font-headline-sm text-primary">4. Identifiers</h2>
          </div>

          <div class="flex flex-col gap-lg">
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Client ID</label>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline"
                  data-icon="badge">badge</span>
                <input id="clientId" name="id"
                  class="w-full pl-xl p-md border border-outline rounded-lg bg-surface-bright text-body-md"
                  placeholder="Client ID" type="text" />
              </div>
            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Old Client ID</label>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline"
                  data-icon="badge">badge</span>
                <input id="oldClientId" name="oldId"
                  class="w-full pl-xl p-md border border-outline rounded-lg bg-surface-bright text-body-md"
                  placeholder="Old Client ID" type="text" />
              </div>
            </div>
            
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">DTI Konek ID</label>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline"
                  data-icon="badge">badge</span>
                <input id="dtiKonekId" name="dtiKonekId"
                  class="w-full pl-xl p-md border border-outline rounded-lg bg-surface-bright text-body-md"
                  placeholder="ID Number" type="text" />
              </div>
            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Philippine ID System (PhilSys)</label>
              <input id="philippineIdentificationSystem" name="philippineIdentificationSystem"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" placeholder="PCN Number"
                type="text" />
            </div>

          </div>


        </section>
        <!-- SECTION 6: Location -->
        <section class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant">
          <div class="flex items-center gap-sm mb-lg">
            <span class="material-symbols-outlined text-primary" data-icon="location_on">location_on</span>
            <h2 class="text-headline-sm font-headline-sm text-primary">6. Location</h2>
          </div>

          <div class="flex flex-col gap-md">
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Region</label>
              <select id="regionCode" name="regionCode"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="">Select region</option>
              </select>
            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Province</label>
              <select id="provinceCode" name="provinceCode"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="">Select province</option>
              </select>
            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">City / Municipality</label>
              <select id="cityMunicipalityCode" name="cityMunicipalityCode"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="">Select city / municipality</option>
              </select>
            </div>

            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Baranggay</label>
              <select id="baranggayCode" name="baranggayCode"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="">Select baranggay</option>
              </select>
            </div>

            <div class="grid grid-cols-2 gap-sm">
              <div class="flex flex-col gap-xs">
                <label class="text-label-md font-label-md text-on-surface-variant">District</label>
                <select id="district" name="district"
                  class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                  <option value="">Select District</option>
                  <option value="1st">1st</option>
                  <option value="2nd">2nd</option>
                  <option value="3rd">3rd</option>
                  <option value="4th">4th</option>
                  <option value="5th">5th</option>
                  <option value="6th">6th</option>
                  <option value="7th">7th</option>
                  <option value="8th">8th</option>
                  <option value="Lone District">Lone District</option>
                </select>
              </div>

              <div class="flex flex-col gap-xs">
                <label class="text-label-md font-label-md text-on-surface-variant">Zip Code</label>
                <input id="zipCode" name="zipCode"
                  class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" placeholder="4026"
                  type="text" />
              </div>

            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Full Address</label>
              <textarea id="address" name="address"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md"
                placeholder="Street, Building, Unit No." rows="2"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-sm">
              <div class="flex flex-col gap-xs">
                <label class="text-label-md font-label-md text-on-surface-variant">Latitude</label>
                <input id="latitude" name="latitude"
                  class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" placeholder="14.3125"
                  type="text" />
              </div>

              <div class="flex flex-col gap-xs">
                <label class="text-label-md font-label-md text-on-surface-variant">Longitude</label>
                <input id="longitude" name="longitude"
                  class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" placeholder="121.0917"
                  type="text" />
              </div>

            </div>
            <div class="h-32 rounded-xl bg-surface-container overflow-hidden mt-sm relative group">
              <div
                class="absolute inset-0 bg-black/5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                <button class="bg-white/90 px-md py-sm rounded-full text-label-md font-label-md shadow-lg">Pin
                  Location</button>
              </div>

              <img class="w-full h-full object-cover"
                data-alt="A clean, highly detailed digital map visualization showing a suburban street grid in a modern light mode aesthetic. The map features subtle institutional blue markers and soft grey outlines to represent a municipal jurisdiction. High clarity and professional GIS mapping style with a soft ambient lighting feel."
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuB1kAA3cfhixcamhOTmpitN-HDLOV8ITI7zz9JFfDAPQoKtfSxVX6_ZJdU2DtWbM6muWJ9-ufE8UMDGWwTr7GZb64ChA8N2M13Pfl8ayqh1fKp-JwtcysIRw50kkaaPEkRwi8LORWWM0XpSDIwR_JrhP-nUS9BB5ud0vxA_n1_xvHJQzn3CWHU5Jggy1AmKB1ApdNDf2Lv7LEEcn6fRykyOHfXDAOCSCeoLhQn38NTYlRbEOSzwBev2g6UwAOWU1pqrTkTR7C-oN1t9" />
            
            </div>

          </div>
        </section>


      </div>
      <!-- SECTION 5: Contact Details -->
      <div class="lg:col-span-12">
        <section class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant">
          <div class="flex items-center gap-sm mb-lg">
            <span class="material-symbols-outlined text-primary" data-icon="contact_page">contact_page</span>
            <h2 class="text-headline-sm font-headline-sm text-primary">5. Contact Details</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-lg">
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Mobile Number</label>
              <input id="mobileNumber" name="mobileNumber"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md"
                placeholder="+63 9xx xxx xxxx" type="tel" />
            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Email Address</label>
              <input id="emailAddress" name="emailAddress"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md"
                placeholder="example@domain.com" type="email" />
            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Landline</label>
              <input id="landlineNumber" name="landlineNumber"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" type="tel" />
            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Fax</label>
              <input id="faxNumber" name="faxNumber"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" type="tel" />
            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Social Media</label>
              <input id="socialMedia" name="socialMedia"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md"
                placeholder="Facebook / LinkedIn URL" type="text" />
            </div>
            <div class="flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">Website</label>
              <input id="website" name="website"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md" placeholder="https://"
                type="url" />
            </div>
            <div class="md:col-span-2 flex flex-col gap-xs">
              <label class="text-label-md font-label-md text-on-surface-variant">eCommerce Platform</label>
              <select id="eCommercePlatform" name="eCommercePlatform"
                class="p-md border border-outline rounded-lg bg-surface-bright text-body-md">
                <option value="Shopee / Lazada">Shopee / Lazada</option>
                <option value="Facebook Marketplace">Facebook Marketplace</option>
                <option value="Proprietary Platform">Proprietary Platform</option>
                <option value="None">None</option>
              </select>
            </div>
          </div>
        </section>

      </div>


      <!-- Floating Action Bar / Submission -->
      <div class="lg:col-span-12 sticky bottom-8 z-30">
        <div
          class="bg-primary-container p-lg rounded-xl shadow-xl flex flex-col md:flex-row justify-between items-center gap-md">
          <div class="flex items-center gap-md text-on-primary">
            <span class="material-symbols-outlined text-[32px]" data-icon="cloud_upload">cloud_upload</span>
            <div>
              <p class="font-bold">Offline Sync Ready</p>
              <p class="text-body-sm opacity-80">Survey data will be cached locally until a connection is found.</p>
            </div>
          </div>
          <div class="flex gap-md w-full md:w-auto">
            <button id="save-for-sync-btn"
              class="flex-1 md:flex-none px-xl py-md border border-on-primary-container text-on-primary-container font-label-lg rounded-full hover:bg-white/10 transition-colors"
              type="button">
              Save for Sync
            </button>
            <button
              class="flex-1 md:flex-none px-xxl py-md bg-primary-fixed-dim text-on-primary-fixed font-bold text-label-lg rounded-full hover:opacity-90 transition-opacity"
              type="submit">
              Submit Form
            </button>
          </div>
        </div>
      </div>
    </form>

  </main>


  <footer
    class="w-full py-lg px-xl flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto bg-surface-container-lowest border-t border-outline-variant mt-xxl">
    <div class="text-body-sm font-body-sm text-on-surface-variant mb-md md:mb-0">
      © 2024 Municipal Governance Authority. All data is encrypted and official.
    </div>
    <div class="flex gap-xl text-label-md font-label-md">
      <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
      <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
      <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Help Desk</a>
    </div>
  </footer>

  <!-- Toast Notification Container -->
  <div id="toast-container" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 max-w-sm"></div>

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