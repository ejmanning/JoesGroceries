<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, current list, groceries">
    <meta name="keywords" content="Grocery List, current, list, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries - Current List</title>
    <link rel="stylesheet" href="css/list.css">
    <script src="js.index.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
      <h1>Joe's Groceries</h1>
      <a href="index.php"><button>Home</button></a>
      <a href="logout.php"><button>Log Out</button></a>
    </header>

    <main>
      <?php
        foreach ($listList as $listData) {
          if($listData['userID'] == $_SESSION['userID']) { ?>
          <?php
            $formattedListDate = date("F jS, Y", strtotime($listData['listDate']));
          ?>
          <div class="lists"><h1>Grocery List for <?php echo $formattedListDate; ?></h1>
            <a href="newList.php?listID=<?php echo $listData['listID'] ?>"><button>Edit List Info</button></a><br>
            <a href="groceryMenu.php"><button class="add">Add More Items to List</button></a><br>
            <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
              <input type="hidden" name="listDate" value=<?php echo $listData['listDate'] ?>>
              <input type="hidden" name="listID" value=<?php echo $listData['listID'] ?>>
              <input type="hidden" name="userID" value=<?php echo $listData['userID'] ?>>
              <input type="hidden" name="status" value="past">
              <input type="submit" name="markAsDone" id="markAsDone" value="Mark as Done">
            </form></div><br>
            <?php
              foreach ($itemNamesList as $itemNamesData) {
              foreach ($itemsOnListList as $itemsOnListData) {
              if($listData['listID'] === $itemsOnListData['listID']) {
                if($itemsOnListData['itemID'] === $itemNamesData['itemID']) {
                  if($itemsOnListData['checked'] == "checked") {?>

                    <div class="itemsOnListChecked">
                      <form id="changeToUnchecked" name="checked" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                        <input type="hidden" name="itemID" value=<?php echo $itemsOnListData['itemID']?>>
                        <input type="hidden" name="itemQuantity" value=<?php echo $itemsOnListData['itemQuantity']?>>
                        <input type="hidden" name="itemMeasurement" value=<?php echo $itemsOnListData['itemMeasurement']?>>
                        <input type="hidden" name="listID" value=<?php echo $itemsOnListData['listID']?>>
                        <input type="hidden" name="checked" value="">
                        <input type="submit" value="✓" name="checkedStatus" class="checked"><?php echo $itemsOnListData['itemQuantity']; ?> <?php echo $itemsOnListData['itemMeasurement']; ?> <?php echo $itemNamesData['itemName'];?>
                      </form>
                    </div><br>
                  <?php } else { ?>
                    <div class="itemsOnListUnchecked">
                      <form id="changeToChecked" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                        <input type="hidden" name="itemID" value=<?php echo $itemsOnListData['itemID']?>>
                        <input type="hidden" name="itemQuantity" value=<?php echo $itemsOnListData['itemQuantity']?>>
                        <input type="hidden" name="itemMeasurement" value=<?php echo $itemsOnListData['itemMeasurement']?>>
                        <input type="hidden" name="listID" value=<?php echo $itemsOnListData['listID']?>>
                        <input type="hidden" name="checked" value="checked">
                        <input type="submit" value=" " name="checkedStatus" class="unchecked"><?php echo $itemsOnListData['itemQuantity']; ?> <?php echo $itemsOnListData['itemMeasurement']; ?> <?php echo $itemNamesData['itemName'];?>
                      </form>
                    </div><br>
                    <?php }?>
                  <?php }?>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
            <?php } ?>
        <?php } ?>

        <button onclick="window.print()">Print this List</button><br>
        <a href="newList.php"><button class="add">Create New List</button></a><br>
        <a href="viewPastLists.php"><button class="add">View Past Lists</button></a>
    </main>
  </body>
</html>
