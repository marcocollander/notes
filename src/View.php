<?php

declare(strict_types=1);

namespace Notes;

class View
{
    public function render(string $page, array $params): void
    {
        require_once 'templates/layout.php';
    }
}
