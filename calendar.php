
<?php

/*

Да се създаде работещ календар. За целта трябва да бъдат изпълнени следните условия:

1. При избран месец от падащото меню и попълнена година в полето - да се визуализира календар за въпросните месец и година
2. Ако не е избран месец или година, да се използват текущите (пример: ноември, 2021)
3. Месецът и годината, за които е показан календар да са попълнени в падащото меню и полето за година
3. При натискане на бутон "Today" да се показва календар за текущите месец и година
5. В първия ред на календара да има:
  1. Стрелка на ляво, която да показва предишния месец при кликване
  2. Текст с името на месеца и годината, за които са показани дните
  3. Стрелка в дясно, която да показва следващия месец при кликване
6. Таблицата да показва дни от предишния и/или следващия месец до запълване на седмиците (пример: Ако месеца започва в сряда, да се покажат последните два дни от предишния месец за вторник и понеделник)
7. Показаните дни в таблицата трябва да са черни и удебелени за текущия месец, и сиви за предишен или следващ месец (css клас "fw-bold" за текущия месец и "text-black-50" за останалите)

*/

// your code here...

//Задаваме часова зона по пордразбиране:
date_default_timezone_get();

//Предишен и следващ месец
if (isset($_GET['ym'])) 
{
    $ym=$_GET ['ym'];
} else {
    //Сегашен месец
    $ym = date('Y-m');
}
//Проверка за формата
$timestamp = strtotime($ym, '-01');
if ($timestamp === false)
{
    $timestamp = time();
}

//Днешна дата
$today = date('Y-m-d', time());
$first_day = date('y-m-01');

$html_title = date('Y / m', $timestamp);

//Линковете за предишен и следващ месец
$prev = date('Y-m', mktime(0,0,0, date('m', $timestamp) -1,1,date('Y', $timestamp)));
$next = date('Y-m', mktime(0,0,0, date('m', $timestamp) +1,1,date('Y', $timestamp)));

//Дните в месеца
$day_count = date('t', $timestamp);
$first_day_of_the_month = date ('w', mktime(0,0,0, date('m', $timestamp), 1, date('Y', $timestamp)));
$calendar_month_start_day = strtotime("-". $first_day_of_the_month - 1, strtotime($first_day));

//Създаваме календара
$weeks = array();
$week = '';
$day = $calendar_month_start_day;
        
for ($count = 0; $count < 7 * 5; $count++) {
    $formatted_day = date('d', $day);
    
    if ($count % 7 === 0) {
        if ($count !== 0) {
            $week .= '</tr>';
        }
        $week .= '<tr>';
    }  
    
    if ($today == date('Y-m-d', $day)) {
        $week .= '<td class = "today">' . $formatted_day;
    } else {
        $week .= '<td>' . $formatted_day;
    }
    $week .= '</td>';
    
    $next_day = strtotime("+1 day", $day);
    $day = $next_day;
   
    $weeks[] = $week;
    $week = '';    
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Calendar</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Calendar</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
          <form class="row g-3">
            <div class="col-md-6 col-lg-6">
              <label class="form-label" for="month">Select month</label>
              <select name="m" class="form-control" id="month">
                <option  value="1">January</option>
                <option  value="2">February</option>
                <option  value="3">March</option>
                <option  value="4">April</option>
                <option  value="5">May</option>
                <option  value="6">June</option>
                <option  value="7">July</option>
                <option  value="8">August</option>
                <option  value="9">September</option>
                <option  value="10">October</option>
                <option selected value="11">November</option>
                <option  value="12">December</option>
              </select>
            </div>
            <div class="col-md-6 col-lg-6">
              <label class="form-label" for="year"> Year: </label>
              <input type="text" name="y" class="form-control" value="2021">
            </div>
            <div class="col-md-12 col-lg-12">
              <button type="submit" class="btn btn-primary">Show</button>
              <a href="?m=11&y=2021" class="btn btn-secondary">Today</a>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mt-5 offset-md-3 col-lg-6 offset-lg-3">
          <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>
                  <a href="?ym = <?php echo $prev; ?>">&larr;</a>
                </th>
                <th colspan="5" class="text-center">November, 2021</th>
                <th>
                  <a href="?ym = <?php echo $next; ?>"title="Next month">&rarr;</a>
                </th>
              </tr>
              <tr>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
                <th>Sun</th>
              </tr>
            </thead>
            <tbody>
              <!-- remove the following and add your code to display the days: -->
             <?php
             foreach($weeks as $week){
                 echo $week;
             }                 
             ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>