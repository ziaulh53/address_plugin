import { ElNotification } from "element-plus";

export const onCopyHandle = (text) => {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text)
            .then(() => {
                ElNotification.success({
                    message: `${text} copied to clipboard`,
                    showClose: false,
                    position: 'bottom-right',
                    duration: 2000
                })
            })
            .catch((error) => {
                console.error('Error copying text to clipboard:', error);
            });
    } else {
        console.error('Clipboard API is not supported');
    }
}

export const onCheckCapability = (cap)=>{
    const permissions = pr_tk_get_permission_list.permissions;
    return permissions[cap];
}