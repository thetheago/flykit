<template>
  <div class="status-filter">
    <label for="status-select" class="filter-label">Filtro por status</label>
    <select
      id="status-select"
      v-model="selectedStatus"
      @change="handleStatusChange"
      class="status-select"
    >
      <option value="">Todos os status</option>
      <option v-for="(value, key) in ORDER_STATUS" :key="key" :value="value">
        {{ formatStatus(value) }}
      </option>
    </select>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { ORDER_STATUS, type OrderStatus } from '../types';

const emit = defineEmits<{
  (e: 'filter', status: OrderStatus | null): void;
}>();

const selectedStatus = ref<OrderStatus | ''>('');

const formatStatus = (status: string): string => {
  const statusMap: Record<string, string> = {
    requested: 'Solicitado',
    approved: 'Aprovado',
    cancelled: 'Cancelado',
  };
  return statusMap[status] || status;
};

const handleStatusChange = () => {
  emit('filter', selectedStatus.value || null);
};
</script>

<style scoped lang="scss">
@import './StatusFilter.scss';
</style>
