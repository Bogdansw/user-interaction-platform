<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>userplatform - Acasa</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/layout.css">
  <script src="js/script.js"></script>
</head>
<body class="layout-body">
  <div class="layout">
    <aside class="sidebar sidebar-left">
      <div class="sidebar-content">
        <div class="brand-row">
          <div class="brand-avatar">test</div>
          <div class="brand-name">cod</div>
          <button class="icon-button" type="button" aria-label="Menu">Menu</button>
        </div>

        <div class="search-field">
          <input type="text" placeholder="Search" aria-label="Search">
        </div>

        <nav class="nav-list" aria-label="Main navigation">
          <a class="nav-item active" href="index.php">Home</a>
          <a class="nav-item" href="#">Popular</a>
          <a class="nav-item" href="#">Explore</a>
          <a class="nav-item" href="#">Saved</a>
          <a class="nav-item" href="#">Communities</a>
        </nav>

        <div class="section-label">
          <span>SERVERS</span>
          <button class="icon-button small" type="button" aria-label="Add server">Add</button>
        </div>

        <div class="server-list">
          <div class="server-item">
            <span class="server-dot"></span>
            <span>[server-name]</span>
          </div>
          <div class="server-item">
            <span class="server-dot"></span>
            <span>[server-name]</span>
          </div>
          <div class="server-item">
            <span class="server-dot"></span>
            <span>[server-name]</span>
          </div>
          <div class="server-item">
            <span class="server-dot"></span>
            <span>[server-name]</span>
          </div>
        </div>
      </div>

      <div class="profile-bar">
        <div class="profile-avatar">IN</div>
        <div class="profile-info">
          <span class="profile-name">Itsuki Nakano</span>
          <span class="profile-handle">iliketoeat@quint.net</span>
        </div>
        <button class="icon-button" type="button" aria-label="Profile options">More</button>
      </div>
    </aside>

    <main class="feed-column">
      <div class="feed-inner">
        <div class="feed-header">
          <h1>Feed</h1>
          <button class="btn primary new-post" type="button">New post</button>
        </div>

        <div class="sort-tabs">
          <button class="sort-tab active" type="button">Hot</button>
          <button class="sort-tab" type="button">New</button>
          <button class="sort-tab" type="button">Top</button>
        </div>

        <div class="layout-card">[post-title]</div>
        <div class="layout-card">[post-title]</div>
      </div>
    </main>

    <aside class="sidebar sidebar-right">
      <div class="panel">
        <div class="panel-title">Trending today</div>
        <div class="panel-placeholder">[trending-title]</div>
        <div class="panel-placeholder">[trending-title]</div>
        <div class="panel-placeholder">[trending-title]</div>
      </div>
      <div class="panel">
        <div class="panel-title">Suggested communities</div>
        <div class="panel-placeholder">[community-name]</div>
        <div class="panel-placeholder">[community-name]</div>
      </div>
    </aside>
  </div>
</body>
</html>
