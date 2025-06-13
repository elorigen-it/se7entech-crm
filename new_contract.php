<?php 
   session_start();
   require_once './config/config.php';
   require_once './config/connection.php';
   require_once './access.php';
   
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
    $r=$_POST['r'];
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
    
    $rand=(rand(11111111,9999999));
    $r = $rand.$_FILES['r']['name'];
    $company_sign = '1';
    $client_sign = '2';
    $ka=$_POST['ka'];
    $initial=$_POST['initial'];
    $services = $_POST['services'];
        
        
        $sql="insert into  contactnew (a,b,c,d,e,f,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,aa,bb,cc,dd,ee,ff,gg,hh,ii,jj,kk,ll,mm,nn,oo,pp,rand,company_sign,client_sign,ka,initial,logid,services) value ('$a','$b','$c','$d','$e','$f','$i','$j','$k','$l','$m','$n','$o','$p','$q','$r','$s','$t','$u','$v','$w','$x','$y','$z','$aa','$bb','$cc','$dd','$ee','$ff','$gg','$hh','$ii','$jj','$kk','$ll','$mm','$nn','$oo','$pp','$rand','$company_sign','$client_sign','$ka','$initial','$logid','$services')";
        $result=mysqli_query($con,$sql);
 
        // $g=$_POST['g'];
        // $h=$_POST['h'];
        // $des=$_POST['des'];
        // foreach($g as $index =>$names)
        //   {
        //   $gg=$names;
        //   $hhh=$h[$index];
        //   $dess=$des[$index];
 
        //     $sqll="insert into contractitem (g,h,rand,des) value ('$gg','$hhh','$rand','$dess')";
        //     $resulte=mysqli_query($con,$sqll);
        //     }
        
        if(empty($r))
        {
          echo ".'<script>window.location.href='sign1.php?id=$rand';</script>.'";
        }
        
        else
        {
            if(move_uploaded_file( $_FILES['r']['tmp_name'], 'images/'.$r));
            echo ".'<script>window.location.href='sign1.php?id=$rand';</script>.'";
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
               I <input type="text" placeholder="Se7entech RP" name="a" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;"    class="no-outline" >
            </div>
            
            <div class="col-sm-6">
            the Representative of SE7ENTECH CORPORATION hereby enter into a Sales Agreement with <input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" type="text" name="b" class="no-outline" placeholder="Company Representative Name">
            </div>
            <div class="col-sm-6">
            who is the owner/Representative of <input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" type="text" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" name="c" class="no-outline" placeholder="Company Name">
            </div>
            <div class="col-sm-6">
            for a term of business to be enacted on this <input type="date" required style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" name="d" class="no-outline" placeholder="">
            </div>
            <div class="col-sm-6">
            And shall automatically end on <input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" type="date" required  name="e" class="no-outline" placeholder=""> 
            </div>
            <div class="col-sm-6">
            unless further contractual terms are added within this Sales Agreement. This Sales Agreement shall include the following services offered to <input style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" type="text" name="f" class="no-outline" placeholder="">
            </div>
             
            at the rates so listed there in beside each service offered: 
            <br><br><br> 
 
            <div id="wrap">
               <div class="col-md-12 col-sm-12 col-xs-12 my_box">
                  <textarea id="summernote" name="services"></textarea>
                  
                  <!--<label>Name</label><b style="color:red;">*</b>-->
                  <!--<input  required type="text" name="g[]" placeholder="Service/Product Name"   id="g" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" onblur="checkValue(this)"  />-->
               </div>
               <!--<div class="col-md-4 col-sm-4 col-xs-4 my_box">-->
               <!--   <label>Price</label><b style="color:red;">*</b>-->
               <!--   <input required  type="number" name="h[]" placeholder="Service/Product Price"  id="h" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" onblur="checkValue(this)"  />-->
               <!--</div>-->
               
               <!--<div class="col-md-4 col-sm-4 col-xs-4 my_box">-->
               <!--   <label>Description</label><b style="color:red;">*</b>-->
               <!--   <input  type="text" name="des[]" placeholder="Description"  id="des" style="width: 100%;height:32px;padding:3px;border: 1px solid #dddd;border-radius: 4px;box-sizing: border-box;margin-top: 3px;margin-bottom:3px;" onblur="checkValue(this)"  />-->
               <!--</div>-->
            </div>
            
            <!--<div class="modal-footer">-->
            <!--   <div class="button_box">-->
            <!--      <br><br><input style="background-color:blue;color:white;"  type="button" name="add_btn" value="Add More" onclick="add_more()">-->
            <!--   </div>-->
            <!--</div>-->
            <br><br>
            <div class="col-sm-12">
                *Our company shall provide <input name="i" type="text" class="form-control" placeholder="Maintenance Period"> 
 support at no additional cost after project gets online.
 <br> We shall take care of any bugs or issues caused during that period.
            </div>
            
            <div class="col-sm-12">
            <br><br> <p>   <b>SE7ENTECH CORPORATION</b> agree to provide above listed services and sales to the Owner/Representative  of <input type="text"  name="j" class="form-control" placeholder="Client's Company Name">  
 on a per needed basis and shall remain at their service until they require.</p>
            </div>
             
             <div class="col-sm-12">
             <br><br> <p style="text-align:left"> <b>Easy payment option</b>: Se7entech Corp offers our customer two option to pay via electronic fund transfer. please complete the following information</p>
            </div>
             
            <div class="col-sm-12" style="border-style: solid;border-radius:3px;border-width:1px">
              <br> <p style="text-align:left"><input name="k" type="checkbox" value="checked"> I hereby authrize Se7entech Corp to electronically withdraw my minimum payment on the day <input   name="pp" type="number" min="1" max="31"  placeholder="1-31" width="20%">
               of each month from my credit.</p>
               
             <div class="">
              <div class="col-sm-3"> <br><label>Name On Card:</label>
               <input id="a" name="l" type="text" class="form-control" placeholder="John Done">
               </div>
               
               <div class="col-sm-3"> <br><label>Card Number:</label>
               <input id="b" name="m" type="text" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx">
               </div>
               
               <div class="col-sm-3"> <br><label>Exp Date:</label>
               <input id="c" name="n" type="text" class="form-control" placeholder="05/25">
               </div>
               
               <div class="col-sm-3"> <br><label>Cvv:</label>
               <input id="d" name="o" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="3" class="form-control" placeholder="123">
               </div>
               
                <div class="col-sm-3"> <br><label>Zip Code:</label>
               <input id="h" name="p"   placeholder="Zip Code" maxlength="5" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="">
               </div>
             </div>
              
              <div class="col-sm-12">
               <p style="text-align:left"> I hereby authrize Se7entech Corp to electronically withdraw my minimum payment on the day <input  name="q" type="number" min="1" max="31"     placeholder="1-31">
               of each month from my checking account.</p>
               </div>
               
               <div class="col-sm-12">
                Please attach a copy of a voided check <input name="r"   type="file" >
               </div>
               <script src="jquery-1.4.1.min.js"></script>
			 // <script>
    //             function add_more(){
    //             	var box_count=jQuery("#box_count").val();
    //             	box_count++;
    //             	jQuery("#box_count").val(box_count);
    //             	jQuery("#wrap").append('<div class="my_box" id="box_loop_'+box_count+'"><div class="col-sm-4"><label>Name</label><b style="color:red;"></b><input class="form-control" type="textbox" g="item[]" id="g"></div><div class="col-sm-4"><label>Price</label><b style="color:red;"></b><input class="form-control" type="textbox" name="h[]" id="h"></div><div class="col-sm-4"><label>Description</label><b style="color:red;"></b><input class="form-control" type="textbox" name="des[]" id="des"></div><div class="button_box"><input   type="button" class="btn btn-danger" name="submit" id="submit" value="Remove" onclick=remove_more("'+box_count+'")></div></div>');
    //             }
    //             function remove_more(box_count){
    //             	jQuery("#box_loop_"+box_count).remove();
    //             	var box_count=jQuery("#box_count").val();
    //             	box_count--;
    //             	jQuery("#box_count").val(box_count);
    //             }
    //             </script>

                            

            <div class="col-sm-12">
            <br><br><br><p><b>Initial</b></p>
            <input type="text" name="initial" class="form-control">
            
             (1) <b>CANCELLED</b> this authorization will remain in effect canceled by Se7enetch Corp or untill Se7entech Corp provided my revocation in writing at 460 Irving park rd Suite C123, Bensenville, IL 60106 </p>
             <p> i understand that i may stop any transfer of funds, by notifying the financial instutution,mentioned above,at least three(3) days before my payment date</p>
            </div>
               
             </div>
            
            
            
            
            <!--<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>-->
             <div class="col-sm-12" style="border-style: solid;border-radius:3px;border-width:1px">
                 <h4><b>Charge to credit card:</b></h4>
             
                 <input type="checkbox" name="s"  value="checked"> My down payment
                 <input type="checkbox" name="t"  value="checked"> My total balance
               <div class="">
                 
              <div class="col-sm-3"> <br><label>Name On Card:</label>
               <input type="text" name="u" class="form-control" placeholder="John Done">
              </div>
               
               <div class="col-sm-3"> <br><label>Card Number:</label>
               <input type="text" name="v" class="form-control" maxlength="16" placeholder="xxxx-xxxx-xxxx-xxxx" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
               </div>
               
               <div class="col-sm-3"> <br><label>Exp Date:</label>
               <input type="text" name="w" class="form-control" placeholder="05/25">
               </div>
               
               <div class="col-sm-3"> <br><label>Cvv:</label>
               <input type="text" maxlength="3" name="x" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="123" maxlength="3">
               </div>
               
               <div class="col-sm-3"> <br><label>Card type:</label>
               <select name="y" class="form-control">
                   <option>---Select---</option>
                   <option value="American Card">American Card</option>
                   <option value="Visa">Visa</option>
                   <option value="Discover">Discover</option>
                   <option value="Master Card">Master Card</option>
               </select>
               </div>
               
               <div class="col-sm-3"> <br><label>Zip Code:</label>
               <input name="z" type="text" maxlength="5" placeholder="Zip Code" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
               </div>
               
               <div class="col-sm-3"> <br><label>Initial payment:</label>
               <input name="aa" type="text" class="form-control">
               </div>
               
               <div class="col-sm-3"> <br><label>Total Balance:</label>
               <input name="bb" type="text" class="form-control">
               </div>
               
               <div class="col-sm-3"> <br><label>Amount to be charge:</label>
               <input name="cc" type="number" class="form-control">
               <br>
               </div>
               
             </div>
             </div>
             
             <div class="col-sm-12" style="border-style: solid;border-radius:3px;border-width:1px">
             <div class="">
                 
              <!--<div class="col-sm-3"> <br><label>Sales price:</label>-->
              <!-- <input name="dd" type="text" class="form-control">-->
              <!--</div>-->
               
               <div class="col-sm-4"> <br><label>Shipping cost & handling:</label>
               <input name="ee" type="number" class="form-control">
               </div>
               
               <div class="col-sm-4"> <br><label>Sale tax:</label>
               <input name="ff" type="number" class="form-control">
               </div>
               
               <div class="col-sm-4"> <br><label>Total purchase value:</label>
               <input name="gg" type="number" class="form-control">
               </div>
               
               <div class="col-sm-4"> <br><label>Additional Deposit:</label>
               <input name="hh" type="number" class="form-control">
               </div>
               
                <div class="col-sm-4"> <br><label>Payment date:</label>
               <input name="ii" type="date" required class="form-control">
               </div>
               
                <div class="col-sm-4"> <br><label>Balance dues after additional Deposit:</label>
               <input name="jj" type="number" class="form-control">
               </div>
               
                <p> As use Our Corporation products and services remains in effect, the following terms and conditions will apply in all matters concerning this Sales Agreement.
                </p>
                <p>Term & Condition* (www.se7entech.net/contract/term.php)</p>
                    
               <div class="col-sm-6"> <br><label>Company representative Name:</label>
               <input name="ll" type="text" class="form-control">
               </div>
               
               <div class="col-sm-6"> <br><label>Enter Date	:</label>
               <input name="mm" type="date" required class="form-control">
               </div>
               
               <div class="col-sm-6"> <br><label>Client representative Name:</label>
               <input name="nn" type="text" class="form-control">
               </div>
               
               <div class="col-sm-6"> <br><label>Enter Date	:</label>
               <input name="oo" type="date" required class="form-control">
               <br>
               </div>
               
                <div class="col-sm-6"> <br><label>Company Signature:</label>
                <!--<input name="company_sign" type="file" accept="image/*" class="form-control">-->
                </div>
                
                <div class="col-sm-6"> <br><label>Client Signature:</label>
               <!--<input name="client_sign" type="file" accept="image/*" class="form-control">-->
                </div>
                
                <div class="col-sm-12">
                <center> <br>   <button type="submit" name="save" class="btn btn-primary">Submit & Sign</button></center>
                <br>
                </div>
                </form>
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
               
          