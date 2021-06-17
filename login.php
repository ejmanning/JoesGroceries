<?php
session_start();
$_SESSION['validUser'] = 'no';
require_once('./inc/Users.class.php');
$user = new Users();

//print "<h1> $message</h1>";
if (isset($_POST['submitLogin']))
{
    $userData = $_POST;
    // sanitize
    $userData = $user->sanitize($userData);
    $user->set($userData);
    $user->authorizeUser($_POST['username'], $_POST['password']);
    if ($userInfo = $user->authorizeUser($_POST['username'], $_POST['password']))
    {

      $_SESSION['userID'] = $userInfo[0];
      $_SESSION['username'] = $userInfo[1];
      $_SESSION['validUser'] = 'yes';
      $_SESSION['userID'] = $userInfo[0];

        header("location: index.php");
        exit;
    }
    else
    {
        echo "Login failed";
    }
}

require_once('./tpl/login.tpl.php');
?>
