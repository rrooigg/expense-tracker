<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>Register Page</title>
</head>
<body>
  @auth
  <h3 style="text-align: center;">Welcome, {{ $user->name }}. Track your expenses with eXpnse</h3>
  <form action="/logout" method="POST">
    @csrf
    <button style="width: 80px; position: fixed; top: 10px;">Log out</button>
  </form>
  {{-- add income --}}
  <form action="/add-income" method="POST" class="income-form">
    @csrf
    <input type="number" name="income" style="width: 300px;" placeholder="Enter your income.." value="{{ Auth::user()->income }}">
    <button style="width: 80px;">Enter</button>
  </form>
  <div class="income-container">
    Total Income: ${{ number_format(Auth::user()->income, 2) }}
  </div>
  {{-- add categories --}}
  <form action="/add-category" method="POST" style="display: flex; gap:20px;">
    @csrf
    <input type="text" name="name" placeholder="Add category.." class="income-form"  style="width: 300px;">
    <button style="width: 80px;">Add</button>
  </form>
  @foreach ($categories as $category)
  {{ $category->name }}
  <br>
  @endforeach
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