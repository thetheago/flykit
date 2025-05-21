<template>
  <div class="form-group">
    <label :for="id">{{ label }}</label>
    <QInput
      :id="id"
      v-model="inputValue"
      mask="##/##/####"
      fill-mask="_"
      unmasked-value
      :error="!!error"
      :error-message="error"
      outlined
      dense
      @update:model-value="handleInputChange"
    >
      <template v-slot:append>
        <QIcon name="event" class="cursor-pointer">
          <QPopupProxy cover transition-show="scale" transition-hide="scale">
            <QDate
              v-model="calendarValue"
              mask="DD/MM/YYYY"
              :min="min"
              :max="max"
              @update:model-value="handleCalendarChange"
            />
          </QPopupProxy>
        </QIcon>
      </template>
    </QInput>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { QInput, QDate, QIcon, QPopupProxy } from 'quasar';

interface Props {
  readonly modelValue: string;
  readonly id: string;
  readonly label: string;
  readonly min?: string | undefined;
  readonly max?: string | undefined;
  readonly error?: string | undefined;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void;
}>();

const inputValue = ref(props.modelValue);
const calendarValue = ref(props.modelValue);

// Atualiza os valores locais quando o modelValue muda
watch(
  () => props.modelValue,
  (newValue) => {
    inputValue.value = newValue;
    calendarValue.value = newValue;
  },
);

function handleInputChange(value: string | number | null) {
  if (typeof value === 'string' && value.length === 10) {
    // Data completa
    emit('update:modelValue', value);
  } else if (typeof value === 'string') {
    inputValue.value = value;
  }
}

function handleCalendarChange(value: string) {
  emit('update:modelValue', value);
  inputValue.value = value;
}
</script>

<style scoped>
.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-weight: 500;
  color: #333;
}

.cursor-pointer {
  cursor: pointer;
}
</style>
