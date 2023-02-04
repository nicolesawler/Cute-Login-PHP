<?php
include_once 'session.php';// ~ session start required user pages
include_once 'db-user.php';// ~ connect to db and account obj
$account->logout();
$account->redirect('index');

// This is what's happening above:
// 
//  session_start() ;
//  $_SESSION['loggedin'] = null;
//  session_destroy();
//  unset($_SESSION['loggedin']);
//
//  header('Location: index');
//  exit();