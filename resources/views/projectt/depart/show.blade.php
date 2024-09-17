<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/department.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Department</title>
</head>
<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar and top navigation -->

        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                <header>
                    <div class="header-box">
                        <h1>DEPARTMENT DETAILS</h1>
                    </div>
                </header>

                <main>
                        <div>
                            <h2>{{ $department->name }}</h2>
                            <p>Status: <span class="{{ $department->status === 'Active' ? 'status-active' : 'status-inactive' }}">{{ $department->status }}</span></p>
                            <!-- Add additional details as needed -->
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
