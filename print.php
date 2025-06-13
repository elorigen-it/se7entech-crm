<?php 
   session_start();
   require_once './envloader.php';
   require_once './config/config.php';
   require_once './config/connection.php';
//   require_once './access.php';
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se7entech</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/fav.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/fav.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/fav.png"> 
    <?php
        $id=$_GET['id'];
        $res=mysqli_query($con,"select * from contract where id='$id'");
        $row=mysqli_fetch_assoc($res);
    ?>
    <style>
    body
    {
        font-family: "Times New Roman", Times, serif;
    }
        @media print
    {    
        .printtt, .printtt *
        {
            display: none !important;
        }
    }
    </style>
    <style>
    /*body{*/
    /*    -webkit-print-color-adjust: exact;*/

    /*}*/
    #customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    #customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
    color:black;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #0daea8;
    color: white;
    }
        /*general styling*/

    @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,700;1,400;1,700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');

    * {
        box-sizing: border-box;
    }

    body {
        padding: 0;
        margin: 0;
        background-color: #cccccc;
        font-family: sans-serif;
    }

    section#main-container {
        background: #eeeeee;
        min-height: 110vh;
        width: 768px;
        margin: 120px auto;
        padding: 30px;
        line-height: 1.68em;
    }

    section#main-container #big-logo {
    width: 200px;
    }

    section#main-container h3 {
    margin-top: 60px;
    }




    /*header styling*/
    header#site-header {
        width: 100%;
        background: #f4f4f4;
        padding: 15px 30px;
        transition: all 0.2s ease;
        height: 70px;
        box-shadow: 0 2px 10px #dddddd;
        position: fixed;
        top: 0;
        left: 0;
    }

    header#site-header a {
        color: #666666;
    }

    header#site-header a:hover {
        color: #0097ad !important;
        transition: all 0.2s ease;
    }

    header#site-header button:active {
        position: relative;
        top: 1px;
    }

    header#site-header div#site-header-auth-container button {
        outline: 0;
        background: transparent;
        height: 30px;
        padding: 0 5px;
        border: 0;
        font-family: "Open Sans", sans-serif;
        font-size: 11pt;
        cursor: pointer;
        color: #666666;
    }

    header#site-header div#site-header-container {
        display: flex;
        align-items: center;
        height: 40px;
    }

    header#site-header div#site-header-logo {
        width: auto;
        padding: 0;
        margin-right: 30px;
        height: 30px;
    }

    header#site-header div#site-header-logo img {
        height: 30px;
    }

    header#site-header #site-header-search {
        width: auto;
        padding: 0;
        justify-content: flex-end;
        margin-left: auto;
        margin-right: 5px;
    }

    header#site-header ul#main-menu {
        padding: 0;
    }

    header#site-header ul#main-menu li {
        list-style: none;
        display: inline;
        margin-right: 10px;
        font-weight: bold;
        font-size: 11pt;
    }

    header#site-header ul#main-menu li:last-of-type {
        margin-right: 0;
    }

    header#site-header ul#main-menu li a {
        text-decoration: none;
    }

    header#site-header .social-buttons {
        margin-top: 10px;
        text-align: center;
        font-size: 14pt;
    }

    header#site-header .social-buttons i {
        margin-right: 10px;
    }

    header#site-header .social-buttons i:last-child {
        margin-right: 0;
    }

    header#site-header #site-header-search {
        flex-grow: 4;
    }

    header#site-header #site-header-search-container {
        position: relative;
        height: 30px;
        width: 100%;
        padding: 0;
    }

    header#site-header #site-header-search-container input[type="text"] {
        height: 28px;
        font-size: 12pt;
        font-family: "Open Sans", sans-serif;
        border: none;
        outline: none;
        color: #666666;
        padding-right: 60px;
        width: 0;
        position: absolute;
        top: 0;
        right: 0;
        background: none;
        z-index: 3;
        transition: width .4s cubic-bezier(0.000, 0.795, 0.000, 1.000);
        cursor: pointer;
    }

    header#site-header #site-header-search-container input[type="text"]:focus:hover {
        border-bottom: 1px solid #0097ad;
    }

    header#site-header #site-header-search-container input[type="text"]:focus {
        width: calc(100% - 50px);
        z-index: 1;
        border-bottom: 1px solid #999999;
        cursor: text;
        margin-right: 40px;
    }

    header#site-header #site-header-search-container button#search_submit {
        height: 30px;
        width: 30px;
        border: none;
        color: #999999;
        background: transparent;
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        cursor: pointer;
        transition: opacity 0.3s ease;
        padding: 0;
        font-size: 11pt;
    }

    header#site-header div#site-header-auth-container {
        justify-content: flex-end;
        text-align: right;
        flex-shrink: 0;
    }

    header#site-header div#site-header-auth-container .site-header-auth-button:hover {
        border-color: #0097ad;
        color: #0097ad;
        transition: all 0.3s ease;
    }

    header#site-header div#site-header-auth-container .site-header-auth-button i:after {
        content: "";
        margin-right: 0.32em;
    }

    /*instead of font icons, to show it on Codepen.
    Many thanks to icon8.com */
    header#site-header img.icon-header {
    position: relative; 
    top: 3px;
    }

    /*mobile menu styling*/

    #side-menu-container {
        padding-right: 20px;
        transition: all 0.3s ease-in-out;
    }

    header #side-menu-container #before-side-menu,
    header #side-menu-container #after-side-menu {
        display: none;
    }

    input[type=checkbox]#toggleSideMenu {
        box-sizing: border-box;
        display: none;
    }






    /*media queries*/

    @media screen and (min-width: 1201px) and (max-width: 1500px) {
        /*header#site-header #site-header-search-container input[type="text"]:focus {
            width: 250px;
        }*/
    }

    @media screen and (max-width: 1200px) {

        /*general styling*/
        .main-container {
            width: 90%;
            overflow: hidden;
            padding: 40px;
        }

        /*to fit the size of the hamburger button*/
        header#site-header {
            height: 60px;
        }

        header#site-header div#site-header-container {
            height: 30px;
        }

        header#site-header div#site-header-logo {
            margin-right: 10px;
            margin-left: 35px;
        }

        /*styling the container for the menu*/
        #side-menu-container {
            position: fixed;
            left: -250px;
            top: 0;
            margin-top: 60px;
            padding: 15px;
            width: 250px;
            height: 100%;
            background: #f7f7f7;
            box-shadow: inset -1px 0 5px #eeeeee;
        }

        header #side-menu-container #before-side-menu,
        header #side-menu-container #after-side-menu {
            display: block;
            background: #aaaaaa;
            color: #fafafa;
            padding: 10px;
        }

        header #side-menu-container #before-side-menu span,
        header #side-menu-container #after-side-menu span {
            font-size: 10pt;
            font-style: italic;
        }

        /*styling the menu inside the <nav> block*/
        #top-menu {
            transition: top 0.5s ease;
            width: 100%;
            margin: 0;
        }

        header#site-header ul#main-menu li {
            display: block;
            width: 100%;
            padding: 15px 20px;
            font-size: 13pt;
            border-bottom: 1px solid #dddddd;
        }

        header#site-header ul#main-menu li:last-of-type {
            border-bottom: none;
        }

        header#site-header ul#main-menu li a {
            margin: 0;
            padding: 0;
        }

        input[type=checkbox]#toggleSideMenu {
            box-sizing: border-box;
            display: none;
        }

        input[type="checkbox"]#toggleSideMenu:checked ~ #side-menu-container {
            transform: translateX(250px);
        }

        /*hamburger icon styling*/
        .hamburger-icon {
            box-sizing: border-box;
            cursor: pointer;
            position: absolute;
            z-index: 99;
            top: 22px;
            left: 22px;
            height: 22px;
            width: 22px;
        }

        .hamburger-menu-line {
            transition: all 0.3s;
            box-sizing: border-box;
            position: absolute;
            height: 3px;
            width: 100%;
            background-color: #666;
        }

        .horizontal {
            box-sizing: border-box;
            position: relative;
            float: left;
            margin-top: 3px;
        }

        .diagonal-1 {
            position: relative;
            box-sizing: border-box;
            float: left;
        }

        .diagonal-2 {
            box-sizing: border-box;
            position: relative;
            float: left;
            margin-top: 3px;
        }

        input[type=checkbox]#toggleSideMenu:checked ~ .hamburger-icon > .horizontal {
            box-sizing: border-box;
            opacity: 0;
        }

        input[type=checkbox]#toggleSideMenu:checked ~ .hamburger-icon > .diagonal-1 {
            box-sizing: border-box;
            transform: rotate(135deg);
            margin-top: 8px;
        }

        input[type=checkbox]#toggleSideMenu:checked ~ .hamburger-icon > .diagonal-2 {
            box-sizing: border-box;
            transform: rotate(-135deg);
            margin-top: -9px;
        }

        header#site-header #site-header-search {
            width: 100%;
        }

    }

    @media screen and (max-width: 768px) {
        header#site-header div#site-header-auth-container .site-header-auth-button span {
            display: none;
        }

        header#site-header div#site-header-auth-container .site-header-auth-button i::after {
            margin-right: 0;
        }

    }
    </style>
</head>
<body>
<section id="main-container" style="margin-top:-33px">
  <img  style="height:90px;width:200px" src ="https://se7entech.net/images/logo.png">
  <p style="text-align:right;margin-top:-85px">Contract Id: #<?php echo $row['id'];?></p>
    <p>
    <center> <h2>Sales Contract</h2></center>
    <center><h3 style="margin-top:-20px"> <u>SE7ENTECH</u></h3></center>
    </p>
    <div id="google_translate_element" class="printtt"></div>
    <br>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            
 <p style="margin-top:-28px;font-size:13px;line-height:20px">I <u><?php echo $row['agent_name_1'];?></u> the Representative of SE7ENTECH hereby enter into a Sales Agreement with <u><?php echo $row['customer_name_1'];?></u> who is the owner/Representative of <u><?php echo $row['company_name_1'];?></u> for a term of business to be enacted on this <u><?php echo date('F d, Y', strtotime($row['contract_date_start']));?></u> And shall automatically end on <u><?php echo date('F d, Y', strtotime($row['contract_date_end']));?></u> unless further contractual terms are added within this Sales Agreement. This Sales Agreement shall include the following services offered to <?php echo $row['customer_name_2'];?></p>
 <p style="margin-top:-18px;font-size:13px;line-height:20px">at the rates so listed there in beside each service offered:</p>
  
  <div style="word-break: break-word;">
      <?= $row['services'];?>
  </div>
  <p style="margin-top:-2px;font-size:13px">*Our Company Shall provide <u><?php echo $row['maintenance_period'];?></u> FREE support after the project gets LIVE. We shall take care of any bugs or issues caused during that period.</p>
  <p style="margin-top:-13px;font-size:13px">* PAID Maintenance will start after this period.</p>
  <p style="margin-top:-13px;font-size:13px">SE7ENTECH agree to provide above listed services and sales to the Owner/Representative of <u><?php echo $row['company_name_2'];?></u> on a per needed basis and shall remain at their service until they require.</p>
  <!--<p>Easy payment option: Se7entech Corp offers our customer two option to pay via electronic fund transfer. please complete the following information</p>-->
  
    
 <br> <table id="customers" style="margin-top:-30px">
      <tr>
          <th style="color:black;font-size:13px">Sales price</th>
          <th style="color:black;font-size:13px">Shipping cost & handling</th>
          <th style="color:black;font-size:13px">Sale tax</th>
          <th style="color:black;font-size:13px">Total purchase value</th>
          <!--<th style="color:black">Deposit delivered today</th>-->
          <th style="color:black;font-size:13px">Additional Deposit</th>
          <th style="color:black;font-size:13px">Payment date</th>
          <th style="color:black;font-size:13px">Balance dues after additional Deposit</th>
      </tr>
      
      <tr>
          <td style="font-size:13px"><?php echo $total = $row['total_purchase'];?></td>
          <td style="font-size:13px"><?php echo $shipping= $row['shipping_handling'];?></td>
          <td style="font-size:13px"><?php echo $tax= $row['sale_tax'];?></td>
          <td style="font-size:13px"><?php echo $due= $shipping+$tax+$total;?></td>
          <td style="font-size:13px"><?php echo $depo= $row['additional_deposit'];?></td>
          <td style="font-size:13px"><?php echo $row['payment_date'];?></td>
          <td style="font-size:13px"><?php    $string= $due-$depo; echo (abs($string))?></td>
      </tr>
  </table>
  
  <p style="font-size:13px">As use Our products and services remains in effect, the following terms and conditions will apply in all matters concerning this Sales Agreement.</p>
  <p style="font-size:13px"><u>Term & Condition* (https://se7entech.net/term)</u></p>

<table id="customers">

<tr>
    <th style="color:black;font-size:13px">Company representative Name</th>
    <th style="color:black;font-size:13px">Enter Date</th>
    <th style="color:black;font-size:13px">Client representative Name</th>
    <th style="color:black;font-size:13px">Enter Date</th>
</tr>

<tr>
    <td style="font-size:13px"><?php echo $row['agent_name_2'];?></td>
    <td style="font-size:13px"><?php echo date('F d, Y', strtotime($row['contract_sign_date_agent']));?></td>
    <td style="font-size:13px"><?php echo $row['customer_name_3'];?></td>
    <td style="font-size:13px"><?php echo date('F d, Y', strtotime($row['contract_sign_date_customer']));?></td>
</tr> 

</table>

<br><table id="customers">
    <tr>
       <th style="color:black;font-size:13px">Company Signature</th> 
       <th style="color:black;font-size:13px">Client Signature</th>
        
    </tr>
    
    <tr>
       <td> 
        <br><img src="<?php echo $row['agent_sign'];?>" style="height:50px;width:300px">
        </td>
        
        <td> 
        <br><img src="<?php echo $row['customer_sign'];?>" style="height:50px;width:300px">
        </td>
       </tr>
</table>
 
</section>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        window.print();
    }, false)

</script>
</body>



