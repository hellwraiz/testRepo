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

const isValidEmail = (email) => {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
};


const emit = defineEmits(['update:modelValue']);

const hasError = computed(() => {
    return props.error && (!props.modelValue || !isValidEmail(props.modelValue));
});
</script>

<template>
    <input type="email" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :class="{'border border-red-500': hasError}" class="buttons" placeholder="Ваш Email">
</template>