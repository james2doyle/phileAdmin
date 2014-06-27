<?php include 'partials/header.php'; ?>
    <section id="content" class="content">
      <div class="breadcrumb">
        <ul>
          <li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
          <li>User Listings</li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <table class="item-list">
        <colgroup>
        <col span="1" style="width: 5%;">
        <col span="1" style="width: 15%;">
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 15%;">
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 20%;">
		<col span="1" style="width: 5%;">
      </colgroup>
      <thead>
        <tr>
          <th align="center"><input type="checkbox" id="check-all" value=""></th>
          <th>Username</th>
          <th>Display Name</th>
          <th>Role</th>
          <th align="right">Created</th>
          <th align="right">Logged In</th>
		  <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($safe_users as $user): ?>
        <tr id="<?php echo $user->user_id; ?>">
          <td align="center">
            <input type="checkbox" class="row-select" value="<?php echo $user->user_id; ?>" data-url="<?php echo 'users/' . $user->user_id; ?>">
          </td>
          <td><?php echo $user->username; ?></td>
          <td><?php echo $user->display_name; ?></td>
          <td><?php if(!isset($user->role)) { echo 'Admin'; } ?></td>
          <td align="right"><?php echo date('h:i:s A - d/M/Y', $user->created); ?></td>
          <td align="right"><?php echo date('h:i:s A - d/M/Y', $user->logged); ?></td>
          <td align="right" class="actions">
            <a href="edit_user?id=<?php echo $user->user_id; ?>" class="btn blue small hint--left" data-hint="Edit User"><span class="oi" data-glyph="person"></span></a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div class="editor-buttons">
	  <a href="create_user" class="btn blue">Add User</a>
      <button type="button" class="btn red right" id="delete-selected" disabled>Delete Selected</button>
    </div>
  </section>
<?php include 'partials/footer.php'; ?>
