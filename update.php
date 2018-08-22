<?php

// =============================  DB接続  ============================
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->query('SET NAMES utf8');
// =============================  DB接続  ============================

// =============================  ユーザーが入力した内容を取得する  ============================
    $nickname = htmlspecialchars($_POST['nickname']);
    $comment = htmlspecialchars($_POST['comment']);
    $id = htmlspecialchars($_POST['id']);
// =============================  ユーザーが入力した内容を取得する  ============================

// =============================  データを更新する  ============================
    $sql = 'UPDATE `posts` SET `nickname` = ?, `comment` = ? WHERE `id` = ?';
    $data = [$nickname, $comment, $id];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
// =============================  データを更新する  ============================

    //DB切断
    $dbh = null;

    //リダイレクト
    header("Location: bbs.php");
    exit();
