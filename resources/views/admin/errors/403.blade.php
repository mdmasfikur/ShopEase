<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f9f9f9;
        }
        h1 {
            font-size: 48px;
            color: #e3342f;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        a {
            color: #3490dc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Unauthorized Access</h1>
    <p>You do not have the required permissions to access this page.</p>
    <a href="{{ url('/') }}">Return to Homepage</a>
</body>
</html>
