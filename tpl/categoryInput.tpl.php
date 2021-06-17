<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, categories, category input, groceries">
    <meta name="keywords" content="Grocery List, categories, category input, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries - New Category</title>
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
        <h1>New Category</h1>
        <span class="error"><?php echo (isset($categoryErrorsArray['categoryName']) ? $categoryErrorsArray['categoryName'] : ''); ?></span><br>
        <label for "categoryName">Category: </label>
        <input type="text" name="categoryName" id="categoryName" value="<?php echo (isset($categoryDataArray['categoryName']) ? $categoryDataArray['categoryName'] : ''); ?>"/>
        <input type="hidden" name="categoryID" value="<?php echo (isset($categoryDataArray['categoryID']) ? $categoryDataArray['categoryID'] : ''); ?>"/>
        <input type="submit" name="Save" value="Save">
      </form>

    </main>
  </body>
</html>
