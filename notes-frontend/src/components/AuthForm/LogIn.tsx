import React, { useState, FormEvent } from "react";
import { useNavigate } from "react-router-dom";
import AuthService from './../../services/authService';
import './AuthForm.scss';

const Login: React.FC = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState<string | null>(null);

  const navigate = useNavigate();

  const handleLogin = async (e: FormEvent) => {
    e.preventDefault();
    try {
     const response = await AuthService.login(email, password);
     if (response.status === "success") {
      //console.log("login", response)
      navigate("/");
      window.location.reload();
     } else {
      setError(response.message || "Login Failed")
     }

    } catch (err) {
      console.log(err);
      setError("An error occurred. Please try again.");
    }
  };

  return (
    <div className="form">
      <form onSubmit={handleLogin}>
        <h3>Login</h3>
        {error && <p style={{ color: 'red' }}>{error}</p>} 
        <div>
        <label htmlFor="email">Email</label>
        <input
          type="text"
          placeholder="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        </div>

        <div>
        <label htmlFor="password">Password</label>
        <input
          type="password"
          placeholder="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        </div>
        <button type="submit">Log in</button>
      </form>
    </div>
  );
};

export default Login;

