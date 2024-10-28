<?php

declare(strict_types=1);

namespace Notes;

require_once 'Exceptions/ConfigurationException.php';
require_once 'Exceptions/StorageException.php';

use Notes\Exceptions\ConfigurationException;
use Notes\Exceptions\StorageException;
use PDO;
use PDOException;
use Throwable;

class Database
{
    private PDO $conn;

    /**
     * @throws StorageException
     */
    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConnection($config);
        } catch (PDOException $e) {
            throw new StorageException('Connection error');
        } catch (ConfigurationException $e) {
        }
    }

    /**
     * @throws StorageException
     */
    public function createNote(array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date('Y-m-d H:i:s'));

            $query = "
        INSERT INTO notes(title, description, created)
        VALUES($title, $description, $created)
      ";

            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się utworzyć nowej notatki', 400, $e);
        }
    }


    /**
     * @throws ConfigurationException
     */
    private function validateConfig(array $config): void
    {
        if (
            empty($config['database'])
            || empty($config['host'])
            || empty($config['username'])
            || empty($config['password'])
        ) {
            throw new ConfigurationException('Storage configuration error');
        }
    }

    private function createConnection(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};port={$config['port']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn,
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}
