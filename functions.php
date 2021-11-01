<?php //子テーマ用関数
if (!defined('ABSPATH')) exit;

//*************子テーマ用のビジュアルエディタースタイルを適用*******************
add_editor_style();

//************Noto SansのWebフォントをビジュアルエディタでも読み込む************
add_editor_style('noto-sans.css');

//*****ビジュアルエディタのCocoonオリジナルメニューをカスタマイズ******
require "visual_editor_custom.php";

//*****エントリーカード系でツールチップが出ないようにする******
require "no-tooltip.php";

//******ヘッダーロゴにSVGを使用するので出力関数を上書きする必要がある***********
require "generate_the_site_logo_tag.php";

//*****ブログカードで /pc-freesoft のようなパス表記に対応させる******
require "blogcard-root.php";

//*****ビジュアルエディタに切り替えで、空のspanタグやiタグが消されるのを防止*****
function delete_stop($init) {
    $init['verify_html'] = false; // 空タグや属性なしのタグを消させない
    $initArray['valid_children'] = '+body[style], +div[div|span|a], +span[span]'; // 指定の子要素を消させない
    return $init;
}
add_filter('tiny_mce_before_init', 'delete_stop', 100);

//****************ヘッダーのDNSプリフェッチのs.w.org"を消す（wordpress.org）***********
add_filter('emoji_svg_url', '__return_false');

//**********************ショートリンク表示削除********************
remove_action('wp_head', 'wp_shortlink_wp_head');

//***************管理画面にもファビコンを表示********************************
function admin_favicon() {
    echo '<link rel="shortcut icon" type="image/x-icon" href="/wp-content/uploads/favicon.ico" />';
}
add_action('admin_head', 'admin_favicon');

//**********************各css,script出力削除******************
function deregister_styles() {
    wp_deregister_style('wp-block-library'); //Gutenbergのcss出力削除
    wp_dequeue_style('contact-form-7'); //contact form7のcss出力削除
    wp_dequeue_style('cocoon-keyframes'); //Cocoonのkeyframes用css出力削除
    wp_dequeue_style('cocoon-style'); //親CSS読み込みやめた

    wp_deregister_script('cocoon-js'); //親JSも読み込みやめたよ
    wp_register_script('cocoon-js', false, array(), false, true ); //下と同じダミー
    wp_register_script('cocoon-child-js', $_SERVER['DOCUMENT_ROOT']."/wp-content/themes/cocoon-child-master/javascript.js"); //親JSも読み込みやめたよ

    // CocoonかWordPressのjQuery-migrateを止める
    wp_deregister_script('jquery-migrate');
    // jquery-migrateを止めるとjavascript.jsも読み込まれないので、ダミーを追加する
    wp_register_script('jquery-migrate', false, array(), false, true );

    // CocoonのjQueryを止めて自分でdefer出力する
    wp_deregister_script('jquery-core');
    // jquery-coreも止めるとjavascript.jsも読み込まれないので、ダミーを追加する
    wp_register_script('jquery-core', false, array(), false, true );
}
add_action('wp_enqueue_scripts', 'deregister_styles');
add_filter('wpcf7_load_js', '__return_false'); //contact form7のjs出力削除

//**********************WordPressの自動整形を止める******************
remove_filter('the_content', 'wpautop');

//***********************投稿者アーカイブを廃止***************************
add_filter('author_rewrite_rules', '__return_empty_array');
function disable_author_archive() {
	if($_GET['author'] || preg_match('#/author/.+#', $_SERVER['REQUEST_URI'])) {
		wp_redirect(home_url());
		exit;
	}
}
add_action('init', 'disable_author_archive');

//**********************投稿者クラス名の削除**************************
function remove_comment_author_class($classes) {
	foreach ($classes as $key => $class) {
		if (strstr($class, 'comment-author-')) {
			unset($classes[$key]);
		}
	}
	return $classes;
}
add_filter('comment_class', 'remove_comment_author_class', 10, 1);

//*************************各場所でショートコード有効化**********************
add_filter('the_content', 'do_shortcode');
add_filter('get_the_content', 'do_shortcode');
add_filter('widget_text', 'do_shortcode' );

//******************h2ad.phpをショートコード化***************
function h2ad_display() {
    require_once $_SERVER['DOCUMENT_ROOT']."/wp-content/themes/cocoon-child-master/h2ad.php";
}
add_shortcode('h2ad', 'h2ad_display');

//**サムネイルサイズを1200:630にする＋Cocoon標準で出すthumb100 120 150 160 320を消す****
//記事一覧
add_image_size('index_thumb',412, 216, true);
add_filter('get_entry_card_thumbnail_size', function (){
  return 'index_thumb';
});
//内部ブログカード
add_filter('get_internal_blogcard_thumbnail_size', function (){
  return 'index_thumb';
});
//関連記事ウィジェット
add_filter('get_related_entries_thumbnail_size', function (){
  return 'index_thumb';
});
//ページ送りナビ
add_filter('get_post_navi_thumbnail_size', function (){
  return 'index_thumb';
});
function remove_thumbnail_size() {
    remove_image_size('thumb100');
    remove_image_size('thumb120');
    remove_image_size('thumb150');
    remove_image_size('thumb160');
    remove_image_size('thumb320');
    remove_image_size('1536x1536'); //原因不明だが2020年6月付近でいきなり登場した
    remove_image_size('2048x2048'); //原因不明だが2020年6月付近でいきなり登場した
    remove_image_size('thumb520x293'); //原因不明だが2020年6月付近でいきなり登場した
}
add_action('init', 'remove_thumbnail_size');

//*******5.3から勝手に2560を「-scaled」と作りやがるので停止***********
add_filter('big_image_size_threshold', '__return_zero', 10, 2);

//**************いつも今日の年月を記事内に挿入する********************************
function shortcode_today() {
    return date_i18n("Y年n月");
}
add_shortcode('today_date', 'shortcode_today');

//**************いつも今日の年を記事内に挿入する********************************
function shortcode_year() {
    return date_i18n("Y");
}
add_shortcode('today_year', 'shortcode_year');

//********************目次をデフォルトで閉じるページを指定する**************
add_filter('is_toc_content_visible', function ($is_visible) {
    //689アプリ記事、1497フリーソフト、8961全国2019感想、10056Excel13個、1458買ってよかったもの、9875INSIDE、9648リトルナイトメア、861おすすめゲーム、14338VBコントロール、14464みるらいと、14554漫画
    if (is_single(array(689,1497,8961,10056,1458,9875,9648,861,14338,14464,14554))) {
        $is_visible = false;
    }
    return $is_visible;
});

//*****AdSense非表示対応（関連コンテンツ以外）、各出力先にフラグ設定******
function adsense_disp_control($is_disp) {
    //4718デトランスα、11917nosh-2、11985会社でスキルアップ、12328めざましカーテン、12638枕メイン、13051テクノジェルピロースリープマージピロー、5869JEMTC（ABテストで停止中(2021/2/24~)）、10177ジャストアンサー、15791メーカープログラミング、15764枕腰が痛い、17075親水コート、16391仮想通貨
    if (is_single(array(4718,11917,11985,12328,12638,13051,10177,15791,15764,17075,16391))) {
        $is_disp = false;
        return $is_disp;
    }else{
        $is_disp = true;
        return $is_disp;
    }
}
add_filter('is_adsense_disp','adsense_disp_control');

//*********アフィABテストする記事だけjs出力*******
function affi_ab_test() {
    //5869ジェムテク、10177ジャストアンサー、1458買ってよかったもの、16931仮想通貨
    if (is_single(array(5869,10177,1458,16931))) {
        echo '<script defer src="/wp-content/themes/cocoon-child-master/affi-test.js"></script>';
    }
}
add_action('wp_footer_insert_open','affi_ab_test');

//*********ソースコード表示がある記事にだけhighlight.jsと関連CSSを出力*******
function syntax_highlight($hljs) {
    if (is_single(array(2299,2575,4594,4625,6785,8532,8778,9447,9678,9927,11043,12304,12407,12970,13030,13557,14048,15439,16830,18066,18290,18332,18504,18579,18787))) {
        $js = "<script src='/wp-content/themes/cocoon-master/plugins/highlight-js/highlight.min.js?ver=5.4.4&#038;fver=20200723123944'></script><script>(function($)"."{"."$('.entry-content pre').each(function(i,block){hljs.highlightBlock(block)})})(jQuery);</script>";
        $css = '<link rel="stylesheet" href="/wp-content/themes/cocoon-child-master/hljs.css">';
        return $js.$css;
    }
}
add_filter('footer_hljs','syntax_highlight');

//*****************count.jsoonからTwitterのツイート数＋いいね数を取得*************
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
    return intval($res);
}

//**********************TwitterのシェアURL出力部分をちょい変更********************
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

//**********************特殊文字列の自動置換を停止********************
add_filter('run_wptexturize', '__return_false');

//**************フロントページのタイトルタグをh1に********************
function custom_the_site_logo_tag($tag) {
    if (is_front_page() && preg_match('/logo-header/', $tag)) {
        $tag = preg_replace( '/div/', 'h1', $tag );
    }
    echo $tag;
}
add_action('the_site_logo_tag', 'custom_the_site_logo_tag', 10, 1);

//**************トップページのカードサムネを412x216にする********************
function return_index_thumb($thumb_size) {
    $thumb_size = "index_thumb";
    return $thumb_size;
}
add_filter('get_widget_entries_thumbnail_size','return_index_thumb');

//**************こっちはナビカード（はじめまして）********************
require "get_navi_card_image_attributes.php";

//*********WordPress5.5以降のカスなデフォルトサイトマップを無効化***************
add_filter('wp_sitemaps_enabled', '__return_false');
//これで404にするより既存のサイトマップに301する方が自然なのでそのうち対応

//*********icomoonのCocoonの読み込み停止（フックもなし、fontawesomeあるのでまるごと停止などもできずこの上書き策しか思いつかなかった***************
function wp_enqueue_web_font_lazy_load_js() {
    if (is_web_font_lazy_load_enable() && !is_admin()) {
      wp_enqueue_script('web-font-lazy-load-js', get_template_directory_uri().'/js/web-font-lazy-load.js', array(), false, true);
      $data = ('
        loadWebFont("'.get_site_icon_font_url().'");
      '); //ここにあった「loadWebFont("'.FONT_ICOMOON_URL.'");」を削除
      if (is_site_icon_font_font_awesome_5()) {
        $data .= 'loadWebFont("'.get_template_directory_uri().'/css/fontawesome5.css");';
      }
      wp_add_inline_script('web-font-lazy-load-js', $data, 'after') ;
    }
}

//*********WordPressのsrcを無効化（サムネwebp対応の件で設定。よく考えたら他のところで役に立ってる気もしないし）***************
add_filter('wp_calculate_image_srcset_meta', '__return_null');

//*********webpをWordPressでアップロードできるようにする***************
function allow_upload_extension($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'allow_upload_extension');

//*********親CSSに動的生成されるアクセスカウント***************
function add_accesscount($tag) {
    $post_id = get_the_ID();
    $post_type = get_accesses_post_type();
    $tag = <<<EOD
    <style>body::after{content:url("/wp-content/themes/cocoon-master/lib/analytics/access.php?post_id=$post_id&post_type=$post_type");visibility:hidden;position:absolute;bottom:0;right:0;width:1px;height:1px;overflow:hidden;display:inline!important;}</style>
    EOD;
    return $tag;
}
add_filter('access_count_by_oya_css', 'add_accesscount');

//*********セルフピンバック停止***************
function stop_selfpingback(&$links) {
    $home = get_option('home');
    foreach($links as $l => $link)
        if(strpos($link, $home) === 0) unset($links[$l]);
}
add_action('pre_ping', 'stop_selfpingback');

//*********特定の親カテゴリからaタグを抜く***************
function remove_a_tag($nav_menu) {
    if (strpos($nav_menu, "%e3%82%b0%e3%83%ad%e3%83%bc%e3%83%90%e3%83%ab%e3%83%8a%e3%83%93%ef%bc%88new%ef%bc%89-pc") !== false) {
        $nav_menu = preg_replace('/(.*)https:\/\/.*?\/category\/(details|others)(\".*)/im', "$1#\" class=\"a-disabled$3", $nav_menu);
        return $nav_menu;
    } else {
        return $nav_menu;
    }
}
add_filter('wp_nav_menu', 'remove_a_tag');

//*********Software Designのタグページはnoindexじゃなくする***************
function remove_noindex_softwaredesign($is_noindex) {
    if (strpos(get_tag_link(1734), $_SERVER['REQUEST_URI']) !== false) {
        return 0;
    } else {
        return $is_noindex;
    }
}
add_filter('is_noindex_page', 'remove_noindex_softwaredesign');

//***みるみ吹き出しもLazy Load対応にする（なぜか除外してなくても効いてない）******
function add_lazy_load($content) {
    $content = preg_replace('/class="speech-icon-image"/im', 'class="speech-icon-image" loading="lazy" width="312" height="312"', $content);
    return $content;
}
add_filter('the_content', 'add_lazy_load');

//****ログインしている人にだけadmin用のassetを出力する(js系はなんかダメだったのでcssだけ)*****
function echo_admin_css() {
    if (is_user_logged_in()) {
        echo '<link rel="stylesheet" href="/wp-content/themes/cocoon-child-master/admin-style.css">';
    }
}
add_filter('wp_head', 'echo_admin_css');

//*********商品リンクの画像にもLazy Loadを適用する***************
function apply_lazy_load_product_item_link($tag) {
    $tag = preg_replace('/<img src/im', '<img loading="lazy" src', $tag);
    return $tag;
}
add_filter('amazon_product_link_tag', 'apply_lazy_load_product_item_link');

//*********ヘッダーサイトロゴにwidthとheightを指定する***************
function add_site_header_logo_attr($all_tag, $is_header, $home_url, $site_logo_text, $site_logo_width, $site_logo_height) {
    return preg_replace('/<img /im', '<img width="400" height="90" ', $all_tag);
}
add_filter('the_site_logo_tag', 'add_site_header_logo_attr', 3, 6);

//*****************いいねボタン***********************
function like_button() {
    global $wpdb;
    $type = $_POST["type"];
    $slug = $_POST["slug"];
    $table = "wp_like_button";
    if ($type == "on") {
        $type = true;
    } else if ($type == "off") {
        $type = false;
    }
    if ( ! get_record($table, $slug)) {
        $res = insert_new_record($table, $slug);
    }
    $res = change_like_count($table, $slug, $type);
    die();
}
add_action('wp_ajax_like_button', 'like_button');
add_action('wp_ajax_nopriv_like_button', 'like_button');

//*********レコードデータ取得＆あるかチェック（一応切り出しといた）*************
function get_record($table, $record) {
    global $wpdb;
    // 本当はテーブル名を変数で使いたいのだけど今は無理そうと判断した
    $query = $wpdb->prepare("SELECT * FROM wp_like_button WHERE slug = '%s'", $record);
    $res = $wpdb->get_row($query, OBJECT);
    return $res->like_count; //ヒットなしはnull→false
}

//*********テーブルにレコードを挿入する（一応切り出しといた）***************
function insert_new_record($table, $record) {
    global $wpdb;
    $res = $wpdb->insert($table, array(
        "slug" => $record,
        "like_count" => 0
    ), array(
        "%s",
        "%d"
    ));
    return $res;
}

//*********like_countを+1/-1する（一応切り出しといた）***************
function change_like_count($table, $record, $type) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT like_count FROM wp_like_button WHERE slug = '%s'", $record);
    $result = $wpdb->get_row($query, OBJECT);
    $current = $result->like_count;
    $res = $wpdb->update($table, array(
        "like_count" => $type ? $current + 1 : $current - 1
    ), array(
        "slug" => $record
    ), array(
        "%d"
    ), array(
        "%s"
    ));
    return $res;
}

//*********dropbox側の要因？なのかBackWPupでタイムアウトするのを防止**************
function __extend_http_request_timeout( $timeout ) {
    return 60;
}
add_filter( 'http_request_timeout', '__extend_http_request_timeout' );


