<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grocery List, login, groceries">
    <meta name="keywords" content="Grocery List, login, groceries">
    <meta name="author" content="Erica Manning">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/login.css">
    <title>Joe's Groceries - Log In</title>
  </head>
  <body>
    <header>
      <h1>Joe's Groceries</h1>
    </header>
    <form action="./login.php" method="POST">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="">
<br>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" value="">
<br>
      <button type="reset">Reset</button>
      <button type="submit" name="submitLogin">Log In</button>

    </form>

  </body>
</html>
