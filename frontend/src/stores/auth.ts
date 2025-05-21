import { defineStore } from 'pinia';
import { api } from '../lib/axios';
import type { AxiosError } from 'axios';

interface IUser {
  email: string;
  isAdmin: boolean;
}

interface ApiError {
  error: string;
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as IUser | null,
    error: null as string | null,
  }),

  actions: {
    async login(email: string, password: string) {
      this.error = null;

      try {
        const response = await api.post('/login', { email, password });

        this.user = {
          email: response.data.email,
          isAdmin: response.data.isAdmin,
        };
      } catch (err) {
        const error = err as AxiosError<ApiError>;
        this.error = error.response?.data?.error || 'Login failed';
        this.user = null;
      }
    },

    logout() {
      this.user = null;
    },

    isAuthenticated(): boolean {
      return !!this.user;
    },

    isAdmin(): boolean {
      return !!this.user?.isAdmin;
    },
  },
});
