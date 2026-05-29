(function () {
    const storageKey = "ipss.map.style";
    const fallbackStyle = "light";
    const styles = {
        light: {
            label: "Light",
            icon: "light_mode",
            style: "https://basemaps.cartocdn.com/gl/positron-gl-style/style.json",
        },
        dark: {
            label: "Dark",
            icon: "dark_mode",
            style: "https://basemaps.cartocdn.com/gl/dark-matter-gl-style/style.json",
        },
        satellite: {
            label: "Satellite",
            icon: "satellite_alt",
            style: {
                version: 8,
                glyphs: "https://fonts.openmaptiles.org/{fontstack}/{range}.pbf",
                sources: {
                    "esri-satellite": {
                        type: "raster",
                        tiles: [
                            "https://services.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
                        ],
                        tileSize: 256,
                        attribution: "Tiles (c) Esri",
                    },
                },
                layers: [
                    {
                        id: "esri-satellite-layer",
                        type: "raster",
                        source: "esri-satellite",
                    },
                ],
            },
        },
    };

    function validStyleKey(styleKey) {
        return Object.prototype.hasOwnProperty.call(styles, styleKey);
    }

    function getPreference() {
        try {
            const storedStyle = window.localStorage.getItem(storageKey);
            return validStyleKey(storedStyle) ? storedStyle : fallbackStyle;
        } catch (error) {
            return fallbackStyle;
        }
    }

    function setPreference(styleKey) {
        if (!validStyleKey(styleKey)) return;

        try {
            window.localStorage.setItem(storageKey, styleKey);
        } catch (error) {
            return;
        }
    }

    function getStyle(styleKey = getPreference()) {
        const styleConfig = styles[validStyleKey(styleKey) ? styleKey : fallbackStyle].style;
        return typeof styleConfig === "string"
            ? styleConfig
            : JSON.parse(JSON.stringify(styleConfig));
    }

    function createControl(options = {}) {
        const onChange = typeof options.onChange === "function" ? options.onChange : null;
        let activeStyle = validStyleKey(options.initialStyle) ? options.initialStyle : getPreference();

        return {
            onAdd(map) {
                const container = document.createElement("div");
                container.className = "maplibregl-ctrl ipss-map-style-control";
                container.setAttribute("aria-label", "Map style");

                Object.entries(styles).forEach(([styleKey, config]) => {
                    const button = document.createElement("button");
                    button.type = "button";
                    button.innerHTML = `<span class="material-symbols-outlined" aria-hidden="true">${config.icon}</span><span>${config.label}</span>`;
                    button.dataset.mapStyle = styleKey;
                    button.title = `${config.label} map`;
                    button.setAttribute("aria-pressed", styleKey === activeStyle ? "true" : "false");

                    if (styleKey === activeStyle) {
                        button.classList.add("is-active");
                    }

                    button.addEventListener("click", () => {
                        if (styleKey === activeStyle) return;

                        activeStyle = styleKey;
                        setPreference(styleKey);
                        container.querySelectorAll("button").forEach((controlButton) => {
                            const isActive = controlButton.dataset.mapStyle === styleKey;
                            controlButton.classList.toggle("is-active", isActive);
                            controlButton.setAttribute("aria-pressed", isActive ? "true" : "false");
                        });

                        if (onChange) {
                            onChange(styleKey, map);
                        } else {
                            map.setStyle(getStyle(styleKey));
                        }
                    });

                    container.appendChild(button);
                });

                return container;
            },
            onRemove() {},
        };
    }

    window.IpssMapStyles = {
        createControl,
        getPreference,
        getStyle,
        setPreference,
    };
})();
