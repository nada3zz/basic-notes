import React, { useState } from "react";
import noteService from "../../services/noteService";
import './NoteForm.scss';

const CreateNote: React.FC = () => {
  const [newNote, setNewNote] = useState({
    title: "",
    content: "",
    reminder: new Date().toISOString().split("T")[0]
  });

  const handleCreateNote = async (e: React.MouseEvent<HTMLButtonElement>) => {
    e.preventDefault();
    try {
      await noteService.createNote(newNote.title, newNote.content, newNote.reminder);
      setNewNote({
        title: "",
        content: "",
        reminder: new Date().toISOString().split("T")[0], 
      });
      window.location.reload();
    } catch (error) {
      console.error("Error creating note:", error);
    }
  };

  return (
    <div className="note-form-container">
      <form className="noteForm">
      <h2>Create New Note</h2>
  
      <div className="form-row">
        <label className="label">Title:</label>
        <input
          type="text"
          value={newNote.title}
          onChange={(e) => setNewNote({ ...newNote, title: e.target.value })}
        />
      </div>
  
      <div className="form-row">
        <label className="label">Content:</label>
        <textarea
          value={newNote.content}
          onChange={(e) => setNewNote({ ...newNote, content: e.target.value })}
        />
      </div>
  
      <div className="form-row">
        <label className="label">Reminder:</label>
        <input
          type="date"
          value={newNote.reminder}
          onChange={(e) => setNewNote({ ...newNote, reminder: e.target.value })}
        />
      </div>
  
      <button onClick={handleCreateNote}>Add</button>
      </form>
    </div>
    
  );
};

export default CreateNote;
