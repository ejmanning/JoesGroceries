<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
require_once('./inc/GroceryItems.class.php');

$item = new GroceryItems();

$itemDataArray = array();
$itemErrorsArray = array();

// load the faq if we have it
if (isset($_REQUEST['itemID']) && $_REQUEST['itemID'] > 0)
{
    $item->load($_REQUEST['itemID']);
    $itemDataArray = $item->itemData;
}

// apply the data if we have new data
if (isset($_POST['Save'])) {
    $itemDataArray = $_POST;
    //sanitize
    //var_dump($itemDataArray);

    $itemDataArray = $item->sanitize($itemDataArray);
    //var_dump($itemDataArray);

    //var_dump("sanitized");
    $item->set($itemDataArray);
    //var_dump($itemDataArray);die;
    //validate
    //var_dump($item);die;
    if ($item->validate())
    {
      //var_dump($user);
        //  save
        if ($item->save())
        {
          header("location: groceryMenuItems.php?categoryID=$itemDataArray[categoryID]&subcategoryID=$itemDataArray[subcategoryID]");


        }
        else
        {
            $itemErrorsArray[] = "Save failed";
        }
    }
    else
    {
        $itemErrorsArray = $item->errors;
        $itemDataArray = $item->itemData;
    }

    //var_dump($faqErrorsArray);
  }
require_once('./inc/GrocerySubcategories.class.php');
$subcategory = new GrocerySubcategories();
$subcategoryList = $subcategory->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('subcategoryID'),
    ($_GET['subcategoryID'])
);

require_once('./inc/GroceryCategories.class.php');
$category = new GroceryCategories();
$categoryList = $category->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('categoryID'),
    ($_GET['categoryID'])
);


    require_once('./tpl/itemInput.tpl.php');
  } else {
    header('Location: login.php');
    exit;
  }

?>
