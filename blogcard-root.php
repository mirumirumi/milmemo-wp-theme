<?php

function url_shortcode_to_blogcard($the_content) {
//   $reg = '/\[https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+\]/i';
  $reg = '/\[(https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+|\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)\]/i';
  $res = preg_match_all($reg, $the_content, $m);
  if ($res) {
    $pres = preg_match_all('/<p>.*?<\/p>/is', $the_content, $n);
    if ($pres) {
      foreach ($n[0] as $paragraph) {
        if (preg_match($reg, $paragraph)) {
          $div = str_replace('<p>', '<div class="blogcard-shortcode-wrap paragraph">', $paragraph);
          $div = str_replace('</p>', '</div>', $div);
          $the_content = str_replace($paragraph, $div, $the_content);
        }
      }
    }
  }
  foreach ($m[0] as $match) {
    $url = strip_tags($match);//URL
    $url = preg_replace('{[\[\]]}', '', $url);//[と]の除去
    //$url = str_replace('?', '%3F', $url);//?をエンコード


    // "/" から始まるrootパス表記のときに自ホストを足す
    if ($url[0] === "/") {
        $url = "https://".get_the_site_domain().$url;
    }


    //wpForoのブログカードは外部ブログカードに任せる
    if (includes_wpforo_url($url)) {
      continue;
    }

    //取得した内部URLからブログカードのHTMLタグを作成
    $tag = url_to_internal_blogcard_tag($url);//外部ブログカードタグに変換
    //URLをブログカードに変換
    if ( !$tag ) {//取得したURLが外部URLだった場合
      $tag = url_to_external_blog_card($url);//外部ブログカードタグに変換
    }

    if ( $tag ) {//内部・外部ブログカードどちらかでタグを作成できた場合
      //本文中のURLをブログカードタグで置換
      $the_content = preg_replace('{'.preg_quote($match).'}', $tag , $the_content, 1);
    }
  }
  return $the_content;
}
