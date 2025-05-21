<template>
  <div class="login-container">
    <div class="login-form-container">
      <div class="login-form">
        <h1 class="login-title">Olá</h1>
        <p class="login-subtitle">Por favor, entre com suas credenciais</p>

        <form @submit.prevent="onSubmit">
          <div class="form-group">
            <label class="input-label">Email</label>
            <q-input
              v-model="email"
              outlined
              class="login-input"
              dense
              :rules="[(val) => !!val || 'Email é obrigatório', isValidEmail]"
              lazy-rules
            />
          </div>

          <div class="form-group">
            <label class="input-label">Senha</label>
            <q-input
              v-model="password"
              outlined
              :type="isPwd ? 'password' : 'text'"
              class="login-input"
              dense
              :rules="[
                (val) => !!val || 'Senha é obrigatória',
                (val) => val.length >= 6 || 'A senha deve ter pelo menos 6 caracteres',
              ]"
              lazy-rules
            >
              <template v-slot:append>
                <q-icon
                  :name="isPwd ? 'visibility_off' : 'visibility'"
                  class="cursor-pointer"
                  @click="isPwd = !isPwd"
                />
              </template>
            </q-input>
          </div>

          <q-btn
            type="submit"
            class="sign-in-btn"
            color="primary"
            label="Entrar"
            no-caps
            unelevated
            full-width
            :loading="loading"
          >
            <template v-slot:loading>
              <q-spinner-dots color="white" />
            </template>
          </q-btn>
        </form>
      </div>
    </div>

    <div class="logo-container">
      <img src="public/icons/flykit-logo-by-flaticon.com.png" alt="Logo" class="nuxt-logo" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useQuasar } from 'quasar';
import { useAuthStore } from 'stores/auth';

const $q = useQuasar();

const router = useRouter();
const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const isPwd = ref(true);
const loading = ref(false);

const isValidEmail = (val: string) => {
  const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return emailPattern.test(val) || 'Invalid email format';
};

async function onSubmit(): Promise<void> {
  try {
    if (!email.value || !password.value) {
      $q.notify({
        type: 'warning',
        message: 'Por favor, preencha todos os campos',
        position: 'top',
        timeout: 2000,
      });
      return;
    }

    loading.value = true;

    console.log('Attempting login with:', { email: email.value, password: password.value });

    await authStore.login(email.value, password.value);

    if (authStore.error) {
      $q.notify({
        type: 'negative',
        message: authStore.error,
        position: 'top',
        timeout: 3000,
      });

      return;
    }

    await router.push('/orders');
  } catch (error: unknown) {
    console.error('Erro ao fazer login:', error);
    const errorMessage = error instanceof Error ? error.message : 'Erro ao fazer login';

    $q.notify({
      type: 'negative',
      message: errorMessage,
      position: 'top',
      timeout: 3000,
      actions: [{ icon: 'close', color: 'white' }],
    });
  } finally {
    loading.value = false;
  }
}
</script>

<style lang="scss">
@import './LoginComponent.scss';
</style>
