<?php
$titrePage = "Mentions légales";
require 'inc/header.php'; ?>


<?php
require 'inc/db.php';
require 'inc/functions.php';
$myfile = fopen("docs/mentions.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("docs/mentions.txt"));
fclose($myfile);


// echo file_get_contents("docs/mentions.txt");
// $dte = date('d/m/Y H:i:s');
// $ip = $_SERVER['REMOTE_ADDR'];
//
// //////////////////////////////////////////
// file_put_contents('docs/logs.txt', $dte.' '.$ip.PHP_EOL, FILE_APPEND );
// ////////////////////////////////////////
// copy('docs/logs.txt', 'docs/log2.txt');
// ///////////////////////////////////////////
// rename('docs/log2.txt', 'docs/log3.txt');
// /////////////////////////////////////////
// unlink('docs/log3.txt');
// ////////////////////////////////////////////
// if (file_exists('docs/logs.txt')) {
//   echo "file exist";
// }
// /////////////////////////////////////////////
// echo filesize('docs/logs.txt');
//
// /////////////////////////////////////
// $alogs = file('docs/logs.txt');
// debug($alogs);

/*EXPORT DES CLIENTS */

$rq = 'SELECT * FROM clients';
$stmt = $pdo->query($rq);
$listClient = $stmt->fetchAll(PDO::FETCH_NUM);


$fd = fopen('docs/clients.csv', 'w');

foreach ($listClient as $client) {
  fputcsv($fd, $client, ';');
}
fclose($fd);
/////////////////////////////////////

$directory = 'img';
if (is_dir($directory)) {
    if ($dh = opendir($directory)) {
      echo '<div class="row">';
      while (($file = readdir($dh)) !== false) {
          if ($file == '.' || $file == '..') {
            continue;
          }
          $legende = substr($file, 0, -4);
          echo '<figure class="col-md-3"><img src="img/'.$file.'" class="img-responsive imgscale"/><figcaption class="text-center">'.$legende.'</figcaption></figure>';
      }
      echo "</div>";
      closedir($dh);
    }
}


?>

<?php require 'inc/footer.php' ?>
