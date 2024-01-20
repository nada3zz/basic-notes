import React from 'react';
import { useNavigate , useLocation} from 'react-router-dom';
import AuthService from './../../services/authService';
import './NavBar.scss';

const NavBar: React.FC = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const isLoginPage = location.pathname === '/login';
  const isHomePage = location.pathname === '/';

  const handleLoginClick = () => {
    navigate('/login');
  };

  const handleRegisterClick = () => {
    navigate('/register');
  };

  const handleLogoutClick = () => {
    AuthService.logout(); 
    navigate('/login');
  };

  return (
    <nav className="navbar">
      <div className="brand">Note App</div>
      <div className="nav-links">
      {isHomePage && <button onClick={handleLogoutClick}>Logout</button>}
        {isLoginPage && <button onClick={handleRegisterClick}>Register</button>}
        {!isLoginPage && !isHomePage && <button onClick={handleLoginClick}>Login</button>}
      </div>
    </nav>
  );
};

export default NavBar;
