<?php

use DElfimov\Supernano\Core;
include __DIR__ . '/../vendor/autoload.php';
$core = new Core($_SERVER['REQUEST_URI'], realpath(__DIR__ . '/..'));
echo $core->render();
