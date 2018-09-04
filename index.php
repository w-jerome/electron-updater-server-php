<?php
define('APP_NAME', 'myapp');
define('VERSION', filter_var($_GET['version'], FILTER_SANITIZE_STRING));

if (empty(VERSION)) {
  header('HTTP/1.0 204 No Content');
  exit;
}

define('ENV', filter_var($_GET['env'], FILTER_SANITIZE_STRING));

if (empty(ENV)) {
  header('HTTP/1.0 204 No Content');
  exit;
}

define('ARCH', filter_var($_GET['arch'], FILTER_SANITIZE_STRING));

if (empty(ARCH)) {
  header('HTTP/1.0 204 No Content');
  exit;
}

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__FILE__));
define('UPDATE_RELEASES', ROOT_PATH . DS . 'releases' . DS . ENV . DS . ARCH);
define('URL', 'http://' . $_SERVER['HTTP_HOST'] . '/updater');
define('URL_RELEASES', URL . '/releases/' . ENV . '/' . ARCH);

$system_files = array('.', '..', '.DS_Store');
$releases = scandir(UPDATE_RELEASES);
$new_release = '';

foreach ($releases as $release) {

  if (in_array($release, $system_files) || !is_dir(UPDATE_RELEASES . DS . $release)) {
    continue;
  }

  if (version_compare(VERSION, $release, '<')) {
    $new_release = $release;
  }
}

if (empty($new_release)) {
  header('HTTP/1.0 204 No Content');
  exit;
}

$path = '';
$url = '';

if (ENV === 'darwin') {
  $path = UPDATE_RELEASES . DS . $new_release . DS . APP_NAME . '-' . ENV . '-' . ARCH . '.zip';
  $url = URL_RELEASES . '/' . $new_release . '/' . APP_NAME . '-' . ENV . '-' . ARCH . '.zip';
} else if (ENV === 'win32') {
  $path = UPDATE_RELEASES . DS . $new_release . DS;
  $url = URL_RELEASES . '/' . $new_release . '/';
}

if (empty($url) || !file_exists($url)) {
  header('HTTP/1.0 204 No Content');
  exit;
}

$json = array(
  'url' => $url,
  'name' => APP_NAME,
  'notes' => 'Update',
  'pub_date' => '2016-08-26T19:57:53+01:00',
);

echo json_encode($json, JSON_UNESCAPED_UNICODE);
exit;
