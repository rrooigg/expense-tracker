<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <title>eXpnse</title>
</head>
<body>
  {{-- install Chart.js throught its CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  {{-- plugin to use % --}}
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  @auth
  <h3 style="text-align: center;">Welcome, {{ $user->name }}. Track your expenses with eXpnse</h3>
  <form action="/logout" method="POST">
    @csrf
    <button style="width: 80px;">Log out</button>
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
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="amount" placeholder="Amount">
    <select name="category_id" placeholder="Category">
      @foreach ($categories as $category)
      <option value="{{ $category->id }}">
        {{ $category->name }}</option>        
      @endforeach
    </select>
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
  {{-- pie chart --}}
  <div style="width:400px;">
    <canvas id="expenseChart"></canvas>
  </div>
  <script>
    Chart.register(ChartDataLabels);
    //chart.js expects 2 arrays, 1=labels, other=totals
    const labels = @json($chartData->pluck('name'));
    const totals = @json($chartData->pluck('total')).map(Number);
    console.log(totals);
    console.log(typeof totals[0]);

    const ctx = document.getElementById('expenseChart');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          data:totals
        }]
      },
      plugins: [ChartDataLabels],
      options: {
        plugins: {
          datalabels: {
            color:'#fff',
            formatter: (value, context) => {
              const data = context.chart.data.datasets[0].data;
              const total = data.reduce((a, b) => a + b, 0);
              const percentage = (value / total * 100).toFixed(1);
              return percentage + '%';
            }
          }
        }
      }
    });
  </script>
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