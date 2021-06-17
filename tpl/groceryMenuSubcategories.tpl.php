<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, menu, subcategories, groceries">
    <meta name="keywords" content="Grocery List, menu, subcategories, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries - Menu</title>
    <link rel="stylesheet" href="css/groceryMenu.css">
    <script src=js/index.js></script>
  </head>
  <body>
    <header>
      <h1>Joe's Groceries</h1>
      <a href="index.php"><button>Home</button></a>
      <a href="logout.php"><button>Log Out</button></a>
    </header>

    <main>
      <?php foreach ($categoryList as $categoryData) {?>
        <h1><?php echo $categoryData['categoryName'];?></h1>
      <?php }?>
      <h2>Subcategories</h2>
      <?php
        foreach ($subcategoryList as $subcategoryData) { ?>
          <a href="groceryMenuItems.php?categoryID=<?php echo $_GET['categoryID']; ?>&subcategoryID=<?php echo $subcategoryData['subcategoryID']; ?>"><button><?php echo $subcategoryData['subcategoryName']; ?> <span class="arrow right" /></button></a>
        <?php } ?>

        <a href="subcategoryInput.php?categoryID=<?php echo $_GET['categoryID']; ?>"><button class="add">Add a Subcategory</button></a>
        <a href="groceryMenu.php"><button class="back">Back to Categories</button></a>
    </main>
  </body>
</html>
