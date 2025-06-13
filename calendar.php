<?php
session_start(); //session start always on top.
require_once './config/config.php';
require_once './config/connection.php';
require_once './access.php'; //inside access.php you already have $con variable without importing it there.
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Appointment Calendar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="images/fav.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/fav.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/fav.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
      * {
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
        list-style: none;
        margin: -2px;
        outline: none;
        padding: 0;
      }

      a {
        text-decorat
        ion: none;
      }

      body, html {
        height: 100%;
      }

      body {
        background: #dfebed;
        font-family: 'Roboto', sans-serif;
      }

      .calendar {
        background: #2b4450;
        border-radius: 4px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .3);
        height: 501px;
        perspective: 1000;
        transition: .9s;
        transform-style: preserve-3d;
        width: 100%;
      }

      /* Front - Calendar */
      .front {
        transform: rotateY(0deg);
      }

      .current-date {
        border-bottom: 1px solid rgba(73, 114, 133, .6);
        display: flex;
        justify-content: space-between;
        padding: 30px 40px;
      }

      .current-date h1 {
        color: #dfebed;
        font-size: 1.4em;
        font-weight: 300;
      }

      .week-days {
        color: #dfebed;
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        padding: 30px 40px;
      }

      .days {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
      }

      .weeks {
        color: #fff;
        display: flex;
        flex-direction: column;
        padding: 0 40px;
      }

      .weeks div {
        display: flex;
        font-size: 1.2em;
        font-weight: 300;
        justify-content: space-between;
        margin-bottom: 20px;
        width: 100%;
      }

      .last-month {
        opacity: .3;
      }

      .weeks span {
        padding: 10px;
      }

      .weeks span.active {
        background: #3FE0D0;
        border-radius: 3px;
      }

      .weeks span:not(.last-month):hover {
        cursor: pointer;
        font-weight: 600;
      }

      .event {
        position: relative;
      }

      .event:after {
        content: '•';
        color: #f78536;
        font-size: 1.4em;
        position: absolute;
        right: -4px;
        top: -4px;
      }

      /* Back - Event form */

      .back {
        height: 100%;
        transform: rotateY(180deg);
      }

      .back input {
        background: none;
        border: none;
        border-bottom: 1px solid rgba(73, 114, 133, .6);
        color: #dfebed;
        font-size: 1.4em;
        font-weight: 300;
        padding: 30px 40px;
        width: 100%;
      }

      .info {
        color: #dfebed;
        display: flex;
        flex-direction: column;
        font-weight: 600;
        font-size: 1.2em;
        padding: 30px 40px;
      }

      .info div:not(.observations) {
        margin-bottom: 40px;
      }

      .info span {
        font-weight: 300;
      }

      .info .date {
        display: flex;
        justify-content: space-between;
      }

      .info .date p {
        width: 50%;
      }

      .info .address p {
        width: 100%;
      }

      .actions {
        bottom: 0;
        border-top: 1px solid rgba(73, 114, 133, .6);
        display: flex;
        justify-content: space-between;
        position: absolute;
        width: 100%;
      }

      .actions button {
        background: none;
        border: 0;
        color: #fff;
        font-weight: 600;
        letter-spacing: 3px;
        margin: 0;
        padding: 30px 0;
        text-transform: uppercase;
        width: 50%;
      }

      .actions button:first-of-type {
        border-right: 1px solid rgba(73, 114, 133, .6);
      }

      .actions button:hover {
        background: #497285;
        cursor: pointer;
      }

      .actions button:active {
        background: #5889a0;
        outline: none;
      }

      /* Flip animation */

      .flip {
        transform: rotateY(180deg);
      }

      .front, .back {
        backface-visibility: hidden;
      }
      /* .container {*/
      /*	align-items: center;*/
      /*	display: flex;*/
      /*	height: 100%;*/
      /*	justify-content: center;*/
      /*	margin: 0 auto;*/
      /*	max-width: 600px;*/
      /*	width: 100%;*/
      /*}*/
      
      [type=radio] { 
        opacity: 0;
        width: 0;
        height: 0;
      }
    </style>

  </head>
  <body>
    <?php
     
    $repo=mysqli_query($con,"select count(*) from appointment where d='01'");
    $ress=mysqli_fetch_assoc($repo);
    $o1=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='02'");
    $ress=mysqli_fetch_assoc($repo);
    $o2=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='03'");
    $ress=mysqli_fetch_assoc($repo);
    $o3=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='04'");
    $ress=mysqli_fetch_assoc($repo);
    $o4=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='05'");
    $ress=mysqli_fetch_assoc($repo);
    $o5=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='06'");
    $ress=mysqli_fetch_assoc($repo);
    $o6=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='07'");
    $ress=mysqli_fetch_assoc($repo);
    $o7=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='08'");
    $ress=mysqli_fetch_assoc($repo);
    $o8=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='09'");
    $ress=mysqli_fetch_assoc($repo);
    $o9=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='10'");
    $ress=mysqli_fetch_assoc($repo);
    $o10=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='11'");
    $ress=mysqli_fetch_assoc($repo);
    $o11=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='12'");
    $ress=mysqli_fetch_assoc($repo);
    $o12=$ress['count(*)'];
    
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='13'");
    $ress=mysqli_fetch_assoc($repo);
    $o13=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='14'");
    $ress=mysqli_fetch_assoc($repo);
    $o14=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='15'");
    $ress=mysqli_fetch_assoc($repo);
    $o15=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='16'");
    $ress=mysqli_fetch_assoc($repo);
    $o16=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='17'");
    $ress=mysqli_fetch_assoc($repo);
    $o17=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='18'");
    $ress=mysqli_fetch_assoc($repo);
    $o18=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='19'");
    $ress=mysqli_fetch_assoc($repo);
    $o19=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='20'");
    $ress=mysqli_fetch_assoc($repo);
    $o20=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='21'");
    $ress=mysqli_fetch_assoc($repo);
    $o21=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='22'");
    $ress=mysqli_fetch_assoc($repo);
    $o22=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='23'");
    $ress=mysqli_fetch_assoc($repo);
    $o23=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='24'");
    $ress=mysqli_fetch_assoc($repo);
    $o24=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='25'");
    $ress=mysqli_fetch_assoc($repo);
    $o25=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='26'");
    $ress=mysqli_fetch_assoc($repo);
    $o26=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='27'");
    $ress=mysqli_fetch_assoc($repo);
    $o27=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='28'");
    $ress=mysqli_fetch_assoc($repo);
    $o28=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='29'");
    $ress=mysqli_fetch_assoc($repo);
    $o29=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='30'");
    $ress=mysqli_fetch_assoc($repo);
    $o30=$ress['count(*)'];
    
    $repo=mysqli_query($con,"select count(*) from appointment where d='31'");
    $ress=mysqli_fetch_assoc($repo);
    $o31=$ress['count(*)'];
    
    date_default_timezone_set("America/New_York");
    $day = date('d');
    ?>
    <div class="container" style="padding-top:70px">
        <div class="row">
        <div class="col-sm-6">
          <div class="calendar">
        <div class="front">
          <div class="current-date">
            <h1><?= date('l jS');?></h1>
            <h1><?= date('F Y');?></h1>	
          </div>

          <div class="current-month">
            <ul class="week-days">
              <li>MON</li>
              <li>TUE</li>
              <li>WED</li>
              <li>THU</li>
              <li>FRI</li>
              <li>SAT</li>
              <li>SUN</li>
            </ul>
            <form method="post">
            <div class="weeks">
              <div class="first">
                <span class="last-month">28</span>
                <span class="last-month">29</span>
                <span class="last-month">30</span>
                <span class="last-month">31</span>
                <span class="<?php echo ($day==01)?'active':'';?> <?php echo ($o1<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '01'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">01</label></span>
                <span class="<?php echo ($day==02)?'active':'';?> <?php echo ($o2<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '02'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">02</label></span>
                <span class="<?php echo ($day==03)?'active':'';?> <?php echo ($o3<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '03'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">03</label></span>
              </div>

              <div class="second">
                <span class="<?php echo ($day==04)?'active':'';?> <?php echo ($o4<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '04'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">04</label></span>
                <span class="<?php echo ($day==05)?'active':'';?> <?php echo ($o5<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '05'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">05</label></span>
                <span class="<?php echo ($day==06)?'active':'';?> <?php echo ($o6<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '06'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">06</label></span>
                <span class="<?php echo ($day==07)?'active':'';?> <?php echo ($o7<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '07'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">07</label></span>
                
                <span class="<?php // echo ($day==08)?'active':'';?> <?php echo ($o8<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '08'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">08</label></span>
                <span class="<?php // echo ($day==09)?'active':'';?> <?php echo ($o9<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '09'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">09</label></span>
                <span class="<?php echo ($day==10)?'active':'';?> <?php echo ($o10<>0)?'event':'';?>"><label><input type="radio" value="<?php echo '10'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">10</label></span>
              </div>

              <div class="third">
                <span class="<?php echo ($day==11)?'active':'';?> <?php echo ($o11<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '11'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">11</label></span>
                <span class="<?php echo ($day==12)?'active':'';?> <?php echo ($o12<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '12'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">12</label></span>
                <span class="<?php echo ($day==13)?'active':'';?> <?php echo ($o13<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '13'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">13</label></span>
                <span class="<?php echo ($day==14)?'active':'';?> <?php echo ($o14<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '14'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">14</label></span>
                <span class="<?php echo ($day==15)?'active':'';?> <?php echo ($o15<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '15'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">15</label></span>
                <span class="<?php echo ($day==16)?'active':'';?> <?php echo ($o16<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '16'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">16</label></span>
                <span class="<?php echo ($day==17)?'active':'';?> <?php echo ($o17<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '17'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">17</label></span>
              </div>

              <div class="fourth">
                <span class="<?php echo ($day==18)?'active':'';?> <?php echo ($o18<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '18'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">18</label></span>
                <span class="<?php echo ($day==19)?'active':'';?> <?php echo ($o19<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '19'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">19</label></span>
                <span class="<?php echo ($day==20)?'active':'';?> <?php echo ($o20<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '20'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">20</label></span>
                <span class="<?php echo ($day==21)?'active':'';?> <?php echo ($o21<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '21'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">21</label></span>
                <span class="<?php echo ($day==22)?'active':'';?> <?php echo ($o22<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '22'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">22</label></span>
                <span class="<?php echo ($day==23)?'active':'';?> <?php echo ($o23<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '23'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">23</label></span>
                <span class="<?php echo ($day==24)?'active':'';?> <?php echo ($o24<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '24'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">24</label></span>
              </div>

              <div class="fifth">
                <span class="<?php echo ($day==25)?'active':'';?> <?php echo ($o25<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '25'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">25</label></span>
                <span class="<?php echo ($day==26)?'active':'';?> <?php echo ($o26<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '26'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">26</label></span>
                <span class="<?php echo ($day==27)?'active':'';?> <?php echo ($o27<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '27'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">27</label></span>
                <span class="<?php echo ($day==28)?'active':'';?> <?php echo ($o28<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '28'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">28</label></span>
                <span class="<?php echo ($day==29)?'active':'';?> <?php echo ($o29<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '29'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">29</label></span>
                <span class="<?php echo ($day==30)?'active':'';?> <?php echo ($o31<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '30'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">30</label></span>
                <span class="<?php echo ($day==31)?'active':'';?> <?php echo ($o31<>0)?'event':''; ?>"><label><input type="radio" value="<?php echo '31'; ?>" name="d" id="d" onchange="getData(this.value, 'displaydata')">31</label></span>
              </div>
              </div>
             </form>
           </div>
        </div>
 
      </div> 
      <br><br>
        </div>
        <div class="col-sm-6">
           <div id="displaydata"> 
        </div>
       </div>
      </div>
    </div>
  
 	  <!--	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" -->
		<!--crossorigin="anonymous">-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript">
        function getData(d, divid){
            $.ajax({
                url: 'fetch_data.php?d='+d, 
                success: function(html) {
                    var ajaxDisplay = document.getElementById(divid);
                    ajaxDisplay.innerHTML = html;
                }
            });
        }
    </script>
  </body>
</html>
    
    