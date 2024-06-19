document.addEventListener('DOMContentLoaded', () => {
    const movingLink = document.getElementById('moving-link');
    const storageLink = document.getElementById('storage-link');
    const movingServicesSection = document.getElementById('moving-services');
    const storageServicesSection = document.getElementById('storage-services');

    movingLink.addEventListener('click', (event) => {
        event.preventDefault();
        movingServicesSection.classList.remove('hidden');
        storageServicesSection.classList.add('hidden');
    });

    storageLink.addEventListener('click', (event) => {
        event.preventDefault();
        storageServicesSection.classList.remove('hidden');
        movingServicesSection.classList.add('hidden');
    });

    // Extract package and service from URL and pre-fill form if necessary
    const urlParams = new URLSearchParams(window.location.search);
    const packageType = urlParams.get('package');
    const serviceType = urlParams.get('service');

    if (packageType && serviceType) {
        const packages = {
            moving: {
                basic: {
                    title: "Basic Package",
                    description: "✔ Distance: Within the city limits.<br>✔ Services include packing materials, transportation, loading and unloading.<br>✔ Price Range: ₱4,000 - ₱6,000"
                },
                premium: {
                    title: "Premium Package",
                    description: "✔ Distance: Across city limits or neighboring cities.<br>✔ Services include packing materials, transportation, loading and unloading, assembly of furniture.<br>✔ Price Range: ₱6,000 - ₱8,500"
                },
                executive: {
                    title: "Executive Package",
                    description: "✔ Tailored for large households with extensive belongings or long-distance moves.<br>✔ Distance: Across Luzon Region.<br>✔ Services include premium packing materials, transportation, loading and unloading, furniture assembly, specialized handling of fragile items.<br>✔ Price Range: ₱12,000 - NEGOTIABLE"
                }
            },
            storage: {
                small: {
                    title: "Small Storage",
                    description: "✔ Suitable for a few boxes and small furniture items.<br>✔ Price Range: ₱1,000 - ₱2,000 per month"
                },
                medium: {
                    title: "Medium Storage",
                    description: "✔ Suitable for the contents of a small apartment.<br>✔ Price Range: ₱3,000 - ₱5,000 per month"
                },
                large: {
                    title: "Large Storage",
                    description: "✔ Suitable for the contents of a large house or extensive belongings.<br>✔ Price Range: ₱6,000 - ₱10,000 per month"
                }
            }
        };

        const selectedPackage = packages[serviceType][packageType];
        if (selectedPackage) {
            const form = document.querySelector('.quote-form');
            form.querySelector('input[name="package"]').value = selectedPackage.title;
            form.querySelector('textarea[name="description"]').value = selectedPackage.description;
        }
    }
});
