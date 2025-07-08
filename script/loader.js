  fetch('/Temp/header/header.htm')
    .then(res => res.text())
    .then(data => {
      document.getElementById('header').innerHTML = data;
    });

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