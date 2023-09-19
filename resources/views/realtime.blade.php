<!-- resources/views/realtime.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Realtime Page</title>
</head>
<body>
    <h1>Realtime Page</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Query</th>
                <th>Bindings</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($queryLog as $query)
                <tr>
                    <td>{{ $query['sql'] }}</td>
                    <td>{{ implode(', ', $query['bindings']) }}</td>
                    <td>{{ $query['time'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
