<!-- Check to verify that the message need not be shown everytime the user logs in -->
<?php if(isset($_SESSION['message'])): ?>
<!-- Displaying success message on logging user in -->
<!-- <div class="msg success"> -->
  <div class="<?php echo $_SESSION['type'];?>">
    <li><?php echo $_SESSION['message']; ?></li>
    <!-- The code is to display loggedin message only once -->
    <?php
      unset($_SESSION['message']);
      unset($_SESSION['type']);
    ?>
  </div>
<?php endif; ?>