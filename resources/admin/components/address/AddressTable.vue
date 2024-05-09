<template>
    <el-table v-loading="loading" :data="tableData" style="width: 100%">
        <el-table-column prop="id" label="#" width="50" />
        <el-table-column prop="name" label="Name" />
        <el-table-column prop="country" label="Country" />
        <el-table-column prop="state" label="State" />
        <el-table-column prop="city" label="City" />
        <el-table-column prop="zipcode" label="Zip Code" width="100" />
        <el-table-column prop="status" label="Status" width="100">
            <template #default="scope">
                <el-tag type="primary" style="text-transform: uppercase; font-weight: bold;">{{ scope.row?.status
                    }}</el-tag>
            </template>
        </el-table-column>
        <el-table-column label="Short Code" width="150">
            <template #default="scope">
                <el-tag type="info" style="cursor: pointer;"
                    @click="() => onCopyHandle(`[pr_tk_address id=${scope.row.id}]`)">[pr_tk_address
                    id="{{ scope?.row?.id }}"]
                </el-tag>
            </template>
        </el-table-column>
        <el-table-column fixed="right" label="Actions">
            <template #default="scope">
                <el-button type="danger" :icon="Delete" @click="() => onDeleteAddress(scope.row.id)" circle />
                <el-button type="primary" :icon="Edit" @click="() => onEditModal(scope.row)" circle />
                <el-button type="info" :icon="View" @click="() => onPreview(scope.row.id)" circle />
            </template>
        </el-table-column>
    </el-table>
    <el-dialog v-model="visible" title="Address" width="500">
        <AddressForm :addressData="addressData" />
        <div style="margin-bottom: 5px;"><label>Status</label></div>
        <el-select size="large" v-model="addressData.status" placeholder="Select"
            style="width: 100%; margin-bottom: 20px;">
            <el-option v-for="item in statusOptions" :key="item.value" :label="item.label" :value="item.value" />
        </el-select>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="visible = false">Cancel</el-button>
                <el-button type="primary" @click="onEditAddress" :disabled="disabled" :loading="editLoading">
                    Update
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script setup>
import { toRefs, ref } from 'vue'
import { deleteData, updateData } from '../../../js/ajax';
import { ElNotification } from 'element-plus';
import {
    Delete,
    Edit,
    View
} from '@element-plus/icons-vue';
import AddressForm from './AddressForm.vue';
import { onCopyHandle } from '../../../js/utils'

const props = defineProps({
    tableData: Array,
    handleSubmit: Function,
    loading: Boolean,
    fetchAddress: Function
})
const { tableData, fetchAddress } = toRefs(props);

const addressData = ref({});
const visible = ref(false);
const editLoading = ref(false);
const statusOptions = [{ label: 'Active', value: 'active' }, { label: 'Deactive', value: 'deactive' }]


const onDeleteAddress = async (id) => {
    try {
        const res = await deleteData('pr_tk_delete_address', id);
        if (res?.success) {
            fetchAddress.value();
            ElNotification.success({
                message: res?.msg,
                position: 'bottom-right',
                duration: 2000
            })
        }
    } catch (error) {
        console.log(error);
    }

}

const onEditModal = (data) => {
    addressData.value = {
        ...data
    }
    visible.value = true;
}

const onEditAddress = async () => {
    editLoading.value = true;
    try {
        const res = await updateData('pr_tk_update_address', { ...addressData.value });
        if (res?.success) {
            fetchAddress.value();
            visible.value = false;
            ElNotification.success({
                message: res?.msg,
                position: 'bottom-right',
                duration: 2000
            });
        }
    } catch (error) {

    }
    editLoading.value = false;
}

const onPreview = async (id) => {
    const previewUrl = `${window.location.origin}/wp-todo/?pr_tk_preview=${id}`;
    window.open(previewUrl, '_blank');
}



</script>