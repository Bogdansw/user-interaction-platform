<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ForumHub - Contact</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
</head>
<body>
  <header>
    <p>Navbar ForumHub</p>
  </header>

  <main>
    <h1>Contact</h1>

    <form action="contact.php" method="post">
      <div>
        <label for="name">Nume</label>
        <input type="text" id="name" name="name" required>
      </div>

      <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div>
        <label for="subject">Subiect</label>
        <input type="text" id="subject" name="subject" required>
      </div>

      <div>
        <label for="message">Mesaj</label>
        <textarea id="message" name="message" rows="6" required></textarea>
      </div>

      <button type="submit">Trimite mesaj</button>
    </form>
  </main>

  <aside>
    <p>Informatii contact</p>
  </aside>

  <footer>
    <p>ForumHub</p>
  </footer>
</body>
</html>
