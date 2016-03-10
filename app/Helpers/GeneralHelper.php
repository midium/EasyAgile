<?php

function getAvailableThemes(){
  $themes = explode(',', env('APP_THEMES', 'default'));

  return $themes;

}

function GetFileExtension($filename){
  if($filename==null || $filename=='') return '';
  $pieces = explode('.', $filename);
  return strtolower($pieces[count($pieces)-1]);
}

function IsImageFile($filename){
  if($filename==null || $filename=='') return false;

  switch(GetFileExtension($filename)){
    case 'jpg':
    case 'gif':
    case 'bmp':
    case 'jpeg':
    case 'png':
      return true;

      break;

    default:
      return false;
      break;
  }
}

function formatBytes($bytes, $precision = 2) {
    $units = array('b', 'kb', 'mb', 'gb', 'tb');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>
