<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/technician.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Technician</title>
</head>
<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar and top navigation -->

        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <header>
                        <div class="header-box">
                            <h1>CREATE TECHNICIAN</h1>
                        </div>
                    </header>

                    <main>
                        <form action="{{ route('technicians.store') }}" method="POST">
                            @csrf
                            <label for="technicianName">Name:</label>
                            <input type="text" id="technicianName" name="name" required>

                            <label for="technicianStatus">Status:</label>
                            <select id="technicianStatus" name="status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>

                            <button type="submit">Create Technician</button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
