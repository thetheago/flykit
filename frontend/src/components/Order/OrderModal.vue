<template>
  <div v-if="show" class="modal-overlay" @click.self="onClose">
    <div class="modal">
      <div class="modal-header">
        <h2>Editar Status do Pedido #{{ order?.orderId }}</h2>
        <button class="close-button" @click="onClose">×</button>
      </div>

      <div class="modal-content">
        <div v-if="error" class="modal-error">
          <i class="error-icon">⚠️</i>
          {{ error }}
        </div>

        <div class="form-group">
          <label for="status">Status do Pedido:</label>
          <select v-model="selectedStatus" id="status" class="status-select">
            <option :value="ORDER_STATUS.REQUESTED">Solicitado</option>
            <option :value="ORDER_STATUS.APPROVED">Aprovado</option>
            <option :value="ORDER_STATUS.CANCELLED">Cancelado</option>
          </select>
        </div>

        <div class="modal-actions">
          <button @click="handleSave" :disabled="saving" class="save-button">
            <span v-if="saving" class="spinner small"></span>
            <span v-else>Salvar Alterações</span>
          </button>
          <button @click="onClose" :disabled="saving" class="cancel-button">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { ORDER_STATUS, type OrderStatus, type OrderModalProps } from './types';

const props = defineProps<OrderModalProps>();
const selectedStatus = ref<OrderStatus>(ORDER_STATUS.REQUESTED);

watch(
  () => props.order,
  (newOrder) => {
    if (newOrder) {
      selectedStatus.value = newOrder.status;
    }
  },
);

async function handleSave() {
  await props.onSave(selectedStatus.value);
}
</script>

<style scoped>
@import './OrderModal.scss';
</style>
