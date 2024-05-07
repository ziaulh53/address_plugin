import { createApp } from "vue";
import router from "./routes";
import App from "./App.vue";
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import '../scss/admin/admin.scss'

createApp(App).use(ElementPlus).use(router).mount('#pr_tk_admin');
