<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
require_once('./inc/GroceryLists.class.php');

$list = new GroceryLists();
//var_dump($list);
$listList = $list->getList(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('status'),
    ('current')
);

$listDataArray = array();
$listErrorsArray = array();

if (isset($_POST['markAsDone'])) {
  $listDataArray = $_POST;
  $listDataArray = $list->sanitize($listDataArray);
  $list->set($listDataArray);

  if ($list->validate())
  {
    //var_dump($list);die;
    //var_dump($user);
      //  save
      if ($list->save())
      {
        header("location: viewCurrentList.php");
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

$listIDArray = array();
//var_dump(count($itemsOnListList));
$listIDArrayGoThrough = count($listList) - 1;
//var_dump($itemArrayGoThrough);
for ($i = 0; $i <= $listIDArrayGoThrough; $i++) {
  $listID = $listList[$i]['listID'];
  array_push($listIDArray, $listID);
}

//var_dump($listList[0]['listID']);

require_once('./inc/JoesGroceries.class.php');

$itemsOnList = new JoesGroceries();
$itemsOnListList = $itemsOnList->getListArray(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('listID'),
    ($listIDArray)
);

$itemDataArray = array();
$itemErrorsArray = array();
if (isset($_POST['checkedStatus'])) {
  $itemDataArray = $_POST;
  var_dump($_POST);
  $itemDataArray = $itemsOnList->sanitize($itemDataArray);
  $itemsOnList->set($itemDataArray);
  var_dump($itemsOnList);
  if ($itemsOnList->validate())
  {
    //var_dump($list);die;
    //var_dump($user);
      //  save
      if ($itemsOnList->save())
      {
        header("location: viewCurrentList.php");
      }
      else
      {
          $itemErrorsArray[] = "Save failed";
      }
  }
  else
  {
      $itemErrorsArray = $itemsOnList->errors;
      $itemDataArray = $itemsOnList->itemsOnListData;
  }

  //var_dump($faqErrorsArray);
}



//var_dump($itemsOnListList);

$itemArray = array();
//var_dump(count($itemsOnListList));
$itemArrayGoThrough = count($itemsOnListList) - 1;
//var_dump($itemArrayGoThrough);
for ($x = 0; $x <= $itemArrayGoThrough; $x++) {
  $item = $itemsOnListList[$x]['itemID'];
  array_push($itemArray, $item);
}

//var_dump($itemArray);

require_once('./inc/GroceryItems.class.php');
$itemNames = new GroceryItems();
$itemNamesList = $itemNames->getListArray(
    (isset($_GET['sortColumn']) ? $_GET['sortColumn'] : null),
    (isset($_GET['sortDirection']) ? $_GET['sortDirection'] : null),
    ('itemID'),
    ($itemArray)
);

//var_dump($itemNamesList);

//var_dump($userList);

require_once('./tpl/viewCurrentList.tpl.php');
} else {
  header('Location: login.php');
  exit;
}
?>
