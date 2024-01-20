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
  return axios.get<Note[]>(API_URL + `/notes?=${id}`, { headers: authHeader() });
};

const createNote = ( title:string, content:string, reminder:Date): Promise<AxiosResponse<Note[]>> => {
  return axios.post<Note[]>(API_URL + "/notes", { headers: authHeader() });
}; 

const updateNote = (id: number, title:string, content:string, reminder:Date): Promise<AxiosResponse<Note[]>> => {
  return axios.post<Note[]>(API_URL + `/notes?=${id}`, { headers: authHeader() });
};

const deleteNote = (id: number): Promise<AxiosResponse<Note[]>> => {
  return axios.post<Note[]>(API_URL + `/notes?=${id}`, { headers: authHeader() });
};

const noteService = {
  getAllNotes,
  getNoteById,
  createNote,
  updateNote,
  deleteNote
};

export default noteService;
