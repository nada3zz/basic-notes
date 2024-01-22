import { BrowserRouter, Routes, Route } from "react-router-dom";
import Home from "./pages/Home";
import LogInPage from "./pages/LogIn";
import RegisterPage from './pages/Register';
import EditNote from './components/NoteForm/EditNote';


function App() {
  return (
    <div className="app">
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/login" element={<LogInPage />} />
          <Route path="/register" element={< RegisterPage/>} />
          <Route path="/editnote/:id" element={< EditNote/>} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
