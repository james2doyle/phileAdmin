<?php include 'partials/header.php'; ?>
<div class="container">
  <?php include 'partials/sidebar.php'; ?>
  <div class="content">
    <h2>Pages</h2>
    <ul class="nested-sortable">
      <?php for ($i=0; $i < count($pages); $i++): ?>
        <li <?php if ($i === 0): ?>class="active"<?php endif ?>>
          <a href="#" data-path="<?php echo $pages[$i]['real_url'] ?>" id="item_<?php echo $i ?>"><?php echo $pages[$i]['title'] ?></a>
        </li>
      <?php endfor; ?>
      <div class="clearfix"></div>
      <a href="#" class="btn blue" id="new-page">New Page</a>
    </ul>
    <div class="page-info">
<!--       <h2><?php echo $pages[0]['title']; ?></h2>
      <p><strong>Description</strong> <?php echo $pages[0]['meta']['description']; ?></p>
      <ul>
        <?php
        unset($pages[0]['meta']['title']);
        unset($pages[0]['meta']['description']);
        foreach ($pages[0]['meta'] as $key => $value): ?>
        <li><strong><?php echo ucfirst($key) ?></strong>: <em><?php echo $value ?></em></li>
      <?php endforeach ?>
    </ul>
    <div class="page-controls" data-url="<?php echo $pages[0]['real_url']; ?>">
      <a href="#" class="btn green" id="add-child">Add Child</a>
      <a href="#" class="btn green" id="edit-page">Edit Page</a>
      <a href="#" class="btn green" id="rename-page">Rename Page</a>
      <a href="#" class="btn red top-close" id="delete-page">X</a>
    </div> -->
  </div>
</div>
</div>
<?php include 'partials/footer.php'; ?>
