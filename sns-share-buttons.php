<?php //シェアボタン
/**
 * Cocoon WordPress Theme
 * @author: yhira
 * @link: https://wp-cocoon.com/
 * @license: http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */
if ( !defined( 'ABSPATH' ) ) exit; ?>
<?php if ( is_sns_share_buttons_visible($option) ):
//var_dump($option) ?>
<div class="sns-share<?php echo esc_attr(get_additional_sns_share_button_classes($option)); ?>">
  <?php if ( get_sns_bottom_share_message() && $option == SS_BOTTOM ): //シェアボタン用のメッセージを取得?>
    <div class="sns-share-message"><?php echo get_sns_bottom_share_message(); ?></div>
  <?php endif; ?>

  <div class="sns-share-buttons sns-buttons">

    <?php $comment_out = <<<EOT
    <?php if ( is_facebook_share_button_visible($option) )://Facebookボタン ?>
        <a href="<?php echo esc_url(get_facebook_share_url()); ?>" class="share-button facebook-button facebook-share-button-sq" target="_blank" rel="nofollow noopener noreferrer">
        <svg style="width:17px;height:27px;transform:scale(0.87);"><path fill="#fff" d="M14.984 0.187v4.125h-2.453c-1.922 0-2.281 0.922-2.281 2.25v2.953h4.578l-0.609 4.625h-3.969v11.859h-4.781v-11.859h-3.984v-4.625h3.984v-3.406c0-3.953 2.422-6.109 5.953-6.109 1.687 0 3.141 0.125 3.563 0.187z"></path></svg>
        <?php /*if(!get_facebook_count() == 0){*/ ?><span class="snsbadge"><?php echo get_facebook_count(); ?></span><?php /*}*/ ?></a>
    <?php endif; ?>
EOT;
    ?>

    <?php if ( is_twitter_share_button_visible($option) )://Twitterボタン ?>
    <div class="sns-buttons-wrap">
      <a href="<?php echo esc_url(get_twitter_share_url()); ?>" class="share-button twitter-button twitter-share-button-sq" target="_blank" rel="nofollow noopener noreferrer">
        <svg style="width:32px;height:31.9px;transform:scale(1.3);"><path fill="#8cbadb" d="M31.939 6.092c-1.18 0.519-2.44 0.872-3.767 1.033 1.352-0.815 2.392-2.099 2.884-3.631-1.268 0.74-2.673 1.279-4.169 1.579-1.195-1.279-2.897-2.079-4.788-2.079-3.623 0-6.56 2.937-6.56 6.556 0 0.52 0.060 1.020 0.169 1.499-5.453-0.257-10.287-2.876-13.521-6.835-0.569 0.963-0.888 2.081-0.888 3.3 0 2.28 1.16 4.284 2.917 5.461-1.076-0.035-2.088-0.331-2.971-0.821v0.081c0 3.18 2.257 5.832 5.261 6.436-0.551 0.148-1.132 0.228-1.728 0.228-0.419 0-0.82-0.040-1.221-0.115 0.841 2.604 3.26 4.503 6.139 4.556-2.24 1.759-5.079 2.807-8.136 2.807-0.52 0-1.039-0.031-1.56-0.089 2.919 1.859 6.357 2.945 10.076 2.945 12.072 0 18.665-9.995 18.665-18.648 0-0.279 0-0.56-0.020-0.84 1.281-0.919 2.4-2.080 3.28-3.397z"></path></svg>
      </a>
      <span class="snsbadge" style="color: #8cbadb;"><?php echo fetch_twitter_count(get_permalink()); ?></span>
    </div>
    <?php endif; ?>

    <?php if ( is_hatebu_share_button_visible($option) )://はてなボタン ?>
    <div class="sns-buttons-wrap">
      <a href="<?php echo esc_url(get_hatebu_share_url()); ?>" class="share-button hatebu-button hatena-bookmark-button hatebu-share-button-sq" data-hatena-bookmark-layout="simple" target="_blank" rel="nofollow noopener noreferrer">
        <svg style="width:38px;height:32px;transform:scale(1.13);"><path fill="#72bbe5" d="M2.722 15.915v13.738l6.037-0.030c6.031-0.024 6.745-0.048 8.299-0.26 3.648-0.502 5.928-2.141 6.829-4.912 0.514-1.567 0.526-3.714 0.030-5.287-0.526-1.67-1.639-2.952-3.194-3.684-0.538-0.248-1.494-0.52-2.051-0.581-0.194-0.018-0.363-0.054-0.375-0.079s0.242-0.127 0.563-0.236c1.155-0.393 2.135-0.968 2.795-1.639 1.010-1.010 1.44-2.329 1.373-4.204-0.067-1.833-0.629-3.182-1.803-4.295-0.738-0.702-1.621-1.204-2.74-1.573-1.845-0.599-3.254-0.696-10.574-0.696h-5.19v13.738zM13.762 8.426c1.228 0.266 1.784 0.665 2.105 1.536 0.188 0.514 0.181 1.657-0.006 2.147-0.321 0.811-0.901 1.222-2.081 1.464-0.605 0.127-2.244 0.23-3.254 0.206l-0.817-0.018-0.018-2.746-0.012-2.74 1.827 0.030c1.295 0.024 1.954 0.054 2.256 0.121zM13.919 18.752c0.792 0.085 1.555 0.26 1.954 0.46 0.859 0.43 1.301 1.282 1.307 2.516 0.006 1.809-0.938 2.631-3.279 2.885-0.327 0.036-1.403 0.067-2.408 0.067h-1.815v-5.989h1.809c0.992 0 2.087 0.030 2.432 0.061z"></path><path fill="#72bbe5" d="M29.217 11.342v9.164h6.049v-18.329h-6.049v9.164z"></path><path fill="#72bbe5" d="M31.407 22.805c-0.653 0.175-1.131 0.448-1.621 0.938-0.69 0.69-0.992 1.428-0.992 2.42 0 1.022 0.296 1.73 1.022 2.456 0.708 0.708 1.464 1.022 2.468 1.022 1.149 0 2.202-0.563 2.849-1.53 0.411-0.617 0.587-1.192 0.581-1.918 0-1.016-0.315-1.76-1.047-2.48-0.901-0.895-2.069-1.216-3.261-0.907z"></path></svg>
      </a>
      <span class="snsbadge" style="color: #72bbe5;"><?php echo get_hatebu_count(); ?></span>
    </div>
    <?php endif; ?>

    <?php if ( is_feedly_follow_button_visible() )://Feedlyフォローボタン ?>
    <div class="sns-buttons-wrap">
      <a href="//feedly.com/i/discover/sources/search/feed/<?php echo urlencode(get_site_url()); ?>" class="follow-button feedly-button feedly-follow-button-sq" target="_blank" rel="nofollow noopener noreferrer">
        <svg style="width:32px;height:33.45px;transform:scale(1.2);"><path fill="#9fcc95" d="M18.48 2.652c-0.632-0.644-1.511-1.043-2.484-1.043s-1.852 0.399-2.483 1.043l-0.001 0.001-12.488 12.717c-0.633 0.654-1.024 1.546-1.024 2.53s0.39 1.876 1.024 2.531l-0.001-0.001 8.912 9.077c0.613 0.549 1.427 0.884 2.32 0.885h7.484c0.978-0.001 1.862-0.404 2.495-1.054l0.001-0.001 8.739-8.9c0.634-0.654 1.025-1.546 1.025-2.53s-0.391-1.877-1.026-2.531l0.001 0.001zM18.133 25.881l-1.247 1.267c-0.090 0.094-0.217 0.152-0.357 0.152 0 0 0 0 0 0h-1.067c-0.127-0.001-0.242-0.050-0.33-0.128l0 0-1.272-1.293c-0.090-0.093-0.146-0.221-0.146-0.361s0.056-0.268 0.146-0.361l-0 0 1.783-1.813c0.090-0.092 0.215-0.15 0.354-0.15s0.264 0.057 0.354 0.15l0 0 1.783 1.815c0.091 0.093 0.147 0.221 0.147 0.361s-0.056 0.269-0.148 0.363l0-0zM18.133 18.267l-4.983 5.077c-0.090 0.091-0.216 0.148-0.355 0.148-0.001 0-0.002 0-0.003 0h-1.065c-0.001 0-0.002 0-0.003 0-0.127 0-0.242-0.047-0.331-0.125l0.001 0-1.268-1.293c-0.091-0.094-0.147-0.222-0.147-0.363s0.056-0.269 0.147-0.363l-0 0 5.519-5.619c0.090-0.092 0.215-0.149 0.354-0.149s0.264 0.057 0.354 0.149l0 0 1.783 1.816c0.090 0.093 0.146 0.219 0.146 0.359 0 0.141-0.057 0.268-0.148 0.361l0-0zM18.133 10.657l-8.72 8.88c-0.090 0.093-0.216 0.151-0.356 0.151-0 0-0.001 0-0.001 0h-1.067c-0.001 0-0.001 0-0.002 0-0.127 0-0.243-0.048-0.331-0.126l0 0-1.271-1.296c-0.090-0.093-0.146-0.22-0.146-0.36s0.056-0.267 0.146-0.36l-0 0 9.257-9.427c0.090-0.092 0.215-0.149 0.354-0.149s0.264 0.057 0.354 0.149l0 0 1.783 1.813c0.091 0.093 0.147 0.221 0.147 0.361s-0.056 0.269-0.148 0.363l0-0z"></path></svg>
      </a>
      <span class="snsbadge" style="color: #9fcc95;"><?php echo get_feedly_count(); ?></span>
    </div>
    <?php endif; ?>

    <?php if ( is_pocket_share_button_visible($option) )://pocketボタン ?>
    <div class="sns-buttons-wrap">
      <a href="<?php echo esc_url(get_pocket_share_url()); ?>" class="share-button pocket-button pocket-share-button-sq" target="_blank" rel="nofollow noopener noreferrer">
        <svg style="width:32px;height:31.8px;transform:scale(1.13);"><path fill="#e88992" d="M25.084 13.679l-7.528 7.225c-0.427 0.407-0.973 0.611-1.521 0.611-0.547 0-1.095-0.204-1.521-0.611l-7.528-7.225c-0.876-0.837-0.903-2.228-0.065-3.101 0.84-0.876 2.228-0.905 3.1-0.067l6.015 5.763 6.023-5.763c0.88-0.841 2.263-0.809 3.101 0.065 0.841 0.86 0.82 2.26-0.060 3.101zM31.861 3.617c-0.399-1.144-1.5-1.915-2.721-1.915h-26.235c-1.2 0-2.289 0.752-2.716 1.873-0.125 0.333-0.189 0.681-0.189 1.032v9.66l0.112 1.921c0.464 4.369 2.729 8.189 6.243 10.852 0.060 0.048 0.125 0.093 0.191 0.14l0.040 0.031c1.881 1.373 3.985 2.304 6.259 2.763 1.048 0.211 2.121 0.32 3.185 0.32 0.985 0 1.975-0.089 2.945-0.272 0.117-0.039 0.235-0.060 0.352-0.080 0.031 0 0.065-0.020 0.099-0.039 2.177-0.48 4.197-1.381 6.011-2.7l0.039-0.041 0.18-0.14c3.503-2.66 5.765-6.483 6.248-10.864l0.097-1.921v-9.644c0-0.335-0.041-0.667-0.161-0.989z"></path></svg>
      </a>
      <span class="snsbadge" style="color: #e88992;"><?php echo get_pocket_count(); ?></span>
    </div>
    <?php endif; ?>

    <div class="sns-buttons-wrap">
      <button class="share-button like-button" aria-label="いいね">
        <div class="heart-wrapper">
          <div class="heart">
            <div class="tl"></div>
            <div class="tr"></div>
            <div class="bl"></div>
            <div class="br"></div>
          </div>
          <div class="ring"></div>
          <div class="circles"></div>
        </div>
      </button>
      <?php $like_count = get_record("like_count", preg_replace('/https:\/\/.*?\//im', '', get_permalink()));
      if($like_count != null) { ?>
          <span class="snsbadge"><?php echo $like_count; ?></span>
      <?php } else {?>
          <span class="snsbadge"><?php echo "0"; ?></span>
      <?php }?>
    </div>

  </div><!-- /.sns-share-buttons -->

</div><!-- /.sns-share -->
<?php endif; ?>
