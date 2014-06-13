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
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 15%;">
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 20%;">
      </colgroup>
      <thead>
        <tr>
          <th align="center"><input type="checkbox" id="check-all" value=""></th>
          <th>Username</th>
          <th>Display Name</th>
          <th>Role</th>
          <th align="right">Created</th>
          <th align="right">Logged In</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($safe_users as $user): ?>
        <tr id="<?php echo $user->username; ?>">
          <td align="center">
            <input type="checkbox" class="row-select" value="<?php echo $user->username; ?>">
          </td>
          <td><?php echo $user->username; ?></td>
          <td><?php echo $user->display_name; ?></td>
          <td><?php echo $user->role; ?></td>
          <td align="right"><?php echo $user->created; ?></td>
          <td align="right"><?php echo $user->logged_in; ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div class="editor-buttons">
      <button type="button" class="btn blue" id="add-user">Add User</button>
      <button type="button" class="btn red right" id="delete-selected" disabled>Delete Selected</button>
    </div>
  </section>
<?php include 'partials/footer.php'; ?>
