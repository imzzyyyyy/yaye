<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- External CSS Links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Project-specific CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/itemt.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- JS Scripts -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>HTC-SMO</title>
</head>
<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar -->
        <div class="dashboard_sidebar" id="dashboard_sidebar">
            <h3 class="dashboard_logo" id="dashboard_logo"></h3>
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                    <li class="menuActive"><a href="#"><i class=""></i> <span class="menuText"> Storage</span></a></li>
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
                </ul>
            </div>
        </div>
        <!-- Main Content -->
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
                    <div class="layout">
                        <!-- Sidebar for Items -->
                        <div class="sidebar">
                            <div class="toolbar">
                                <input type="text" placeholder="Search..." class="search">
                                <button class="add-button" onclick="openModal()">+</button>
                            </div>
                            <ul class="item-list" id="item-list">
                                <!-- Loop through items, properties, and parts -->
                                @foreach ($items as $item)
                                    <li>{{ $item->name }} ({{ $item->short_name }})</li>
                                    <ul>
                                        @foreach ($item->properties as $property)
                                            <li>{{ $property->label }}: {{ $property->default_value }}</li>
                                        @endforeach
                                    </ul>
                                    <ul>
                                        @foreach ($item->parts as $part)
                                            <li>{{ $part->part_name }} ({{ $part->name }})</li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </ul>
                        </div>             
                        <!-- Main Content Area -->
                        <div class="main-content">
                            <div class="modal-container" id="modal-container">
                                <div class="modal-toolbar">
                                    <button class="btn primary" onclick="saveItem()">Save</button>
                                    <button class="btn secondary" onclick="closeModal()">Cancel</button>
                                </div>
                                <div class="modal-content">
                                    <form class="modal-form" id="modal-form">
                                        <!-- Form Groups -->
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" placeholder="Enter name">
                                        </div>
                                        <div class="form-group">
                                            <label for="short-name">Short name</label>
                                            <input type="text" id="short-name" placeholder="Enter short name">
                                        </div>
                                        <div class="form-group">
                                            <label for="icon">Icon</label>
                                            <div class="icon-select">
                                                <div id="icon-selector" class="icon-selector">
                                                    <i class="fa-solid fa-caret-down"></i> 
                                                </div>
                                                <ul id="icon-list" class="icon-list">
                                                    <li class="option" data-icon="mdi mdi-desktop-classic">
                                                        <i class="mdi mdi-desktop-classic"></i> Computer
                                                    </li>
                                                    <li class="option" data-icon="mdi mdi-harddisk"><i class="mdi mdi-harddisk"></i> Hard Disk</li>
                                                    <li class="option" data-icon="mdi mdi-memory"><i class="mdi mdi-memory"></i> Memory</li>
                                                    <li class="option" data-icon="mdi mdi-monitor"><i class="mdi mdi-monitor"></i> Monitor</li>
                                                    <li class="option" data-icon="mdi mdi-chip"><i class="mdi mdi-chip"></i> Processor</li>
                                                    <li class="option" data-icon="mdi mdi-mouse"><i class="mdi mdi-mouse"></i> Mouse</li>
                                                    <li class="option" data-icon="mdi mdi-keyboard"><i class="mdi mdi-keyboard"></i> Keyboard</li>
                                                    <li class="option" data-icon="mdi mdi-headset"><i class="mdi mdi-headset"></i> Headset</li>
                                                    <li class="option" data-icon="mdi mdi-speaker"><i class="mdi mdi-speaker"></i> Speaker</li>
                                                </ul>
                                                <input type="hidden" id="selected-icon" name="icon-selector">
                                            </div>
                                        </div>
                                        <!-- Properties Section -->
                                        <fieldset class="properties">
                                            <legend>Properties</legend>
                                            <div id="properties-container">
                                                <!-- Header Row (to indicate column titles) -->
                                                <div class="property-row header-row">
                                                    <div class="label-box">Label</div>
                                                    <div class="value-box">Value</div>
                                                    <div class="name-box">Name</div>
                                                    <div class="required-box">Required</div>
                                                    <div class="delete-box"></div> <!-- Empty space for delete button -->
                                                </div>

                                                <!-- Body Section for Dynamic Rows -->
                                                <div id="properties-body">
                                                    <!-- Example property row -->
                                                </div>
                                            </div>
                                            <a href="#" class="add-property" onclick="addProperty()">Add property</a>
                                        </fieldset>

                                        <!-- Parts Section -->
                                        <fieldset class="parts">
                                        <legend>Parts</legend>
                                        <div id="parts-container">
                                            <!-- Header Row (to indicate column titles) -->
                                            <div class="part-row header-row">
                                                <div class="partname-box">Part Name</div>
                                                <div class="name-box">Name</div>
                                                <div class="required-box">Required</div>
                                                <div class="delete-box"></div> <!-- Empty space for delete button -->
                                            </div>

                                            <!-- Body Section for Dynamic Rows -->
                                            <div id="parts-body">
                                                <!-- Example part row -->
                                                
                                            </div>
                                        </div>
                                        <a href="#" class="add-part" onclick="addPart()">Add part</a>
                                    </fieldset>

                                        <!-- Comments Section -->
                                        <div class="form-group">
                                            <label for="comments">Comments</label>
                                            <textarea id="comments" placeholder="Enter comments"></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Project-specific JS -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/itemt.js') }}"></script>
</body>
</html>
