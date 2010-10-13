<?php
/**
 * @package Thanks_Comment 
 * @version 0.0.1
 */
/*
Plugin Name: Thanks Comment 
Plugin URI: #
Description: 未承認の既読コメントにthanksを加えるだけです。
Author: monmon
Version: 0.0.1
Author URI: http://twitter.com/lesamoureuses/
*/

function thanks_comment_js() {
    $commentFileName;
    if ($commentFileName = $_GET['thanks']) {
        list($path) = explode('wp-admin', $_SERVER['SCRIPT_FILENAME']);

        touch($path . 'wp-content/plugins/thanks-comment/' . $commentFileName);
    }

    echo 
        '<script type="text/javascript" src="'
        . get_option('siteurl') 
        . '/wp-content/plugins/thanks-comment/jquery-1.4.2.min.js"></script>
        .<script type="text/javascript" src="'
        . get_option('siteurl') 
        . '/wp-content/plugins/thanks-comment/thanks-comment.js"></script>';
}

add_action('load-edit-comments.php', 'thanks_comment_js');


// とりあえず全体舐めて未承認のコメントを確認
function add_thanks_comment($comments_array) {
    foreach ($comments_array as $comment) {
        if ($comment->comment_approved == '0') {
            $comment->comment_content = $comment->comment_ID . "thanks\t\t" . $comment->comment_content;
        }
    }
    return $comments_array;
}
function replace_thanks_comment($comment) {
    list($path) = explode('index.php', $_SERVER['SCRIPT_FILENAME']);
    if (preg_match("/^(\d+)thanks\t\t/", $comment, $m)) {
        if (file_exists($path . 'wp-content/plugins/thanks-comment/comment-' . $m[1])) {
            return preg_replace("/^(\d+)thanks\t\t/", 
                '<strong>
                （ブログにコメントありがとうございます。今返信出来ないけど、後日返信しますね。あなたのコメントはオーナーに読まれました）
                </strong><br>', $comment);
        }
        else {
            return preg_replace("/^(\d+)thanks\t\t/", '', $comment);
        }
    }
    else {
        return $comment;
    }
}

add_filter('comments_array', 'add_thanks_comment');
add_filter('comment_text', 'replace_thanks_comment');

?>
