<?php

declare(strict_types=1);

namespace Notes;

class View
{
    public function render(string $page, array $params = []): void
    {
        $params = $this->escape($params);
        require_once 'templates/layout.php';
    }

    private function escape(array $params): array
    {
        $clearParams = [];

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $clearParams[$key] = $this->escape($value);
            } elseif ($value) {
                $clearParams[$key] = htmlspecialchars((string)$value);
            } else {
                $clearParams[$key] = $value;
            }
        }

        return $clearParams;
    }
}
