<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    error: {
        type: String,
    }
});

const emit = defineEmits(['update:modelValue']);

const hasError = computed(() => {
    return props.error && !props.modelValue;
});
</script>

<template>
    <input type="text" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :class="{'border border-red-500': hasError}" class="buttons" placeholder="Ім'я та Прізвище">
</template>