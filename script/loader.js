  fetch('/Temp/header/header.htm')
    .then(res => res.text())
    .then(data => {
        document.getElementById('header').innerHTML = data;

        // --- Add logic for the mobile navigation toggle ---
        const navToggle = document.querySelector('.mobile-nav-toggle');
        const navLinks = document.querySelector('.nav-links');

        if (navToggle && navLinks) {
            navToggle.addEventListener('click', () => {
                // Toggle a class on the body to manage the open state
                document.body.classList.toggle('nav-open');
                const isExpanded = document.body.classList.contains('nav-open');
                navToggle.setAttribute('aria-expanded', isExpanded);
            });
        }
    }).catch(error => console.error('Error loading header:', error));

    document.addEventListener('DOMContentLoaded', () => {
    // Fetch and inject the footer HTML
    fetch('/Temp/footer/footer.htm')
        .then(res => res.text())
        .then(data => {
            document.getElementById('footer').innerHTML = data;

            // Once the footer is loaded, set the current year
            const yearSpan = document.getElementById('current-year');
            if (yearSpan) {
                yearSpan.textContent = new Date().getFullYear();
            }
        })
        .catch(error => console.error('Error loading footer:', error));
});