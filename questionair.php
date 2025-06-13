<?php 
   session_start();
   require_once './config/config.php';
   require_once './config/connection.php';
   require_once './access.php';

$id = $_GET['id'];
$sql = "select * from questioner where id='$id'";
$res = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Questionnaire | Se7entech</title>

    <link rel="shortcut icon" href="images/fav.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/logo.png" />  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <style>
      html, body {
      overflow-x: hidden;
      }

      p{
          color:#94dc09;
      }
    </style>
  </head>
<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-2" style="background-color:lavender;"><div id="google_translate_element"></div>
  </div>
  <div class="col-sm-8" style="background:#625c5c;border-radius:3px;padding-top:5px;padding-bottom:5px">
    <center>
    <div style="background: white;
  border-radius: 50%;
  width: 171px;
  height: 170px;
  padding-right: 100px;">
      <img style="height: 100px;
  width: 200px;
  padding: 25px;
  margin-top: 46px;margin-left: -14px;" src="https://se7entech.net/images/logo.png">
    </div>
    <form method="POST" enctype="multipart/form-data">
    <h2 style="color:white;font-size:45px"><b>BRIEF</b></h2>
    
    <h2 style="color:blue;font-size:106px"><b>I know!<b></h2>
    <h2 style="color:white">Maybe you, like me, are bored with surveys, or maybe not.</h2>
    
    <h2 style="color:white;font-size:65px">"IT IS NOT ENOUGH TO GIVE YOU SOMETHING GOOD, NOT EVEN THE BEST.</h2>
       

    <div class="h-divider">
    <div class="shadow"></div>
    <div class="text2"><img style="border-radius: 50%;" class="img"src="https://t1.gstatic.com/images?q=tbn:ANd9GcQsmMfybMIwoE5etmOIAuvnFWdfv_8C1Bq15urJFqwhhI55FyYNP2YuUA" /></div>
    </div>
   

      <h2 style="color:white;font-size:65px">WE WANT TO GIVE YOU WHAT YOU NEED".</h2>
      <h2 style="color:white;border-style:solid;border-color:white;border-width:8px;padding:5px">That is why I require you to take a few minutes to answer these simple questions that you need to provide me with in order to understand you.</h2>
     
     <h2 style="color:white;font-size:40px;padding-top:20px">QUESTIONNAIRE</h2>
     
     <h2 style="color:white;font-size:53px;padding-top:20px"><b>BRAND DATA</b></h2>
     <h2 style="color:white">(In order to understand you better and give you what you need)</h2>
      </center>
      
      <h3 style="color:white">1. What is the brand name?</h3>
      <p><?= $data['a'];?></p>
      <h3 style="color:white">2. What are your services and/or products?</h3>
      <p><?= $data['b'];?></p>
      <h3 style="color:white">3. What are the benefits or advantages of your services or products?</h3>
      <p><?= $data['c'];?></p>
      <h3 style="color:white">4. What values stand out most in your brand?</h3> 
      <p><?= $data['d'];?></p>
      <h3 style="color:white">5. Write down 3 characteristics that distinguish your brand from others.</h3> 
      <p><?= $data['e'];?></p>
      <h3 style="color:white">6. Who is your main competitor? </h3>
      <p><?= $data['f'];?></p>
      <h3 style="color:white">7. Who is your primary consumer?</h3>
      <p><?= $data['g'];?></p>
      <h3 style="color:white">8. How old is your primary consumer?</h3>
      <p><?= $data['h'];?></p>
      
      <center><h2 style="color:white">IN CASE OF LOGOS</h2></center>
      
      <h3 style="color:white">9. Do you have any referential logo you would like to mention?</h3>
      <!--<input type="file" class="form-control" name="i" accept="image/*">-->
      <img src="../images/<?= $empty= $data['i'];?>" style="height:150px;width:150px;<?=  ($empty=='')?'display:none ':'';?>">
      <?=  ($empty=='')?'<p>N/A</p>':'';?>
      <h3 style="color:white">10. Do you have a color preference that you would like to be included in your design?</h3>
      <div class="col-sm-4"><span  style="padding:10px;background-color:<?= $data['j'];?>"></span></div>
      <div class="col-sm-4"><span  style="padding:10px;background-color:<?= $data['k'];?>"></span></div>
      <div class="col-sm-4"><span  style="padding:10px;background-color:<?= $data['l'];?>"></span></div>
       
       <br>
      
      <center><h2 style="color:white;font-size:40px;padding-top:20px">REQUIREMENTS </h2></center>
      <Center><h2 style="color:white">INFORMATION FOR THE ELABORATION OF THE REQUIREMENT</h2></Center>
      
      <h3 style="color:white">1. Type of request</h3> 
      <p><?= $data['m'];?></p>
      <h3 style="color:white">2. Detailed customer information to be mentioned in such request</h3> 
      <p><?= $data['n'];?></p>
      <h3 style="color:white">3. detailed information about the product or service being referred to</h3> 
      <p><?= $data['o'];?></p>
      <h3 style="color:white">4. Estimated processing time taking into account a minimum of 24 hours depending on the type of requirement.</h3> 
      <p><?= $data['p'];?></p>
      <h3 style="color:white">5. Objective of the requirement, what you want to achieve with the creative </h3>
      <p><?= $data['q'];?></p>
      <h3 style="color:white">6. Target Audience</h3> 
      <p><?= $data['r'];?></p>
      <h3 style="color:white">7. Any additional comments</h3> 
      
      <center><h2 style="color:white">IN CASE OF LOGOS</h2></center>
      
      <h3 style="color:white">9. Do you have any referential logo you would like to mention?</h3>
      <img src="../images/<?= $empty= $data['s'];?>" style="height:150px;width:150px;<?=  ($empty=='')?'display:none ':'';?>">
      <?=  ($empty=='')?'<p>N/A</p>':'';?>
      <h3 style="color:white">10. Do you have a color preference that you would like to be included in your design?</h3>
     
      <div class="col-sm-4"><span  style="padding:10px;background-color:<?= $data['t'];?>"></span></div>
      <div class="col-sm-4"><span  style="padding:10px;background-color:<?= $data['u'];?>"></span></div>
      <div class="col-sm-4"><span  style="padding:10px;background-color:<?= $data['v'];?>"></span></div>
       <br>
       
      <center><h2 style="color:white;font-size:40px;padding-top:20px">REQUIREMENTS </h2></center>
      <Center><h2 style="color:white">REQUIREMENT FOR SOCIAL NETWORK MANAGEMENT</h2></Center>
      <ul style="color:white;font-size:25px;padding-top:13px">
          <li>Topics you want to show to the public What</li>
          <p><?= $data['w'];?></p>
          
          <li>is the focus of your business?</li>
          <p><?= $data['x'];?></p>
          
          <li>What is your target audience?</li>
          <p><?= $data['y'];?></p>
          
          <li>Factors you most want to highlight about your business</li>
          <p><?= $data['z'];?></p>
      </ul>
      <br><br>
      <p style="color:white;font-size:18px">It is necessary to keep in mind that the purpose of social networks is to generate reach, attracting the largest possible number of followers, who can create empathy with the brand, recognition, interaction and thus increase the likelihood of sales through this flow of people.</p>
      <p style="color:white;font-size:18px">It should also be noted that the management of social networks is only a segment of marketing, a fundamental part of the work that every company must carry out today if it wants to have market reach, however, this is not the only management that should be done if you expect to achieve sales, since its main objective is not to sell directly, but to achieve growth and visualization among potential customers.</p>
      
      <center><h2 style="color:white;font-size:40px;padding-top:20px">REQUIREMENTS </h2></center>
      <Center><h2 style="color:white">VIDEO EDITING REQUIREMENT </h2></Center>
      
      
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Zoom in with body movements, never zoom in with the zoom functions of the camera, as they affect the quality of the video and in other shots you can zoom in with the editing program Play with the attractiveness of the food, use resources such as olive oil to</p>
      <p><?= $data['aa'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> make fruits like tomatoes and others look more attractive and appetizing. Make the environment as suitable as possible for the elaboration of the shots, eliminating </p>
      <p><?= $data['bb'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> those elements that may hinder or detract from the quality of the scenes. When sending the material, do it through the telegram app, as it preserves the quality of the</p>
      <p><?= $data['cc'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> videos and images and allows direct conversion from MOV format to Android or MP4 format (speeds up the final delivery process). Scenes should be submitted by product in an orderly manner that can be understood when separating and arranging shots</p>
      <p><?= $data['dd'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Avoid making entries of scenes that should not be used or are not suitable for inclusion in the video.</p>
      <p><?= $data['ee'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> previous information, such as: Product name</p>
      <p><?= $data['ff'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Web address and social networks to appear in the video</p>
      <p><?= $data['gg'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Zoom in with body movements, never zoom in with the zoom functions of the camera, as they affect the quality of the video and in other shots you can zoom in with the editing program Play with the attractiveness of the</p>
      <p><?= $data['hh'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> food, use resources such as olive oil to make the fruits like tomatoes and others, to make them more attractive, use the camera's</p>
      <p><?= $data['ii'];?></p>
      <p style="color:white;font-size:18px"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> zoom functions, as they affect the quality of the video and in other shots you can zoom in with the editing program. Send each product to be elaborated with previous information, such as:</p>
      <p><?= $data['jj'];?></p><br><br>
      
      
      <h4 style="color:white">- Product name</h4> 
      <p><?= $data['kk'];?></p>
      <h4 style="color:white">- Web address and social networks to appear in the video</h4> 
      <p><?= $data['ll'];?></p>
      <h4 style="color:white">- Direction of trade</h4> 
      <p><?= $data['mm'];?></p>
      <h4 style="color:white">- Telephone and contact information </h4>
      <p><?= $data['nn'];?></p>
      <h4 style="color:white">- Local or business logo</h4> 
      <p><?= $data['oo'];?></p>
      <h4 style="color:white">- Type of music in case you want to add sound </h4>
      <p><?= $data['pp'];?></p>
      <h4 style="color:white">- other data that the customer wants to appear in the video</h4>
      <p><?= $data['qq'];?></p>
      <p style="color:white;font-size:18px">It is necessary to comply with all these procedures in an organized manner, as this allows us to offer an early delivery, with no setbacks or complications.</p>
    
    <center><h2 style="color:white;font-size:60px;padding-top:20px"><b>TERMS</b></h2></center>
    <center><h2 style="color:white;">LET'S TALK ABOUT MARKETING SERVICES</h2></center>
    <center><h4 style="color:white;">(In case you have had previous experience with marketing and design) </h4></center>
    
    <br><br>
    
    <p style="color:white;font-size:17px">1. What did you like about the service? </p>
    <p><?= $data['rr'];?></p>
    <p style="color:white;font-size:17px">2. What did you dislike about the service? </p>
    <p><?= $data['ss'];?></p>
    <p style="color:white;font-size:17px">3. What do you expect from us?</p>
    <p><?= $data['tt'];?></p>
    
    <center><h2 style="color:white;">TERMS AND CONDITIONS</h2></center>
    <center><h4 style="color:white;">(We also expect your support and understanding).</h4></center>
    
    <br><br>
    <h4 style="color:white;">• Once the above form has been completed, it is important to take into account the following:</h4> 
    <h4 style="color:white;">• Once the first request has been made, you have at your disposal</h4>
    
    <br>
    <!--<center><button class="btn btn-primary" name="save" type="submit">Submit</button></center>-->
    <br>
    </form>
    </div>
    
     <div class="col-sm-2" style="background-color:lavender;"></div>
  </div>
</div>

  <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en' , includedLanguages : 'es,en'}, 'google_translate_element');
      }
  </script>

  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
