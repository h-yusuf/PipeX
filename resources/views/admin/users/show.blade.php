@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header">{{ __('View User') }}</div>

        <div class="card-body">

            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Back to List</a>

            <br /><br />



                <table class="table table-borderless">

                    <tr>
                        <th>ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>NPK/Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ $user->role->title ?? '--' }}</td>
                    </tr>

                </table>




        </div>
    </div>

@endsection
