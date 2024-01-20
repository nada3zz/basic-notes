import { BrowserRouter, Routes, Route } from "react-router-dom";
import Home from "./pages/Home";
import LogInPage from "./pages/LogIn";
import RegisterPage from './pages/Register';


function App() {
  return (
    <div className="app">
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/login" element={<LogInPage />} />
          <Route path="/register" element={< RegisterPage/>} />
        </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
