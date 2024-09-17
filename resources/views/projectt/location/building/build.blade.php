<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/building.css') }}">
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
                </ul>
            </div>
        </div>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_topNav">
                <div>
                    <a href="#" id="toggleBtn"><i class="fa-solid fa-bars"></i> </a>
                    <span id="inventorySystemText">Inventory System</span>
                </div>
                <a href="{{ route('logout') }}" id="logoutBtn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log-out</a>
            </div>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <header>
                        <div class="header-box">
                            <h1>BUILDINGS</h1>
                            <button id="openModalButton">ADD NEW BUILDING</button>
                        </div>
                    </header>
                
                    <main>
                        <div id="myModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2 id="modalTitle">ADD NEW BUILDING</h2>
                                <form id="addBuildingForm">
                                    <input type="hidden" id="buildingId" name="buildingId">
                                    <label for="buildingName">Name:</label>
                                    <input type="text" id="buildingName" name="buildingName" required>
                                    <label for="buildingStatus">Status:</label>
                                    <select id="buildingStatus" name="buildingStatus">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <button type="submit" id="submitButton">Add Building</button>
                                </form>
                            </div>
                        </div>
                
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Building Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="buildingTableBody">
                            @foreach($buildings as $building)
                                <tr data-id="{{ $building->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $building->name }}</td>
                                    <td>
                                        <div class="status-box {{ $building->status === 'Active' ? 'status-active' : 'status-inactive' }}">
                                            {{ $building->status }}
                                        </div>
                                    </td>
                                    <td>
                                        <button onclick="editBuilding('{{ $building->id }}', '{{ addslashes($building->name) }}', '{{ $building->status }}')" class="action-button">
                                            <i class="fas fa-pencil-alt action-icon"></i> 
                                        </button>
                                        <button onclick="deleteBuilding('{{ $building->id }}')" class="action-button">
                                            <i class="fas fa-trash-alt action-icon"></i> 
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </main>
                
                    <footer>
                        <!-- Add footer content if needed -->
                    </footer>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/building.js') }}"></script>
</body>
</html>