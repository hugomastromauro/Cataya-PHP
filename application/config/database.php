<?php

/*
 * Configurações da base de dados
 * 
 */

$config['doctrine']['driver'] = "pdo_mysql";
$config['doctrine']['host'] = "localhost";
$config['doctrine']['dbname'] = "";
$config['doctrine']['user'] = "";
$config['doctrine']['password'] = "";

$config['doctrine']['models'] = $config['apppath'] . '/models/';
$config['doctrine']['proxies'] = $config['apppath'] . '/models/proxies/';
$config['doctrine']['mappings'] = $config['apppath'] . '/models/mappings/';