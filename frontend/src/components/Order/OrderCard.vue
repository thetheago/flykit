<template>
  <div
    :class="[
      'order-card',
      {
        'order-card--disabled':
          order.status === ORDER_STATUS.APPROVED || order.status === ORDER_STATUS.CANCELLED,
        'order-card--editable': isAdmin && order.status === ORDER_STATUS.REQUESTED,
      },
    ]"
    @click="handleCardClick"
  >
    <div class="order-header">
      <h3>Pedido #{{ order.orderId }}</h3>
      <span :class="['status-badge', order.status]">{{ getStatusLabel(order.status) }}</span>
    </div>

    <div class="order-details">
      <div class="detail-item">
        <span class="label">Solicitante:</span>
        <span class="value">{{ order.requesterName }}</span>
      </div>
      <div class="detail-item">
        <span class="label">Destino:</span>
        <span class="value">{{ order.destination }}</span>
      </div>
      <div class="detail-item">
        <span class="label">Saída:</span>
        <span class="value">{{ formatDateForDisplay(order.departureDate) }}</span>
      </div>
      <div class="detail-item">
        <span class="label">Chegada:</span>
        <span class="value">{{ formatDateForDisplay(order.arrivalDate) }}</span>
      </div>
    </div>

    <div v-if="isAdmin && order.status === ORDER_STATUS.REQUESTED" class="order-actions">
      <button @click.stop="onEdit(order)" class="edit-button">Editar Status</button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ORDER_STATUS, type OrderStatus, type OrderCardProps } from './types';
import { formatDateForDisplay } from '../../utils/dateUtils';

const props = defineProps<OrderCardProps>();

function getStatusLabel(status: OrderStatus): string {
  const labels: Record<OrderStatus, string> = {
    [ORDER_STATUS.REQUESTED]: 'Solicitado',
    [ORDER_STATUS.APPROVED]: 'Aprovado',
    [ORDER_STATUS.CANCELLED]: 'Cancelado',
  };
  return labels[status];
}

function handleCardClick() {
  if (props.isAdmin && props.order.status === ORDER_STATUS.REQUESTED) {
    props.onEdit(props.order);
  }
}
</script>

<style scoped>
@import './OrderCard.scss';
</style>
