document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    var sideBarIsOpen = true;
    var toggleBtn = document.getElementById('toggleBtn');
    var logoutBtn = document.getElementById('logoutBtn');
    var dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    var dashboard_sidebar = document.querySelector('.dashboard_sidebar');
    var dashboard_content_container = document.querySelector('.dashboard_content_container');
    var dashboard_logo = document.querySelector('#inventorySystemText');

    if (toggleBtn && dashboard_sidebar && dashboard_content_container && dashboard_logo) {
        // Function to toggle sidebar open/close
        toggleBtn.addEventListener('click', function(event) {
            event.preventDefault();

            if (sideBarIsOpen) {
                dashboard_sidebar.style.width = '10%';
                dashboard_content_container.style.width = '90%';
                dashboard_logo.style.fontSize = '60px';

                var menuIcons = document.querySelectorAll('.menuText');
                menuIcons.forEach(icon => icon.style.display = 'none');

                document.querySelector('.dashboard_menu_lists').style.textAlign = 'center';
                sideBarIsOpen = false;
            } else {
                dashboard_sidebar.style.width = '20%';
                dashboard_content_container.style.width = '80%';
                dashboard_logo.style.fontSize = '80px';

                var menuIcons = document.querySelectorAll('.menuText');
                menuIcons.forEach(icon => icon.style.display = 'inline-block');

                document.querySelector('.dashboard_menu_lists').style.textAlign = 'left';
                sideBarIsOpen = true;
            }
        });
    }

    if (logoutBtn) {
        // Function to handle logout
        logoutBtn.addEventListener('click', function(event) {
            event.preventDefault();

            // Clear tokens from localStorage (if any)
            localStorage.removeItem('authToken');
            localStorage.removeItem('user');

            // Clear tokens from sessionStorage (if any)
            sessionStorage.removeItem('authToken');
            sessionStorage.removeItem('user');

            // Redirect to login page
            window.location.href = "{{ route('logout') }}"; // Adjust the path as necessary for your application
        });
    }

    // Function to handle dropdown click
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function(event) {
            event.preventDefault();
            var dropdownMenu = toggle.nextElementSibling;
            if (dropdownMenu) {
                dropdownMenu.classList.toggle('show');

                var dropdownArrow = toggle.querySelector('.dropdown-arrow');
                if (dropdownArrow) {
                    dropdownArrow.classList.toggle('fa-chevron-down');
                    dropdownArrow.classList.toggle('fa-chevron-up');
                }
            }
        });
    });
});
