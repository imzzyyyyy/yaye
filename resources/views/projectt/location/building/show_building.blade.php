<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/building.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Building Details</title>
</head>
<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar and top navigation -->

        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <header>
                        <div class="header-box">
                            <h1>BUILDING DETAILS</h1>
                        </div>
                    </header>

                    <main>
                        <div>
                            <h2>{{ $building->name }}</h2>
                            <p>Status: <span class="{{ $building->status === 'Active' ? 'status-active' : 'status-inactive' }}">{{ $building->status }}</span></p>
                            <!-- Add additional details as needed -->
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
