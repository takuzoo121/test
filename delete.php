<?php

// =============================  DB接続  ============================
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->query('SET NAMES utf8');
// =============================  DB接続  ============================


// =============================  削除処理  ============================
    $sql = 'DELETE FROM `posts` WHERE `id` = ?';
    $data[] = $_GET['id'];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
// =============================  削除処理  ============================

    // DB切断
    $dbh = null;

    //リダイレクト
    header("Location: bbs.php");
    exit();
