<?php

function my_posts_columns($defaults) {
    $defaults['link'] = '過去記事→リンク';
    $defaults['grc'] = 'GRC';
    $defaults['rewrite'] = 'リライト';
    $defaults['free_memo'] = 'フリーめも';

    return $defaults;
}
add_filter('manage_posts_columns', 'my_posts_columns');


function my_posts_custom_column($column, $post_id) {
    switch ($column) {
        case 'link':
            //テキスト欄の場合
            $post_meta = get_post_meta($post_id, 'link', true);
            if ($post_meta) {
                echo $post_meta;
            } else {
                echo ''; //値が無い場合の表示
            }
            break;
        case 'grc':
            //チェックボックスの場合
            if (!!get_post_meta($post_id , 'grc' , true)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            echo "<input type='checkbox' readonly $checked/>";
            break;
        case 'rewrite':
            //チェックボックスの場合
            if (!!get_post_meta($post_id , 'rewrite' , true)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
            echo "<input type='checkbox' readonly $checked/>";
            break;
        case 'free_memo':
            //テキスト欄の場合
            $post_meta = get_post_meta($post_id, 'free_memo', true);
            if ($post_meta) {
                echo $post_meta;
            } else {
                echo ''; //値が無い場合の表示
            }
            break;
    }
}
add_action('manage_posts_custom_column' , 'my_posts_custom_column', 10, 2);


function display_my_custom_quickedit($column_name, $post_type) {
    static $print_nonce = TRUE;
    if ($print_nonce) {
        $print_nonce = FALSE;
        wp_nonce_field('quick_edit_action', $post_type . '_edit_nonce'); //CSRF対策
    }

    ?>
    <fieldset class="inline-edit-col-right inline-custom-meta">
        <div class="inline-edit-col column-<?php echo $column_name ?>">
            <label class="inline-edit-group">
                <?php
                switch ($column_name) {
                    case 'link':
                        ?><span class="title">過去記事→リンク</span><input name="link" /><?php
                        break;
                    case 'grc':
                        ?><span class="title">GRC</span><input name="grc" type="checkbox" /><?php
                        break;
                    case 'rewrite':
                        ?><span class="title">リライト</span><input name="rewrite" type="checkbox" /><?php
                        break;
                    case 'free_memo':
                        ?><span class="title">フリーめも</span><input name="free_memo" /><?php
                        break;
                }
                ?>
            </label>
        </div>
    </fieldset>
<?php
}
add_action('quick_edit_custom_box', 'display_my_custom_quickedit', 10, 2);


function save_custom_meta($post_id) {
    $slug = 'post'; //カスタムフィールドの保存処理をしたい投稿タイプを指定

    if ($slug !== get_post_type($post_id)) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $_POST += array("{$slug}_edit_nonce" => '');
    if (!wp_verify_nonce($_POST["{$slug}_edit_nonce"], 'quick_edit_action')) {
        return;
    }

    if (isset($_REQUEST['link'])) {
        update_post_meta($post_id, 'link', $_REQUEST['link']);
    }
    if (isset($_REQUEST['grc'])) {
        update_post_meta($post_id, 'grc', TRUE);
    } else {
        update_post_meta($post_id, 'grc', FALSE);
    }
    if (isset($_REQUEST['rewrite'])) {
        update_post_meta($post_id, 'rewrite', TRUE);
    } else {
        update_post_meta($post_id, 'rewrite', FALSE);
    }
    if (isset($_REQUEST['free_memo'])) {
        update_post_meta($post_id, 'free_memo', $_REQUEST['free_memo']);
    }
}
add_action('save_post', 'save_custom_meta');











