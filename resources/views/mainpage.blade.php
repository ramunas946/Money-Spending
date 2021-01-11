<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <title>Graph</title>
</head>

<body style="padding: 15px;">
  <div id="example"></div>
  <script src="{{ mix('js/app.js') }}"></script>

  <div class="containermain">

    <div class="row">
      <div class="col-sm-2">

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
            <label>Goal:</label>
            <input id='goal' type="number" name="goal" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <label>Money:</label>
            <input id='money' type="number" name="money" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <button class="btn btn-primary" type="submit">submit</button>
          </form>
            
          <h3>{{Session::get('message')}}</h3>
          <h3>{{Session::get('Deleted')}}</h3>

          @if(Session::has('goal'))
          <h3> {{Session::get('goal')}}$</h3>
          <span>add to expenses</span>
          <label>Expenses name:</label>
            <input id='expenses' type="text" name="expenses" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <button class="btn btn-primary" type="submit">add</button>
          @endif
          <form action="money_goal" method="post">
            {{ csrf_field() }}
            <label>type how much it cost</label>
            <input id='goal_money' type="number" name="goal_money" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <label>how many months to get in</label>
            <input id='goal' type="number" name="goal" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">

            <button class="btn btn-primary" type="submit">submit</button>
          </form>

      </div>
      @if($income->money > $endmoney)
      <div class="col-sm-6" id="piechart"></div>
      @endif
      <div class="col-sm-4" style="padding: 0;
      margin: 0;
      position: absolute;
      top: 62px;
      bottom: 100px;
      right: 0px;
      width: 50%;
      overflow-y: scroll;">
        @foreach ($spendings as $x)
        @if($loop->first)
        <div class="col">
          <div class="row">
            @endif
            <div class="col-sm-12" style="text-align: center;">
              <?php
              $calculation = ($x->goal - $x->money) / $x->goal * 100;
              $procentage = round($calculation, 2);
              $procentage1 = 100 - ($x->goal - $x->money) / $x->goal * 100;
              ?>
              @if ( $calculation < 0.1 ) <label>{{ $x->expenses }}</label>
                </br>
                <label>You reachd your limit</label>
                @else

                <label>{{ $x->expenses }}</label>
                </br>
                <label>spending left: {{$procentage}}% </label>
                @endif
                <?php
                if ($x->goal / 2 > $x->money) {
                  $color = "green";
                } elseif ($x->goal + 1 > $x->money) {
                  $color = "blue";
                } else {
                  $color = "red";
                }
                ?>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: {{$procentage1}}%; background-color: {{$color}};" aria-valuenow="{{ $x->money }}" aria-valuemin="0" aria-valuemax="100">
                    {{$x->money}}
                    <div style="text-align: right;">{{$procentage}}%</div>
                  </div>
                </div>
                <label>Spending limit :{{ $x->goal }}</label>
                <form action="money_update/{{$x->id}}" method="post">
                  {{ csrf_field() }}
                  <label>Add spendings:</label>
                  <input id='money' type="number" name="money" required class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <button class="btn btn-primary" type="submit">submit</button>
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    More
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal">
                      Delete
                    </a>
                  </div>
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Are you sure u want to delete this Goal?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <a type="button" class="btn btn-secondary" href="money_delete/{{ $x->id }}">Yes</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
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
          // @foreach($spendings as $x)["{{ $x->expenses }}", {{$x -> money}}], @endforeach]);

          // Optional; add a title and set the width and height of the chart
          var options = {
            'title': 'money spent: {{$income->money - $endmoney}}$',
            'width': 650,
            'height': 600
          };

          // Display the chart inside the <div> element with id="piechart"
          var chart = new google.visualization.PieChart(document.getElementById('piechart'));
          chart.draw(data, options);
        }
</script>

</html>