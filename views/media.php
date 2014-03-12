<?php include 'partials/header.php'; ?>
<div class="container">
  <?php include 'partials/sidebar.php'; ?>
  <div class="content">
    <h2>Media</h2>
    <form action="upload" method="post" enctype="multipart/form-data" class="dropzone" id="media-upload">
      <div class="drop-icon"><i class="fa fa-cloud-upload"></i></div>
    </form>
    <div id="file-area">
      <?php foreach($images as $image): ?>
        <div class="upload-thumb">
          <a href="<?php echo $image['src'] ?>" target="_blank" title="<?php echo $image['title'] ?>"><img src="<?php echo $image['src'] ?>" width="<?php echo $image['width'] ?>" height="<?php echo $image['height'] ?>" alt="<?php echo $image['alt'] ?>"></a>
          <p><?php echo $image['filename'] ?></p>
          <a href="#" class="btn red top-close">X</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
</div>
<?php include 'partials/footer.php'; ?>
