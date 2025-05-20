<template>
  <div class="login-container">
    <div class="login-form-container">
      <div class="login-form">
        <h1 class="login-title">Hello</h1>
        <p class="login-subtitle">Please sign in below</p>

        <form @submit.prevent="onSubmit">
          <div class="form-group">
            <label class="input-label">Email</label>
            <q-input
              v-model="email"
              outlined
              class="login-input"
              dense
              :rules="[(val) => !!val || 'Email is required', isValidEmail]"
              lazy-rules
            />
          </div>

          <div class="form-group">
            <label class="input-label">Password</label>
            <q-input
              v-model="password"
              outlined
              :type="isPwd ? 'password' : 'text'"
              class="login-input"
              dense
              :rules="[
                (val) => !!val || 'Password is required',
                (val) => val.length >= 6 || 'Password must be at least 6 characters',
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
            label="Sign in"
            no-caps
            unelevated
            full-width
            :loading="loading"
            @click="onSubmit"
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
import { useQuasar } from 'quasar';
const $q = useQuasar();

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
        message: 'Please fill in all fields',
        position: 'top',
        timeout: 2000,
      });

      return;
    }

    loading.value = true;

    console.log('Attempting login with:', { email: email.value, password: password.value });

    await new Promise((resolve) => setTimeout(resolve, 2000));

    $q.notify({
      type: 'positive',
      message: 'Login successful!',
      position: 'top',
      timeout: 2000,
    });

    console.log('Login success');
  } catch (error: unknown) {
    console.error('Login error:', error);
    const errorMessage = error instanceof Error ? error.message : 'Login failed';

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
