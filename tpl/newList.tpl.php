<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, new list, groceries">
    <meta name="keywords" content="Grocery List, new, list, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries - New List</title>
    <link rel="stylesheet" href="css/groceryMenu.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
      <h1>Joe's Groceries</h1>
      <a href="index.php"><button>Home</button></a>
      <a href="logout.php"><button>Log Out</button></a>
    </header>

    <main>
      <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
        <?php if(isset($listDataArray['listDate'])) { ?>
          <h1>Edit List</h1>
        <?php } else { ?>
          <h1>New List</h1>
        <?php } ?>
        <span class="error"><?php echo (isset($listErrorsArray['listDate']) ? $listErrorsArray['listDate'] : ''); ?></span><br>
        <label for "listDate">Date: </label>
        <input type="date" name="listDate" id="listDate" value="<?php echo (isset($listDataArray['listDate']) ? $listDataArray['listDate'] : ''); ?>"/><br>
        <?php  if(isset($listDataArray['status']) && $listDataArray['status'] === "past") { ?>
          <label for "status">List Status: </label><br>
          <input type="radio" name="status" id="current" value="current">Current</input>
          <input type="radio" name="status" id="past" checked value="past">Past</input><br>
        <?php } else if(isset($listDataArray['status']) && $listDataArray['status'] === "current") { ?>
          <label for "status">List Status: </label><br>
          <input type="radio" name="status" id="current" checked value="current">Current</input>
          <input type="radio" name="status" id="past" value="past">Past</input><br>
        <?php } else if(!isset($listDataArray['status'])) { ?>
          <input type="hidden" name="status" id="current" checked value="current"></input>
        <?php }?>
        <input type="hidden" name="listID" value="<?php echo (isset($listDataArray['listID'])) ?>"/>
        <input type="hidden" name="userID" value="<?php echo (isset($listDataArray['userID']) ? $listDataArray['userID'] : $_SESSION['userID']); ?>"/>
        <input type="submit" name="Save" value="Save">
      </form>

    </main>
  </body>
</html>
