<?php
//fetch the email id of the user
// $emailid=$_GET['email'];
// //decode the emailid
// $emailid1=base64_decode($emailid);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" class="gr__visuallightbox_com">
<head>
<title>Unsubscribe</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<style>
    @import "http://fonts.googleapis.com/css?family=Open+Sans:300&subset=latin,greek-ext,cyrillic-ext,greek,vietnamese,cyrillic,latin-ext";
#formoid{
font-size:14px;
font-size:14px;
width:;
margin:0 auto;
}
#formoid div.selector,
#formoid select,
#formoid input[type=button],
#formoid input[type=submit] {
font-family: "Open Sans","Helvetica Neue","Helvetica",Arial,Verdana,sans-serif;
color: #666;
padding: 5px;
}
#formoid h2 {
margin: 0.2em 0;
}
#formoid div.uploader:active span.action,#formoid div.uploader.active span.action{
background-color: #E6E6E6;
background-image: none;
outline: 0 none;
color: #333333;
}
#formoid div.uploader input {
opacity: 0;
filter: alpha(opacity:0);
position: absolute;
top: 0;
right: 0;
bottom: 0;
float: right;
height: 25px;
border: none;
cursor: default;
}
#formoid div.uploader.disabled span.action {
color: #aaa;
}
#formoid div.uploader.disabled span.filename {
border-color: #ddd;
color: #aaa;
}
#formoid div.selector:active,
#formoid select:active,
#formoid input[type=button]:active{
background-color: #cccccc;
}
#formoid div.selector:hover,
#formoid select:hover,
#formoid input[type=button]:hover {
color: #333333;
text-decoration: none;
background-position: 0 -15px;
}
#formoid div.selector:active,
#formoid select:active,
#formoid input[type=button]:active {
background-image: none;
outline: 0;
}
#formoid input[type=button][disabled] {
cursor: default;
background-image: none;
opacity: 0.65;
filter: alpha(opacity=65);
}
#formoid input[type=submit] {
background-color: #006dcc;
color: #ffffff;
text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
background-image: linear-gradient(top, #67c2ef, #2FABE9);
background-repeat: repeat-x;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#67c2ef', endColorstr='#2FABE9', GradientType=0);
border-color: #1598d9 #1598d9 #007bb8 #1598d9;
}
#formoid input[type=submit]:hover {
background-color: #2FABE9;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#47b4eb', endColorstr='#2FABE9', GradientType=0);
color: #ffffff;
text-decoration: none;
background-position: 0 -15px;
}
#formoid input[type=submit]:active,
#formoid input[type=submit][disabled] {
background-color: #2FABE9;
*background-color: #2FABE9;
background-image: none;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
outline: 0 none;
}
#formoid input[type=text],
#formoid input[type=password],
#formoid textarea {
width: 96%;
padding: 6px 2%;
margin-left:-1px;
font-size: 1em;
font-weight: normal;
padding: 6px;
color: #777;
border-top: solid 1px #aaa;
border-left: solid 1px #aaa;
border-bottom: solid 1px #ccc;
border-right: solid 1px #ccc;
border-radius: 3px;
outline: 0;
}
body {
padding-top: 40px;
padding-bottom: 40px;
background-color: #f5f5f5;
}
.alert {
padding: 8px 35px 8px 14px;
margin-bottom: 20px;
text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
background-color: #fcf8e3;
border: 1px solid #fbeed5;
}
.formun {
color: #333;
max-width: 500px;
padding: 19px 29px 29px;
margin: 0 auto 20px;
background-color: #fff;
border: 1px solid #e5e5e5;
}
</style>
</head>
<body>
<form autocomplete="off" method="post" id="formoid" class="formun">
<div><h2 class="title">Do you want to unsubscribe?</h2></div>
<div><label class="title">Email to unsubscribe:</label><input autocomplete="on" type="text" name="email"></div>
<div><label class="title">Please let us know why you are unsubscribing:</label>
<div> <input type="radio" name="answer" value="Inappropriate emails"><span>Inappropriate emails</span><br>
<input type="radio" name="answer" value="Not interested anymore"><span>Not interested anymore</span><br>
<input type="radio" name="answer" value="Never signed up"><span>Never signed up</span><br>
<input type="radio" name="answer" value="Too often"><span>Too often</span><br>
<input type="radio" name="answer" value="Bad products"><span>Bad products</span><br>
<input type="radio" name="answer" value="Awful support"><span>Awful support</span><br>
<input type="radio" name="answer" value="Spam!"><span>Spam!</span><br>
</div>
</div>
<div><input type="submit" name="unsubscribe" value="Unsubscribe"></div>
<p class="link"><a href="https://www.se7entech.net/" target="_blank">Se7entech.net</a>
</p>
</form>
</body>
</html>