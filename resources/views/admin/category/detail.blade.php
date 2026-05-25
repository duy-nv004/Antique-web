@extends('layout.admin')
@section('content')
    <body>
        <h1>detail</h1>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>description</th>
                        <th>parent_id</th>
                        <th>is_active</th>
                        <th>is_deleted</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{ $categories['id'] }}</td>
                            <td>{{ $categories['name'] }}</td>
                            <td>{{ $categories['description'] }}</td>
                            <td>{{ $categories['parent_id'] }}</td>
                            <td>{{ $categories['is_active'] }}</td>
                            <td>{{ $categories['is_deleted'] }}</td>
                            <td>
                                <button class="btn btn-info">
                                    <a href="{{ route('categories.edit', $categories->id) }}"
                                        class="text-decoration-none text-dark">edit</a>
                                </button>
                                <button class="btn btn-danger">
                                    <a href="{{ route('categories.destroy', $categories->id) }}"
                                        class="text-decoration-none text-dark">delete</a>
                                </button>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </body>
@endsection