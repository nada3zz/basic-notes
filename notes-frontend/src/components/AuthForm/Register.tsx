import React, { useState, FormEvent } from "react";
import { useNavigate } from "react-router-dom";
import AuthService from "../../services/authService";
import './AuthForm.scss';

const Signup: React.FC = () => {
  const [username, setusername] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState<string | null>(null);

  const navigate = useNavigate();

  const handleSignup = async (e: FormEvent) => {
    e.preventDefault();

    if (!username || !email || !password) {
      setError("All fields are required");
      return;
    }

    try {
      const response = await AuthService.signup(username, email, password);
      if (response.status === 'success') {
        //console.log("Sign up", response);
        navigate("/");
        window.location.reload();
      } else {
        console.log("Sign up", response);
        setError(response.message || "Signup failed");
      }

    } catch (err) {
      console.log(err);
      setError("An error occurred. Please try again.");
    }
  };

  return (
    <div className="form">
      <form onSubmit={handleSignup}>
        <h2>Register</h2>
         {error && <p style={{ color: 'red' }}>{error}</p>} 
        <div>
        <label htmlFor="username">Username</label>
        <input
          type="text"
          placeholder="username"
          value={username}
          onChange={(e) => setusername(e.target.value)}
        />
        </div>
        <div>
        <label htmlFor="Email">Email</label>
        <input
          type="text"
          placeholder="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        </div>

        <div>
        <label htmlFor="password">password</label>
        <input
          type="password"
          placeholder="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        </div>
        <div>
        <button type="submit">Sign up</button>
        </div>
      </form>
    </div>
  );
};

export default Signup;
