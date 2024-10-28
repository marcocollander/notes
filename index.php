<?php

declare(strict_types=1);

namespace Notes;

/*
 * Na produkcji odkomentujemy te
 * dwie linijki kodu , aby świadomie wyłączyć
 * wyświetlanie komunikatów o błędach i oczywiście zakomentujemy funkcję debug/dump

    error_reporting(0);
    ini_set('display_errors', '0');

*/

use Notes\Exceptions\AppException;
use Notes\Exceptions\ConfigurationException;
use Throwable;

require_once 'src/utils/debug.php';
require_once 'src/Controller.php';
require_once 'src/Exceptions/AppException.php';
require_once 'src/Exceptions/ConfigurationException.php';

$configuration = require_once('config/config.php');

$request = [
    'get' => $_GET,
    'post' => $_POST
];

try {
    Controller::initConfiguration($configuration);
    (new Controller($request))->run();

} catch (ConfigurationException $e) {
    //mail('xxx@xxx.com', 'Errro', $e->getMessage());
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo 'Problem z applikacją, proszę spróbować za chwilę.';
} catch (AppException $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $e->getMessage() . '</h3>';
} catch (Throwable $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    dump($e);
}
