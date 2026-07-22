<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>eXpnse</title>
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
    <input type="number" name="income" style="width: 300px;" placeholder="Enter your income..">
    <button style="width: 80px;">Enter</button>
  </form>
  {{-- combine income & balance div to arrange horizontally --}}
  <div style="display: flex; gap:30px;">
    <div class="income-container">
      Income: Ksh. {{ number_format(Auth::user()->income, 2) }}
    </div>
  {{-- show balance --}}
    <div class="income-container">
      Balance: Ksh. {{ $income - $total_expenses }}
    </div>
  </div>
  {{-- add categories --}}
  <form action="/add-category" method="POST" style="display: flex; gap:20px;">
    @csrf
    <input type="text" name="name" placeholder="Add category.." class="income-form"  style="width: 300px;">
    <button style="width: 80px;">Add</button>
  </form>
  <div style="margin-bottom: 20px;">
    @foreach ($categories as $category)
    {{ $category->name }}
    <br>
  @endforeach
  </div>
  {{-- table showing expenses --}}
  <form action="/add-expenses" method="POST">
    @csrf
    <input type="text" name="name" class="expenses-input" placeholder="Name">
    <input type="text" name="amount" class="expenses-input" placeholder="Amount">
    <input type="text" name="category_id" class="expenses-input" placeholder="Category">
    <Button style="width: 80px;">Add</Button>
  </form>

  <table>
    @foreach ($expenses as $expense)
    <tr>
      <td>{{ $expense->name }}</td>
      <td>{{ $expense->amount }}</td>
      <td>{{ $expense->category_id }}</td>
      {{-- add delete button --}}
      <td>
        <form action="/delete-expense/{{ $expense->id }}" method="POST">
          @csrf
          @method('DELETE')
          <button style="border:none; background-color: white; width: 30px; height: 30px;"><img src="{{ asset('images/Trash Can.jpg') }}" alt="trash-can" style="width: 30px; height: 30px;"></button>
        </form>
      </td>
    </tr>
    @endforeach
  </table>
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