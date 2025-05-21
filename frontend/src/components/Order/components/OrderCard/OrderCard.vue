<template>
  <div
    class="order-card"
    :class="{
      'order-card--admin': isAdmin,
      'order-card--approved': order.status === ORDER_STATUS.APPROVED,
      'order-card--cancelled': order.status === ORDER_STATUS.CANCELLED,
    }"
  >
    <div class="order-card__header">
      <h3 class="order-card__title">Pedido #{{ order.orderId }}</h3>
      <span class="order-card__status" :class="`order-card__status--${order.status}`">
        {{ getStatusLabel(order.status) }}
      </span>
    </div>

    <div class="order-card__content">
      <p class="order-card__date">
        <i class="icon-calendar"></i>
        {{ formatDate(order.departureDate) }} - {{ formatDate(order.arrivalDate) }}
      </p>
      <p class="order-card__customer">
        <i class="icon-user"></i>
        {{ order.requesterName }}
      </p>
      <p class="order-card__destination">
        <i class="icon-location"></i>
        {{ order.destination }}
      </p>
    </div>

    <div v-if="isAdmin" class="order-card__actions">
      <button
        class="order-card__edit-button"
        @click="$emit('edit', order)"
        :disabled="
          order.status === ORDER_STATUS.CANCELLED || order.status === ORDER_STATUS.APPROVED
        "
      >
        Editar Status
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { type Order, ORDER_STATUS } from '../../types';
import { formatDate, getStatusLabel } from '../../utils';

defineProps<{
  order: Order;
  isAdmin: boolean;
}>();

defineEmits<{
  (e: 'edit', order: Order): void;
}>();
</script>

<style lang="scss">
@import './OrderCard.scss';
</style>
