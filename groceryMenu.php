<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
require_once('./inc/GroceryCategories.class.php');

$categories = new GroceryCategories();
$categoryList = $categories->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    (isset($_GET['filterColumn']) ? $_GET['filterColumn'] : null),
    (isset($_GET['filterText']) ? $_GET['filterText'] : null)
);

//var_dump($userList);
require_once('./tpl/groceryMenu.tpl.php');
} else {
  header('Location: login.php');
  exit;
}
?>
