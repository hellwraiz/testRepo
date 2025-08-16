<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: false,
    },
    error: {
        type: String,
    }
});

const emit = defineEmits(['update:modelValue']);

const hasError = computed(() => {
    return props.error && props.modelValue.length > 500;
});
</script>

<template>
    <textarea :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :class="{'border border-red-500': hasError}" class="flex grow h-24 resize-none buttons" placeholder="Додаткові деталі"/>
</template> 