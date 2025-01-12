<?php

namespace NotesApp\Models;

class NoteModel
{
    private $conn;
    private $table = 'notes';

    public $id;
    public $title;
    public $content;
    public $user_id;
    public $user_name;
    public $reminder;
    public $created_at;
    public $updated_at;
    
    public function __construct(\PDO $db)
    {
        $this->conn = $db;
    }

    public function createNote()
    {
        try {
            $query = 'INSERT INTO ' . $this->table .
                ' SET user_id = :user_id, title = :title, content = :content, reminder= :reminder';
            $stmt = $this->conn->prepare($query);

            $this->user_id  = htmlspecialchars(strip_tags($this->user_id));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->content = htmlspecialchars(strip_tags($this->content));
            $this->reminder = htmlspecialchars(strip_tags($this->reminder));

            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':reminder', $this->reminder);


            if ($stmt->execute()) {
                return $this;
            }

            return false;
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function GetAllNotes()
    {
        try {
            $query = '
        SELECT u.username as user_name, n.id, n.user_id, n.title, n.content, n.reminder, n.created_at, n.updated_at
                                  FROM ' . $this->table . ' n
                                  LEFT JOIN
                                    users u ON n.user_id = u.id
                                  ORDER BY
                                    n.created_at DESC
        ';

            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                return $stmt;
            }
            return null;
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function GetNoteByID($id)
    {
        try {
            $query = 'SELECT u.username as user_name, n.id, n.user_id, n.title, n.content, n.reminder, n.created_at, n.updated_at
                                  FROM ' . $this->table . ' n
                                  LEFT JOIN
                                    users u ON n.user_id = u.id
                                  WHERE
                                    n.id = ?
                                  LIMIT 1';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();

            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($row) {
                $this->user_id = $row['user_id'];
                $this->title = $row['title'];
                $this->content = $row['content'];
                $this->user_name = $row['user_name'];
                $this->reminder = $row['reminder'];
                $this->created_at = $row['created_at'];
                $this->updated_at = $row['updated_at'];

                return $this;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }



    public function updateNote($id)
    {
        try {
            $query = 'UPDATE ' . $this->table . '
                          SET title = :title, content = :content, reminder = :reminder, updated_at = :updated_at
                          WHERE id = :id';

            $stmt = $this->conn->prepare($query);

            $this->id  = htmlspecialchars(strip_tags($this->id));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->content = htmlspecialchars(strip_tags($this->content));
            $this->reminder = htmlspecialchars(strip_tags($this->reminder));
            $this->updated_at = htmlspecialchars(strip_tags($this->updated_at));

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':content', $this->content);
            $stmt->bindParam(':reminder', $this->reminder);
            $stmt->bindParam(':updated_at', $this->updated_at);

            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    public function deleteNote($id)
    {
        try {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $noteId = htmlspecialchars(strip_tags($id));
            $stmt->bindParam(':id', $noteId);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

}