<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mnitem.css') }}">
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
                    <li><a href="{{ route('management.users') }}"><i class=""></i> <span class="menuText"> Users Management</span></a></li>
                    <li><a href="{{ route('technicians.index') }}"><i class=""></i> <span class="menuText"> Technician</span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"><i class=""></i> <span class="menuText"> Location</span> <i class="fa-solid fa-chevron-right dropdown-arrow"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('buildings.index') }}">Building</a></li>
                            <li><a href="{{ route('departments.index') }}">Department</a></li>
                            <li><a href="{{ route('facilities.index') }}">Facility</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('units.index') }}"><i class=""></i> <span class="menuText"> Item</span></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"><i class=""></i> <span class="menuText"> Settings</span> <i class="fa-solid fa-chevron-right dropdown-arrow"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('items.index') }}">Items Type</a></li>
                            <li><a href="#">Reports</a></li>
                        </ul>
            </div>
        </div>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <div>
                    <a href="#" id="toggleBtn"><i class="fa-solid fa-bars"></i></a>
                    <span id="inventorySystemText">Inventory System</span>
                </div>
                <a href="{{ route('logout') }}" id="logoutBtn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log-out</a>
            </div>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <header>
                    <div class="header-box">
                        <h1>All Items</h1>
                        <div class="button-group">
                            <button id="transferItemsButton">Transfer Items</button>
                            <button id="barcodeButton"><i class="fas fa-barcode"></i></button>
                            <button id="searchButton"><i class="fas fa-search"></i></button>
                            <button id="addButton"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    </header>
                <main>
                     <div id="myModal" class="modal">
                            <div class="modal-content">
                                <!-- Header section -->
                                <div class="modal-header" role="banner">
                                <div class="toolbar" role="toolbar">
                                    <div class="toolbar-content">
                                    <!-- Close button -->
                                    <div class="icon-button">
                                        <div class="button-box">
                                        <button type="button" class="close-button">
                                            <span class="close">&times;</span>
                                        </button>
                                        </div>
                                    </div>

                                    <!-- Title Label -->
                                    <div class="label">
                                        <div class="label-box">Add a new item</div>
                                    </div>

                                    <!-- Cancel button -->
                                    <div class="button cancel">
                                        <div class="button-box">
                                        <button type="button" class="button-text">Cancel</button>
                                        </div>
                                    </div>

                                    <!-- Save button -->
                                    <div class="button save">
                                        <div class="button-box">
                                        <button type="submit" class="button-text">Save</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>

                                <!-- Body section -->
                                <div class="modal-body">
                                <!-- Form content -->
                                <form>
                                    <label for="itemName">Item Name:</label>
                                    <input type="text" id="itemName" name="itemName"><br><br>
                                </form>
                                </div>
                            </div>
                        </div>

                    <div class="units-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Item ID</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Barcode</th>    
                                    <th>Department</th>
                                    <th>Assigned to</th>
                                    <th>Date</th>
                                    <th>Condition</th>
                                </tr>
                            </thead>
                            <tbody id="unitTableBody">
                                @foreach($units as $unit)
                                    <tr>
                                        <td><span class="status-marker {{ $unit->status === 'Taken' ? 'taken' : 'available' }}">{{ $unit->status }}</span></td>
                                        <td>{{ $unit->item_id }}</td>
                                        <td>{{ $unit->type }}</td>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->barcode }}</td>
                                        <td>{{ $unit->department }}</td>
                                        <td>{{ $unit->assigned_to }}</td>
                                        <td>{{ $unit->date }}</td>
                                        <td>{{ $unit->condition }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </main>
                
                    <footer>
                        <!-- Add footer content if needed -->
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/mnitem.js') }}"></script>

</body>
</html>
