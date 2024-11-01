<?php

namespace Notes\Model;

use Notes\Exceptions\NoFoundException;
use Notes\Exceptions\StorageException;
use PDO;
use Throwable;

class NoteModel extends AbstractModel implements ModelInterface
{
    /**
     * @throws StorageException
     */
    public function list(int $pageNumber, int $pageSize, string $sortBy, string $sortOrder): array
    {
        return $this->findBy(null, $pageNumber, $pageSize, $sortBy, $sortOrder);
    }

    /**
     * @throws StorageException
     */
    public function search(string $phrase, int $pageNumber, int $pageSize, string $sortBy, string $sortOrder): array
    {
        return $this->findBy($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
    }

    /**
     * @throws StorageException
     */
    public function count(): int
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

    /**
     * @throws StorageException
     */
    public function searchCount(string $phrase): int
    {
        try {
            $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);
            $query = "SELECT count(*) AS cn FROM notes WHERE title LIKE($phrase)";
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

    /**
     * @throws StorageException
     * @throws NoFoundException
     */
    public function get(int $id): array
    {
        try {
            $query = "SELECT * FROM notes WHERE id = $id";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatki', 400, $e);
        }

        if (!$note) {
            throw new NoFoundException("Notatka o id: $id nie istnieje");
        }

        return $note;
    }

    /**
     * @throws StorageException
     */
    public function create(array $data): void
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
     * @throws StorageException
     */
    public function edit(int $id, array $data): void
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
     * @throws StorageException
     */
    public function delete(int $id): void
    {
        try {
            $query = "DELETE FROM notes WHERE id = $id LIMIT 1";
            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się usunąć notatki', 400, $e);
        }
    }

    /**
     * @throws StorageException
     */
    private function findBy(
        ?string $phrase,
        int $pageNumber,
        int $pageSize,
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

            $wherePart = '';
            if ($phrase) {
                $phrase = $this->conn->quote('%' . $phrase . '%', PDO::PARAM_STR);
                $wherePart = "WHERE title LIKE ($phrase)";
            }

            $query = "
        SELECT id, title, created 
        FROM notes
        $wherePart
        ORDER BY $sortBy $sortOrder
        LIMIT $offset, $limit
      ";

            $result = $this->conn->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatek', 400, $e);
        }
    }
}
