<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, menu, items groceries">
    <meta name="keywords" content="Grocery List, menu, items, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries - Menu</title>
    <link rel="stylesheet" href="css/groceryMenuItems.css">
    <script src=js/index.js></script>
  </head>
  <body>
    <header>
      <h1>Joe's Groceries</h1>
      <a href="index.php"><button>Home</button></a>
      <a href="logout.php"><button>Log Out</button></a>
    </header>

    <main>
      <?php foreach ($subcategoryList as $subcategoryData) {?>
        <h1><?php foreach ($categoryList as $categoryData) {echo $categoryData['categoryName'];}?>:<br><?php echo $subcategoryData['subcategoryName'];?></h1>
      <?php }?>
      <h2>Items</h2>
      <?php
        foreach ($itemList as $itemData) { ?>
          <div class="item">
            <form action="<?php echo $_SERVER['SCRIPT_NAME']?>?categoryID=<?php foreach ($categoryList as $categoryData) {echo $categoryData['categoryID'];}?>&subcategoryID=<?php foreach ($subcategoryList as $subcategoryData) {echo $subcategoryData['subcategoryID'];}?>" method="post">
              <label for "itemQuantity">Quantity: </label> <input name="itemQuantity" type="number" />
              <label for "itemMeasurement">Measurement: </label> <input name="itemMeasurement" type="text" />
              <input name="itemID" type="hidden" value="<?php echo $itemData['itemID'];?>" />
              <input name="checked" type="hidden" value="" />
              <input name="listID" type="hidden" value="<?php echo $_SESSION['currentListID']; ?>" />
              <span class="itemName"><?php echo $itemData['itemName']; ?></span>
              <input type="submit" value="Add" name="Add">
            </form>
          </div><br>

        <?php } ?>

        <a href="itemInput.php?categoryID=<?php echo $_GET['categoryID']; ?>&subcategoryID=<?php echo $_GET['subcategoryID']; ?>"><button class="add">Add an Item</button></a>
        <a href="groceryMenuSubcategories.php?categoryID=<?php foreach ($categoryList as $categoryData) {echo $categoryData['categoryID'];}?>"><button class="back">Back to <?php foreach ($categoryList as $categoryData) {echo $categoryData['categoryName'];}?></button></a>
        <a href="viewCurrentList.php"><button>View List</button></a>
    </main>
  </body>
</html>
