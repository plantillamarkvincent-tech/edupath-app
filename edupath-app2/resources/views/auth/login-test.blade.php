<!DOCTYPE html>
<html>
<head>
    <title>TEST LOGIN</title>
</head>
<body>
    <h1>TEST - If you see this, the page is loading</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
