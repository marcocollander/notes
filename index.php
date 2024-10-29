<?php

declare(strict_types=1);

namespace Notes;

require_once 'src/utils/debug.php';
require_once 'src/NoteController.php';
require_once 'src/Request.php';
require_once 'src/Exceptions/AppException.php';
require_once 'src/Exceptions/ConfigurationException.php';

use Notes\Request;
use Notes\Exceptions\AppException;
use Notes\Exceptions\ConfigurationException;
use Throwable;


$configuration = require_once('config/config.php');

$request = new Request($_GET, $_POST);

try {
    NoteController::initConfiguration($configuration);
    (new NoteController($request))->run();

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
