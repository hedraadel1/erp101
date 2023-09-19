<!DOCTYPE html>
<html>
<head>
    <title>Page Loading</title>
</head>
<body>
    <div class="container">
        <h1>The page is loading.</h1>
        <p>
            <span id="timer">10</span> seconds remaining.
        </p>
    </div>
    <script>
        const timer = document.querySelector('#timer');
        const interval = setInterval(() => {
            timer.textContent--;
            if (timer.textContent <= 0) {
                clearInterval(interval);
                // Show the original message or view.
            }
        }, 1000);
    </script>
</body>
</html>