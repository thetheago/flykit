<template>
  <div class="orders-container">
    <div class="orders-header">
      <h1>Pedidos</h1>
      <button class="create-button" @click="openCreateModal">
        <span class="plus-icon">+</span>
        Novo Pedido
      </button>
    </div>

    <div v-if="loading" class="loading-state">
      <div class="spinner"></div>
      <p>Carregando pedidos...</p>
    </div>

    <div v-else-if="error" class="error-state">
      <i class="error-icon">⚠️</i>
      <p>{{ error }}</p>
    </div>

    <div v-else class="orders-grid">
      <OrderCard
        v-for="order in orders"
        :key="order.orderId"
        :order="order"
        :is-admin="isAdmin"
        @edit="openEditModal"
      />
    </div>

    <OrderModal
      :order="selectedOrder"
      :show="showModal"
      :saving="saving"
      :error="modalError"
      @close="closeModal"
      @save="saveStatus"
    />

    <CreateOrderModal v-model="showCreateModal" @created="handleOrderCreated" />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useAuthStore } from '../../stores/auth';
import { api } from '../../lib/axios';
import { type Order, type OrderStatus } from './types';
import OrderCard from './OrderCard.vue';
import OrderModal from './OrderModal.vue';
import CreateOrderModal from './CreateOrderModal.vue';

const orders = ref<Order[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

const showModal = ref(false);
const selectedOrder = ref<Order | null>(null);
const saving = ref(false);
const modalError = ref<string | null>(null);

const showCreateModal = ref(false);

const authStore = useAuthStore();
const isAdmin = computed(() => authStore.isAdmin());

const fetchOrders = async () => {
  try {
    loading.value = true;
    const response = await api.get('/v1/order');
    orders.value = response.data;
  } catch (error) {
    console.error('Error fetching orders:', error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  void fetchOrders();
});

function openEditModal(order: Order) {
  selectedOrder.value = { ...order };
  modalError.value = null;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
  selectedOrder.value = null;
  modalError.value = null;
}

async function saveStatus(status: OrderStatus) {
  if (!selectedOrder.value) return;
  saving.value = true;
  modalError.value = null;
  try {
    await api.patch(`/v1/order/${selectedOrder.value.orderId}`, {
      status,
    });
    // Atualiza localmente
    const idx = orders.value.findIndex((o) => o.orderId === selectedOrder.value!.orderId);
    if (idx !== -1) {
      (orders.value[idx] as Order).status = status;
    }
    closeModal();
  } catch (err: unknown) {
    if (
      typeof err === 'object' &&
      err !== null &&
      'response' in err &&
      typeof (err as { response?: unknown }).response === 'object' &&
      (err as { response?: { data?: unknown } }).response &&
      'data' in (err as { response: { data?: unknown } }).response &&
      typeof (err as { response: { data?: unknown } }).response.data === 'object' &&
      (err as { response: { data: { error?: string } } }).response.data &&
      'error' in (err as { response: { data: { error?: string } } }).response.data
    ) {
      modalError.value =
        (err as { response: { data: { error?: string } } }).response.data.error ||
        'Erro ao atualizar status';
    } else if (typeof err === 'object' && err && 'message' in err) {
      modalError.value = (err as { message?: string }).message || 'Erro ao atualizar status';
    } else {
      modalError.value = 'Erro ao atualizar status';
    }
  } finally {
    saving.value = false;
  }
}

function openCreateModal() {
  showCreateModal.value = true;
}

async function handleOrderCreated() {
  await fetchOrders();
}
</script>

<style scoped>
@import './OrderList.scss';
</style>
