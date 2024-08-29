
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.createElement('button');
        menuToggle.classList.add('menu-toggle');
        menuToggle.textContent = '☰ Menu';
        document.body.insertBefore(menuToggle, document.body.firstChild);

        const dashboard = document.querySelector('.dashboard');
        menuToggle.addEventListener('click', function () {
            dashboard.classList.toggle('show-sidebar');
        });
    });

