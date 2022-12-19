<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Task Assignment Project | Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('js/app.js') }}" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
        }
    </style>
</head>
<body>
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-5 mx-auto">

            <div class="row">
                <div class="col-lg">
                    <div class="card h-100 justify-content-center rounded-3 border-0 shadow">
                        <form class="p-5" action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="row pb-2">
                                <h3> Task Assignment Project </h3>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bolder">Email</label>
                                <input class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       type="email" name="email" id="email" value="{{ old('email') }}" required>
                                @error('email') <span class="text-danger fw-bolder"
                                                      role="alert">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bolder">Password</label>
                                <input class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       type="password" name="password" id="password" required>
                                @error('password') <span class="text-danger fw-bolder"
                                                         role="alert">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <button class="btn btn-primary btn-lg text-white fw-bolder">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
