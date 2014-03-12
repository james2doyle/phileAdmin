<?php include 'partials/header.php'; ?>
  <div class="container">
    <?php include 'partials/sidebar.php'; ?>
    <div class="content">
      <h2>Settings</h2>
      <input type="checkbox" name="check-all" id="check-all"> Check All
      <div class="settings-form">
      <?php foreach ($config as $key => $value): ?>
        <?php if (is_array($value)) {
          continue;
          } ?>
        <div class="settings-control" id="<?php echo $key; ?>">
          <input type="checkbox" class="prop-check" name="delete[<?php echo $key; ?>]" value="">
          <input type="text" class="prop-key" name="<?php echo $key; ?>" value="<?php echo $key; ?>" placeholder="<?php echo $key; ?>" disabled>
          <input type="text" class="prop-value" name="value[<?php echo $key; ?>]" value="<?php echo $value; ?>" placeholder="<?php echo $key; ?>">
        </div>
        <?php endforeach ?>
      </div>
      <a href="#" class="btn blue" id="save-setting">Save Setting</a>
      <a href="#" class="btn green" id="new-setting">New Setting</a>
      <a href="#" class="btn red" id="delete-setting">Delete Setting</a>
    </div>
  </div>
<?php include 'partials/footer.php'; ?>
