import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import noteService from "../../services/noteService";

interface Note {
  id: number;
  title: string;
}

const NoteList: React.FC = () => {
  const [notes, setNotes] = useState<Note[]>([]);

  useEffect(() => {
    fetchNotes();
  }, []);

  const fetchNotes = async () => {
    try {
      const response = await noteService.getAllNotes();
      setNotes(response.data);
    } catch (error) {
      console.error("Error fetching notes:", error);
    }
  };

  return (
    <div>
      <h2>All Notes</h2>
      <ul>
        {notes.map((note) => (
          <li key={note.id}>
            <Link to={`/notes/${note.id}`}>{note.title}</Link>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default NoteList;
