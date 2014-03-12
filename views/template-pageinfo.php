<h2><?php echo $title; ?></h2>
<?php if (isset($meta['description'])): ?>
  <p><strong>Description</strong> <?php echo $meta['description']; ?></p>
<?php else: ?>
  <p><strong>Description</strong> <em>No Description set.</em></p>
<?php endif ?>
<ul>
<?php if (count($meta) > 1): ?>
    <?php
    unset($meta['title']);
    unset($meta['description']);
    foreach ($meta as $key => $value): ?>
    <li><strong><?php echo ucfirst($key) ?></strong>: <em><?php echo $value ?></em></li>
  <?php endforeach ?>
<?php else: ?>
  <li><em>No Other Meta Set</em></li>
<?php endif; ?>
</ul>
<div class="page-controls" data-url="<?php echo $real_url; ?>">
  <!-- <a href="#" class="btn green" id="add-child">Add Child</a> -->
  <a href="editor?page=<?php echo $real_url ?>" class="btn green" id="edit-page">Edit Page</a>
  <a href="#" class="btn green" id="rename-page">Rename Page</a>
  <a href="#" class="btn red top-close" id="delete-page">X</a>
</div>
