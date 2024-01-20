import React from "react";
import Login from "../components/AuthForm/LogIn";
import './../components/AuthForm/AuthForm.scss';

const LogInPage: React.FC = () => {
  return (
    <div className="form-container">
      <Login />
    </div>
  );
};

export default LogInPage;
