import React, { useEffect, useState } from "react";
import noteService from "../../services/noteService";
import { MdDeleteForever, MdModeEdit } from "react-icons/md";
import { useNavigate } from "react-router-dom";
import "./NotesList.scss";


interface Note {
  id: number;
  title: string;
  content: string;
  created_at: string;
}

const NoteList: React.FC = () => {
  const [notes, setNotes] = useState<Note[]>([]);
  const [error, setError] = useState<string | null>(null);
  const navigate = useNavigate();

  useEffect(() => {
    fetchNotes();
  }, []);

  const fetchNotes = async () => {
    try {
      const response = await noteService.getAllNotes();
      if (response && response.status === 200){
      setNotes(response.data);
      } else {
        setError(response?.message || "No Notes Found")
      }
    } catch (error) {
      console.error("Error fetching notes:", error);
    }
  };

  const editNoteHandler = (id: number) => {
    navigate(`/editnote/${id}`);
  };

  const deleteNoteHandler = async (id: number) => {
    try {
      const response = await noteService.deleteNote(id);
      console.log(response);
      fetchNotes();
    } catch (error) {
      console.error("Error deleting note", error);
    }
  };


  return (
    <div>
      <div className="container">
      {error && <p style={{ color: 'red' }}>{error}</p>} 
        {notes.map((note) => (
          <div className="note">
            <h3>{note.title}</h3>
            <p>{note.content}</p>
            <div className="note-footer">
            <small>{note.created_at}</small>
            <div className="icons">
              <MdModeEdit className="edit-icon" size="1.3em" onClick={() => editNoteHandler(note.id)}/>
              <MdDeleteForever className="delete-icon" size="1.3em" onClick={() => deleteNoteHandler(note.id)} />
            </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default NoteList;
