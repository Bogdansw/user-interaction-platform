<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>userplatform - Login</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
</head>
<body>
  <header>
    <p>Navbar userplatform</p>
  </header>

  <main>
    <h1>Autentificare</h1>

    <form action="login.php" method="post">
      <div>
        <label for="login">Username sau email</label>
        <input type="text" id="login" name="login" required>
      </div>

      <div>
        <label for="password">Parola</label>
        <input type="password" id="password" name="password" required>
      </div>

      <button type="submit">Conectare</button>
    </form>
  </main>

  <aside>
    <p>Link-uri utile</p>
  </aside>

  <footer>
    <p>userplatform</p>
  </footer>
</body>
</html>
