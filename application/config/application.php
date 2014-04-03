<?php

/*
 * Versão da aplicação
 * 
 */
$config['version'] = '3.0';

/*
 * 
 * Nome da sua aplicação
 */
$config['appname'] = 'Project Name';

/*
 * Caractere que separa o título
 * 
 */
$config['hashtitle'] = '|';

/*
 * 
 * Âmbiente: development/production
 * 
 */
$config['appmode'] = 'development';

/*
 * Configurações locais
 * 
 */
$config['apppath'] = realpath(dirname(__FILE__) . '/../');
$config['baseurl'] = 'http://cataya.local/';
$config['namespaceseparator'] = '\\';

/*
 * Configurações de módulos
 * 
 */
$config['controller']['path'] = $config['apppath'] . '/controllers/';
$config['controller']['default'] = 'controllerdefault';
$config['controller']['method']['default'] = 'indexAction';
$config['controller']['method']['error'] = 'errorAction';
$config['controller']['module']['default'] = 'main';
$config['controller']['module']['path'] = realpath(dirname(__FILE__) . '/../../') . '/public/';

/*
 * Configuração de template
 * 
 */
$config['view']['token'] = '%%';

/*
 * Configuração de sessões
 * 
 */
$config['session']['temp'] = realpath('./temp');

/*
 * Configurações de cache
 * 
 */
$config['memcache']['server'] = 'localhost';
$config['memcache']['port'] = 11211;

