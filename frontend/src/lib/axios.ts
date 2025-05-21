import axios from 'axios';

export const api = axios.create({
  baseURL: process.env.API_URL || 'http://localhost:9501',
  withCredentials: true,
  headers: {
    'Content-Type': 'application/json',
  },
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    console.error('Axios error:', error);
  },
);

export default api;
