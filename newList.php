<?php
session_start();
if($_SESSION['validUser'] == 'yes') {
require_once('./inc/GroceryLists.class.php');

$list = new GroceryLists();

$listDataArray = array();
$listErrorsArray = array();

// load the faq if we have it
if (isset($_REQUEST['listID']) && $_REQUEST['listID'] > 0)
{
    $list->load($_REQUEST['listID']);
    $listDataArray = $list->listData;
}

// apply the data if we have new data
if (isset($_POST['Save'])) {
    $listDataArray = $_POST;
    //var_dump($listDataArray);die;
    //sanitize
    $listDataArray = $list->sanitize($listDataArray);
    //var_dump("sanitized");
    $list->set($listDataArray);
    //var_dump($user);
    //validate
    if ($list->validate())
    {
      //var_dump($user);
        //  save
        if ($list->save())
        {
          //var_dump($listDataArray);
          if($listDataArray['status'] == "current") {
            if($list->getListInfo($listDataArray['status'], $listDataArray['listDate'])) {
              $listID = $list->getListInfo($listDataArray['status'], $listDataArray['listDate']);
              unset($_SESSION['currentList']);
              unset($_SESSION['currentListID']);
              $_SESSION['currentList'] = $listDataArray['listDate'];
              $_SESSION['currentListID'] = $listID;
              header("location: groceryMenu.php");
              exit;
            }
          } else {
            header("location: viewPastLists.php");
            exit;
          }

        }
        else
        {
            $listErrorsArray[] = "Save failed";
        }
    }
    else
    {
        $listErrorsArray = $list->errors;
        $listDataArray = $list->listData;
    }

    //var_dump($faqErrorsArray);
  }
    require_once('./tpl/newList.tpl.php');
  } else {
    header('Location: login.php');
    exit;
  }
?>
