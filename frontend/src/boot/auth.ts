import { defineBoot } from '#q-app/wrappers';
import { useAuthStore } from 'stores/auth';
import { api } from 'src/lib/axios';

// "async" is optional;
// more info on params: https://v2.quasar.dev/quasar-cli-vite/boot-files
export default defineBoot(async (/* { app, router, ... } */) => {
  const authStore = useAuthStore();

  try {
    debugger;
    const response = await api.get('/profile');

    authStore.user = {
      email: response.data.email,
      isAdmin: response.data.isAdmin,
    };
  } catch (err) {
    console.error(err);
    authStore.user = null;
  }
});
