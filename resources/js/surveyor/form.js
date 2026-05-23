document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('survey-form');

    form.addEventListener('submit', function (e) {
        let isValid = true;
        const fields = form.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]), textarea');

        fields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error-border');
            } else {
                field.classList.remove('error-border');
            }
        });

        if (!isValid) {
            e.preventDefault(); // Prevent form submission

            // Scroll to and focus the first invalid field
            const firstInvalid = form.querySelector('.error-border');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }
    });

    // Remove error styling when user types or changes the field
    const allFields = form.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]), textarea, select');
    allFields.forEach(field => {
        field.addEventListener('input', function () {
            if (this.value.trim()) {
                this.classList.remove('error-border');
            }
        });
        field.addEventListener('change', function () {
            if (this.value.trim()) {
                this.classList.remove('error-border');
            }
        });
    });

    // Cascading Location Dropdowns
    const regionSelect = document.getElementById('regionCode');
    const provinceSelect = document.getElementById('provinceCode');
    const citySelect = document.getElementById('cityMunicipalityCode');
    const barangaySelect = document.getElementById('baranggayCode');

    function resetSelect(select, defaultText) {
        select.innerHTML = `<option value="">${defaultText}</option>`;
        select.disabled = true;
    }

    function populateSelect(select, data, defaultText) {
        resetSelect(select, defaultText);
        select.disabled = false;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.code;
            option.textContent = item.name;
            select.appendChild(option);
        });
    }

    // Initial state
    resetSelect(provinceSelect, 'Select province');
    resetSelect(citySelect, 'Select city / municipality');
    resetSelect(barangaySelect, 'Select baranggay');

    // Fetch regions on load
    fetch('/api/regions', {
    })
        .then(res => res.json())
        .then(data => {
            populateSelect(regionSelect, data, 'Select region');
        })
        .catch(err => console.error('Error fetching regions:', err));

    regionSelect.addEventListener('change', function () {
        const regionCode = this.value;
        resetSelect(provinceSelect, 'Select province');
        resetSelect(citySelect, 'Select city / municipality');
        resetSelect(barangaySelect, 'Select baranggay');

        if (regionCode) {
            fetch(`/api/provinces?region_code=${regionCode}`)
                .then(res => res.json())
                .then(data => populateSelect(provinceSelect, data, 'Select province'))
                .catch(err => console.error('Error fetching provinces:', err));
        }
    });

    provinceSelect.addEventListener('change', function () {
        const provinceCode = this.value;
        resetSelect(citySelect, 'Select city / municipality');
        resetSelect(barangaySelect, 'Select baranggay');

        if (provinceCode) {
            fetch(`/api/cities?province_code=${provinceCode}`)
                .then(res => res.json())
                .then(data => populateSelect(citySelect, data, 'Select city / municipality'))
                .catch(err => console.error('Error fetching cities:', err));
        }
    });

    citySelect.addEventListener('change', function () {
        const cityCode = this.value;
        resetSelect(barangaySelect, 'Select baranggay');

        if (cityCode) {
            fetch(`/api/barangays?city_municipality_code=${cityCode}`)
                .then(res => res.json())
                .then(data => populateSelect(barangaySelect, data, 'Select baranggay'))
                .catch(err => console.error('Error fetching barangays:', err));
        }
    });

});