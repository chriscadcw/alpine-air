<?php
require APPROOT . '/views/includes/header.php';
$user = $data['user'];
?>
<div class="container-fluid">
  <h1 class="h3 p-4">Welcome <?php echo $user->getFirstName() .' ' . $user->getLastName(); ?></h1>

  <p>This is the content of the test site.  You can view your profile by clicking the button below or the link above.</p>

  <br /><br />
  <div class="container-fluid">
    <a class="btn btn-lg btn-primary p-3" href="<?php echo URLROOT . '/users/profile/'. $user->getId(); ?>">View Profile</a>
  </div>
</div>
<?php
require APPROOT . '/views/includes/footer.php';
?>
