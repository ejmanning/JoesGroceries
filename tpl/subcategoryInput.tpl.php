<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, subcategories, input, groceries">
    <meta name="keywords" content="Grocery List, subcategories, input, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries - New Subcategory</title>
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

      <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>?categoryID=<?php foreach ($categoryList as $categoryData) { echo $categoryData['categoryID']; }?>" method="post">

        <h1>New Subcategory for <?php foreach ($categoryList as $categoryData) {echo $categoryData['categoryName']; }?> </h1>
        <span class="error"><?php echo (isset($subcategoryErrorsArray['subcategoryName']) ? $subcategoryErrorsArray['subcategoryName'] : ''); ?></span><br>
        <label for "subcategoryName">Subcategory: </label>
        <input type="text" name="subcategoryName" id="subcategoryName" value="<?php echo (isset($subcategoryDataArray['subcategoryName']) ? $subcategoryDataArray['subcategoryName'] : ''); ?>"/>
        <input type="hidden" name="subcategoryID" value="<?php echo (isset($subcategoryDataArray['subcategoryID']) ? $subcategoryDataArray['subcategoryID'] : ''); ?>"/>
        <input type="hidden" name="categoryID" value="<?php echo $categoryData['categoryID']?>"/>
        <input type="submit" name="Save" value="Save">
      </form>

    </main>
  </body>
</html>
