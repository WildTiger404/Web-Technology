<!DOCKTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link  href="calendar.css" type="text/css" rel="stylesheet" />
    <title>Календарь</title>
</head>
<body>


<?php

/* Функция генерации календаря */
/**
 * @param $month
 * @param $year
 * @param $cource
 * @return string
 */
function draw_calendar($month, $year, $cource){
    /* Начало таблицы */
    $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

    /* Заглавия в таблице */
    $headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

    $calendar.= '<tr class="calendar-row">
              <td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">',$headings) . '</td></tr>';

    /* необходимые переменные дней и недель... */
    $running_day = date('w',mktime(0,0,0,$month,1,$year));
    $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();



    $first_month = mktime(0, 0, 0, $month, 1, $year);
    $timestamp_last_month = $first_month - (24*60*60);
    if($month == '1')
    {
      $last_month = '12';
    }
    else
    {
      $last_month = $month-1;
    }

    if($month == '1') 
      $last_year = $year-1;
    else 
      $last_year = $year;

    if($month == '12')
        $next_month = '1';
    else
        $next_month = $month+1;

      if($month == '12') 
      $next_year = $year + 1;
    else 
      $next_year = $year;
    echo "<br/>
          <a href='calendar.php?month=$last_month&year=$last_year&cource=$cource'> <h2>prev</h2></a>
          <a href='calendar.php?month=$next_month&year=$next_year&cource=$cource'> <h2>next</h2></a>";



    if (($cource==1)or($cource==2))
    {
        switch ($month)
        {
          case 1:
              $first_day_first_month=26;
              $last_day_first_month=31;
              break;
          case 2:
              $first_day_first_month=1;
              $last_day_first_month=8;
              break;
          case 7:
              $first_day_first_month=3;
              $last_day_first_month=31;
              break;
          case 8:
              $first_day_first_month=1;
              $last_day_first_month=31;
              break;
        }
    }
    else if (($cource==3)or($cource==4))
    {
        switch ($month)
        {
          case 1:
              $first_day_first_month=12;
              $last_day_first_month=25;
              break;
          case 7:
              $first_day_first_month=3;
              $last_day_first_month=31;
              break;
          case 8:
              $first_day_first_month=1;
              $last_day_first_month=31;
              break;
        }
    }
    /* первая строка календаря */
    $calendar.= '<tr class="calendar-row">';

    /* вывод пустых ячеек в сетке календаря */
    for($x = 0; $x < $running_day; $x++):
        $calendar.= '<td class="calendar-day-np"> </td>';
        $days_in_this_week++;
    endfor;
    /* дошли до чисел, будем их писать в первую строку */
    for($list_day = 1; $list_day <= $days_in_month; $list_day++):
        $calendar.= '<td class="calendar-day">';
        /* Пишем номер в ячейку */;
        if(((int)$list_day >= (int)$first_day_first_month) && ((int)$list_day <= (int)$last_day_first_month) )
        {
            $calendar.= '<div class="day-holyday-number">'.$list_day.'</div>';
        }
        else
        {
            $calendar.= '<div class="day-number">'.$list_day.'</div>';
        }

        $calendar.= str_repeat('<p> </p>',2);

        $calendar.= '</td>';
        if($running_day == 6):
            $calendar.= '</tr>';
            if(($day_counter+1) != $days_in_month):
                $calendar.= '<tr class="calendar-row">';
            endif;
            $running_day = -1;
            $days_in_this_week = 0;
        endif;
        $days_in_this_week++; $running_day++; $day_counter++;
    endfor;
    /* Выводим пустые ячейки в конце последней недели */
    if($days_in_this_week < 8):
        for($x = 1; $x <= (8 - $days_in_this_week); $x++):
            $calendar.= '<td class="calendar-day-np"> </td>';
        endfor;
    endif;
    /* Закрываем последнюю строку */
    $calendar.= '</tr>';
    /* Закрываем таблицу */
    $calendar.= '</table>';

    /* Все сделано, возвращаем результат */
    return $calendar;
}



$all_months = array(
    "1" => "January",
    "2" => "February",
    "3" => "March",
    "4" => "April ",
    "5" => "May",
    "6" => "June",
    "7" => "July",
    "8" => "August",
    "9" => "September",
    "10" => "October",
    "11" => "November",
    "12" => "December");


echo "<form class='select_month'  action='calendar.php' method='GET'>";

echo "<select name='month' class='month_choice'>";
for($i=1; $i<=12; $i++) {
    echo "<option value='".($i)."'";
    if($all_months == $i) echo "selected = 'selected'";
    echo ">".$all_months[$i]."</option>";
}
echo "</select>";


echo "<select name='year' class='year_choice'>";
for($i=date('Y')-10; $i<=(date('Y')+10); $i++)
{
    $selected = ($year == $i ? "selected = 'selected'" : '');

    echo "<option value=\"".($i)."\"$selected>".$i."</option>";
}
echo "</select>";

echo "    Курс: ";
echo "<select name='cource' >";
for($i=1; $i<=4; $i++)
{
    $selected = ($cource == $i ? "selected = 'selected'" : '');

    echo "<option value=\"".($i)."\"$selected>".$i."</option>";
}
echo "</select>";

echo "<input type='submit' value='Выбрать' /></form>";


if(isset($_GET['month']) && isset($_GET['year']) && isset($_GET['cource']))
{
    $year = $_GET['year'];
    $month = $_GET['month'];
    $cource = $_GET['cource'];

    echo '<h2>' . $all_months[$month] . ' ' . $year .'</h2>';

    if(!empty($year) && !empty($month) && !empty($cource))
    {
        echo draw_calendar($month,$year,$cource);
        //echo ('<hr>');
    }
    else
    {
        echo "Fill the empty field";
    }
}

?>



</body>
</html>

