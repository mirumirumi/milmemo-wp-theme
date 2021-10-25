<?php
function generate_the_site_logo_tag($is_header = true){
  $tag = 'div';
  if (!is_singular() && !is_archive() && !is_search() && $is_header) {
    $tag = 'h1';
  }
  if ($is_header) {
    $class = ' logo-header';
  } else {
    $class = ' logo-footer';
  }

  $logo_url = get_the_site_logo_url();
  $footer_logo_ur = get_footer_logo_url();
  if (!$is_header && $footer_logo_ur) {
    $logo_url = $footer_logo_ur;
  }
  if ( $logo_url ) {
    $class .= ' logo-image';
  } else {
    $class .= ' logo-text';
  }

  if ($is_header) {
    $img_class = 'header-site-logo-image';
  } else {
    $img_class = 'footer-site-logo-image';
  }

  //ロゴの幅設定
  $site_logo_width = get_the_site_logo_width();
  $width_attr = null;
  if ($site_logo_width && $is_header) {
    $width_attr = ' width="'.$site_logo_width.'"';
  }
  //ロゴの高さ設定
  $site_logo_height = get_the_site_logo_height();
  $height_attr = null;
  if ($site_logo_height && $is_header) {
    $height_attr = ' height="'.$site_logo_height.'"';
  }
  //パーマリンク設定とホームURLの出力を合わせる
  $home_url = user_trailingslashit(get_home_url());
  $home_url = apply_filters('site_logo_url', $home_url);
  //サイトロゴテキスト（Alt属性）
  $site_logo_text = apply_filters('site_logo_text', get_bloginfo('name'));
  if ($is_header) {
    $home_url = apply_filters('header_site_logo_url', $home_url);
    $site_logo_text = apply_filters('header_site_logo_text', $site_logo_text);
  } else {
    $home_url = apply_filters('footer_site_logo_url', $home_url);
    $site_logo_text = apply_filters('footer_site_logo_text', $site_logo_text);
  }
  $logo_before_tag = '<'.$tag.' class="logo'.$class.'"><a href="'.esc_url($home_url).'" class="site-name site-name-text-link" itemprop="url"><span class="site-name-text" itemprop="name about">';
  $logo_after_tag = '</span></a></'.$tag.'>';
//   if ($logo_url) {
    // $site_logo_tag = '<img class="site-logo-image '.$img_class.'" src="'.$logo_url.'" alt="'.esc_attr($site_logo_text).'"'.$width_attr.$height_attr.'>';
    $site_logo_tag = '<svg id="site-logo" data-name="site-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 152 152" aria-label="みるめも"><title>みるめも</title><desc>みるみのブログ</desc><circle cx="76" cy="76" r="76" style="fill:#604134;stroke:#604134;stroke-miterlimit:10"/><path d="M126.28,71.25c.72,11-.45,14.48.72,16,.57.74,7.27,4.83,10,9,3.28,5,6,10.58-1.82,14.92-4.85,2.68-11.5-2.33-15.27-4.52-1.86,6.32-5.22,22.81-12.45,24.95-16,4.71-10.58-13.76-8-20.8,1.53-4.18,3.85-7.62,3.6-10.53-.14-1.75-2.62-3.72-3.92-4.7C94.32,92,88.29,90.1,82.57,88.2c-3.51,10-8.17,18.85-16,26.13-18.76,17.48-49.74,11-51.76-16.75C13,72.67,30.17,60.67,69.61,66.22,72.78,47.88,66,38.05,47.15,37.3c-6.2-.25-13.56.34-14.3-7.7C31.86,19,44.11,19.4,51.22,20c19.25,1.55,32.62,9.16,36.51,29.08,1.31,6.71.41,13.11-.39,19.81-.22,1.92,17.87,8.5,20.45,9.76.32-2.53.16-5.12.7-7.61C113,50.33,125.57,60.42,126.28,71.25Zm-91.11,29.2c7.11,18.57,34.5-8.93,30.08-16.34-.76-1.26-21.4-4.26-30,.14C30.53,86.67,32.55,93.62,35.17,100.45Z" style="fill:#fff"/></svg>';
//   } else {
    // $site_logo_tag = esc_html($site_logo_text);
//   }
  $all_tag = $logo_before_tag.$site_logo_tag.$logo_after_tag;
  echo apply_filters( 'the_site_logo_tag', $all_tag, $is_header, $home_url, $site_logo_text, $site_logo_width, $site_logo_height );
}
