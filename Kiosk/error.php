<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <style>
        body {
            background-color: #f44336; /* Red background color for error */
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        .container {
            background-color: #fff;
            color: #000;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        button {
            background-color: #4CAF50; /* Green background color for button */
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }
        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Error 404</h1>
        <p>Invalid Student ID. Please check your ID number.</p>
        <button onclick="redirectToIndex()">Go Back</button>
    </div>
    <script>
        function redirectToIndex() {
            window.location.href = 'index.html';
        }
    </script>
</body>
</html>