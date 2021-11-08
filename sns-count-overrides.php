<?php

//***********count.jsoonからTwitterのツイート数＋いいね数を取得***********
function fetch_twitter_count_raw($url) {
    $url = rawurlencode($url);
    $args = array('sslverify' => true);
    $subscribers = wp_remote_get("https://jsoon.digitiminimi.com/twitter/count.json?url=$url", $args);
    $res = '0';
    if (!is_wp_error( $subscribers ) && $subscribers["response"]["code"] === 200) {
      $body = $subscribers['body'];
      $json = json_decode($body);
      $res = ($json->{"count"} ? $json->{"count"} + $json->{"likes"} + 1 : '0');
    }

    // milmemo.net分も合算
    $url = preg_replace("/(.*?)mirumi\.me/", "$1milmemo.net", $url);
    $subscribers = wp_remote_get("https://jsoon.digitiminimi.com/twitter/count.json?url=$url", $args);
    if (!is_wp_error( $subscribers ) && $subscribers["response"]["code"] === 200) {
      $body = $subscribers['body'];
      $json = json_decode($body);
      $res += ($json->{"count"} ? $json->{"count"} + $json->{"likes"} + 1 : 0);
    }
    return intval($res);
}

//***************TwitterのシェアURL出力部分をちょい変更*************
function get_twitter_share_url() {
    $hash_tag = null;
    if (get_twitter_hash_tag()) {
      $hash_tag = '+'.urlencode( get_twitter_hash_tag() );
    }
    return 'https://twitter.com/intent/tweet?text='.urlencode(get_share_page_title()).' - みるめも'.' @milmemo_net&amp;url='.
    urlencode( get_share_page_url() ).$hash_tag.
    get_twitter_via_param(). //ツイートにメンションを含める
    get_twitter_related_param();//ツイート後にフォローを促す
}

//**********************はてブ********************
function fetch_hatebu_count_raw($url){
    $encoded_url = rawurlencode($url);
    $args = array( 'sslverify' => true );
    $response = wp_remote_get( 'http://api.b.st-hatena.com/entry.count?url='.$encoded_url, $args );
    $res = 0;
      if (!is_wp_error( $response ) && $response["response"]["code"] === 200) {
      $body = $response['body'];
      $res = !empty($body) ? $body : 0;
    }

    // milmemo.netの合算
    $url = preg_replace("/(.*?)mirumi\.me/", "$1milmemo.net", $url);
    $response = wp_remote_get("http://api.b.st-hatena.com/entry.count?url=$url", $args);
    if (!is_wp_error( $response ) && $response["response"]["code"] === 200) {
      $body = $response['body'];
      $res += !empty($body) ? $body : 0;
    }
    return intval($res);
}

//**********************feedly********************
function fetch_feedly_count(){
    $count = 0;
    $transient_id = TRANSIENT_FOLLOW_PREFIX.'_feedly';
    if (is_sns_follow_count_cache_enable()) {
      $count = get_transient( $transient_id );
      //_v($count);
      if ( is_numeric($count) ) {
        return $count;
      }
    }
  
    $url = get_bloginfo( 'rss2_url' );
    $res = fetch_feedly_count_raw($url);

    if (is_sns_follow_count_cache_enable() && is_another_scheme_sns_follow_count()) {
      $res = $res + fetch_feedly_count_raw(get_another_scheme_url($url));
    }

    // [add] : milmemo.netの合算
    $res = $res + 234;
  
    if (is_sns_follow_count_cache_enable()) {
      set_transient( $transient_id, $res, HOUR_IN_SECONDS * get_sns_follow_count_cache_interval() );
    }
    return $res;
}

//**********************Pocket********************
function fetch_pocket_count_raw($url){
    $res = 0;
    $url = urlencode($url);
    $query = 'https://widgets.getpocket.com/api/saves?url='.$url;
    $args = array( 'sslverify' => true );
    $result = wp_remote_get($query, $args);
    if (!is_wp_error($result)) {
        $body = isset($result["body"]) ? $result["body"] : null;
        if ($body) {
            $json = json_decode($body);
            $res = isset($json->{'saves'}) ? $json->{'saves'} : 0;
        }
    }
    
    // milmemo.netの合算
    $url = preg_replace("/(.*?)mirumi\.me/", "$1milmemo.net", $url);
    $query = 'https://widgets.getpocket.com/api/saves?url='.$url;
    $args = array( 'sslverify' => true );
    $result = wp_remote_get($query, $args);
    if (!is_wp_error($result)) {
        $body = isset($result["body"]) ? $result["body"] : null;
        if ($body) {
            $json = json_decode($body);
            $res += isset($json->{'saves'}) ? $json->{'saves'} : 0;
        }
    }
    
    return intval($res);
}
