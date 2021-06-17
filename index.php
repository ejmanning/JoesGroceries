<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
  require_once(__DIR__ . '/tpl/index.tpl.php');
} else {
  header('Location: login.php');
  exit;
}
 ?>
