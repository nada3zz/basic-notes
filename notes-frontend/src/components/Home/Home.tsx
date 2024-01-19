import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import noteService from './../../services/note';
import AuthService from "../../services/authService";

interface Note {
  id: number;
  title: string
  content: string;
  reminder: Date;
  created_at: Date;
}

const Home: React.FC = () => {
  const [notes, setnotes] = useState<Note[]>([]);

  const navigate = useNavigate();

  useEffect(() => {
    noteService.getAllNotes().then(
      (response) => {
        setnotes(response.data);
      },
      (error) => {
        console.log("Private page", error.response);
        if (error.response && error.response.status === 401) {
          AuthService.logout();
          navigate("/login");
          window.location.reload();
        }
      }
    );
  });

  return (
    <div>
      <h3>{notes.map((note) => note.content)}</h3>
    </div>
  );
};

export default Home;
