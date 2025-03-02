@extends('layouts.app')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/login" class="h2"><b>LOGIN</b></a>
            </div>
            <div class="card-body">
                <img src="{{ asset('icons/logo-dark.jpeg') }}" width="198px" alt="Logo"
                    class="logo-api rounded img-fluid mb-4" style="display: block; margin: 0 auto;"></img>

                <!-- Form Login -->
                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <!-- Tampilkan Error Jika Ada -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Input Username atau Email -->
                    <div class="input-group mb-3">
                        <input id="login" type="text" name="login" class="form-control @error('login') is-invalid @enderror"
                            placeholder="Npk or Name or Email" value="{{ old('login') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="input-group mb-3">
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>

                </form>
            </div>
        </div>
    </div>
@endsection