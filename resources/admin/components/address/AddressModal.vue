<template>
    <MyInput label="Name" placeholder="e.g John" v-model="addressData.name" />
    <MyInput label="Country" placeholder="Bangladesh" v-model="addressData.country" />
    <MyInput label="State" placeholder="Sylhet" v-model="addressData.state" />
    <MyInput label="City" placeholder="Sylhet" v-model="addressData.city" />
    <MyInput label="Zip Code" placeholder="3ABC05" v-model="addressData.zipcode" />
</template>

<script setup>
import { MyInput } from '../shared';

const props = defineProps({
    addressData: Object,
    handleSubmit: Function
})
</script>