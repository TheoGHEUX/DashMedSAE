<?php
declare(strict_types=1);

// Chargement de l'autoloader
$siteDir = __DIR__ . '/../SITE';
$autoLoader = $siteDir . '/Core/AutoLoader.php';

if (!is_file($autoLoader)) {
    die('Autoloader introuvable');
}

require $autoLoader;

// Bootstrap et lancement de l'application
use Core\App;

$app = App::getInstance();
$app->run();