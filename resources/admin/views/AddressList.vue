<template>
    <div class="section-header">
        <h2>All Address</h2>
        <el-button type="primary" @click="dialogVisible = true">Add Address</el-button>
    </div>
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <el-select v-model="filters.status" @change="() => fetchAddress()" placeholder="Select"
                style="width: 240px;">
                <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value" />
            </el-select>
            <el-button type="info" @click="shortVisible = true">
                Short Code
            </el-button>
        </div>

        <AddressTable :tableData="allAddress" :loading="loading" :fetchAddress="fetchAddress" />
    </div>
    <el-dialog v-model="dialogVisible" title="Address" width="500">
        <AddressForm :addressData="addressData" :handleSubmit="onAddAddress" />
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="onAddAddress" :disabled="disabled" :loading="addLoading">
                    Confirm
                </el-button>
            </div>
        </template>
    </el-dialog>
    <el-dialog v-model="shortVisible" title="Short codes" width="500">
        <div style="margin-bottom: 10px;">
            <label style="display: block; margin-bottom: 5px;">All address list</label>
            <el-tag type="info" style="cursor: pointer;"
                @click="() => onCopyHandle('[pr_tk_address_list]')">[pr_tk_address_list]
            </el-tag>

        </div>
        <div style="margin-bottom: 10px;">
            <label style="display: block; margin-bottom: 5px;">Staus</label>
            <el-tooltip class="box-item" effect="dark"
                content="You can change the status. Available status are: active, deactive, all" placement="top">
                <el-tag type="info" style="cursor: pointer;"
                    @click="() => onCopyHandle('[pr_tk_address_list status=active]')">[pr_tk_address_list
                    status="active"]
                </el-tag>
            </el-tooltip>

        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="shortVisible = false">Close</el-button>
                <!-- <el-button type="primary" @click="onAddAddress" :disabled="disabled" :loading="addLoading">
                    Confirm
                </el-button> -->
            </div>
        </template>
    </el-dialog>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { AddressTable, AddressForm } from '../components/address';
import { fetchData, saveData } from '../../js/ajax';
import { onCopyHandle } from '../../js/utils';
import { ElNotification } from 'element-plus'

const addressData = ref({
    name: '',
    country: '',
    state: '',
    city: '',
    zipcode: '',
})
const filters = ref({
    status: 'all'
});
const dialogVisible = ref(false);

const allAddress = ref();
const loading = ref(false);
const addLoading = ref(false);
const shortVisible = ref(false);

const options = [{ label: 'All', value: 'all' }, { label: 'Active', value: 'active' }, { label: 'Deactive', value: 'deactive' }]

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
        const res = await fetchData("pr_tk_get_address", filters.value);
        allAddress.value = res?.data;
    } catch (error) {

    }
    loading.value = false;
}

onMounted(() => {
    fetchAddress();
})

</script>