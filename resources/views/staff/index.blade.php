<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HTC-SMO</title>
</head>
<body>
        <div id="dashboardMainContainer">
            <div class="dashboard_sidebar" id="dashboard_sidebar">
                <h3 class="dashboard_logo" id="dashboard_logo"></h3>
                <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li class="menuActive">
                        <a href="#"><i class=""></i> <span class="menuText"> Storage</span></a>
                    </li>
                    <li><a href="{{ route('units.index') }}"><i class=""></i> <span class="menuText"> Item</span></a></li>
            </div>
        </div>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <div>
                    <a href="#" id="toggleBtn"><i class="fa-solid fa-bars"></i> </a>
                    <span id="inventorySystemText">Inventory System</span>
                </div>
                <a href="#" id="logoutBtn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log-out</a>
            </div>
            <div class="dashboard_content">
                <div class="dashboard_content_main"></div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>