<?php

declare(strict_types=1);

namespace Notes;

use Notes\Exceptions\ConfigurationException;

require_once("Exceptions/ConfigurationException.php");
require_once("Database.php");
require_once("View.php");

abstract class AbstractConntroller
{
    protected const string DEFAULT_ACTION = 'list';

    private static array $configuration = [];

    protected Database $database;
    protected Request $request;
    protected View $view;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {
        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException('Configuration error');
        }
        $this->database = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        $action = $this->action() . 'Action';
        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION . 'Action';
        }

        $this->$action();
    }

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}