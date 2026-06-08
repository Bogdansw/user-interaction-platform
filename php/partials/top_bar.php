<?php
$is_logged_in = $is_logged_in ?? false;
?>
<header class="top-bar" role="banner">
  <div class="top-bar-inner">
    <div class="top-bar-actions">
      <button
        class="top-bar-control theme-toggle"
        type="button"
        aria-label="Comuta tema"
        data-i18n-aria-label="toggleTheme"
        aria-pressed="true"
        data-theme-toggle
      >
        <?= ui_icon('sun', 18, ['class' => 'icon-sun']) ?>
        <?= ui_icon('moon', 18, ['class' => 'icon-moon']) ?>
      </button>

      <div class="lang-switcher" data-lang-switcher>
        <button
          class="top-bar-control lang-toggle"
          type="button"
          aria-label="Schimba limba"
          data-i18n-aria-label="changeLanguage"
          aria-haspopup="listbox"
          aria-expanded="false"
          data-lang-toggle
        >
          <?= ui_icon('language', 18) ?>
          <span class="lang-current" data-lang-label>RO</span>
          <span class="lang-chevron" aria-hidden="true"></span>
        </button>
        <ul class="lang-menu" role="listbox" hidden data-lang-menu>
          <li><button type="button" role="option" data-lang="ro" aria-selected="true">RO - Romana</button></li>
          <li><button type="button" role="option" data-lang="en">EN - English</button></li>
          <li><button type="button" role="option" data-lang="ru">RU - Rusa</button></li>
        </ul>
      </div>

      <a class="btn ghost top-bar-btn" href="contact.php" data-i18n="contact">Contact</a>

      <?php if (!$is_logged_in): ?>
        <a class="btn ghost top-bar-btn" href="login.php" data-i18n="login">Autentificare</a>
        <a class="btn primary top-bar-btn" href="register.php" data-i18n="register">Inregistrare</a>
      <?php else: ?>
        <a class="btn ghost top-bar-btn" href="profile.php" data-i18n="profile">Profil</a>
      <?php endif; ?>
    </div>
  </div>
</header>
