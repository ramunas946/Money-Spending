<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <title>Graph</title>
</head>
<body>
  <div id="example"></div>
  <script src="{{ mix('js/app.js') }}"></script>

  <div class="containermain">

    <div class="row">
      <div class="col-6 col-sm-2">

        <label>current day: {{ $curentTime }}</label>
        </br>
        <label>Total Income: {{$income->money}}$</label>
        </br>
        @if($endmoney < 0 ) <label>debt: {{$endmoney}}$</label>
          @else
          <label>Spending Money: {{$endmoney}}$</label>
          @endif

          @error('money')<h3>{{$message}}</h3></br> @enderror
          <form action="income_create" method="post">
            {{ csrf_field() }}
            <label>add income for each month:</label>
            <select id="month" name="month" class="form-control">
              <option value="January">January: 1</option>
              <option value="February">February: 2</option>
              <option value="March">March: 3</option>
              <option value="April">April: 4</option>
              <option value="May">May: 5</option>
              <option value="June">June: 6</option>
              <option value="July">July: 7</option>
              <option value="August">August: 8</option>
              <option value="September">September: 9</option>
              <option value="October">October: 10</option>
              <option value="November">November: 11</option>
              <option value="December">December: 12</option>
            </select>
            <input id='money' type="number" name="money" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <button class="btn btn-primary" type="submit">submit</button>
          </form>

          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Delete incomes months:
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              @foreach ($monthleyEarnings as $x)
              <a class="dropdown-item" href="income_delete/{{ $x->id }}" class="list-group-item list-group-item-action">
              {{ $x->month }} ${{ $x->money }}
              </a>
              @endforeach
            </div>
          </div>


            <form action="money_create" method="post">
              {{ csrf_field() }}
              <label>Expenses name:</label>
              <input id='expenses' type="text" name="expenses" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <label>Money:</label>
              <input id='money' type="number" name="money" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <button class="btn btn-primary" type="submit">submit</button>
            </form>
            <h3>{{Session::get('message')}}</h3>
            <h3>{{Session::get('Deleted')}}</h3>

            <p>Click on button below to delete:</p>

            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Delete spendings:
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach ($spendings as $x)
                <a href="money_delete/{{ $x->id }}" class="list-group-item list-group-item-action">
                  {{ $x->expenses }} ${{ $x->money }}
                </a>
                @endforeach
            </div>
          </div>
      </div>
      @if($income->money > $endmoney)
      <div id="piechart"></div>
      @endif
    </div>
</body>
<footer>
 put here somthing
 later
 filler content
</footer>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  // Load google charts
  google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);

  // Draw the chart and set the chart values
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      @foreach($spendings as $x)["{{ $x->expenses }}",{{$x -> money}}],
      @endforeach
    ]);

    // Optional; add a title and set the width and height of the chart
    var options = {
      'title': 'money left: {{$income->money - $endmoney}}$',
      'width': 650,
      'height': 600
    };

    // Display the chart inside the <div> element with id="piechart"
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
  }
</script>

</html>