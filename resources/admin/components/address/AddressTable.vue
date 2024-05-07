<template>
    <el-table v-loading="loading" :data="tableData" style="width: 100%">
        <el-table-column prop="id" label="#" />
        <el-table-column prop="name" label="Name" />
        <el-table-column prop="country" label="Country" />
        <el-table-column prop="state" label="State" />
        <el-table-column prop="zipcode" label="Zip Code" />
        <el-table-column label="Short Code" width="180">
            <template #default="scope">
                <el-button type="info" @click="() => onCopyHandle(scope?.row?.id)">[wp-test id="{{ scope?.row?.id
                    }}"]</el-button>
            </template>
        </el-table-column>
        <el-table-column fixed="right" label="Actions" width="150">
            <template #default="scope">
                <el-button type="danger" :icon="Delete" @click="() => onDeleteAddress(scope.row.id)" />
                <el-button link type="primary" size="small">Edit</el-button>
                <el-button link type="primary" size="small">View</el-button>
            </template>
        </el-table-column>
    </el-table>
</template>

<script setup>
import { toRefs, ref } from 'vue'
import { deleteData } from '../../../js/ajax';
import { ElNotification } from 'element-plus';
const props = defineProps({
    tableData: Array,
    handleSubmit: Function,
    loading: Boolean,
    fetchAddress: Function
})
const { tableData, fetchAddress } = toRefs(props);

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

const onCopyHandle = (id) => {
    if (navigator.clipboard) {
        // Use the Clipboard API to copy text to the clipboard
        navigator.clipboard.writeText(`[wp id=${id}]`)
            .then(() => {
            ElNotification.success({
                message: `[wp id=${id}] copied to clipboard`,
                showClose: false,
                position: 'bottom-right',
                duration: 2000
            })
                console.log('Text copied to clipboard:', text);
            })
            .catch((error) => {
                console.error('Error copying text to clipboard:', error);
            });
    } else {
        console.error('Clipboard API is not supported');
    }
}

</script>