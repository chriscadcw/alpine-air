<?php
require APPROOT . '/views/includes/header.php';
?>
<div class="container-fluid">
  <div class="form-register">
      <form action="<?php echo URLROOT . '/auth/store'; ?>" method="POST">
          <h1 class="h3 mb-3 fw-normal">User Registration</h1>
          <p>Please fill out the following form to register</p>
          <div class="form-floating">
              <input type="text" class="form-control" id="first_name" name="first_name" ></input>
              <label for="first_name">First Name</label>
          </div>
          <div class="form-floating">
              <input type="text" class="form-control" id="last_name" name="last_name"></input>
              <label for="last_name">Last Name</label>
          </div>
          <div class="form-floating">
              <input type="email" class="form-control" id="email_address" name="email_address"></input>
              <label for="email_address">Email Address</label>
          </div>
          <div class="form-floating">
              <input type="password" class="form-control" id="password" name="password"></input>
              <label for="password">Password</label>
          </div>
          <div class="form-floating">
              <input type="password" class="form-control" id="confirm_password"></input>
              <label for="confirm_password">Confirm Password</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" id="btn_register" disabled="disabled" type="submit">Register</button>
      </form>
  </div>
</div>
<?php
require APPROOT .'/views/includes/footer.php';
