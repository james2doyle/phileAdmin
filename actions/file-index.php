<?php

$images = array();
if ($handle = opendir('uploads')) {
  while (false !== ($entry = readdir($handle))) {
    $check = preg_match("/\.(jpg|jpeg|png|gif|webp)/i", $entry);
    if ($entry != "." && $entry != ".." && $check) {
      $alt = preg_replace('/\.(jpg|jpeg|png|gif|webp)/', '', $entry);
      $image_info = getimagesize('uploads/'.$entry);
      $images[] = array(
        'src' => 'uploads/'.$entry,
        'filename' => $entry,
        'width' => $image_info[0],
        'height' => $image_info[1],
        'title' => $alt,
        'alt' => $alt
        );
    }
  }
  closedir($handle);
}
header('Content-Type: text/html');
?>
<?php foreach($images as $image): ?>
  <div class="upload-thumb">
    <a href="<?php echo $image['src'] ?>" target="_blank" title="<?php echo $image['title'] ?>"><img src="<?php echo $image['src'] ?>" width="<?php echo $image['width'] ?>" height="<?php echo $image['height'] ?>" alt="<?php echo $image['alt'] ?>"></a>
    <p><?php echo $image['filename'] ?></p>
    <a href="#" class="btn red top-close">X</a>
  </div>
<?php endforeach; ?>
