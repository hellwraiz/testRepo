<script setup>
import { ref, onMounted, computed } from 'vue';
import intlTelInput from 'intl-tel-input/intlTelInputWithUtils';
import 'intl-tel-input/build/css/intlTelInput.css';

const props = defineProps({
  error: String
});

const emit = defineEmits(['country-change']);

const inputElement = ref(null);
const itiInstance = ref(null);

const hasError = computed(() => {
  return props.error && !itiInstance.value?.isValidNumber();
});

onMounted(() => {
  itiInstance.value = intlTelInput(inputElement.value, {
    initialCountry: 'ua',
    separateDialCode: true,
    nationalMode: false
  });

  inputElement.value.addEventListener('countrychange', handleInput);
});

// Handle input changes
const handleInput = () => {
  emit('country-change', {
    fullNumber: itiInstance.value.getNumber(),
    validNumber: itiInstance.value.isValidNumber()
  });
};



</script>

<template>
  <div>
    <input
      ref="inputElement"
      type="tel"
      @input="handleInput"
      class="buttons"
      :class="{'border border-red-500': hasError}"
      placeholder="Enter phone number"
    />
  </div>
</template>