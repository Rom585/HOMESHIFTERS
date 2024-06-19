
// Add event listeners to buttons
document.getElementById('view-all-quotes').addEventListener('click', function() {
    showSection(quotesSection);
    hideSection([dashboardSection, processSection, customerSection, recentSection]);
    quotesLink.classList.add('active');
    deactivateLinks([dashboardLink, processLink, customerLink, recentLink]);
});

document.getElementById('view-all-processing').addEventListener('click', function() {
    showSection(processSection);
    hideSection([dashboardSection, quotesSection, customerSection, recentSection]);
    processLink.classList.add('active');
    deactivateLinks([dashboardLink, quotesLink, customerLink, recentLink]);
});

document.getElementById('view-all-customers').addEventListener('click', function() {
    showSection(customerSection);
    hideSection([dashboardSection, quotesSection, processSection, recentSection]);
    customerLink.classList.add('active');  // corrected ID here
    deactivateLinks([dashboardLink, quotesLink, processLink, recentLink]);
});

document.getElementById('view-all-recents').addEventListener('click', function() {
    showSection(recentSection);
    hideSection([dashboardSection, quotesSection, processSection, customerSection]);
    recentLink.classList.add('active');
    deactivateLinks([dashboardLink, quotesLink, processLink, customerLink]);
});

function deactivateLinks(links) {
    links.forEach(link => link.classList.remove('active'));
}