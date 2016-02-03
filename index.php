<?php
/**
 * Created by PhpStorm.
 * User: Niklas
 * Date: 20.08.2015
 * Time: 12:52
 */
 
$file = ''; // Your Image-Link (e.g. http://prntscr.com/xyz123)
 
// Caching

header('Pragma: public');
header('Cache-Control: max-age=86400');
header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));

// Image type

header('Content-Type: image/png'); 


if (strpos($file,'prntscr') !== false) {
  $newprntscrlink = explode('http://prntscr.com/', $file);
  $newprntscrlink = $newprntscrlink[1];
  $content = get_contents('http://prnt.sc/'.$newprntscrlink);
  $image = get_string_between($content, '<meta name="twitter:image:src" content="', '"/> <meta property="');
  $filecontent = file_get_contents($image);
  echo $filecontent;
} elseif (strpos($file,'directupload') !== false) {
  $content = get_contents($file);
  $directuploadhotlink = get_string_between($content, 'id="hotlink" value="', '" onClick="this.select()">');
  $filecontent = file_get_contents($directuploadhotlink);
  echo $filecontent;
} elseif (strpos($file,'screencloud.net/v/') !== false) {
  $content = file_get_contents($file);
  $screencloudsourcelink = get_string_between($content, 'png"><img src="', '" alt="Screenshot at');
  $screencloudhotlink = str_replace('//', 'https://', $screencloudsourcelink);
  $filecontent = file_get_contents($screencloudhotlink);
  echo $filecontent;
} elseif (strpos($file,'gyazo.com') !== false) {
  $content = file_get_contents($file);
  $gyazohotlink = get_string_between($content, '"gyazo"><img class="image" id="gyazo_img" src="', '" style=" ');
  $filecontent = file_get_contents($gyazohotlink);
  echo $filecontent;
} elseif (strpos($file,'mediafire.com') !== false) {
  $content = url_get_contents($file);
  $mediafirehotlink = get_string_between($content, '</div> <img src="', '" alt="');
  $filecontent = file_get_contents($mediafirehotlink);
  echo $filecontent;
} else {
  $file = base64_decode($_GET['file']);
  $filecontent = file_get_contents($file);
  echo $filecontent;
}
