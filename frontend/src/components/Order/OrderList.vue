<template>
  <div class="orders-container">
    <div class="orders-header">
      <h1>Pedidos</h1>
      <button class="orders-header__create-button" @click="openCreateModal">
        <span class="orders-header__plus-icon">+</span>
        Novo Pedido
      </button>
    </div>

    <StatusFilter @filter="handleStatusFilter" />

    <div v-if="loading" class="orders-loading">
      <div class="orders-loading__spinner"></div>
      <p>Carregando pedidos...</p>
    </div>

    <div v-else-if="error" class="orders-error">
      <i class="orders-error__icon">⚠️</i>
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
import OrderCard from './components/OrderCard/OrderCard.vue';
import OrderModal from './components/OrderModal/OrderModal.vue';
import CreateOrderModal from './components/CreateOrderModal/CreateOrderModal.vue';
import StatusFilter from './components/Filter/StatusFilter/StatusFilter.vue';

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

const currentStatus = ref<OrderStatus | null>(null);

const fetchOrders = async () => {
  try {
    loading.value = true;
    error.value = null;
    const params = currentStatus.value ? { status: currentStatus.value } : {};
    console.log('Fetching orders with params:', params);
    const response = await api.get('/v1/order', { params });
    console.log('Orders received from API:', response.data);
    orders.value = response.data;
    console.log('Orders after update:', orders.value);
  } catch (err) {
    console.error('Error fetching orders:', err);
    error.value = 'Erro ao carregar pedidos. Tente novamente mais tarde.';
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
    await api.patch(`/v1/order/${selectedOrder.value.orderId}`, { status });

    // Update locally
    const idx = orders.value.findIndex((o) => o.orderId === selectedOrder.value!.orderId);
    const currentOrder = idx !== -1 ? orders.value[idx] : null;

    if (currentOrder) {
      const updatedOrder: Order = {
        orderId: currentOrder.orderId,
        requesterName: currentOrder.requesterName,
        destination: currentOrder.destination,
        departureDate: currentOrder.departureDate,
        arrivalDate: currentOrder.arrivalDate,
        status: status,
      };
      orders.value[idx] = updatedOrder;
    }

    closeModal();
  } catch (err: unknown) {
    modalError.value = getErrorMessage(err);
  } finally {
    saving.value = false;
  }
}

function getErrorMessage(err: unknown): string {
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
    return (
      (err as { response: { data: { error?: string } } }).response.data.error ||
      'Erro ao atualizar status'
    );
  }

  if (typeof err === 'object' && err && 'message' in err) {
    return (err as { message?: string }).message || 'Erro ao atualizar status';
  }

  return 'Erro ao atualizar status';
}

function openCreateModal() {
  showCreateModal.value = true;
}

async function handleOrderCreated() {
  console.log('Order created, fetching updated list...');
  await fetchOrders();
  console.log('Orders after creation:', orders.value);
}

function handleStatusFilter(status: OrderStatus | null) {
  currentStatus.value = status;
  void fetchOrders();
}
</script>

<style lang="scss">
@import './styles.scss';
</style>
