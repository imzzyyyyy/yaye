<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StackES</title>
    <link rel="shortcut icon" type="x-icon" href="{{ asset('icons8-person-64.png') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<body>
    <div class="logo"></div>
    <div class="login-box">
        <h2>Login</h2>
        <form id="LoginForm" action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="user-box">
                <input type="text" name="username" required>
                <label for="username">Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required>
                <label for="password">Password</label>
            </div>
            <a href="#" onclick="submitButtonClicked(event)" class="submit-button">
                <span></span>
                <span></span>
                <span></span>
                <span></span>Login
            </a>
        </form>
    </div>

    <script>
        function submitButtonClicked(event) {
            event.preventDefault(); // Prevent default anchor behavior

            var form = document.getElementById('LoginForm');
            if (form) {
                form.submit(); // Submit the form
            }
        }
    </script>
</body>
</html>
