<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>userplatform - Inregistrare</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
</head>
<body>
  <header>
    <p>Navbar userplatform</p>
  </header>

  <main>
    <h1>Inregistrare cont</h1>

    <form action="register.php" method="post">
      <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div>
        <label for="password">Parola</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div>
        <label for="confirm_password">Confirma parola</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
      </div>

      <button type="submit">Creeaza cont</button>
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
