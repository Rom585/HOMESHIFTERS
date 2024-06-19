// Update functions for the new pickup location form
function updatePickupCityDropdown() {
    const provinceDropdown = document.getElementById('citystorage');
    const cityDropdown = document.getElementById('municipalitystorage');
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
    
    updatePickupBarangayDropdown();
    updatePickupLocation();
}

function updatePickupBarangayDropdown() {
    const cityDropdown = document.getElementById('municipalitystorage');
    const barangayDropdown = document.getElementById('barangaystorage');
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

    updatePickupLocation();
}

function updatePickupLocation() {
    const province = document.getElementById('citystorage').value;
    const city = document.getElementById('municipalitystorage').value;
    const barangay = document.getElementById('barangaystorage').value;
    const houseNumber = document.getElementById('moving_number').value;

    const fullPickupLocation = `${barangay}, ${city}, ${province}, ${houseNumber}`;
    document.getElementById('pickup_location').value = fullPickupLocation;
}