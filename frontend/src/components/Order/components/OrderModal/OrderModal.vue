<template>
  <Teleport to="body">
    <div v-if="show" class="modal-overlay" @click="onClose">
      <div class="modal" @click.stop>
        <div class="modal__header">
          <h2 class="modal__title">Editar Status do Pedido</h2>
          <button class="modal__close" @click="onClose">&times;</button>
        </div>

        <div class="modal__content">
          <div v-if="error" class="modal__error">
            {{ error }}
          </div>

          <div class="modal__form">
            <div class="form-group">
              <label class="form-group__label">Status</label>
              <select v-model="selectedStatus" class="form-group__select" :disabled="saving">
                <option v-for="status in availableStatuses" :key="status" :value="status">
                  {{ getStatusLabel(status) }}
                </option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal__footer">
          <button class="modal__button modal__button--cancel" @click="onClose" :disabled="saving">
            Cancelar
          </button>
          <button
            class="modal__button modal__button--save"
            @click="handleSave"
            :disabled="saving || !selectedStatus"
          >
            {{ saving ? 'Salvando...' : 'Salvar' }}
          </button>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { type Order, type OrderStatus, ORDER_STATUS } from '../../types';
import { getStatusLabel } from '../../utils';

const props = defineProps<{
  order: Order | null;
  show: boolean;
  saving: boolean;
  error: string | null;
}>();

const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'save', status: OrderStatus): void;
}>();

const selectedStatus = ref<OrderStatus | null>(null);

const availableStatuses = computed(() => {
  if (!props.order) return [];

  const currentStatus = props.order.status;
  const statuses = Object.values(ORDER_STATUS);

  // Remove current status from available options
  return statuses.filter((status) => status !== currentStatus);
});

function handleSave() {
  if (selectedStatus.value) {
    emit('save', selectedStatus.value);
  }
}

function onClose() {
  selectedStatus.value = null;
  emit('close');
}
</script>

<style lang="scss">
@import './OrderModal.scss';
</style>
