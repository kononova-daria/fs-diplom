@extends('layouts.app')

@section('content')
    <div class="admin-page" id="app">
        <header class="page-header">
            <h1 class="page-header-title">Идём<span>в</span>кино</h1>
            <span class="page-header-subtitle">Администраторррская</span>
        </header>

        <main>
            <section class="login">
                <header class="login-header">
                    <h2 class="login-title">Авторизация</h2>
                </header>
                <div class="login-wrapper">
                    <form class="login-form"  method="POST" action="{{ route('login') }}">
                        @csrf
                        @error('email')
                            <div style="padding-bottom: 10px;">
                                <span class="invalid-feedback" role="alert" style="color:#a5090c;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        @error('password')
                            <div style="padding-bottom: 10px;">
                                <span class="invalid-feedback" role="alert" style="color:#a5090c;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                        @enderror
                        <div class="row mb-3">
                            <label for="email" class="login-label">E-mail</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="login-input" name="email" required placeholder="example@domain.xyz">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="login-label">Пароль</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="login-input" name="password" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="login-button">Авторизоваться</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
@endsection
