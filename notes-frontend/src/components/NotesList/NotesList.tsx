import React from 'react';
import Note from '../Note/Note';
import AddNote from '../createNote/AddNote';
import './NotesList.scss';


interface NotesListProps {
  notes: Array<{
    id: string;
    title: string;
    content: string;
    date: string; 
  }>;
  handleAddNote: (text: string) => void;
  deleteNoteHandler: (id: string) => void;
}

const NotesList: React.FC<NotesListProps> = ({
  notes,
  handleAddNote,
  deleteNoteHandler,
}) => {
  return (
    <div className='notes-list'>
      {notes.map((note) => (
        <Note
          id={note.id}
          title={note.title}
          content={note.content}
          date={note.date}
          handleDeleteNote={deleteNoteHandler}
        />
      ))}
      <AddNote handleAddNote={handleAddNote} />
    </div>
  );
};

export default NotesList;
