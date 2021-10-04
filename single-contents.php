<?php
/**
 * Cocoon WordPress Theme
 * @author: yhira
 * @link: https://wp-cocoon.com/
 * @license: http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */
if ( !defined( 'ABSPATH' ) ) exit;

///////////////////////////////////////
// 投稿ページのコンテンツ
///////////////////////////////////////?>
<?php //パンくずリストがメイントップの場合
/* ここではなくて<header>内に移動
if (is_single_breadcrumbs_position_main_top()){
  get_template_part('tmp/breadcrumbs');
} 
*/
?>

<?php //本文テンプレート
get_template_part('tmp/content') ?>


<div class="under-entry-content">

  <?php //関連記事上ページ送りナビ
  /*
  if (is_post_navi_position_over_related()) {
    get_template_part('tmp/pager-post-navi');
  } */ ?>

  <?php //関連記事下ページ送りナビ（場所移動させた）
  if (is_post_navi_position_under_related()) {
    get_template_part('tmp/pager-post-navi');
  } ?>

  <?php /* //テスト中で非表示（20210108~）
  <div class="relation-contents">関連しそうな記事</div>
  <ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-2873410957106428"
     data-ad-slot="2850148528"
     data-matched-content-ui-type="image_sidebyside,image_stacked"
     data-matched-content-rows-num="5,2"
     data-matched-content-columns-num="1,2"></ins>
  <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
  */ ?>

  <?php /* get_template_part('tmp/related-entries'); //関連記事  */ ?>

  <?php /* //関連記事下の広告表示 
  if (is_ad_pos_below_related_posts_visible() && is_all_adsenses_visible()){
    get_template_part_with_ad_format(get_ad_pos_below_related_posts_format(), 'ad-below-related-posts', is_ad_pos_below_related_posts_label_visible());
  }; */ ?>

  <?php //投稿関連記事下ウイジェット
  if ( is_active_sidebar( 'below-single-related-entries' ) ): ?>
    <?php dynamic_sidebar( 'below-single-related-entries' ); ?>
  <?php endif; ?>

  <?php //コメントを表示する場合
  if (is_single_comment_visible()) {
    comments_template(); //コメントテンプレート
  } ?>

  <?php //コメントフォーム下ウイジェット
  if ( is_active_sidebar( 'below-single-comment-form' ) ): ?>
    <?php dynamic_sidebar( 'below-single-comment-form' ); ?>
  <?php endif; ?>

  <?php //コメント下ページ送りナビ
  if (is_post_navi_position_under_comment()) {
    get_template_part('tmp/pager-post-navi');
  } ?>

</div>

<?php /* //パンくずリストがメインボトムの場合
if (is_single_breadcrumbs_position_main_bottom()){
  get_template_part('tmp/breadcrumbs');
} */ ?>

<?php //メインカラム追従領域
get_template_part('tmp/main-scroll'); ?>
