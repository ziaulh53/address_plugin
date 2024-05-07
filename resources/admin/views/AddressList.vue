<template>
    <div class="section-header">
        <h2>All Address</h2>
        <el-button type="primary" @click="dialogVisible = true">Add Address</el-button>
    </div>
    <div>
        <AddressTable :tableData="allAddress" :loading="loading" :fetchAddress="fetchAddress" />
    </div>
    <el-dialog v-model="dialogVisible" title="Address" width="500">
        <AddressModal :addressData="addressData" :handleSubmit="onAddAddress" />
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="onAddAddress" :disabled="disabled" :loading="addLoading">
                    Confirm
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { AddressTable, AddressModal } from '../components/address';
import { fetchData, saveData } from '../../js/ajax';
import { ElNotification } from 'element-plus'

const addressData = ref({
    name: '',
    country: '',
    state: '',
    city: '',
    zipcode: '',
})
const dialogVisible = ref(false);

const allAddress = ref();
const loading = ref(false);
const addLoading = ref(false);

const disabled = computed(() => !addressData.value.name || !addressData.value.country || !addressData.value.state || !addressData.value.zipcode)

const onAddAddress = async () => {
    addLoading.value = true
    try {
        const res = await saveData("pr_tk_save_address", addressData.value);
        if (res?.success) {
            dialogVisible.value = false;
            ElNotification.success({
                message: res?.msg,
                position: 'bottom-right',
            })
            fetchAddress()
        }
    } catch (error) {

    }

    addLoading.value = false
}

const fetchAddress = async () => {
    loading.value = true;
    try {
        const res = await fetchData("pr_tk_get_address");
        allAddress.value = res?.data;
    } catch (error) {

    }
    loading.value = false;
}

onMounted(() => {
    fetchAddress();
})

</script>