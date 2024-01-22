import axios, { AxiosResponse } from "axios";
import authHeader from "./authHeader";

interface Note {
  id: number;
  title: string;
  content: string;
  reminder: Date;
  created_at: Date;
  updated_at:Date;
}

const API_URL = "http://localhost/luftborn-task/notesBackend/src/index.php";

const getAllNotes = (): Promise<AxiosResponse<Note[]>> => {
  return axios.get<Note[]>(API_URL + "/notes", { headers: authHeader() });
};

const getNoteById = (id: number): Promise<AxiosResponse<Note[]>> => {
  return axios.get<Note[]>(API_URL + `/notes?id=${id}`, { headers: authHeader() });
};

const createNote = (title: string, content: string, reminder: string): Promise<AxiosResponse<Note[]>> => {
  return axios.post<Note[]>(API_URL + "/notes", { title, content, reminder }, { headers: authHeader() });
};

const updateNote = (id: number, title: string, content: string, reminder: Date, updated_at: Date): Promise<AxiosResponse<Note[]>> => {
  return axios.put<Note[]>(API_URL + `/notes?id=${id}`, { title, content, reminder, updated_at }, { headers: authHeader() });
};

const deleteNote = (id: number): Promise<AxiosResponse<Note[]>> => {
  return axios.delete<Note[]>(API_URL + `/notes?id=${id}`, { headers: authHeader() });
};

const noteService = {
  getAllNotes,
  getNoteById,
  createNote,
  updateNote,
  deleteNote
};

export default noteService;
