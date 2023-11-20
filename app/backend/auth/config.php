<?php

$remoteSecret = parse_ini_file('../yourSecrets.ini');

$current = $remoteSecret;

$GLOBALS['config'] = array(

    'app' => array(
        'name'          => 'Buckled Shoes',
    ),

    'mysql' => array(
        'host'          => $current['db_host'],
        'username'      => $current['db_user'],
        'password'      => $current['db_password'],
        'db_name'        => $current['db_name']
    ),

    'password' => array(
        'algo_name' => PASSWORD_DEFAULT,
        'cost'      => 10,
        'salt'      => 50,
    ),

    'hash' => array(
        'algo_name' => 'sha512',
        'salt'      => 30,
    ),

    'remember'  => array(
        'cookie_name'   => 'token',
        'cookie_expiry' => 604800
    ),

    'session'   => array(
        'session_name'  => 'user',
        'token_name'    => 'csrf_token'
    ),
);
