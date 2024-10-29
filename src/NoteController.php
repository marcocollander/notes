<?php

declare(strict_types=1);

namespace Notes;

require_once 'AbstractConntroller.php';

use Notes\Exceptions\ConfigurationException;
use Notes\Exceptions\NoFoundException;
use Notes\Exceptions\StorageException;

class NoteController extends AbstractConntroller
{
    /**
     * @throws StorageException
     */
    public function createAction(): void
    {
        if ($this->request->hasPost()) {
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->database->createNote($noteData);
            header('Location: /?before=created');
            exit;
        }

        $this->view->render('create');
    }

    public function showAction(): void
    {
        $noteId = (int)$this->request->getParam('id');

        if (!$noteId) {
            header('Location: /?error=missingNoteId');
            exit;
        }

        try {
            $note = $this->database->getNote($noteId);
        } catch (NoFoundException $e) {
            header('Location: /?error=noteNotFound');
            exit;
        }

        $this->view->render(
            'show',
            ['note' => $note]
        );
    }

    public function listAction()
    {
        $this->view->render(
            'list',
            [
                'notes' => $this->database->getAllNotes(),
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error')
            ]
        );
    }
}
