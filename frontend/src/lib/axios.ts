import axios from 'axios';

// const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:9501';

const API_URL = 'http://localhost:9501';

export const api = axios.create({
  baseURL: API_URL,
  withCredentials: true, // enviar e receber cookies
  headers: {
    'Content-Type': 'application/json',
  },
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    const errorToReject = error instanceof Error ? error : new Error(String(error));
    return Promise.reject(errorToReject);
  },
);

export default api;
