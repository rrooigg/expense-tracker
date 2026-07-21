<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>Register Page</title>
</head>
<body>
  @auth
  <p>Welcome, {{ $user->name }}. Track your expenses with eXpnse</p>
  <form action="/logout" method="POST">
    @csrf
    <button style="width: 80px;">Log out</button>
  </form>
  @else
  <h1 style="text-align: center;">Welcome to ExpenseTracker</h1>
  <form action="/register" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Enter your name..">
    <input type="text" name="email" placeholder="Enter your email..">
    <input type="password" name="password" placeholder="Enter your password.."> <br>
    <button style="width: 80px;">Register</button>
  </form>
  {{-- login section --}}
  <h3 style="text-align: center;">Already have an account? Log in.</h3>
  <form action="/login" method="POST">
    @csrf
    <input type="text" name="loginname" placeholder="Enter your name..">
    <input type="password" name="loginpassword" placeholder="Enter your password.."> <br>
    <button style="width: 80px;">Login</button>
  </form>
  @endauth
  
</body>
</html>