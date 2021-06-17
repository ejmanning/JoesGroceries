<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, past lists, groceries">
    <meta name="keywords" content="Grocery List, past, lists, groceries">
    <meta name="author" content="Erica Manning">
    <title>Joe's Groceries - Past Lists</title>
    <link rel="stylesheet" href="css/list.css">
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
          if($listData['userID'] == $_SESSION['userID']) {
            $formattedListDate = date("F jS, Y", strtotime($listData['listDate']));
          ?>
          <div class="lists"><h1>Grocery List for <?php echo $formattedListDate; ?></h1>
            <a href="newList.php?listID=<?php echo $listData['listID'] ?>"><button>Edit List Info</button></a>
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

        <a href="newList.php"><button class="add">Create New List</button></a><br>
        <a href="viewCurrentList.php"><button>View Current List</button></a>

    </main>
  </body>
</html>
