import React, { useEffect, useState } from "react";
import noteService from "../../services/noteService";
import { useNavigate, useParams } from "react-router-dom";
import './NoteForm.scss';

interface Note {
  id: number;
  title: string;
  content: string;
  reminder: string;
  updated_at: string;
}

const EditNote: React.FC = () => {
  const [note, setNote] = useState<Note | null>(null);
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    fetchNote();
  }, [id]);

  const fetchNote = async () => {
    try {
      const response = await noteService.getNoteById(Number(id));
      //console.log(response.data)
      setNote(response.data);
    } catch (error) {
      console.error("Error fetching note:", error);
    }
  };

  const handleUpdateNote = async () => {
    if (note) {
      try {
        await noteService.updateNote(
          note.id,
          note.title,
          note.content,
          note.reminder,
          new Date()
        );
      } catch (error) {
        console.error("Error updating note:", error);
      }
    }
    navigate("/"); 
    window.location.reload();
  };

  if (!note) {
    return <div>Loading...</div>;
  }

  return (
<div className="note-form-container">
  <form className="noteForm">
    <h2>Update Note</h2>

    <div className="form-row">
      <label className="label">Title:</label>
      <input
        type="text"
        value={note.title} 
        onChange={(e) => setNote({ ...note, title: e.target.value })}
      />
    </div>

    <div className="form-row">
      <label className="label">Content:</label>
      <textarea
        value={note.content}
        onChange={(e) => setNote({ ...note, content: e.target.value })}
      />
    </div>

    <div className="form-row">
      <label className="label">Reminder:</label>
      <input
        type="date"
        value={note.reminder}
        onChange={(e) => setNote({ ...note, reminder: e.target.value })}
      />
    </div>

    <button onClick={handleUpdateNote}>Update</button>
  </form>
</div>

  );
};

export default EditNote;
