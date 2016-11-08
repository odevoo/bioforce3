<?php
require_once 'inc/functions.php';
session_start();
if (!empty($_POST)) {

  if ($_SESSION['css'] == 1) {
    $_SESSION['css'] = 2;
  } else if ($_SESSION['css'] == 2) {
    $_SESSION['css'] = 3;
  } else {
      $_SESSION['css'] = 1;
  }
}

header('location: admin.php');
