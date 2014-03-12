<?php foreach($images as $image): ?>
  <div class="upload-thumb">
    <a href="<?php echo $image['src'] ?>" target="_blank" title="<?php echo $image['title'] ?>"><img src="<?php echo $image['src'] ?>" width="<?php echo $image['width'] ?>" height="<?php echo $image['height'] ?>" alt="<?php echo $image['alt'] ?>"></a>
    <p><?php echo $image['filename'] ?></p>
    <a href="#" class="btn red top-close">X</a>
  </div>
<?php endforeach; ?>