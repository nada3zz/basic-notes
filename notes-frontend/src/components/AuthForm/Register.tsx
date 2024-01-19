import React, { useState, FormEvent } from "react";
import { useNavigate } from "react-router-dom";
import AuthService from "../../services/authService";


const Signup: React.FC = () => {
  const [username, setusername] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const navigate = useNavigate();

  const handleSignup = async (e: FormEvent) => {
    e.preventDefault();
    try {
      await AuthService.signup(email, password, username).then(
        (response) => {
          //console.log("Sign up successfully", response);
          navigate("/home");
          window.location.reload();
        },
        (error) => {
          console.log(error);
        }
      );
    } catch (err) {
      console.log(err);
    }
  };

  return (
    <div>
      <form onSubmit={handleSignup}>
        <h3>Sign up</h3>
        <input
          type="text"
          placeholder="username"
          value={email}
          onChange={(e) => setusername(e.target.value)}
        />
        <input
          type="text"
          placeholder="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <input
          type="password"
          placeholder="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        <button type="submit">Sign up</button>
      </form>
    </div>
  );
};

export default Signup;
