<?php
require APPROOT . '/views/includes/header.php';
?>

<div class="d-flex flex-row mt-30">
  <div class="form-signin col-12 justify-content-center">
      <form action="<?php echo URLROOT . '/auth/checkLogin'; ?>" method="POST">
          <h1 class="h3 mb-3 fw-normal">Welcome To Alpine Air</h1>
          <h2 class="h4 mb-3 fw-normal">Please Sign In</h2>
          <div class="form-floating">
              <input type="email" class="form-control" id="email_address" name="email_address">
              <label for="email_address">Email Address</label>
          </div>
          <div class="form-floating">
              <input type="password" class="form-control" id="password" name="password">
              <label for="password">Password</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Sign In</button>
          <a href="<?php echo URLROOT . '/auth/register'; ?>">Need to register? Click here</a>
      </form>
  </div>
</div>
<?php
require APPROOT . '/views/includes/footer.php';

