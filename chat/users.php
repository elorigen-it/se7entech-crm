<?php 
  session_start();
  require('../vendor/autoload.php');
  include_once "php/config.php";
    require_once('../config/config.php');
    require_once('../connection.php');
  use Se7entech\Contractnew\Middlewares\hasFilledRequirementForm;
    $md = new hasFilledRequirementForm();
    $md->handle(0);
  if(!isset($_SESSION['id'])){
    header("location: ../index.php");
  }
?>
<?php include_once "header.php"; ?>

  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM invoice_user WHERE id = {$_SESSION['id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          <!--<img src="../profile/<?php echo $row['image']; ?>" alt="">-->
          <div class="details">
            <span><?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?></span>
            <p><?php   if($row['status']=='0'){echo 'online';} else{echo 'online';}?></p>
          </div>
        </div>
        <!--<a href="../logout.php?logout_id=<?php echo $row['id']; ?>" class="logout">Logout</a>-->
        <!--<a href="https://crm.se7entech.net/" class="logout">Profile</a>-->
      </header>
      <div class="search">
        <span class="text">Select an user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>

</body>
</html>
