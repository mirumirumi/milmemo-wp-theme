<?php

function url_to_external_ogp_blogcard_tag($url){
    if ( !$url ) return;
    $url = strip_tags($url);//URL
    if (preg_match('/.+(\.mp3|\.midi|\.mp4|\.mpeg|\.mpg|\.jpg|\.jpeg|\.png|\.gif|\.svg|\.pdf)$/i', $url, $m)) {
      return;
    }
    $url = ampersand_urldecode($url);
    $params = get_url_params($url);
    $user_title = !empty($params['title']) ? $params['title'] : null;
    $user_snippet = !empty($params['snippet']) ? $params['snippet'] : null;
    //$url = add_query_arg(array('title' => null, 'snippet' => null), $url);
    //_v($url);
  
    $url_hash = TRANSIENT_BLOGCARD_PREFIX.md5( $url );
    $error_title = $url; //エラーの場合はURLを表示
    $title = $error_title;
    $error_image = get_site_screenshot_url($url);
  
    $image = $error_image;
    $snippet = '';
    $error_rel_nofollow = ' rel="nofollow"';
  
  
  
    require_once abspath(__FILE__).'open-graph.php';
    //ブログカードキャッシュ更新モード、もしくはログインユーザー以外のときはキャッシュの取得
    if ( !(is_external_blogcard_refresh_mode() && is_user_administrator()) ) {
      //保存したキャッシュを取得
      $ogp = get_transient( $url_hash );
    }
  
    if ( empty($ogp) ) {
      $ogp = OpenGraphGetter::fetch( $url );
      //_v($ogp);
      if ( $ogp == false ) {
        $ogp = 'error';
      } else {
        //キャッシュ画像の取得
        $res = fetch_card_image($ogp->image, $url);
  
        if ( $res ) {
          $ogp->image = $res;
        }
  
        if ( isset( $ogp->title ) && $ogp->title )
          $title = $ogp->title;//タイトルの取得
  
        if ( isset( $ogp->description ) && $ogp->description )
          $snippet = $ogp->description;//ディスクリプションの取得
  
        if ( isset( $ogp->image ) && $ogp->image )
          $image = $ogp->image;////画像URLの取得
  
        $error_rel_nofollow = null;
      }
  
      set_transient( $url_hash, $ogp,
                     DAY_IN_SECONDS * intval(get_external_blogcard_cache_retention_period()) );
  
    } elseif ( $ogp == 'error' ) {
      //前回取得したとき404ページだったら何も出力しない
    } else {
      if ( isset( $ogp->title ) && $ogp->title )
        $title = $ogp->title;//タイトルの取得
  
      if ( isset( $ogp->description ) && $ogp->description )
        $snippet = $ogp->description;//ディスクリプションの取得
  
      if ( isset( $ogp->image ) && $ogp->image )
        $image = $ogp->image;//画像URLの取得
  
      $error_rel_nofollow = null;
    }
    //var_dump($image);
  
    //ドメイン名を取得
    $domain = get_domain_name(isset($ogp->url) ? punycode_decode($ogp->url) : punycode_decode($url));
  
    //og:imageが相対パスのとき
    if(!$image || (strpos($image, '//') === false) || (is_ssl() && (strpos($image, 'https:') === false))){    // //OGPのURL情報があるか
      //相対パスの時はエラー用の画像を表示
      $image = $error_image;
    }
    $title = strip_tags($title);
    if ($user_title) {
      $title = $user_title;
    }
    //タイトルのフック
    $title = apply_filters('cocoon_blogcard_title',$title);
    $title = apply_filters('cocoon_external_blogcard_title',$title);
  
  
    $image = strip_tags($image);
  
    $snippet = get_content_excerpt( $snippet, 160 );
    $snippet = strip_tags($snippet);
    if ($user_snippet) {
      $snippet = $user_snippet;
    }
    $snippet = apply_filters( 'cocoon_blogcard_snippet', $snippet );
    $snippet = apply_filters( 'cocoon_external_blogcard_snippet', $snippet );
  
    //新しいタブで開く場合
    $target = is_external_blogcard_target_blank() ? ' target="_blank"' : '';
  
    $rel = '';
    if (is_external_blogcard_target_blank()) {
      $rel = ' rel="noopener"';
    }
    //コメント内でブログカード呼び出しが行われた際はnofollowをつける
    global $comment; //コメント内以外で$commentを呼び出すとnullになる
    if (is_external_blogcard_target_blank() && $comment) {
      $rel = ' rel="nofollow noopener"';
    }
  
    //GoogleファビコンAPIを利用する
    ////www.google.com/s2/favicons?domain=nelog.jp
    $favicon_tag = '<div class="blogcard-favicon external-blogcard-favicon">'.
      get_original_image_tag('https://www.google.com/s2/favicons?domain='.$domain, 16, 16, 'blogcard-favicon-image external-blogcard-favicon-image').
    '</div>';
  
    //サイトロゴ
    $site_logo_tag = '<div class="blogcard-domain external-blogcard-domain">'.$domain.'</div>';
    $site_logo_tag = '<div class="blogcard-site external-blogcard-site">'.$favicon_tag.$site_logo_tag.'</div>';
  
    //サムネイルを取得できた場合
    $image = apply_filters('get_external_blogcard_thumbnail_url', $image);
    if ( $image ) {
      $thumbnail = get_original_image_tag($image, THUMB160WIDTH, THUMB160HEIGHT, 'blogcard-thumb-image external-blogcard-thumb-image');
    }
  
    //取得した情報からブログカードのHTMLタグを作成
    $tag =
    '<a href="'.esc_url($url).'" title="'.esc_attr($title).'" class="blogcard-wrap external-blogcard-wrap a-wrap cf"'.$target.$rel.'>'.
      '<div class="blogcard external-blogcard'.get_additional_external_blogcard_classes().' cf">'.
        '<div class="blogcard-label external-blogcard-label">'.
          '<span class="fa"></span>'.
        '</div>'.
        '<figure class="blogcard-thumbnail external-blogcard-thumbnail">'.$thumbnail.'</figure>'.
        '<div class="blogcard-content external-blogcard-content">'.
          '<div class="blogcard-title external-blogcard-title">'.$title.'</div>'.
          '<div class="blogcard-snippet external-blogcard-snippet">'.$snippet.'</div>'.
          '<div class="blogcard-footer external-blogcard-footer cf">'.$site_logo_tag.'</div>'.
        '</div>'.
      '</div>'.
    '</a>';
  
    return $tag;
}


