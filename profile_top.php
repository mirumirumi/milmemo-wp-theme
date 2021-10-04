<?php

function echo_profbox_html($category_text) {
    ?>
    <div class="prof-box-wrap pb-top">
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
                <span class="pb-title-mirumi">みるみ</span>
            </div>
            <div class="pb-contents">
    <?php
echo $category_text;
    ?>
            </div>
        </div>
    </div>
    <?php
}


$category_id = (get_the_category()[0])->cat_ID;

switch ($category_id) {
    case 982: //PC
        $category_text = <<<EOT
        <p>朝起きてから夜寝るまでPCしか触っていない人。</p>
        <p>Micr◯s◯ft製のソフトウェアが死ぬほど嫌いなことで有名。</p>
EOT;
        echo_profbox_html($category_text);
        break;
    case 1010: //スマホ
        $category_text = <<<EOT
        <p>Android 2.3くらいの頃からのカスタマイズオタク。</p>
        <p>2020年にiPhoneデビューしたのでiOS寄りの記事も書き始めました。</p>
EOT;
        echo_profbox_html($category_text);
        break;
    case 3: //ゲーム
        $category_text = <<<EOT
        <p>１歳のときファミコンでゲームデビュー。話題のFPSより鬼畜2Dアクションとかが好き。あと無類のゲーム音楽オタクです。</p>
        <p>最近はインディーズゲームにお熱。</p>
EOT;
        echo_profbox_html($category_text);
        break;
    case 1212: //技術職
    case 1213: //技術職
    case 1214: //技術職
        $category_text = <<<EOT
        <p>大手電機メーカーでエンジニアやってます。</p>
        <p><a href="https://milmemo.net/engineer-blog-start">こういう背景</a>があり、このブログでは技術職の魅力を多くの人に知ってもらうべくリアルな情報を色々書いています。</p>
EOT;
        echo_profbox_html($category_text);
        break;
    case 5: //音楽
        $category_text = <<<EOT
        <p>歴17年の打楽器奏者。ドラムからマリンバまで何でもやります。吹奏楽オタク。</p>
        <p>いつかまた音楽の日々を取り戻すのが密かな夢。</p>
EOT;
        echo_profbox_html($category_text);
        break;
    case 548: //ブログ運営
        $category_text = <<<EOT
        <p>雑記ブロガー。文章を書くのが好き。たまにライターの仕事もしています。</p>
        <p>Cocoonを使ったサイトカスタマイズが得意です<span style="font-size:0.83em;">（このブログもCocoon）</span>。</p>
EOT;
        echo_profbox_html($category_text);
        break;
    case 685: //カーナビ
        $category_text = <<<EOT
        <p>カーナビの販売経験あり。</p>
        <p>数百人分の車/カーナビ/取り付け事情を見てきたプロだからこそ説明できる「複雑なカーナビ購入事情」について、どこよりも分かりやすい説明を目指しています。</p>
EOT;
        echo_profbox_html($category_text);
        break;
    case 1455: //枕
        $category_text = <<<EOT
        <p>肩こりを治したくて枕に15万円以上も使ってしまった人。悲しくも枕に詳しくなってしまいました。</p>
        <p>このブログでは「同じ過ちを繰り返す人が1人でも少なくなるように…！」と思って色々記事にしています。</p>
EOT;
        echo_profbox_html($category_text);
        break;
    case 594: //明晰夢/体外離脱
        $category_text = <<<EOT
        <p>高校生のとき「授業は全て寝ているのに内容は知っていた」という現象に頻繁に遭い、そこから睡眠について研究し始める。</p>
        <p>以来、夢や睡眠時の脳に関する話題などが大好き。このブログでも色々書いています。</p>
EOT;
        echo_profbox_html($category_text);
        break; 
    default: //その他(ライフハック,Googleローカルガイド,ねこ,サンホラ,ICL体験記,プログラミング,雑記)
        $category_text = <<<EOT
        <p>ブロガー、エンジニア。</p>
        <p>文章を書くのが好きです。</p>
EOT;
        echo_profbox_html($category_text);
        break;
}

?>