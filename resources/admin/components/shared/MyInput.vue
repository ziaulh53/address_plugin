<template>
    <div class="my-input-wrapper">
        <label>{{ label }}</label>
        <input v-if="!isTextArea" :type="type" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4"
            :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
            :disabled="disabled" />
        <textarea v-if="isTextArea" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4"
            :placeholder="placeholder" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
            :disabled="disabled"></textarea>
    </div>
</template>

<script setup>
defineProps({
    modelValue: String,
    label: String,
    placeholder: String,
    type: String,
    disabled: Boolean,
    isTextArea: Boolean
})
</script>