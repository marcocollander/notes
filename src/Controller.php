<?php
declare(strict_types=1);

namespace Notes;

use Notes\Exceptions\ConfigurationException;
use Notes\Exceptions\StorageException;

require_once 'Database.php';
require_once 'View.php';

class Controller
{
    private const string DEFAULT_ACTION = 'list';
    private static array $configuration = [];
    private Database $database;
    private array $request;
    private View $view;

    /**
     * @throws StorageException
     * @throws ConfigurationException
     */
    public function __construct(array $request)
    {
        if (empty(self::$configuration['db'])) {

            throw new ConfigurationException('Configuration error');
        }
        $this->database = new Database(self::$configuration['db']);
        $this->request = $request;
        $this->view = new View();
    }

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    /**
     * @throws StorageException
     */
    public function run(): void
    {
        $viewParams = [];

        switch ($this->action()) {
            case 'create':
                $page = 'create';

                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $noteData = [
                        'title' => $data['title'],
                        'description' => $data['description'],
                    ];
                    $this->database->createNote($noteData);
                    header(header: 'Location: /?before=created');
                }
                break;
            case 'show':
                $viewParams = [
                    'title' => 'Moja notatka',
                    'description' => 'Opis'
                ];
                break;
            default:
                $page = 'list';
                $data = $this->getRequestGet();
                $viewParams['before'] = $data['before'] ?? null;
                break;
        }

        $this->view->render($page, $viewParams);
    }

    private function action(): string
    {
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }

    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }
}