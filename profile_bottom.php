<?php

function echo_profbox_html_bottom($category_text) {
    ?>
    <div class="prof-box-wrap">
        <div class="pb-left">
            <img loading="lazy" src="https://milmemo.net/wp-content/uploads/mirumi.png" alt="みるみ" width="312" height="312">
            <div class="pb-follow-me">Follow Me!</div>
            <div class="pb-follow-btns">
                <a class="pb-follow-btn pb-tw-btn" href="https://twitter.com/milmemo_net" target="_blank"><i class="fab fa-twitter"></i></a>
                <a class="pb-follow-btn pb-rss-btn" href="https://feedly.com/i/discover/sources/search/feed/https%3A%2F%2Fmilmemo.net" target="_blank"><i class="fas fa-rss"></i></a>
            </div>
        </div>
        <div class="pb-right">
            <div class="pb-titles">
                <span class="pb-title-mirumi">みるみ<span class="pb-title-author">みるめも筆者</span></span>
            </div>
            <div class="pb-contents">
    <?php
echo $category_text;
    ?>
                <p>詳しいプロフィールは<a href="https://milmemo.net/profile">このページ</a>で色々書いてます。<a href="https://twitter.com/milmemo_net" class="twitter-link" target="_blank">Twitter</a>もやってます。</p>
            </div>
        </div>
    </div>
    <?php
}


$category_id = (get_the_category()[0])->cat_ID;

switch ($category_id) {
    case 982: //PC
        $category_text = <<<EOT
        <p>仕事と趣味と副業がプログラミングとブログでごちゃまぜになっている人。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    case 1010: //スマホ
        $category_text = <<<EOT
        <p>Android 2.3の頃からいじり倒している10年超えのオタク。2020年にiPhoneデビューしたのでちょっとずつiOS寄りの記事も書き始めてます。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    case 3: //ゲーム
        $category_text = <<<EOT
        <p>１歳でコントローラーを持つ。ゲームを芸術作品として楽しむのが好き。最近はインディーズゲームにお熱です。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    case 1212: //技術職
    case 1213: //技術職
    case 1214: //技術職
        $category_text = <<<EOT
        <p>大手電機メーカーのエンジニア。以前はハード屋、今はプログラムばっかり書いてます。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    case 5: //音楽
        $category_text = <<<EOT
        <p>歴17年の打楽器奏者。演奏も鑑賞も音楽理論もなんでも好き。またいつか音楽活動するんだ。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    case 548: //ブログ運営
        $category_text = <<<EOT
        <p>雑記ブロガー。文章を書くのが大好き。WordPress制作やカスタマイズはもちろん、Webアプリ/サービスも作ります。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    case 685: //カーナビ
        $category_text = <<<EOT
        <p>数百人分の車/カーナビ/取り付け事情を見てきた元カーナビ販売員。どこよりも詳しいカーナビ情報を書いています。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    case 1455: //枕
        $category_text = <<<EOT
        <p>肩こりを治したくて枕に15万円以上も使ってしまったゆえにめちゃくちゃ詳しくなってしまった悲しい人。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    case 594: //明晰夢/体外離脱
        $category_text = <<<EOT
        <p>趣味で夢や睡眠の研究をしている人。体外離脱が得意。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
    default: //その他(ライフハック,Googleローカルガイド,ねこ,サンホラ,ICL体験記,プログラミング,雑記)
        $category_text = <<<EOT
        <p>ブロガー、エンジニア。</p>
EOT;
        echo_profbox_html_bottom($category_text);
        break;
}

?>
