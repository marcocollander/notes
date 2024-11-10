<?php

declare(strict_types=1);

namespace Notes;

require_once 'Exceptions/ConfigurationException.php';
require_once 'Exceptions/StorageException.php';
require_once 'Exceptions/NoFoundException.php';

use Notes\Exceptions\ConfigurationException;
use Notes\Exceptions\NoFoundException;
use Notes\Exceptions\StorageException;
use PDO;
use PDOException;
use Throwable;

class Database
{
    private PDO $conn;

    /**
     * @param array $config
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
     * @param array $config
     * @return void
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


    /**
     * @param array $config
     * @return void
     */
    private function createConnection(array $config): void
    {
        //        $dsn = "mysql:dbname={$config['database']};port={$config['port']};host={$config['host']}";
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn,
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    /**
     * @param array $data
     * @return void
     * @throws StorageException
     */
    public function createNote(array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date('Y-m-d H:i:s'));

            $query = "INSERT INTO notes(title, description, created)
                      VALUES($title, $description, $created)";
            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się utworzyć nowej notatki', 400, $e);
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @throws StorageException
     */
    public function editNote(int $id, array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);

            $query = "
        UPDATE notes
        SET title = $title, description = $description
        WHERE id = $id
      ";

            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się zaktualizować notetki', 400, $e);
        }
    }

    /**
     * @param int $id
     * @throws StorageException
     */
    public function deleteNote(int $id): void
    {
        try {
            $query = "DELETE FROM notes WHERE id = $id LIMIT 1";
            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się usunąć notatki', 400, $e);
        }
    }

    /**
     * @param int $id
     * @return array
     * @throws NoFoundException
     * @throws StorageException
     */
    public function getNote(int $id): array
    {
        try {
            $query = "SELECT * FROM notes WHERE id = $id";
            $note =
                $this->
                conn->
                query($query)->
                fetch(PDO::FETCH_ASSOC);

        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatki', 400, $e);
        }

        if (!$note) {
            throw new NoFoundException('Notatka o podanym id nie istnieje');
        }

        return $note;
    }

    /**
     * @param int $pageNumber
     * @param int $pageSize
     * @param string $sortBy
     * @param string $sortOrder
     * @return array
     * @throws StorageException
     */
    public function getAllNotes(
        int    $pageNumber,
        int    $pageSize,
        string $sortBy,
        string $sortOrder
    ): array {

        try {
            $limit = $pageSize;
            $offset = ($pageNumber - 1) * $pageSize;

            if (!in_array($sortBy, ['created', 'title'])) {
                $sortBy = 'title';
            }

            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'desc';
            }

            $query = "
                SELECT id, title, created
                FROM notes
                ORDER BY $sortBy $sortOrder
                LIMIT $offset, $limit
                ";

            return
                $this->
                conn->
                query($query)->
                fetchAll(PDO::FETCH_ASSOC);

        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać danych o notatkach', 400, $e);
        }
    }

    /**
     * @return int
     * @throws StorageException
     */
    public function getCount(): int
    {
        try {
            $query = "SELECT count(*) AS cn FROM notes";
            $result = $this->conn->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new StorageException('Błąd przy próbie pobrania ilości notatek', 400);
            }

            return (int) $result['cn'];
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać informacji o liczbie notatek', 400, $e);
        }
    }
}
