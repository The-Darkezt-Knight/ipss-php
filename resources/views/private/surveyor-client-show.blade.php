<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>{{ $clientMapPoint['name'] ?? 'Client Profile' }}</title>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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
        <script id="tailwind-config">
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: "#001e40",
                            background: "#f9f9fc",
                            surface: "#f9f9fc",
                            "surface-container-low": "#f3f3f6",
                            "surface-container-lowest": "#ffffff",
                            "surface-container": "#eeeeee",
                            "on-surface": "#1a1c1e",
                            "on-surface-variant": "#44474e",
                            outline: "#737780",
                            "outline-variant": "#c3c6d1",
                            "on-primary": "#ffffff",
                        },
                        fontFamily: {
                            display: ["Public Sans", "sans-serif"],
                            body: ["Public Sans", "sans-serif"],
                        },
                    },
                },
            };
        </script>
        <style>
            body {
                font-family: "Public Sans", sans-serif;
            }
        </style>
    </head>
    <body class="bg-background text-on-surface min-h-screen">

        <!--Individual client modal-->
        <main class="max-w-5xl mx-auto px-6 py-8">
            <div class="mb-6 flex items-center justify-between gap-4">
                <div>
                    <a href="{{ route('private.surveyor-dashboard') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:underline">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        Back to Dashboard
                    </a>
                    <h1 class="mt-3 text-3xl font-bold text-primary">{{ $clientMapPoint['name'] ?? 'Unnamed Client' }}</h1>
                    <p class="text-sm text-on-surface-variant">{{ $client->client_id ?? 'No client ID' }}</p>
                </div>
            </div>

            <section class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden shadow-sm">
                <div class="px-5 py-4 border-b border-outline-variant bg-surface-container-low flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-primary">Client Location</h2>
                        <p class="text-sm text-on-surface-variant">Saved latitude and longitude for this client.</p>
                    </div>
                    <span class="material-symbols-outlined text-primary">location_on</span>
                </div>

                @if($clientMapPoint)
                    <div id="single-client-map" class="h-[320px] w-full overflow-hidden"></div>
                @else
                    <div class="h-[220px] flex flex-col items-center justify-center gap-2 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[42px] text-outline">location_off</span>
                        <p class="font-semibold">No saved coordinates</p>
                        <p class="text-sm">This client does not have latitude and longitude values yet.</p>
                    </div>
                @endif
            </section>

            <section class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-5">
                    <p class="text-xs uppercase font-semibold text-on-surface-variant">Mobile</p>
                    <p class="mt-1 text-sm">{{ $client->mobile_number ?? '-' }}</p>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-5">
                    <p class="text-xs uppercase font-semibold text-on-surface-variant">Address</p>
                    <p class="mt-1 text-sm">{{ $client->address ?? '-' }}</p>
                </div>
            </section>
        </main>

        <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
        <script src="{{ asset('js/map-style-control.js') }}?v=20260529-2"></script>
        <script>
            const singleClientMapPoint = @json($clientMapPoint);

            document.addEventListener('DOMContentLoaded', function () {
                const mapEl = document.getElementById('single-client-map');
                if (!mapEl || !singleClientMapPoint || typeof maplibregl === 'undefined') return;
                const fallbackMapStyle = 'https://basemaps.cartocdn.com/gl/positron-gl-style/style.json';

                function getInitialMapStyle() {
                    return window.IpssMapStyles?.getStyle() || fallbackMapStyle;
                }

                function addMapStyleChooser(map) {
                    if (!window.IpssMapStyles) return;

                    map.addControl(window.IpssMapStyles.createControl({
                        initialStyle: window.IpssMapStyles.getPreference(),
                        onChange: (styleKey, activeMap) => {
                            activeMap.setStyle(window.IpssMapStyles.getStyle(styleKey));
                        },
                    }), 'top-right');
                }

                // Negros Island bounding box: [west, south, east, north]
                const negrosBounds = [122.25, 9.0, 123.55, 11.1];
                const lngPad = (negrosBounds[2] - negrosBounds[0]) * 0.08;
                const latPad = (negrosBounds[3] - negrosBounds[1]) * 0.08;
                const paddedBounds = [
                    [negrosBounds[0] - lngPad, negrosBounds[1] - latPad],
                    [negrosBounds[2] + lngPad, negrosBounds[3] + latPad],
                ];

                const position = [singleClientMapPoint.longitude, singleClientMapPoint.latitude];

                const map = new maplibregl.Map({
                    container: mapEl,
                    style: getInitialMapStyle(),
                    center: position,
                    zoom: 16,
                    minZoom: 8,
                    maxZoom: 19,
                    maxBounds: paddedBounds,
                    attributionControl: true,
                });
                map.addControl(new maplibregl.NavigationControl(), 'top-right');
                addMapStyleChooser(map);

                const popup = new maplibregl.Popup({ offset: 25 })
                    .setHTML(`
                        <strong>${singleClientMapPoint.name}</strong>
                        <span>${singleClientMapPoint.client_id || 'No client ID'}</span>
                    `);

                new maplibregl.Marker({ color: '#3a5f94' })
                    .setLngLat(position)
                    .setPopup(popup)
                    .addTo(map);

                // Open popup by default
                popup.addTo(map);
            });
        </script>
    </body>
</html>
