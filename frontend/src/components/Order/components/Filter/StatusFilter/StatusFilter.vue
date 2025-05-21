<template>
  <div class="status-filter">
    <button
      v-for="status in availableStatuses"
      :key="status"
      class="status-filter__button"
      :class="{
        'status-filter__button--active': currentStatus === status,
        [`status-filter__button--${status}`]: true,
      }"
      @click="handleClick(status)"
    >
      {{ getStatusLabel(status) }}
    </button>
    <button
      class="status-filter__button status-filter__button--clear"
      :class="{ 'status-filter__button--active': currentStatus === null }"
      @click="handleClick(null)"
    >
      Todos
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { type OrderStatus, ORDER_STATUS } from '../../../types';
import { getStatusLabel } from '../../../utils';

const props = defineProps<{
  initialStatus?: OrderStatus | null;
}>();

const emit = defineEmits<{
  (e: 'filter', status: OrderStatus | null): void;
}>();

const currentStatus = ref<OrderStatus | null>(props.initialStatus ?? null);
const availableStatuses = Object.values(ORDER_STATUS);

function handleClick(status: OrderStatus | null) {
  console.log('Status filter changed to:', status);
  currentStatus.value = status;
  emit('filter', status);
}
</script>

<style lang="scss">
@import './StatusFilter.scss';
</style>
