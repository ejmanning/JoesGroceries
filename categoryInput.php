<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
require_once('./inc/GroceryCategories.class.php');

$category = new GroceryCategories();

$categoryDataArray = array();
$categoryErrorsArray = array();

// load the faq if we have it
if (isset($_REQUEST['categoryID']) && $_REQUEST['categoryID'] > 0)
{
    $category->load($_REQUEST['categoryID']);
    $categoryDataArray = $category->categoryData;
}

// apply the data if we have new data
if (isset($_POST['Save'])) {
    $categoryDataArray = $_POST;
    //var_dump($categoryDataArray);die;
    //sanitize

    $categoryDataArray = $category->sanitize($categoryDataArray);
    //var_dump("sanitized");
    $category->set($categoryDataArray);
    //var_dump($user);
    //validate
    if ($category->validate())
    {
      //var_dump($user);
        //  save
        if ($category->save())
        {
          header("location: groceryMenu.php");


        }
        else
        {
            $categoryErrorsArray[] = "Save failed";
        }
    }
    else
    {
        $categoryErrorsArray = $category->errors;
        $categoryDataArray = $category->categoryData;
    }

    //var_dump($faqErrorsArray);
  }
    require_once('./tpl/categoryInput.tpl.php');
  } else {
    header('Location: login.php');
    exit;
  }
?>
