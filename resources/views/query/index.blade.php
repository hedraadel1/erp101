@extends('layouts.app')

@section('content')
    <h1>All Queries, Requests, and Responses</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Time</th>
                <th>Query</th>
                <th>Request</th>
                <th>Response</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($queries as $query)
                <tr>
                    <td>{{ $query->created_at }}</td>
                    <td>{{ $query->query }}</td>
                    <td>{{ $query->request }}</td>
                    <td>{{ $query->response }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
