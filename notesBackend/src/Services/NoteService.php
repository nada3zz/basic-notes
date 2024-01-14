<?php

namespace NotesApp\Services;
use NotesApp\Utils\Database;
use NotesApp\Models\NoteModel;

class NoteService
{
  
    public function getUserNotes($userId)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM notes WHERE user_id = ?");
        $stmt->execute([$userId]);
        $notesData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $notes = [];
        foreach ($notesData as $noteData) {
            $notes[] = $this->mapNoteDataToObject($noteData);
        }

        return ['notes' => $notes];
    }

    public function getNoteById($noteId)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
        $stmt->execute([$noteId]);
        $noteData = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($noteData) {
            $note = $this->mapNoteDataToObject($noteData);
            return ['note' => $note];
        } else {
            return ['error' => 'Note not found'];
        }
    }

    public function createNote($userId, $title, $content, $reminder)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content, reminder) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $title, $content, $reminder]);
        $noteId = $pdo->lastInsertId();
        $newNote = $this->getNoteById($noteId)['note'];

        return ['message' => 'Note created successfully', 'note' => $newNote];
    }

    public function updateNote($noteId, $title, $content, $reminder)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, reminder = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$title, $content, $reminder, $noteId]);
        $updatedNote = $this->getNoteById($noteId)['note'];

        return ['message' => 'Note updated successfully', 'note' => $updatedNote];
    }

    public function deleteNote($noteId)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
        $stmt->execute([$noteId]);

        return ['message' => 'Note deleted successfully'];
    }

    private function mapNoteDataToObject($noteData)
    {
        $note = new NoteModel();
        $note->setId($noteData['id']);
        $note->setTitle($noteData['title']);
        $note->setContent($noteData['content']);
        $note->setUserId($noteData['user_id']);
        $note->setReminder($noteData['reminder']);
        $note->setCreatedAt($noteData['created_at']);
        $note->setupdatedAt($noteData['updated_at']);
       
        return $note;
    }
}
