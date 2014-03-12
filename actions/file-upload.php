<?php

$ds = DIRECTORY_SEPARATOR;
$storeFolder = 'uploads';

function slugify($text) {
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
  // trim
  $text = trim($text, '-');
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // lowercase
  $text = strtolower($text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  if (empty($text)){
    return 'n-a';
  }
  return $text;
}

if (!empty($_FILES)) {
  $tempFile = $_FILES['file']['tmp_name'];
  $targetPath = dirname( __FILE__ ) . $ds . $storeFolder . $ds;
  // cleanup the filename
  $info = pathinfo($_FILES['file']['name']);
  $filename = slugify($info['filename']);
  // add a timestamp for lazy fix of name conflicts
  $date = new DateTime();
  $cleanName = $filename . '-' . $date->getTimestamp() . '.' . $info['extension'];
  $targetFile =  $targetPath . $cleanName;
  move_uploaded_file($tempFile, $targetFile);
}
