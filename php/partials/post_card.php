<?php
$post = $post ?? [];
$can_interact = $can_interact ?? false;
$current_user = $current_user ?? current_user();

$post_id = (string) ($post['id'] ?? '');
$title = (string) ($post['title'] ?? '');
$excerpt = (string) ($post['excerpt'] ?? '');
$type = (string) ($post['type'] ?? 'discussion');
$community = (string) ($post['community'] ?? '');
$community_color = (string) ($post['communityColor'] ?? '#2e384f');
$community_icon_url = (string) ($post['communityIconUrl'] ?? '');
$author = (string) ($post['author'] ?? '');
$media_url = (string) ($post['mediaUrl'] ?? '');
$liked_by = normalize_id_list($post['likedBy'] ?? []);
$disliked_by = normalize_id_list($post['dislikedBy'] ?? []);
$saved_by = normalize_id_list($post['savedBy'] ?? []);
$post_comments = is_array($post['commentsList'] ?? null) ? $post['commentsList'] : [];
$upvotes = count($liked_by) - count($disliked_by);
$comments = count_comments($post_comments);
$created_at = (string) ($post['createdAt'] ?? '');
$badge = badge_config($type);
$is_author = $current_user && (string) ($post['authorId'] ?? '') === (string) ($current_user['id'] ?? '');
$current_user_id = (string) ($current_user['id'] ?? '');
$has_liked = $current_user_id !== '' && in_array($current_user_id, $liked_by, true);
$has_disliked = $current_user_id !== '' && in_array($current_user_id, $disliked_by, true);
$has_saved = $current_user_id !== '' && in_array($current_user_id, $saved_by, true);
?>
<article class="post-card" id="post-<?= htmlspecialchars($post_id) ?>" aria-label="<?= htmlspecialchars($title) ?>" data-upvotes="<?= htmlspecialchars((string) $upvotes) ?>" data-created-at="<?= htmlspecialchars($created_at) ?>">
  <div class="post-meta">
    <span class="community-dot" style="background: <?= htmlspecialchars($community_color) ?>;">
      <?php if ($community_icon_url !== ''): ?>
        <img src="<?= htmlspecialchars($community_icon_url) ?>" alt="">
      <?php else: ?>
        <?= htmlspecialchars(strtoupper(substr($community, 0, 1))) ?>
      <?php endif; ?>
    </span>
    <span class="community-name"><?= htmlspecialchars($community) ?></span>
    <span class="post-badge <?= htmlspecialchars($badge['class']) ?>"><?= htmlspecialchars($badge['label']) ?></span>
  </div>

  <?php if ($media_url !== ''): ?>
    <div class="post-media">
      <img src="<?= htmlspecialchars($media_url) ?>" alt="">
      <div class="post-media-title"><?= htmlspecialchars($title) ?></div>
    </div>
  <?php else: ?>
    <div class="post-text">
      <?php if ($excerpt !== ''): ?>
        <p class="post-excerpt"><?= htmlspecialchars($excerpt) ?></p>
      <?php endif; ?>
      <h2 class="post-title"><?= htmlspecialchars($title) ?></h2>
    </div>
  <?php endif; ?>

  <div class="post-actions" aria-label="Actiuni postare">
    <form method="post" action="php/post_actions.php">
      <input type="hidden" name="action" value="post_like">
      <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
      <button class="post-action<?= $has_liked ? ' active' : '' ?>" type="submit" aria-label="Like"<?= $can_interact ? '' : ' disabled' ?>>
        <?= ui_icon('like', 16) ?>
        <span class="count"><?= htmlspecialchars((string) $upvotes) ?></span>
      </button>
    </form>
    <form method="post" action="php/post_actions.php">
      <input type="hidden" name="action" value="post_dislike">
      <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
      <button class="post-action<?= $has_disliked ? ' active' : '' ?>" type="submit" aria-label="Dislike"<?= $can_interact ? '' : ' disabled' ?>>
        <?= ui_icon('dislike', 16) ?>
      </button>
    </form>
    <span class="action-divider"></span>
    <div class="post-meta-right">
      <button class="post-action" type="button" aria-label="Comments" data-comments-toggle>
        <?= ui_icon('comments', 16) ?>
        <span class="count"><?= htmlspecialchars((string) $comments) ?></span>
      </button>
      <form method="post" action="php/post_actions.php">
        <input type="hidden" name="action" value="post_save">
        <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
        <button class="post-action<?= $has_saved ? ' active' : '' ?>" type="submit" aria-label="Save"<?= $can_interact ? '' : ' disabled' ?>>
          <?= ui_icon('saved', 16) ?>
        </button>
      </form>
      <span class="meta-sep">&middot;</span>
      <span class="time-ago"><?= htmlspecialchars(format_time_ago($created_at)) ?></span>
    </div>
    <div class="post-author">
      <span class="author-avatar"></span>
      <span class="author-name"><?= htmlspecialchars($author) ?></span>
    </div>
    <?php if ($is_author && $post_id !== ''): ?>
      <a class="post-edit-link" href="post.php?id=<?= urlencode($post_id) ?>">Edit</a>
    <?php endif; ?>
  </div>

  <section class="comments-panel" data-comments-panel hidden>
    <?php if ($can_interact): ?>
      <form class="comment-form" method="post" action="php/post_actions.php">
        <input type="hidden" name="action" value="comment_create">
        <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
        <textarea name="body" rows="3" placeholder="Scrie un comentariu..." required></textarea>
        <button class="btn primary small" type="submit">Comenteaza</button>
      </form>
    <?php else: ?>
      <p class="comments-login-hint">Autentifica-te pentru a comenta.</p>
    <?php endif; ?>

    <div class="comment-list">
      <?php if (count($post_comments) === 0): ?>
        <p class="comments-empty">Nu exista comentarii inca.</p>
      <?php else: ?>
        <?php foreach ($post_comments as $comment): ?>
          <?php
            $comment_id = (string) ($comment['id'] ?? '');
            $comment_likes = normalize_id_list($comment['likedBy'] ?? []);
            $comment_dislikes = normalize_id_list($comment['dislikedBy'] ?? []);
            $comment_score = count($comment_likes) - count($comment_dislikes);
          ?>
          <article class="comment-item">
            <div class="comment-body">
              <div class="comment-meta">
                <span class="comment-author"><?= htmlspecialchars((string) ($comment['author'] ?? 'User')) ?></span>
                <span><?= htmlspecialchars(format_time_ago((string) ($comment['createdAt'] ?? ''))) ?></span>
              </div>
              <p><?= htmlspecialchars((string) ($comment['body'] ?? '')) ?></p>
              <div class="comment-actions">
                <form method="post" action="php/post_actions.php">
                  <input type="hidden" name="action" value="comment_like">
                  <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
                  <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment_id) ?>">
                  <button class="post-action<?= in_array($current_user_id, $comment_likes, true) ? ' active' : '' ?>" type="submit"<?= $can_interact ? '' : ' disabled' ?>>
                    <?= ui_icon('like', 14) ?>
                    <span><?= htmlspecialchars((string) $comment_score) ?></span>
                  </button>
                </form>
                <form method="post" action="php/post_actions.php">
                  <input type="hidden" name="action" value="comment_dislike">
                  <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
                  <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment_id) ?>">
                  <button class="post-action<?= in_array($current_user_id, $comment_dislikes, true) ? ' active' : '' ?>" type="submit"<?= $can_interact ? '' : ' disabled' ?>>
                    <?= ui_icon('dislike', 14) ?>
                  </button>
                </form>
                <?php if ($can_interact): ?>
                  <button class="comment-reply-toggle" type="button" data-reply-toggle>Reply</button>
                <?php endif; ?>
              </div>
              <?php if ($can_interact): ?>
                <form class="comment-form reply-form" method="post" action="php/post_actions.php" hidden>
                  <input type="hidden" name="action" value="reply_create">
                  <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
                  <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment_id) ?>">
                  <textarea name="body" rows="2" placeholder="Scrie un reply..." required></textarea>
                  <button class="btn primary small" type="submit">Raspunde</button>
                </form>
              <?php endif; ?>
            </div>

            <?php $replies = is_array($comment['replies'] ?? null) ? $comment['replies'] : []; ?>
            <?php if (count($replies) > 0): ?>
              <div class="reply-list">
                <?php foreach ($replies as $reply): ?>
                  <?php
                    $reply_id = (string) ($reply['id'] ?? '');
                    $reply_likes = normalize_id_list($reply['likedBy'] ?? []);
                    $reply_dislikes = normalize_id_list($reply['dislikedBy'] ?? []);
                    $reply_score = count($reply_likes) - count($reply_dislikes);
                  ?>
                  <article class="comment-item reply-item">
                    <div class="comment-meta">
                      <span class="comment-author"><?= htmlspecialchars((string) ($reply['author'] ?? 'User')) ?></span>
                      <span><?= htmlspecialchars(format_time_ago((string) ($reply['createdAt'] ?? ''))) ?></span>
                    </div>
                    <p><?= htmlspecialchars((string) ($reply['body'] ?? '')) ?></p>
                    <div class="comment-actions">
                      <form method="post" action="php/post_actions.php">
                        <input type="hidden" name="action" value="comment_like">
                        <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
                        <input type="hidden" name="comment_id" value="<?= htmlspecialchars($reply_id) ?>">
                        <button class="post-action<?= in_array($current_user_id, $reply_likes, true) ? ' active' : '' ?>" type="submit"<?= $can_interact ? '' : ' disabled' ?>>
                          <?= ui_icon('like', 14) ?>
                          <span><?= htmlspecialchars((string) $reply_score) ?></span>
                        </button>
                      </form>
                      <form method="post" action="php/post_actions.php">
                        <input type="hidden" name="action" value="comment_dislike">
                        <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
                        <input type="hidden" name="comment_id" value="<?= htmlspecialchars($reply_id) ?>">
                        <button class="post-action<?= in_array($current_user_id, $reply_dislikes, true) ? ' active' : '' ?>" type="submit"<?= $can_interact ? '' : ' disabled' ?>>
                          <?= ui_icon('dislike', 14) ?>
                        </button>
                      </form>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>
</article>
