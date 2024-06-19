const header = document.querySelector("header");

// Toggle "sticky" class on the header based on scroll position
window.addEventListener("scroll", function() {
    header.classList.toggle("sticky", window.scrollY > 60);
});

const checkbox = document.getElementById("myCheckBox");
const button = document.getElementById("btnSave");
const form = document.querySelector(".form");

// Function to check if all required fields are filled
function checkForm() {
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let formComplete = true;

    inputs.forEach(function(input) {
        if (input.value.trim() === '') {
            formComplete = false;
        }
    });

    return formComplete;
}

function updateCityDropdown() {
    const provinceDropdown = document.getElementById('updatecity');
    const cityDropdown = document.getElementById('cityDropdown');
    const selectedProvince = provinceDropdown.value;

    // Clear previous city options
    cityDropdown.innerHTML = '<option value="" disabled selected>Select City/Municipality</option>';

    if (selectedProvince && provinces[selectedProvince]) {
        provinces[selectedProvince].forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            cityDropdown.appendChild(option);
        });
    }
    
    updateBarangayDropdown();
    updateToAddress();
}

function updateBarangayDropdown() {
    const cityDropdown = document.getElementById('cityDropdown');
    const barangayDropdown = document.getElementById('barangayDropdown');
    const selectedCity = cityDropdown.value;

    // Clear previous barangay options
    barangayDropdown.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

    if (selectedCity && barangays[selectedCity]) {
        barangays[selectedCity].forEach(barangay => {
            const option = document.createElement('option');
            option.value = barangay;
            option.textContent = barangay;
            barangayDropdown.appendChild(option);
        });
    }

    updateToAddress();
}

function updateFromCityDropdown() {
    const fromProvinceDropdown = document.getElementById('updatecityfrom');
    const fromCityDropdown = document.getElementById('fromCityDropdown');
    const selectedFromProvince = fromProvinceDropdown.value;

    // Clear previous city options
    fromCityDropdown.innerHTML = '<option value="" disabled selected>Select City/Municipality</option>';

    if (selectedFromProvince && provinces[selectedFromProvince]) {
        provinces[selectedFromProvince].forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            fromCityDropdown.appendChild(option);
        });
    }

    updateFromBarangayDropdown();
    updateFromAddress();
}

function updateFromBarangayDropdown() {
    const fromCityDropdown = document.getElementById('fromCityDropdown');
    const fromBarangayDropdown = document.getElementById('fromBarangayDropdown');
    const selectedFromCity = fromCityDropdown.value;

    // Clear previous barangay options
    fromBarangayDropdown.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

    if (selectedFromCity && barangays[selectedFromCity]) {
        barangays[selectedFromCity].forEach(barangay => {
            const option = document.createElement('option');
            option.value = barangay;
            option.textContent = barangay;
            fromBarangayDropdown.appendChild(option);
        });
    }

    updateFromAddress();
}

function updateToAddress() {
    const province = document.getElementById('updatecity').value;
    const city = document.getElementById('cityDropdown').value;
    const barangay = document.getElementById('barangayDropdown').value;
    const houseNumber = document.querySelector('.input-box input[placeholder="House Number1 and Street."]').value;

    const fullAddress = `${barangay}, ${city}, ${province}, ${houseNumber}`;
    document.getElementById('moving_to').value = fullAddress;
}

function updateFromAddress() {
    const fromProvince = document.getElementById('updatecityfrom').value;
    const fromCity = document.getElementById('fromCityDropdown').value;
    const fromBarangay = document.getElementById('fromBarangayDropdown').value;
    const fromHouseNumber = document.querySelector('.input-box input[placeholder="House Number2 and Street."]').value;

    const fullFromAddress = `${fromBarangay}, ${fromCity}, ${fromProvince}, ${fromHouseNumber}`;
    document.getElementById('moving_from').value = fullFromAddress;
}