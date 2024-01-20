import NavBar from "../components/NavBar/NavBar";
//import CreateNote from "../components/CreateNote/AddNote";
import HomeComponent from './../components/Home/Home';


const Home: React.FC = () => {
  return (
    <div>
      <NavBar></NavBar>
      <HomeComponent></HomeComponent>
  </div>
  );
};

export default Home;

