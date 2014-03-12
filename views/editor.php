<?php include 'partials/header.php'; ?>
<div class="container">
  <?php include 'partials/sidebar.php'; ?>
  <div class="content">
    <h2>Editing: <em><?php echo $data['title'] ?></em></h2>
    <div class="editor-buttons">
      <a href="pages" class="btn red"><i class="fa fa-chevron-left"></i> Back</a>
      <a href="#" class="btn blue" id="save-content">Save</a>
    </div>
    <textarea id="editor" data-path="<?php echo $data['path'] ?>" class="editor"><?php echo $data['raw_content'] ?></textarea>
    <div id="viewer" class="viewer"><?php echo $data['content'] ?></div>
  </div>
</div>
<?php include 'partials/footer.php'; ?>
