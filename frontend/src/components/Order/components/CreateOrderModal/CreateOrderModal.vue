<template>
  <QDialog v-model="isOpen" persistent @hide="handleClose">
    <QCard class="modal-content">
      <QCardSection class="modal-header">
        <div class="text-h6">Criar Novo Pedido</div>
        <QBtn flat round dense icon="close" @click="handleClose" />
      </QCardSection>

      <QCardSection>
        <form @submit.prevent="handleSubmit" class="create-order-form">
          <div class="form-group">
            <label for="orderId">ID do Pedido</label>
            <QInput
              id="orderId"
              v-model="formData.orderId"
              type="number"
              min="1"
              :error="!!validationErrors.orderId"
              :error-message="validationErrors.orderId"
              outlined
              dense
              placeholder="Digite o ID do pedido"
            />
          </div>

          <div class="form-group">
            <label for="requesterName">Nome do Requerente</label>
            <QInput
              id="requesterName"
              v-model="formData.requesterName"
              type="text"
              maxlength="30"
              :error="!!validationErrors.requesterName"
              :error-message="validationErrors.requesterName"
              outlined
              dense
              placeholder="Digite o nome do requerente"
            />
          </div>

          <div class="form-group">
            <label for="destination">Destino</label>
            <QInput
              id="destination"
              v-model="formData.destination"
              type="text"
              maxlength="60"
              :error="!!validationErrors.destination"
              :error-message="validationErrors.destination"
              outlined
              dense
              placeholder="Digite o destino"
            />
          </div>

          <DateInput
            id="departureDate"
            v-model="formData.departureDate"
            label="Data de Partida"
            :min="minDate"
            @update:modelValue="(value) => (formData.departureDate = value)"
            :max="maxDate"
            :error="validationErrors.departureDate"
          />

          <DateInput
            id="arrivalDate"
            v-model="formData.arrivalDate"
            label="Data de Chegada"
            :min="formData.departureDate || minDate"
            :max="maxDate"
            :error="validationErrors.arrivalDate"
          />

          <QCardActions align="right" class="q-mt-md">
            <QBtn flat label="Cancelar" color="primary" :disable="saving" @click="handleClose" />
            <QBtn type="submit" label="Criar Pedido" color="primary" :loading="saving" />
          </QCardActions>
        </form>
      </QCardSection>
    </QCard>
  </QDialog>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useQuasar } from 'quasar';
import { QDialog, QCard, QCardSection, QCardActions, QBtn, QInput } from 'quasar';
import { api } from '../../../../lib/axios';
import DateInput from './components/DateInput.vue';
import type { CreateOrderFormData, ValidationErrors } from '../../../../types/order';
import {
  getMinDate,
  getMaxDate,
  formatDateForApi,
  isValidDateRange,
} from '../../../../utils/dateUtils';

interface Props {
  modelValue: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void;
  (e: 'created'): void;
}>();

const $q = useQuasar();

const isOpen = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});

const formData = ref<CreateOrderFormData>({
  orderId: '',
  requesterName: '',
  destination: '',
  departureDate: '',
  arrivalDate: '',
});

const saving = ref(false);
const validationErrors = ref<ValidationErrors>({});

const minDate = getMinDate();
const maxDate = getMaxDate();

function resetForm() {
  formData.value = {
    orderId: '',
    requesterName: '',
    destination: '',
    departureDate: '',
    arrivalDate: '',
  };
  validationErrors.value = {};
}

function handleClose() {
  if (!saving.value) {
    resetForm();
    isOpen.value = false;
  }
}

function validateForm(): boolean {
  const errors: ValidationErrors = {};

  // Validar ID do pedido
  const orderIdNum = Number(formData.value.orderId);
  if (isNaN(orderIdNum) || orderIdNum <= 0 || !Number.isInteger(orderIdNum)) {
    errors.orderId = 'ID do pedido deve ser um número inteiro positivo';
  }

  // Validar nome do requerente
  if (formData.value.requesterName.length > 30) {
    errors.requesterName = 'Nome do requerente deve ter no máximo 30 caracteres';
  }

  // Validar destino
  if (formData.value.destination.length > 60) {
    errors.destination = 'Destino deve ter no máximo 60 caracteres';
  }

  // Validar datas
  if (formData.value.departureDate && formData.value.arrivalDate) {
    if (!isValidDateRange(formData.value.departureDate, formData.value.arrivalDate)) {
      errors.departureDate = 'Data de partida não pode ser posterior à data de chegada';
    }
  }

  validationErrors.value = errors;
  return Object.keys(errors).length === 0;
}

async function handleSubmit() {
  if (!validateForm()) {
    $q.notify({
      type: 'negative',
      message: 'Por favor, corrija os erros no formulário',
      position: 'top',
    });
    return;
  }

  saving.value = true;
  validationErrors.value = {}; // Limpa erros anteriores

  try {
    const payload = {
      ...formData.value,
      departureDate: formatDateForApi(formData.value.departureDate),
      arrivalDate: formatDateForApi(formData.value.arrivalDate),
      status: 'requested' as const,
    };

    const response = await api.post('/v1/order', payload);

    if (response.status === 201) {
      $q.notify({
        type: 'positive',
        message: 'Pedido criado com sucesso!',
        position: 'top',
      });
      emit('created');
      handleClose();
    }
  } catch (error: unknown) {
    if (error && typeof error === 'object' && 'response' in error) {
      const apiError = error as {
        response?: {
          status?: number;
          data?: {
            message?: string;
            errors?: string[];
          };
        };
      };

      // Trata todos os erros 4xx como erros de validação
      if (
        apiError.response?.status &&
        apiError.response.status >= 400 &&
        apiError.response.status < 500
      ) {
        // Trata erros de validação
        const apiErrors = apiError.response.data?.errors || [];
        const newErrors: ValidationErrors = {};
        let hasFieldErrors = false;

        apiErrors.forEach((err: string) => {
          if (err.includes('orderId')) {
            newErrors.orderId = err;
            hasFieldErrors = true;
          } else if (err.includes('requesterName')) {
            newErrors.requesterName = err;
            hasFieldErrors = true;
          } else if (err.includes('destination')) {
            newErrors.destination = err;
            hasFieldErrors = true;
          } else if (err.includes('departureDate')) {
            newErrors.departureDate = err;
            hasFieldErrors = true;
          } else if (err.includes('arrivalDate')) {
            newErrors.arrivalDate = err;
            hasFieldErrors = true;
          }
        });

        if (hasFieldErrors) {
          validationErrors.value = newErrors;
          $q.notify({
            type: 'negative',
            message: 'Por favor, corrija os erros indicados no formulário',
            position: 'top',
          });
        } else {
          // Se não houver erros específicos de campo, mostra a mensagem geral
          const errorMessage = apiError.response.data?.message || 'Erro de validação';
          $q.notify({
            type: 'negative',
            message: `${errorMessage}: ${apiErrors.join(', ')}`,
            position: 'top',
            timeout: 5000, // Aumenta o tempo de exibição para 5 segundos
          });
        }
        return;
      }

      // Se não for erro de validação, mostra a mensagem de erro da API
      const errorMessage = apiError.response?.data?.message || 'Erro ao criar pedido';
      $q.notify({
        type: 'negative',
        message: errorMessage,
        position: 'top',
      });
    } else {
      // Erro genérico
      $q.notify({
        type: 'negative',
        message: 'Erro ao criar pedido',
        position: 'top',
      });
    }
  } finally {
    saving.value = false;
  }
}
</script>

<style lang="scss" scoped>
@import './CreateOrderModal.scss';
</style>
