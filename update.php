<?php 
   session_start();
   require_once './config/config.php';
   require_once './config/connection.php';
   require_once './access.php';

    $rand=$_GET['rand'];
    $res=mysqli_query($con,"select * from contactnew where rand='$rand'");
	$row=mysqli_fetch_assoc($res);
    $checked=$row['ka'];
    $chaked2=$row['k'];
    
     $sss=$row['s'];
     $ttt=$row['t'];
     $depo=$row['ii'];

if (isset($_POST['save']))
{
    $a=$_POST['a'];
    $b=$_POST['b'];
    $c=$_POST['c'];
    $d=$_POST['d'];
    $e=$_POST['e'];
    $f=$_POST['f'];
    $i=$_POST['i'];
    $j=$_POST['j'];
    $k=$_POST['k'];
    $l=$_POST['l'];
    $m=$_POST['m'];
    $n=$_POST['n'];
    $o=$_POST['o'];
    $p=$_POST['p'];
    $q=$_POST['q'];
    // $r=$_POST['r'];
    $s=$_POST['s'];
    $t=$_POST['t'];
    $u=$_POST['u'];
    $v=$_POST['v'];
    $w=$_POST['w'];
    $x=$_POST['x'];
    $y=$_POST['y'];
    $z=$_POST['z'];
    $aa=$_POST['aa'];
    $bb=$_POST['bb'];
    $cc=$_POST['cc'];
    $dd=$_POST['dd'];
    $ee=$_POST['ee'];
    $ff=$_POST['ff'];
	$gg=$_POST['gg'];
	$hh=$_POST['hh'];
    $ii=$_POST['ii'];
    $jj=$_POST['jj'];
    $kk=$_POST['kk'];
    $ll=$_POST['ll'];
    $mm=$_POST['mm'];
    $nn=$_POST['nn'];
    $oo=$_POST['oo'];
    $pp=$_POST['pp'];
    $ka=$_POST['ka'];
    $initial=$_POST['initial'];
    $services = $_POST['services'];
    
        $sql="update  contactnew set a='$a',
        b='$b',
        c='$c',
        d='$d',
        e='$e',
        f='$f',
        i='$i',
        j='$j',
        k='$k',
        l='$l',
        m='$m',
        n='$n',
        o='$o',
        p='$p',
        q='$q',
        
        s='$s',
        t='$t',
        u='$u',
        v='$v',
        w='$w',
        x='$x',
        y='$y',
        z='$z',
        aa='$aa',
        bb='$bb',
        cc='$cc',
        dd='$dd',
        ee='$ee',
        ff='$ff',
        gg='$gg',
        hh='$hh',
        ii='$ii',
        jj='$jj',
        kk='$kk',
        ll='$ll',
        mm='$mm',
        nn='$nn',
        oo='$oo',
        pp='$pp',
        ka='$ka',
        initial='$initial',
        services='$services'
        where rand='$rand'";
        $result=mysqli_query($con,$sql);
        
        if(mysqli_affected_rows($con)==1)
        
        {
        echo "<script>alert(Success!);</script>";
        echo "<script>window.location.href='Contract'</script>";
        }
        else{
        echo "<script>alert('sorry! unable to insert..');</script>";
        }
        }
        ?>

<head>
<body>
    <title>Se7entech Corps | Contract</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="editor/summernote-bs4.min.css">
   </head>
   <div class="container">
      <a class="btn btn-primary" href="<?php echo $base_url;?>/Contract"><i class="fa fa-arrow-left" aria-hidden="true"></i> Go back</a>
      <form class="well form-horizontal" enctype="multipart/form-data"  method="post"  id="contact_form">
         <fieldset>
            <!-- Form Name -->
            <legend>
               <center>
                   <img style="height:50px;width:150px" src="https://se7entech.net/images/logo.png">
                  <h1 style="color:#000080;"><b>Sales Contract<br>
                     <U>SE7ENTECH CORPORATION</u></b>
                  </h1>
                  <BR>
                  <P>460 Irving park rd Suite C123, Bensenville, IL 60106<br>
                     (773)-666-2021
                  </P>
               </center>
               <div id="google_translate_element"></div>
            </legend>
            <br>
            <script type="text/javascript">
               function googleTranslateElementInit() {
                 new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
               }
            </script>
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            <div class="col-sm-6">
               I <input type="text" placeholder="Se7entech RP" name="a" value="<?php echo $row['a'];?>" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;"    class="no-outline" >
            </div>
            
            <div class="col-sm-6">
            the Representative of SE7ENTECH CORPORATION hereby enter into a Sales Agreement with <input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" type="text" name="b" value="<?php echo $row['b'];?>" class="no-outline" placeholder="Company Representative Name">
            </div>
            <div class="col-sm-6">
            who is the owner/Representative of <input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" type="text" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" name="c" value="<?php echo $row['c'];?>" class="no-outline" placeholder="Company Name">
            </div>
            <div class="col-sm-6">
            for a term of business to be enacted on this <input type="date" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" name="d" class="no-outline" placeholder="" value="<?php echo $row['d'];?>">
            </div>
            <div class="col-sm-6">
            And shall automatically end on <input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" type="date"  name="e" class="no-outline" placeholder="" value="<?php echo $row['e'];?>"> 
            </div>
            <div class="col-sm-6">
            unless further contractual terms are added within this Sales Agreement. This Sales Agreement shall include the following services offered to <input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" type="text" name="f" value="<?php echo $row['f'];?>" class="no-outline" placeholder="">
            </div>
             
            at the rates so listed there in beside each service offered: 
             <br> <br> 
             
             <label>Services</label>
             <textarea id="summernote" name="services"> <?php echo $row['services'];?></textarea>
             <br>
            <div id="wrap">
               
               <?php
                    $sql="select * from contractitem where rand='$rand'";
                    $result11=mysqli_query($con,$sql);
                    
                    if(mysqli_num_rows($result11))
                    {
                    
                    $i=1;
                    while($rows11=mysqli_fetch_assoc($result11))
                    {
                          $total +=$rows11['h'];
                     ?>
                    <input type="hidden" name="id" value="<?php echo $rows11['id'];?>">
               <div class="col-md-3 col-sm-3 col-xs-3 my_box">
                  <label>Name</label><b style="color:red;">*</b>
                  <input  type="text" name="g" value="<?php echo $rows11['g'];?>" placeholder="Service/Product Name"   id="g" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" onblur="checkValue(this)"  />
               </div>
               <div class="col-md-3 col-sm-3 col-xs-3 my_box">
                  <label>Price</label><b style="color:red;">*</b>
                  <input  type="number" name="h" value="<?php echo $rows11['h'];?>" placeholder="Service/Product Price"  id="h" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" onblur="checkValue(this)"  />
               </div>
               
               <div class="col-md-3 col-sm-3 col-xs-3 my_box">
                  <label>Description</label><b style="color:red;">*</b>
                  <input  type="text" name="des" value="<?php echo $rows11['des'];?>" placeholder="Description"  id="des" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" onblur="checkValue(this)"  />
               </div>
               <div class="col-md-3 col-sm-3 col-xs-3 my_box">
                  <label>.</label>
                  <a href="Service_Update.php?id=<?php echo $rows11['id'];?>">Update</a>
               </div>
              
               <?php $i++;}}?>
                
            </div>
            <br>
            
            
            <!--<div class="modal-footer">-->
            <!--   <div class="button_box">-->
            <!--      <br><br><input style="background-color:blue;color:white;" class="form-control"  type="button" name="add_btn" value="Add More" onclick="add_more()">-->
            <!--   </div>-->
            <!--</div>-->
            
            
            <div class="col-sm-12">
               <br><br> *Our Company Shall provide <input name="i" value="<?php echo $row['i'];?>" type="text" class="form-control" placeholder="Maintenance Period"> 
 FREE support after the project gets LIVE. We shall take care of any bugs or issues caused during that period.
<br>* PAID Maintenance will start after this period.
            </div>
            
            <div class="col-sm-12">
            <br><br> <p>   <b>SE7ENTECH CORPORATION</b> agree to provide above listed services and sales to the Owner/Representative  of <input type="text"  name="j" value="<?php echo $row['j'];?>" class="form-control" placeholder="Client's Company Name">  
 on a per needed basis and shall remain at their service until they require.</p>
            </div>
             
             <div class="col-sm-12">
             <br><br> <p style="text-align:left"> <b>Easy payment option</b>: Se7entech Corp offers our customer two option to pay via electronic fund transfer. please complete the following information</p>
            </div>
             
             
             
             <?php 
             $kkk=$row['k'];
             $ppp=$row['pp'];
             $lll= $row['l'];
             $mmm= $row['m'];
             $nnn= $row['n'];
             $ooo= $row['o'];
             $ppp= $row['pp'];
             $rr=$row['r'];
             $ini=$row['initial'];
             $qqq=$row['q'];
             $idd=$row['id'];
             if($chaked2=='checked')
             {
                 echo '<div class="col-sm-12" style="border-style: solid;border-radius:3px;border-width:1px">
              <br> <p style="text-align:left"><input name="k"  type="checkbox" '.$kkk.' value="checked"> I hereby authrize Se7entech Corp to electronically withdraw my minimum payment on the day <input   name="pp" value="'.$ppp.'" type="number" min="1" max="31"  placeholder="1-31" width="20%">
               of each month from my credit.</p>
               
             <div class="">
              <div class="col-sm-3"> <br><label>Name On Card:</label>
               <input id="a" name="l" value="'.$lll.'" type="text" class="form-control" placeholder="John Done">
               </div>
               
               <div class="col-sm-3"> <br><label>Card Number:</label>
               <input id="b" name="m" value="'.$mmm.'" type="text" maxlength="16"   class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx">
               </div>
               
               <div class="col-sm-3"> <br><label>Exp Date:</label>
               <input id="c" name="n" value="'.$nnn.'" type="text" class="form-control" placeholder="05/25">
               </div>
               
               <div class="col-sm-3"> <br><label>Cvv:</label>
               <input id="d" name="o" value="'.$ooo.'" type="text"   maxlength="3" class="form-control" placeholder="123">
               </div>
               
                <div class="col-sm-3"> <br><label>Zip Code:</label>
               <input id="h" name="p"  value="'.$ppp.'"  placeholder="Zip Code" maxlength="5" type="text"   class="form-control" placeholder="">
               </div>
             </div>
              
              <div class="col-sm-12">
               <p style="text-align:left"> I hereby authrize Se7entech Corp to electronically withdraw my minimum payment on the day <input  name="q" type="number" value="'.$qqq.'" min="1" max="31"     placeholder="1-31">
               of each month from my checking account.</p>
               </div>
               
               <div class="col-sm-12">
                Please attach a copy of a voided check 
               <img style="height:200px;width:100%" src="images/'.$rr.'">
               <a href="sign_update.php?id='.$idd.'" >Update</a>
               </div>
               
                            

            <div class="col-sm-12">
            <br><br><br><p><b>Initial</b></p>
            <input type="text" name="initial" value="'.$ini.'" class="form-control">
            
             (1) <b>CANCELLED</b> this authorization will remain in effect canceled by Se7enetch Corp or untill Se7entech Corp provided my revocation in writing at 460 Irving park rd Suite C123, Bensenville, IL 60106 </p>
             <p> i understand that i may stop any transfer of funds, by notifying the financial instutution,mentioned above,at least three(3) days before my payment date</p>
            </div>
               
             </div>
            ';
             }
             else{}
             ?>
             
            
            
            
            
            <?php
            $chh=$row['s'];
            $rtrt=$row['t'];
            $uuu=$row['u'];
            $vvv=$row['v'];
            $www=$row['w'];
            $xxx=$row['x'];
            $yyy=$row['y'];
            $zzz=$row['z'];
            $aaa=$row['aa'];
            $bbb=$row['bb'];
            $ccc=$row['cc'];
            if($sss=='checked' or $ttt=='checked')
            {
                echo '<div class="col-sm-12" style="border-style: solid;border-radius:3px;border-width:1px">
                 <h4><b>Charge to credit card:</b></h4>
             
                 <input type="checkbox" value="checked" name="s"  '.$sss.'> My down payment
                 <input type="checkbox" value="checked" name="t"  '.$ttt.'> My total balance
               <div class="">
                 
              <div class="col-sm-3"> <br><label>Name On Card:</label>
               <input type="text" name="u"   value="'.$uuu.'" class="form-control" placeholder="John Done">
              </div>
               
               <div class="col-sm-3"> <br><label>Card Number:</label>
               <input type="text" name="v"   value="'.$vvv.'" class="form-control" maxlength="16" placeholder="xxxx-xxxx-xxxx-xxxx" >
               </div>
               
               <div class="col-sm-3"> <br><label>Exp Date:</label>
               <input type="text" name="w"   value="'.$www.'" class="form-control" placeholder="05/25">
               </div>
               
               <div class="col-sm-3"> <br><label>Cvv:</label>
               <input type="text" maxlength="3" name="x"   value="'.$xxx.'" class="form-control"  placeholder="123" maxlength="3">
               </div>
               
               <div class="col-sm-3"> <br><label>Card type:</label>
               <select name="y" class="form-control">
                   <option value="'.$yyy.'">'.$yyy.'</option>
                   <option value="American Card">American Card</option>
                   <option value="Visa">Visa</option>
                   <option value="Discover">Discover</option>
                   <option value="Master Card">Master Card</option>
               </select>
               </div>
               
               <div class="col-sm-3"> <br><label>Zip Code:</label>
               <input name="z" value="'.$zzz.'"  type="text" maxlength="5" placeholder="Zip Code" class="form-control" >
               </div>
               
               <div class="col-sm-3"> <br><label>Initial payment:</label>
               <input name="aa" value="'.$aaa.'" type="text" class="form-control">
               </div>
               
               <div class="col-sm-3"> <br><label>Total Balance:</label>
               <input name="bb" value="'.$bbb.'" type="text" class="form-control">
               </div>
               
               <div class="col-sm-3"> <br><label>Amount to be charge:</label>
               <input name="cc" value="'.$ccc.'" type="number" class="form-control">
               </div>
               
             </div>
             </div>
             ';
            }
            ?>
            <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
             
             <div class="col-sm-12" style="border-style: solid;border-radius:3px;border-width:1px">
             <div class="">
                 
              <!--<div class="col-sm-3"> <br><label>Sales price:</label>-->
              <!-- <input name="dd" type="text" class="form-control">-->
              <!--</div>-->
               
               <div class="col-sm-4"> <br><label>Shipping cost & handling:</label>
               <input name="ee" type="number" value="<?php echo $row['ee'];?>" class="form-control">
               </div>
               
               <div class="col-sm-4"> <br><label>Sale tax:</label>
               <input name="ff" type="number" value="<?php echo $row['ff'];?>" class="form-control">
               </div>
              
               <div class="col-sm-4"> <br><label>Payment date:</label>
               <input name="jj" type="date" value="<?php echo $row['jj'];?>" class="form-control">
               </div>
               <!--<div class="col-sm-3"> <br><label>Total purchase value:</label>-->
               <!--<input name="gg" type="text" class="form-control">-->
               <!--</div>-->
               
                
               <!--<div class="col-sm-3"> <br><label>:</label>-->
               <!--<input name="hh" type="text" class="form-control">-->
               <!--</div>-->
               <!--<p>Deposit delivered today</p>-->
               <!--<div class="col-sm-12">-->
              
               <!--</div>-->
               <div class="col-sm-3">
              <p><u>Deposit delivered today:-</u></p>
              <br><label>Additional Deposit:</label>
               <input name="ii" value="<?php echo $row['ii'];?>" type="number" class="form-control">
               </div>
               
               
               
               <!--<div class="col-sm-3"> <br><label>Balance dues after additional Deposit </label>-->
               <!--<input name="kk" type="text" class="form-control">-->
               <!--</div>-->
             </div>
 
             </div>
            
            <div class="col-sm-12">
                <p>As use Our Corporation products and services remains in effect, the following terms and conditions will apply in all matters concerning this Sales Agreement.</p>
            </div>
            
             <br>
            <br><br><br>
            <div class="col-sm-12">
            <details>
               <summary>
                  <p id="open"><u>Term & Condition<sup>*</sup></u></p>
               </summary>
               <center>
                  <p style="text-align:left">1.Contractual Relationship:</p>
                  <p style="text-align:left">As your sales agent, we agree to provide quality products to you and/or your third party designee who is in receipt of our product.</p>
                  <p style="text-align:left">As our client, you agree to use our services within the term limits of each sale and service we have offered to you and/or your third party designee.</p>
                  <p style="text-align:left">As your sales agent, we agree to make adjustments to our products to maintain competitive rates so that you our client may also benefit from the use of our products and services</p>
                  <p style="text-align:left">As our client, you agree to remand payment upon demand therein without arbitration or dispute.</p>
                  <p style="text-align:left">As your sales agent, we agree to make our products available to you our client at a reasonable time frame as the manufacturer therein provides them to us your sales agent. ("During the current pandemic, some items and/or services may not be available, at such time we the sales agent agree to find comparable substitutes to accommodate those items that you the client have requested to the best of our abilities.</p>
                  <p style="text-align:left">As our client, you agree to communicate your concerns or changes in your order with us the sales agent in a timely manner so as to give us the sales agent a chance to make such changes and accommodations to benefit you the client's needs. We the sales agent would request at least a Two</p>
                  <p style="text-align:left">(2) week notification as to any changes in service or product you the client would need.</p>
                  <p style="text-align:left">The Terms within, constitute a legal agreement between you and SE7ENTECH CORPORATION are bound by the bylaws of the United States and their Constitutional Territories.</p>
                  <p style="text-align:left">By accessing and using the services, you confirm your agreement to be bound by these terms. If you do not agree to these terms, you may not access or use the services offered.</p>
                  <p style="text-align:left">SETENTECH CORPORATION may immediately terminate these terms or any services with respect to you, or generally cease offering or deny any access to the services or any portion thereof at any time for any reason.</p>
                  <p style="text-align:left">As the signing of this Sales Agreement, you and SE7ENTECH CORPORATION agree to be bound to the terms so listed within this Sales Agreement until such time that services longer available and/or this Agreement becomes null and void respectfully.</p>
               </center>
            </details>
            </div>
            </head>
           </html>
        <div class="col-sm-3">
        Company representative Name:<input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" type="text" name="ll" value="<?php echo $row['ll'];?>" class="no-outline" placeholder="">   
        </div>
        <div class="col-sm-3">
        Enter Date:<input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;" type="date" name="mm" class="no-outline" placeholder="" value="<?php echo $row['mm'];?>">
        </div>
        <div class="col-sm-3">
        Client's  Name:<input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;"   type="text" name="nn" class="no-outline" placeholder="" value="<?php echo $row['nn'];?>"> 
        </div>
        <div class="col-sm-3">
        Enter Date:<input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;resize: vertical;"   type="date" name="oo" class="no-outline" placeholder="" value="<?php echo $row['oo'];?>">
        </div>
        
             <div class="col-sm-6">
            <h4>Signature company representative  <span style="color:red">(if signature not available pleade <a href="images/sign.png" download>download</a> and upload)</span></h4>
                    <img src="<?php echo $row['company_sign'];?>" style="height:130px;width:100%">
            <img style="height:30px;width:30px" src="https://static.thenounproject.com/png/225648-200.png"> <a href="https://crm.se7entech.net/sign1?id=<?php echo $rand;?>">update</a>
             </div>
        
        <div class="col-sm-6">
        <h4>Signature Client representative <span style="color:red">(if signature not available pleade <a href="images/sign.png" download>download</a> and upload)</span></h4>
        <img src="<?php echo $row['client_sign'];?>" style="height:130px;width:100%">
        <img style="height:30px;width:30px" src="https://static.thenounproject.com/png/225648-200.png"> <a href="https://crm.se7entech.net/sign2?id=<?php echo $rand;?>">update</a>
        </div>
        
        </fieldset>
        
        <br>
        	 
        <button style="width: 100%" type="submit" name="save" class="btn btn-primary">Update</button>
        </form>
        </div>
        </div><!-- /.container -->
        </body>
           <script>
  $(function () {
    // Summernote
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
<script src="editor/summernote-bs4.min.js"></script>
     <script>
                function add_more(){
                	var box_count=jQuery("#box_count").val();
                	box_count++;
                	jQuery("#box_count").val(box_count);
                	jQuery("#wrap").append('<div class="my_box" id="box_loop_'+box_count+'"><div class="field_box col-md-4 col-sm-4 col-xs-4"><label>Name</label><b style="color:red;"></b><input class="form-control" type="textbox" name="g[]" placeholder="Service/Product Name" id="g"></div><div class="field_box col-md-4 col-sm-4 col-xs-4"><label>Price</label><b style="color:red;"></b><input class="form-control" type="number" name="h[]" placeholder="Service/Product Price" id="h"></div><div class="field_box col-md-4 col-sm-4 col-xs-4"><label>Description</label><b style="color:red;"></b><input class="form-control" type="textbox" name="des[]" placeholder="Description" id="des"></div><div class="button_box"><input   type="button" class="btn btn-danger" name="submit" id="submit" value="Remove" onclick=remove_more("'+box_count+'")></div></div>');
                }
                function remove_more(box_count){
                	jQuery("#box_loop_"+box_count).remove();
                	var box_count=jQuery("#box_count").val();
                	box_count--;
                	jQuery("#box_count").val(box_count);
                }
                </script>