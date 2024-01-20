import React, { useState } from "react";
import noteService from "../../services/noteService";

interface CreateNoteProps {
  onCreateNote: () => void;
}

const CreateNote: React.FC<CreateNoteProps> = () => {
  const [newNote, setNewNote] = useState({
    title: "",
    content: "",
    reminder: new Date(),
  });

  const handleCreateNote = async () => {
    try {
      await noteService.createNote(newNote.title, newNote.content, newNote.reminder);
      setNewNote({
        title: "",
        content: "",
        reminder: new Date(),
      });
      onCreateNote();
    } catch (error) {
      console.error("Error creating note:", error);
    }
  };

  return (
    <div>
      <h2>Create New Note</h2>
      <label>Title:</label>
      <input
        type="text"
        value={newNote.title}
        onChange={(e) => setNewNote({ ...newNote, title: e.target.value })}
      />
      <label>Content:</label>
      <textarea
        value={newNote.content}
        onChange={(e) => setNewNote({ ...newNote, content: e.target.value })}
      />
      <label>Reminder:</label>
      <input
        type="text"
        value={newNote.reminder.toString()}
        onChange={(e) => setNewNote({ ...newNote, reminder: new Date(e.target.value) })}
      />
      <button onClick={handleCreateNote}>Create Note</button>
    </div>
  );
};

export default CreateNote;