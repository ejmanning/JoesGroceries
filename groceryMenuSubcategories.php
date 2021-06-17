<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
require_once('./inc/GrocerySubcategories.class.php');
require_once('./inc/GroceryCategories.class.php');

$subcategories = new GrocerySubcategories();
$subcategoryList = $subcategories->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('categoryID'),
    ($_GET['categoryID'])
);

$category = new GroceryCategories();
$categoryList = $category->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('categoryID'),
    ($_GET['categoryID'])
);

//var_dump($categoryList);


//var_dump($userList);
require_once('./tpl/groceryMenuSubcategories.tpl.php');
} else {
  header('Location: login.php');
  exit;
}
?>
