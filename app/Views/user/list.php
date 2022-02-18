<?php
require APPROOT . '/views/includes/header.php';
$users = null;
if( is_array($data['users'])) {
    $users = $data['users'];
}
?>
<div class="container-fluid">
  <h1 class="h3">Current Users</h1>
  <div class="card">
    <div class="card-header">Current Users</div>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">User ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email Address</th>
          </tr>
        </thead>
        <tbody>
          <?php if( is_array($users) ){
            foreach($users as $usr){
              ?>
                    <tr>
                      <td><?php echo $usr->id ?></td>
                      <td><?php echo $usr->first_name ?></td>
                      <td><?php echo $usr->last_name ?></td>
                      <td><?php echo $usr->email_address ?></td>
                    </tr>
            <?php }
          } else { ?>
            <tr>
              <td colspan="4">No Users Found</td>
            </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
require APPROOT . '/views/includes/footer.php';
