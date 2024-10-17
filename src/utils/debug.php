<?php

declare(strict_types=1);

/*
 *  Pełny zakres wyświetlanych błędu
    Przeważnie te dwie instrukcje występują razem
    Ta funkcja tylko w trybie development
    Na produkcji należy ją usunąć
*/

error_reporting(E_ALL);
ini_set('display_errors', '1');

function dump($data): void
{
    echo '<br/><div
    style="
           display: inline-block;
           padding: 10px;
           border: 1px solid gray;
           background: lightgray;
           font-size: 1.6rem;
           margin: 10px;

    "><pre>';
    print_r($data);
    echo '</pre></div><br/>';
}
