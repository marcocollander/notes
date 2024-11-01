<?php

declare(strict_types=1);

spl_autoload_register(function (string $classNamespace) {
    $path = str_replace(['\\', 'Notes/'], ['/', ''], $classNamespace);
    $path = "src/$path.php";

    require_once($path);
});

use Notes\Controller\AbstractController;
use Notes\Controller\NoteController;
use Notes\Exceptions\AppException;
use Notes\Exceptions\ConfigurationException;
use Notes\Request;

require_once 'src/utils/debug.php';

$configuration = require_once('config/config.php');

$request = new Request($_GET, $_POST, $_SERVER);

try {
    AbstractController::initConfiguration($configuration);
    (new NoteController($request))->run();

} catch (ConfigurationException $e) {
    //mail('xxx@xxx.com', 'Errro', $e->getMessage());
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo 'Problem z aplikacją, proszę spróbować za chwilę.<br>';
    echo $e->getMessage();

} catch (AppException $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $e->getMessage() . '</h3>';

} catch (Throwable $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    dump($e);
}
