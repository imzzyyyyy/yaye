<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/building.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Building</title>
</head>
<body>
    <div id="dashboardMainContainer">
        <!-- Sidebar and top navigation -->

        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <header>
                        <div class="header-box">
                            <h1>EDIT BUILDING</h1>
                        </div>
                    </header>

                    <main>
                        <form action="{{ route('buildings.update', $building->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <label for="buildingName">Name:</label>
                            <input type="text" id="buildingName" name="name" value="{{ $building->name }}" required>

                            <label for="buildingStatus">Status:</label>
                            <select id="buildingStatus" name="status">
                                <option value="Active" {{ $building->status === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $building->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <button type="submit">Update Building</button>
                        </form>
                    </main>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
