<?php
require APPROOT . '/views/includes/header.php';
$user = $data['user'];
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <?php echo $user->getFirstName(). ' ' . $user->getLastName(); ?>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item row">
                    <label class="col-form-label col-md-2">First Name:</label>
                    <span><?php echo $user->getFirstName(); ?></span>
                </li>
                <li class="list-group-item row">
                    <label class="col-form-label col-md-2">Last Name:</label>
                    <span><?php echo $user->getLastName(); ?></span>
                </li>
                <li class="list-group-item row">
                    <label class="col-form-label col-md-2">Email Address:</label>
                    <span><?php echo $user->getEmailAddress(); ?></span>
                </li>
            </ul>
        </div>
    </div>
</div>

