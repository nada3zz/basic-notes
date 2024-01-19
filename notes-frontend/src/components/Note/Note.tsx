import React from 'react';
import { useRouteLoaderData, useSubmit } from 'react-router-dom';
import { MdDeleteForever } from 'react-icons/md';
import './Note.scss';

interface NoteProps {
    note: {
       id: string;
       title: string;
       content: string;
       date: string; 
    };
}

function Note({ note }: NoteProps) {
    const token = useRouteLoaderData('root') as string | null;
    const submit = useSubmit();
  
    function deleteNoteHandler() {
      const proceed = window.confirm('Are you sure?');
  
      if (proceed) {
        submit(null, { method: 'delete' });
    }
}

return (
    <div className='note'>
      <span>{note.content}</span>
      <div className='note-footer'>
        <small>{note.date}</small>
        <MdDeleteForever
          onClick={() => deleteNoteHandler()}
          className='delete-icon'
          size='1.3em'
        />
      </div>
    </div>
  );

}



export default Note;
