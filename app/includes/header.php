<header>
    <div class="logo">
      <h1 class="logo-text"><a href="index.php"><span>Awa</span>Inspires</a></h1>
    </div>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
      <!-- <li><a href="../../index.php">Home</a></li> -->
      <li><a href="<?php echo BASE_URL . '/index.php'?>">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Services</a></li>
      <!-- Checking if user exist by pulling corresponding user id from users table -->
      <?php if(isset($_SESSION['id'])):?>
        <li>
        <a href="#">
          <i class="fa fa-user"></i>
          <?php echo $_SESSION['username']; ?>
          <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
        </a>
        <ul>
        <!-- Checking if value of admin 0-not admin,1-admin is true -->
          <?php if($_SESSION['admin']): ?>
          <li><a href="<?php echo BASE_URL. '/admin/dashboard.php'?>">Dashboard</a></li>
          <?php endif; ?>
          <li><a href="<?php echo BASE_URL. '/logout.php'?>" class="logout">Logout</a></li>
        </ul>
      </li>
      <?php else: ?>
        <li><a href="<?php echo BASE_URL. '/register.php'?>">Sign Up</a></li>
        <li><a href="<?php echo BASE_URL. '/login.php'?>">Login</a></li>
      <?php endif; ?>
  
    
    </ul>
  </header>