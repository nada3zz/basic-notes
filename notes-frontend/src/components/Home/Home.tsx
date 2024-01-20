import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import noteService from "../../services/noteService";
import NoteList from "../NotesList/NotesList";
import NoteDetails from "../Note/Note";
import CreateNote from "../CreateNote/AddNote";


interface NoteParams {
  id: string;
}

const HomeComponent: React.FC = () => {
  const { id } = useParams<NoteParams>();
  const navigate = useNavigate();
  const [selectedNote, setSelectedNote] = useState({
    id: 0,
    title: "",
    content: "",
    reminder: new Date(),
  });

  useEffect(() => {
    if (id) {
      fetchNoteById(Number(id));
    }
  }, [id]);

  const fetchNoteById = async (noteId: number) => {
    try {
      const response = await noteService.getNoteById(noteId);
      setSelectedNote(response.data[0]);
    } catch (error) {
      console.error("Error fetching note by ID:", error);
    }
  };

  const handleUpdateNote = async () => {
    if (selectedNote.id) {
      try {
        await noteService.updateNote(selectedNote.id, selectedNote.title, selectedNote.content, selectedNote.reminder);
        fetchNoteById(selectedNote.id);
      } catch (error) {
        console.error("Error updating note:", error);
      }
    }
  };

  const handleDeleteNote = async () => {
    if (selectedNote.id) {
      try {
        await noteService.deleteNote(selectedNote.id);
        navigate("/");
      } catch (error) {
        console.error("Error deleting note:", error);
      }
    }
  };

  return (
    <div>
      <h1>Your Notes</h1>

      <NoteList />

      {id && selectedNote.id && (
        <NoteDetails
          title={selectedNote.title}
          content={selectedNote.content}
          reminder={selectedNote.reminder}
          onUpdateNote={handleUpdateNote}
          onDeleteNote={handleDeleteNote}
        />
      )}
     
    </div>
  );
};

export default HomeComponent;
