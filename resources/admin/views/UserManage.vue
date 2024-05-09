<template>
    <h2>User Permission</h2>
    <div class="user_permission">
        <div>
            <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 5px;">Select Role</label>
            <el-select v-model="value" size="large" placeholder="Select" style="width: 240px">
                <el-option v-for="role in allRoles" :key="role.name" :label="role.name" :value="role.name"
                     />
            </el-select>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { fetchData } from '../../js/ajax';


const allRoles = ref([]);

const fetchAllrole = async()=>{
    try {
        const res = await fetchData('pr_tk_get_role');
        allRoles.value = res?.data;
    } catch (error) {
        
    }
}

onMounted(()=>{
    fetchAllrole();
})

const options=[{label:'Test', value:'test'}]
</script>