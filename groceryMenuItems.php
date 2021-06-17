<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
//var_dump($_SESSION['currentListID']);
require_once('./inc/GroceryItems.class.php');
require_once('./inc/GrocerySubcategories.class.php');
require_once('./inc/GroceryCategories.class.php');
require_once('./inc/JoesGroceries.class.php');

$items = new GroceryItems();
$itemList = $items->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('subcategoryID'),
    ($_GET['subcategoryID'])
);

$subcategory = new GrocerySubcategories();
$subcategoryList = $subcategory->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('subcategoryID'),
    ($_GET['subcategoryID'])
);

$category = new GroceryCategories();
$categoryList = $category->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('categoryID'),
    ($_GET['categoryID'])
);

//var_dump($categoryList);

$joesGroceries = new JoesGroceries();

$joesGroceriesDataArray = array();
$joesGroceriesErrorsArray = array();

if (isset($_POST['Add'])) {
  //var_dump($_POST);
    $joesGroceriesDataArray = $_POST;
    //var_dump($userDataArray);
    //sanitize

    $joesGroceriesDataArray = $joesGroceries->sanitize($joesGroceriesDataArray);
    //var_dump("sanitized");
    //var_dump($joesGroceriesDataArray);
    $joesGroceries->set($joesGroceriesDataArray);
    //var_dump($user);
    //validate
    if ($joesGroceries->validate())
    {

        //  save
        if ($joesGroceries->saveToGroceryList())
        {
          //var_dump($joesGroceries);die;
          echo "<script>alert('Added to List!')</script>";
        }
        else
        {
            echo "not saved";
            $joesGroceriesErrorsArray[] = "Save failed";
        }
    }

    else
    {
        $joesGroceriesErrorsArray = $joesGroceries->errors;
        $joesGroceriesDataArray = $joesGroceries->joesGroceriesData;
    }
  }
require_once('./tpl/groceryMenuItems.tpl.php');
} else {
  header('Location: login.php');
  exit;
}

?>
