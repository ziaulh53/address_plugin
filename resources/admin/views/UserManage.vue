<template>
    <h2>User Permission</h2>
    <div class="user_permission">
        <div>
            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px;">Select Role</label>
            <el-select v-model="selectedRole" @change="onChangeRoles" size="large" placeholder="Select"
                style="width: 240px">
                <el-option v-for="role in allRoles" :key="role.name" :label="role.name"
                    :value="role.name?.toLowerCase()" />
            </el-select>
        </div>
        <div style="margin-top: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px;">Capabilities</label>
            <el-checkbox-group v-model="capabilities" @cheked="onCapabilitiesChange">
                <el-checkbox v-for="({ label, value }) of allCapabilities" :key="value" :label="label" :value="value"
                    @change="onCapabilitiesChange(value, $event)" />
            </el-checkbox-group>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { fetchData, postData } from '../../js/ajax';
import { ElNotification } from 'element-plus';


const allRoles = ref([]);

const capabilities = ref({});
const selectedRole = ref('editor');


const onChangeRoles = async (role) => {
    const rol = allRoles.value.find(rl => rl.name.toLowerCase() === role);
    capabilities.value = Object.keys(rol.capabilities).map((key) => key);
}

const onCapabilitiesChange = async (capability, value) => {
    const data = {
        capability,
        capabilityValue: value
    }
    try {
        const res = await postData('update_capability', { role: selectedRole.value, ...data });
        if (res.success) {

        }
        ElNotification.success({
            message: res?.msg,
            position: 'bottom-right',
        })
    } catch (error) {
        console.log(error.message)
    }
}

const fetchAllrole = async () => {
    try {
        const res = await fetchData('pr_tk_get_role');
        allRoles.value = res?.data;
        capabilities.value = Object.keys(res?.data[0].capabilities).map((key) => key);

    } catch (error) {

    }
}

onMounted(() => {
    fetchAllrole();
})

const allCapabilities = [{ label: 'Delete Address', value: 'delete_address' }, { label: 'Edit Address', value: 'edit_address' }]
</script>