<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/facility.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Facility</title>
</head>
<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar and top navigation -->

        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <header>
                        <div class="header-box">
                        <h1>EDIT FACILITY</h1>
                        </div>
                    </header>

                    <main>
                        <form action="{{ route('facilities.update', $facility->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <label for="facilityName">Name:</label>
                            <input type="text" id="facilityName" name="name" value="{{ $facility->name }}" required>

                            <label for="facilityStatus">Status:</label>
                            <select id="facilityStatus" name="status">
                                <option value="Active" {{ $facility->status === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $facility->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <button type="submit">Update facility</button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
