<template>
  <div class="order-page">
    <div class="page-header">
      <h1>Pedidos de Viagem</h1>
      <p class="subtitle">Gerencie os pedidos de viagem da sua equipe</p>
    </div>
    <OrderList />
  </div>
</template>

<script setup lang="ts">
import OrderList from '../../components/Order/OrderList.vue';
</script>

<style lang="scss">
@import './OrderPage.scss';
</style>
