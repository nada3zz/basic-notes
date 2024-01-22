import NavBar from "../components/NavBar/NavBar";
import CreateNote from "../components/NoteForm/CreateNote";
import NotesList from './../components/NotesList/NotesList';

const Home: React.FC = () => {
  return (
    <div>
      <NavBar/>
      <CreateNote/>
      <NotesList/>
  </div>
  );
};

export default Home;

