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

require_once 'src/utils/debug.php';
require_once 'src/View.php';

const DEFAULT_ACTION = 'list';

$action = $_GET['action'] ?? DEFAULT_ACTION;

$viewParams = [];



if ($action === 'create') {
    $page = 'create';

    if (!empty($_POST)) {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
        ];
        dump($data);
    }

    $viewParams['resultCreate'] = 'Create Note';
} else {
    $page = 'list';
    $viewParams['resultList'] = 'Display Notes';
}


$view = new View();
$view->render($page, $viewParams);
