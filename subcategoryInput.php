<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
require_once('./inc/GrocerySubcategories.class.php');

$subcategory = new GrocerySubcategories();

$subcategoryDataArray = array();
$subcategoryErrorsArray = array();

// load the faq if we have it
if (isset($_REQUEST['subcategoryID']) && $_REQUEST['subcategoryID'] > 0)
{
    $subcategory->load($_REQUEST['subcategoryID']);
    $subcategoryDataArray = $subcategory->subcategoryData;
}

// apply the data if we have new data
if (isset($_POST['Save'])) {
    $subcategoryDataArray = $_POST;
    //sanitize

    $subcategoryDataArray = $subcategory->sanitize($subcategoryDataArray);
    //var_dump("sanitized");
    $subcategory->set($subcategoryDataArray);
    //var_dump($subcategoryDataArray['categoryID']);die;
    //validate
    if ($subcategory->validate())
    {
      //var_dump($user);
        //  save
        if ($subcategory->save())
        {
          header("location: groceryMenuSubcategories.php?categoryID=$subcategoryDataArray[categoryID]");


        }
        else
        {
            $subcategoryErrorsArray[] = "Save failed";
        }
    }
    else
    {
        $subcategoryErrorsArray = $subcategory->errors;
        $subcategoryDataArray = $subcategory->subcategoryData;
    }

    //var_dump($faqErrorsArray);
  }
require_once('./inc/GroceryCategories.class.php');
$category = new GroceryCategories();
$categoryList = $category->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('categoryID'),
    ($_GET['categoryID'])
);


    require_once('./tpl/subcategoryInput.tpl.php');
  } else {
    header('Location: login.php');
    exit;
  }

?>
