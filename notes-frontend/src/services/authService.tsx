import axios, { AxiosResponse } from "axios";

interface User {
  email: string;
  password: string;
  accessToken: string;
}

const API_URL = "http://localhost/luftborn-task/notesBackend/src/index.php";

const signup = (email: string, password: string, username: string): Promise<User> => {
  return axios
    .post<User>(API_URL + "/register", {
    username,
      email,
      password,
    })
    .then((response: AxiosResponse<User>) => {
      if (response.data.accessToken) {
        localStorage.setItem("user", JSON.stringify(response.data));
      }

      return response.data;
    });
};

const login = (email: string, password: string): Promise<User> => {
  return axios
    .post<User>(API_URL + "/login", {
      email,
      password,
    })
    .then((response: AxiosResponse<User>) => {
      if (response.data.accessToken) {
        localStorage.setItem("user", JSON.stringify(response.data));
      }

      return response.data;
    });
};

const logout = (): void => {
  localStorage.removeItem("user");
};

const getCurrentUser = (): User | null => {
  const userString = localStorage.getItem("user");
  return userString ? JSON.parse(userString) : null;
};

const authService = {
  signup,
  login,
  logout,
  getCurrentUser,
};

export default authService;
