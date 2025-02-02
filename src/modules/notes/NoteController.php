<?php

namespace NotesApp\Controllers;

use NotesApp\Models\NoteModel;
use NotesApp\Utils\Database;
use NotesApp\Middleware\IsAuthMiddleware;
use Exception;


class NoteController extends BaseController
{
    private $noteModel;

    public function __construct(Database $database, NoteModel $noteModel)
    {
        parent::__construct($database);
        $this->noteModel = $noteModel;
    }


    public function createNote()
    {
        IsAuthMiddleware::authenticate();
        $userId = IsAuthMiddleware::getUserId();
        try {
            $data = json_decode(file_get_contents("php://input"));
            if (
                !isset($data->title) || !isset($data->content)
            ) {
                $this->respondWithError('Missing required fields');
                return;
            }

            if ( !is_string($data->title) || !is_string($data->content) || !is_string($data->reminder)) {
                $this->respondWithError('Invalid field types or values');
                return;
            }

            $this->noteModel->user_id = $userId;
            $this->noteModel->title = $data->title;
            $this->noteModel->content = $data->content;
            $this->noteModel->reminder = $data->reminder;

            $result = $this->noteModel->createNote();
            if ($result) {
                echo json_encode(
                    array('message' => 'Note Created Successfully')
                );
            } else {
                echo json_encode(
                    array('message' => 'Note Not Created')
                );
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }


    public function getAllNotes()
    {
        IsAuthMiddleware::authenticate();
        $userId = IsAuthMiddleware::getUserId();

        try {
            $result = $this->noteModel->getAllNotes();

            if ($result) {

                $notesArr = array();

                while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                    extract($row);

                    $noteItem = array(
                        'id' => $id,
                        'title' => $title,
                        'content' => html_entity_decode($content),
                        'reminder' => $reminder,
                        'user_id' => $user_id,
                        'user_name' => $user_name,
                        'created_at' => $created_at,
                        'updated_at' => $updated_at,
                    );

                    array_push($notesArr, $noteItem);
                }

               // echo json_encode($notesArr);
            }

            $filteredNotes = array_filter($notesArr, function ($note) use ($userId) {
                return $note['user_id'] == $userId;
            });

            if (!empty($filteredNotes)) {
                echo json_encode($filteredNotes);
            } else {
                $this->respondWithError('No Notes Found', 404);
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function getNoteById()
    {
        IsAuthMiddleware::authenticate();
        $userId = IsAuthMiddleware::getUserId();
        try {
            $noteId = isset($_GET['id']) ? $_GET['id'] : null;
            if (!is_numeric($noteId) || $noteId <= 0) {

                $this->respondWithError('Invalid Note ID');
            }
            $note = $this->noteModel->GetNoteByID($noteId);
            if ($note  && $note->user_id == $userId ) {
                $note_arr = array(
                    'id' => $noteId,
                    'title' => $note->title,
                    'content' => $note->content,
                    'reminder' => $note->reminder,
                    'user_id' => $note->user_id,
                    'user_name' => $note->user_name,
                    'created_at' => $note->created_at,
                    'updated_at' => $note->updated_at,
                );

                echo json_encode($note_arr);
            } else {
                $this->respondWithError('No Notes Found', 404);
            }
        } catch (Exception $e) {

            $this->respondWithError($e->getMessage());
        }
    }


    public function updateNote()
    {
        IsAuthMiddleware::authenticate();
        $userId = IsAuthMiddleware::getUserId();
        try {
            $noteId = isset($_GET['id']) ? $_GET['id'] : null;
            $data = json_decode(file_get_contents("php://input"));

            if (!is_numeric($noteId) || $noteId <= 0) {
                $this->respondWithError('Invalid Note ID');
                return;
            }

            $note = $this->noteModel->getNoteById($noteId);

            if (!$note || $note->user_id != $userId) {
                $this->respondWithError('Note not found or unauthorized');
                return;
            }

            if (
               !isset($data->title) || !isset($data->content) 
            ) {
                $this->respondWithError('Missing required fields');
                return;
            }


            if (!is_string($data->title) || !is_string($data->content) || !is_string($data->reminder)) {
                $this->respondWithError('Invalid field types or values');
                return;
            }

            $this->noteModel->title = $data->title;
            $this->noteModel->content = $data->content;
            $this->noteModel->reminder = $data->reminder;
            $this->noteModel->updated_at = $data->updated_at;

            $result = $this->noteModel->updateNote($noteId);
            if ($result) {
                echo json_encode(
                    array('message' => 'Note Updated Successfully')
                );
            } else {
                echo json_encode(
                    array('message' => 'Note Not updated')
                );
            }
        } catch (Exception $e) {
            $this->respondWithError($e->getMessage());
        }
    }

    public function deleteNote()
    {
        IsAuthMiddleware::authenticate();
        $userId = IsAuthMiddleware::getUserId();

        try {
            $noteId = isset($_GET['id']) ? $_GET['id'] : null;
            $note = $this->noteModel->getNoteById($noteId);

            if (!$note || $note->user_id != $userId) {
                $this->respondWithError('Note not found or unauthorized');
                return;
            }
            $result = $this->noteModel->deleteNote($noteId);
            if ($result) {
                echo json_encode(
                    array('message' => 'Note Deleted Successfully')
                );
            } else {
                echo json_encode(
                    array('message' => 'Note Not Deleted')
                );
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
