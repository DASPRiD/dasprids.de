<?php
chdir(__DIR__);
require 'vendor/autoload.php';

$config = require 'config.php';

$container = new Zend\ServiceManager\ServiceManager();
(new Zend\ServiceManager\Config($config['dependencies']))->configureServiceManager($container);
$container->setService('config', $config);

$runner = $container->get(Staphp\Runner::class);
$runner->run();
