<template>
  <div class="login-container">
    <div class="login-form-container">
      <div class="login-form">
        <h1 class="login-title">Hello</h1>
        <p class="login-subtitle">Please sign in below</p>
        
        <div class="q-mt-md">
          <label class="input-label">Email</label>

          <q-input 
            v-model="email" 
            outlined 
            class="login-input" 
            bg-color="blue-1" 
            dense
          />
        </div>
        
        <div class="q-mt-md">
          <label class="input-label">Password</label>
          <q-input 
            v-model="password" 
            outlined 
            type="password" 
            class="login-input" 
            bg-color="blue-1" 
            dense
          />
        </div>
        
        <q-btn 
          class="sign-in-btn q-mt-md" 
          color="primary" 
          label="Sign in" 
          no-caps 
          unelevated 
          full-width
        />
      </div>
    </div>
    
    <div class="logo-container">
      <img src="public/icons/flykit-logo-by-flaticon.com.png" alt="Logo" class="nuxt-logo" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const email = ref('')
const password = ref('')
</script>

<style lang="scss">
@import './LoginComponent.scss';
</style>