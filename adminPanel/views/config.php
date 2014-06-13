<?php include 'partials/header.php'; ?>
    <section id="content" class="content">
      <div class="breadcrumb">
        <ul>
          <li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
          <li>Change Config Values</li>
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
      <?php foreach ($config as $key => $value): ?>
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
      <button type="button" class="btn blue" id="add-setting">Add Setting</button>
      <button type="button" class="btn green" id="save-setting">Save Setting</button>
      <button type="button" class="btn red right" id="delete-selected" disabled>Delete Selected</button>
    </div>
  </section>
<?php include 'partials/footer.php'; ?>
