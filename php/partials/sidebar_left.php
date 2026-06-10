<?php
$active_page = $active_page ?? 'home';
$is_logged_in = $is_logged_in ?? false;
$user = $user ?? current_user();
$messages = $messages ?? read_json_file(dirname(__DIR__, 2) . '/data/messages.json', []);
$notification_count = $is_logged_in ? count($messages) : 0;
$platform = platform_name();
$brand_logo = brand_logo_path();
$display_name = $is_logged_in ? ($user['name'] ?? 'User') : 'Oaspete';
$profile_initials = $is_logged_in ? user_initials($user['name'] ?? 'User', 'US') : 'GU';
$profile_avatar_url = $is_logged_in ? clean_value($user['avatarUrl'] ?? '') : '';
$joined_servers = $joined_servers ?? [];

$main_nav = [
  ['key' => 'home', 'href' => 'index.php', 'icon' => 'home', 'label' => 'Home'],
  ['key' => 'popular', 'href' => 'popular.php', 'icon' => 'popular', 'label' => 'Popular'],
  ['key' => 'explore', 'href' => 'explore.php', 'icon' => 'explore', 'label' => 'Explore'],
  ['key' => 'saved', 'href' => 'saved.php', 'icon' => 'saved', 'label' => 'Saved'],
  ['key' => 'communities', 'href' => 'communities.php', 'icon' => 'communities', 'label' => 'Communities'],
  ['key' => 'contact', 'href' => 'contact.php', 'icon' => 'support', 'label' => 'Contact'],
];

$utility_nav = [
  ['key' => 'notifications', 'href' => 'notifications.php', 'icon' => 'notifications', 'label' => 'Notifications'],
  ['key' => 'support', 'href' => 'support.php', 'icon' => 'support', 'label' => 'Support'],
  ['key' => 'settings', 'href' => 'profile.php', 'icon' => 'settings', 'label' => 'Settings'],
];
$info_is_active = in_array($active_page, ['about', 'features'], true);
?>
<aside class="sidebar sidebar-left">
  <div class="sidebar-content">
    <div class="brand-row">
      <a class="brand-link" href="index.php" aria-label="<?= htmlspecialchars($platform) ?>">
        <?php if ($brand_logo !== ''): ?>
          <span class="brand-logo-frame">
            <img class="brand-logo" src="<?= htmlspecialchars(asset_version($brand_logo)) ?>" alt="<?= htmlspecialchars($platform) ?>">
          </span>
        <?php else: ?>
          <span class="brand-mark" aria-hidden="true">
            <span class="brand-mark-text">up</span>
            <span class="brand-mark-star"></span>
          </span>
        <?php endif; ?>
        <span class="brand-name"><?= htmlspecialchars($platform) ?></span>
      </a>
      <button class="icon-button icon-button-menu" type="button" aria-label="Menu" aria-expanded="true" data-i18n-aria-label="menu" data-sidebar-toggle>
        <span class="menu-bars" aria-hidden="true"></span>
      </button>
    </div>

    <div class="search-field">
      <span class="input-icon" aria-hidden="true"><?= ui_icon('search', 14) ?></span>
      <input id="server-search" type="text" placeholder="Search" aria-label="Search" data-i18n-placeholder="search" data-i18n-aria-label="search">
    </div>

    <nav class="nav-list" aria-label="Main navigation">
      <?php foreach ($main_nav as $item): ?>
        <a class="nav-item<?= $active_page === $item['key'] ? ' active' : '' ?>" href="<?= htmlspecialchars($item['href']) ?>">
          <?= ui_icon($item['icon'], 18) ?>
          <span data-i18n="<?= htmlspecialchars($item['key']) ?>"><?= htmlspecialchars($item['label']) ?></span>
        </a>
      <?php endforeach; ?>
    </nav>

    <?php if ($is_logged_in && count($joined_servers) > 0): ?>
      <div class="section-label">
        <span>SERVERS</span>
        <button class="icon-button small" type="button" aria-label="Add server">+</button>
      </div>

      <nav class="server-list" id="server-list" aria-label="Servers" data-server-list>
        <?php foreach ($joined_servers as $server): ?>
          <div class="server-item" data-server-name="<?= htmlspecialchars($server['name']) ?>">
            <span class="server-dot" style="background: <?= htmlspecialchars($server['color']) ?>;">
              <?= htmlspecialchars($server['initial']) ?>
            </span>
            <span><?= htmlspecialchars($server['name']) ?></span>
          </div>
        <?php endforeach; ?>
      </nav>
    <?php endif; ?>

    <?php if ($is_logged_in): ?>
      <nav class="nav-list nav-utilities" aria-label="Utilities">
        <?php foreach ($utility_nav as $item): ?>
          <a class="nav-item<?= $active_page === $item['key'] ? ' active' : '' ?>" href="<?= htmlspecialchars($item['href']) ?>" aria-label="<?= htmlspecialchars($item['label']) ?>">
            <?php if ($item['key'] === 'notifications'): ?>
              <span class="icon-wrapper">
                <?= ui_icon($item['icon'], 18) ?>
                <?php if ($notification_count > 0): ?>
                  <span class="badge"><?= htmlspecialchars((string) $notification_count) ?></span>
                <?php endif; ?>
              </span>
            <?php else: ?>
              <?= ui_icon($item['icon'], 18) ?>
            <?php endif; ?>
            <span data-i18n="<?= htmlspecialchars($item['key']) ?>"><?= htmlspecialchars($item['label']) ?></span>
          </a>
        <?php endforeach; ?>
        <div class="nav-group<?= $info_is_active ? ' active' : '' ?>" data-info-nav>
          <button class="nav-item nav-dropdown-toggle<?= $info_is_active ? ' active' : '' ?>" type="button" aria-expanded="<?= $info_is_active ? 'true' : 'false' ?>" data-info-toggle>
            <?= ui_icon('despre', 18) ?>
            <span data-i18n="info">Info</span>
            <span class="nav-chevron" aria-hidden="true"></span>
          </button>
          <div class="nav-sublist"<?= $info_is_active ? '' : ' hidden' ?> data-info-menu>
            <a class="nav-subitem<?= $active_page === 'about' ? ' active' : '' ?>" href="about.php" data-i18n="about">Despre</a>
            <a class="nav-subitem<?= $active_page === 'features' ? ' active' : '' ?>" href="features.php" data-i18n="features">Functionalitati</a>
          </div>
        </div>
      </nav>
    <?php endif; ?>
  </div>

  <div class="profile-bar">
    <div class="profile-avatar">
      <?php if ($profile_avatar_url !== ''): ?>
        <img src="<?= htmlspecialchars($profile_avatar_url) ?>" alt="">
      <?php else: ?>
        <?= htmlspecialchars($profile_initials) ?>
      <?php endif; ?>
    </div>
    <div class="profile-info">
      <span class="profile-name"><?= htmlspecialchars($display_name) ?></span>
    </div>
    <?php if ($is_logged_in): ?>
      <a class="icon-button" href="logout.php" aria-label="Deconectare">
        <?= ui_icon('logout', 16) ?>
      </a>
    <?php else: ?>
      <a class="icon-button" href="login.php" aria-label="Autentificare">
        <?= ui_icon('logout', 16) ?>
      </a>
    <?php endif; ?>
  </div>
</aside>
