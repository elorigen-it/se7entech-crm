<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $id = mysqli_real_escape_string($conn, $_GET['id']);
          $sql = mysqli_query($conn, "SELECT * FROM invoice_user WHERE id = {$id}");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: users.php");
          }
        ?>
        <!--<a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>-->
        <!--<img src="../../images/invoice_user/<?php echo $row['image']; ?>" alt="">-->
        <div class="details">
          <span><?php echo $row['first_name']; echo $row['last_name']?></span>
          <p><?php   if($row['status']=='0'){echo 'online';} else{echo 'online';}?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>
</html>
