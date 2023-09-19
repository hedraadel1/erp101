<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Page</title>
    <style>
        body {
            text-align: center;
        }

        .timer {
            font-size: 30px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="timer">
        <h1>Loading...</h1>
        <span id="countdown"></span>
    </div>

    <script>
        var countdown = 5; // Seconds

        function updateCountdown() {
            if (countdown > 0) {
                countdown--;
                document.getElementById('countdown').innerHTML = countdown;
            } else {
                // Redirect to the next page
                window.location.href = '/';
            }
        }

        setInterval(updateCountdown, 1000);
    </script>
</body>


</html>
