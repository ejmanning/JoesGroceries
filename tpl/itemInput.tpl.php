<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, items, input, groceries">
    <meta name="keywords" content="Grocery List, items, input, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries - New Item</title>
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
      <form action="<?php echo $_SERVER['SCRIPT_NAME']?>?categoryID=<?php foreach ($categoryList as $categoryData) { echo $categoryData['categoryID']; }?>&subcategoryID=<?php foreach ($subcategoryList as $subcategoryData) { echo $subcategoryData['subcategoryID']; }?>" method="post">

        <h1>New Item for <?php foreach ($subcategoryList as $subcategoryData) {echo $subcategoryData['subcategoryName']; }?> </h1>
        <span class="error"><?php echo (isset($itemErrorsArray['itemName']) ? $itemErrorsArray['itemName'] : ''); ?></span><br>
        <label for "itemName">Item: </label>
        <input type="text" name="itemName" id="itemName" value="<?php echo (isset($itemDataArray['itemName']) ? $itemDataArray['itemName'] : ''); ?>"/>
        <input type="hidden" name="itemID" value="<?php echo (isset($itemDataArray['itemID']) ? $itemDataArray['itemID'] : ''); ?>"/>
        <input type="hidden" name="subcategoryID" value="<?php echo $subcategoryData['subcategoryID']?>"/>
        <input type="hidden" name="categoryID" value="<?php echo $subcategoryData['categoryID']?>"/>
        <input type="submit" name="Save" value="Save">
      </form>

    </main>
  </body>
</html>
