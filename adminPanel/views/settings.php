<?php include 'partials/header.php'; ?>
    <section id="content" class="content">
      <div class="breadcrumb">
        <ul>
          <li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
          <li>Admin Settings</li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <table class="item-list">
        <colgroup>
        <col span="1" style="width: 5%;">
        <col span="1" style="width: 40%;">
        <col span="1" style="width: 55%;">
      </colgroup>
      <thead>
        <tr>
          <th align="center"><input type="checkbox" id="check-all" value=""></th>
          <th>Key</th>
          <th>Value</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($safe_settings as $key => $value): ?>
        <tr id="<?php echo $key ?>">
          <td align="center">
            <input type="checkbox" class="row-select" value="<?php echo $key ?>">
          </td>
          <td><?php echo $key ?></td>
          <td><input type="text" name="" value="<?php echo $value ?>" placeholder="<?php echo $value ?>" class="input-100"></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div class="editor-buttons">
      <button type="button" class="btn small blue" id="add-setting">Add Setting</button>
      <button type="button" class="btn small green" id="save-setting">Save Setting</button>
      <button type="button" class="btn small red right" id="delete-selected" disabled>Delete Selected</button>
    </div>
    <h3>Required Fields</h3>
    <p>Fields for new pages</p>
    <table class="item-list">
        <colgroup>
        <col span="1" style="width: 5%;">
        <col span="1" style="width: 40%;">
        <col span="1" style="width: 55%;">
      </colgroup>
      <thead>
        <tr>
          <th align="center"><input type="checkbox" id="check-all" value=""></th>
          <th>Key</th>
          <th>Value</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($required_fields as $field): ?>
        <tr id="<?php echo $field['name'] ?>">
          <td align="center">
            <input type="checkbox" class="row-select" value="<?php echo $field['name'] ?>">
          </td>
          <td><?php echo $field['name'] ?></td>
          <td><input type="text" name="" value="<?php echo $field['default'] ?>" placeholder="<?php echo $field['default'] ?>" class="input-100"></td>
        </tr>
      <?php endforeach; ?>
      <tr id="default_content">
          <td style="vertical-align: top" align="center">
            <input type="checkbox" class="row-select" value="default_content">
          </td>
          <td style="vertical-align: top">Default Content</td>
          <td style="vertical-align: top"><textarea name="" placeholder="<?php echo $default_content ?>" class="input-100"><?php echo $default_content ?></textarea></td>
        </tr>
      </tbody>
    </table>
    <div class="editor-buttons">
      <button type="button" class="btn small blue" id="add-setting">Add Setting</button>
      <button type="button" class="btn small green" id="save-setting">Save Setting</button>
      <button type="button" class="btn small red right" id="delete-selected" disabled>Delete Selected</button>
    </div>
  </section>
<?php include 'partials/footer.php'; ?>
