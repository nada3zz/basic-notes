import React from "react";

interface NoteDetailsProps {
  title: string;
  content: string;
  reminder: Date;
  onUpdateNote: () => void;
  onDeleteNote: () => void;
}

const NoteDetails: React.FC<NoteDetailsProps> = ({ title, content, reminder, onUpdateNote, onDeleteNote }) => {
  return (
    <div>
      <h2>Note Details</h2>
      <p>Title: {title}</p>
      <p>Content: {content}</p>
      <p>Reminder: {reminder.toString()}</p>
      <button onClick={onUpdateNote}>Update Note</button>
      <button onClick={onDeleteNote}>Delete Note</button>
    </div>
  );
};

export default NoteDetails;
