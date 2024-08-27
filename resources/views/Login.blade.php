<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Document</title>
</head>

<body
    style="display: flex; justify-content: center; align-items: center; width: 100vw; height: 100vh; flex-direction: column;">
    <form action="/login" method="POST">
        @csrf
        <div style="text-align: center; font-size: 30px; margin-bottom: 10px; color: rgb(80, 78, 78); font-weight: 600">
            ADMIN LOGIN</div>
        <div class="row">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('name') }}" autocomplete="off"
                placeholder="username@example.com">
            @error('email')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input type="password" name="password" value="{{ old('password') }}">
        </div>
        <button type="submit">Login</button>
        <div style="margin-top: 20px;">
            <a href="/">Go Back</a>
        </div>
    </form>
    <div style="opacity: 0.3; margin-top: 20px; user-select: none;">
        BDBL e-Recruitment 2024
    </div>
</body>

</html>
