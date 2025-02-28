@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Add New User') }}</div>

    <div class="card-body">
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">{{ __('Creation Mode') }}</label>
            <div class="col-md-6">
                <select id="creation_mode" class="form-control">
                    <option value="manual" selected>Manual</option>
                    <option value="auto">Auto (Select from Existing Employee)</option>
                </select>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div id="auto-user-select" class="form-group row" style="display: none;">
                <label for="auto_user" class="col-md-4 col-form-label text-md-right">{{ __('Select Employee') }}</label>
                <div class="col-md-6">
                    <select id="auto_user" class="form-control">
                        <option value="" selected hidden>Please Select a Employee</option>
                        @foreach ($employee as $user)
                            <option value="{{ $user->npk }}" data-name="{{ $user->name }}" data-username="{{ $user->name }}"
                                data-password="{{ $user->password }}" data-email="{{ $user->name }}@mail.com">
                                {{ $user->npk }} - {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="role_id" class="required col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                <div class="col-md-6">
                    <select id="role_id" class="form-control @error('role_id') is-invalid @enderror" name="role_id"
                        required>
                        <option value="" selected hidden>Please Select</option>
                        @foreach ($roles as $id => $role)
                            <option value="{{$id}}" {{ (old('role_id', '') == $id) ? 'selected' : '' }}>{{$role}}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="required col-md-4 col-form-label text-md-right">{{ __('NPK/Name') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="username"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                <div class="col-md-6">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email"
                    class="required col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm"
                    class="required col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const creationMode = document.getElementById('creation_mode');
        const autoUserSelect = document.getElementById('auto-user-select');
        const autoUser = document.getElementById('auto_user');

        creationMode.addEventListener('change', function () {
            if (this.value === 'auto') {
                autoUserSelect.style.display = 'flex';
            } else {
                autoUserSelect.style.display = 'none';
                clearAutoFillFields();
            }
        });

        autoUser.addEventListener('change', function () {
            const selectedUser = this.options[this.selectedIndex];
            console.log(selectedUser);

            if (selectedUser) {
                document.getElementById('name').value = selectedUser.value;
                document.getElementById('username').value = selectedUser.getAttribute('data-name');
                document.getElementById('email').value = selectedUser.getAttribute('data-email');
                const passwordField = document.getElementById('password').value = selectedUser.getAttribute('data-password')
                document.getElementById('password-confirm').value = passwordField;
            }
        });

        function clearAutoFillFields() {
            document.getElementById('name').value = '';
            document.getElementById('username').value = '';
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            document.getElementById('password-confirm').value = '';
        }
    });
</script>

@endsection