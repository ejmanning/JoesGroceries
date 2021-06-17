<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, menu, categories, groceries">
    <meta name="keywords" content="Grocery List, menu, categories, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries - Menu</title>
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
      <?php
        foreach ($categoryList as $categoryData) { ?>
          <a href="groceryMenuSubcategories.php?categoryID=<?php echo $categoryData['categoryID'] ?>"><button><?php echo $categoryData['categoryName']; ?> <span class="arrow right" /></button></a>
        <?php } ?>

        <a href="categoryInput.php"><button class="add">Add a Category</button></a>

    </main>
  </body>
</html>
