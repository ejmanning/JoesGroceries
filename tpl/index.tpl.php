<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, groceries">
    <meta name="keywords" content="Grocery List, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <title>Joe's Groceries</title>
    <link rel="stylesheet" href="css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
      <div class="welcomeBanner"><h2>Welcome <?php echo $_SESSION['username']; ?>!</h2><a href="logout.php"><button>Log Out</button></a></div>
      <h1>Joe's Groceries</h1>
    </header>

    <main>
      <a href="newList.php"><button>Create New List</button></a>
      <a href="viewCurrentList.php"><button>View Current List</button></a>
      <a href="viewPastLists.php"><button>View Past Lists</button></a>
    </main>
  </body>
</html>
