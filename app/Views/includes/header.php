<?php
$messages = '';

if(!empty($data['messages'])){
  $messages = $data['messages'];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo SITENAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- App theme -->
    <link rel="stylesheet" type="text/css" href="/css/site.css" >
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
          <a class="navbar-brand ps-md-4" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarMain" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarMain">
              <div class="navbar-nav">
                  <?php if(isset($data['user'])): ?>
                      <a class="nav-link" href="<?php echo URLROOT; ?>">Home</a>
                      <a class="nav-link" href="<?php echo URLROOT . '/users/profile/' . $data['user']->getId(); ?>">My Profile</a>
                      <?php if($data['user']->getRoleId() === 1): ?>
                          <a class="nav-link" href="<?php echo URLROOT . '/users/list'; ?>">Current Users</a>
                      <?php endif; ?>
                      <a class="nav-link" href="<?php echo URLROOT . '/auth/logout'; ?>">Logout</a>
                  <?php else: ?>
                      <a class="nav-link" href="<?php echo URLROOT . '/auth/login'; ?>">Login</a>
                  <?php endif; ?>
              </div>
          </div>
    </nav>
    <?php if( !empty($messages) ): ?>
    <div class="row">
        <div class="col-md-12">
          <?php echo $messages ?? ''; ?>
        </div>
    </div>
    <?php endif; ?>
