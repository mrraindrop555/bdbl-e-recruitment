<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Document</title>
</head>

<body>
    <h1>Admin Login</h1>
    <form action="/login" method="POST">
        @csrf
        <div class="row">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('name') }}" autocomplete="off"
                placeholder="username@example.com">
            @error('email')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input type="password" name="password">
        </div>
        <button type="submit">Login</button>
    </form>
</body>

</html>
