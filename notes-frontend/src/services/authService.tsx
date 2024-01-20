import axios from "axios";

interface AuthResponse {
  status: string;
  token: string;
  user_id: string;
  message: string;
}

const API_URL = "http://localhost/luftborn-task/notesBackend/src/index.php";

const signup = async ( username: string, email: string, password: string): Promise<AuthResponse> => {
  try {
    const response = await axios.post<AuthResponse>(API_URL + "/register", {
      username,
      email,
      password,
    });

    if (response.data.status === 'success') {
      localStorage.setItem("token", response.data.token);
    }

    return response.data;
  } catch (error) {
    console.error("Signup Failed:", error);
    throw error; 
  }
};


const login = async (email: string, password: string): Promise<AuthResponse> => {
  try {
    const response = await axios.post<AuthResponse>(API_URL + "/login", {
      email,
      password,
    });

    if (response.data.status === 'success') {
      localStorage.setItem("token", response.data.token);
    }

    return response.data;
  } catch (error) {
    console.error("Login failed:", error);
    throw error; 
  }
};


const logout = (): void => {
  localStorage.removeItem("token");
};


const authService = {
  signup,
  login,
  logout,
};

export default authService;




