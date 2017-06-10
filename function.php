<?php
function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
function dateformat($date){
    date('m月d日', strtotime($date.' 00:00:00'));
}
function csrfSetToken(){
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
    return $token;
}

function csrfCheckToken($value){
    if(empty($_SESSION['token']) || $_SESSION['token'] != $value){
        echo h('不正なポスト送信がありました');
        exit();
    }
}
