import React from "react";
import Signup from '../components/AuthForm/Register';
import './../components/AuthForm/AuthForm.scss';

const RegisterPage: React.FC = () => {
  return (
    <div className="form-container">
      <Signup />
    </div>
  );
};

export default RegisterPage;
