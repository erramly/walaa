<template>
    <Layout>
        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold mb-2 hidden md:block">
                    المستخدمين
                </h1>
                <p class="text-muted-foreground">إدارة بيانات المستخدمين</p>
            </div>
            <div class="flex flex-col md:flex-row justify-between gap-4 md:items-center mb-6">
                <div class="relative w-full max-w-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg><input v-model="search"
                        class="flex h-10 border px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-full pr-10 pl-4 bg-background border-input focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-lg"
                        placeholder="بحث برقم الهوية أو التسلسلي" type="search" value="" />
                </div>
                <button @click="openModalCreate = true"
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 h-10 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-plus ml-2 h-4 w-4">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 12h8"></path>
                        <path d="M12 8v8"></path>
                    </svg>إضافة مستخدم جديد
                </button>
            </div>
            <div class="rounded-lg border bg-card shadow-sm">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b bg-muted/50">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <th v-if="userAuth.user == 'admin@example.com'"
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    الموظف
                                </th>
                                <th
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    رقم الهوية
                                </th>
                                <th
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    الرقم التسلسلي
                                </th>
                                <th
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    الملف
                                </th>
                                <th
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    تعديل
                                </th>
                                <th
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    حذف
                                </th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <tr v-for="user in filteredUsers"
                                class="border-b data-[state=selected]:bg-muted hover:bg-muted/50 transition-colors">
                                <td v-if="userAuth.user == 'admin@example.com'"
                                    class="p-4 align-middle [&:has([role=checkbox])]:pr-0 font-medium">
                                    {{ user.user.name }}
                                </td>
                                <!-- view user national id -->
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 font-medium">
                                    {{ user.national_id }}
                                </td>
                                <!-- view user serial number -->
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                                    {{ user.serial_number }}
                                </td>
                                <!-- view user pdf -->
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                                    <a :href="user.pdf_url" target="_blank" rel="noopener"
                                        class="inline-flex cursor-pointer items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:text-accent-foreground h-10 w-10 hover:bg-blue-100 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-file-text h-5 w-5 text-blue-500">
                                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                            <path d="M10 9H8"></path>
                                            <path d="M16 13H8"></path>
                                            <path d="M16 17H8"></path>
                                        </svg><span class="sr-only">عرض الملف</span>
                                    </a>
                                </td>

                                <!-- update user -->
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                                    <button
                                        @click="openUserModalUpdateWithData({ id: user.id, national_id: user.national_id, serial_number: user.serial_number })"
                                        class="inline-flex hover:bg-gray-200 items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:text-accent-foreground h-10 w-10 hover:bg-muted rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-pencil h-5 w-5 text-muted-foreground">
                                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                            <path d="m15 5 4 4"></path>
                                        </svg><span class="sr-only">تعديل</span>
                                    </button>
                                </td>
                                <!-- delete user -->
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                                    <button @click="destroy(user.id)"
                                        class="inline-flex bg-red-500 hover:bg-red-300 items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:text-accent-foreground h-10 w-10 hover:bg-muted rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M4 7H20" stroke="#ddd" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M6 7V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V7"
                                                stroke="#ddd" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                                stroke="#ddd" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg><span class="sr-only">حذف</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- create user modal -->
        <Teleport to="body">
            <createUser @addUserSuccess="addUserSuccess" :openModalCreate="openModalCreate"
                @closeModalCreate="openModalCreate = false" />
        </Teleport>
        <!-- update user modal -->
        <Teleport to="body">
            <UpdateUser :openModalUpdate="openModalUpdate" :user="selectedUser"
                @closeModalUpdate="openModalUpdate = false" />
        </Teleport>
        <!-- alert component -->
        <!-- <Teleport to="body">
            <alertComponent v-if="showAlert" :message="alertMessage" :type="alertType" @close="showAlert = false" />
        </Teleport> -->
    </Layout>
</template>

<script setup>
import createUser from "@/components/home/modals/createUser.vue";
import UpdateUser from "../../components/home/modals/updateUser.vue";
import alertComponent from "../../components/ui/alertComponent.vue";
import { router } from '@inertiajs/vue3';
import Layout from "@/Layouts/AppLayout.vue";
import { ref, computed } from "vue";

const props = defineProps([
    "users"
]);
console.log(props.users);

const usersNoFilter = ref(props.users)
const search = ref('');

const showAlert = ref(false);
const alertMessage = ref("");
const alertType = ref("success"); // success, error, warning, info
const openModalCreate = ref(false);
//for update user
const selectedUser = ref(null);
const openModalUpdate = ref(false);

//delete user
const destroy = (id) => {
    if (confirm('هل تريد الحذف؟')) {
        router.post(`/delete-user/${id}`, {}, {
            onSuccess: () => {
                location.reload();
            }
        });
        showAlert.value = true;
        alertMessage.value = "تم الحذف بنجاح";
        alertType.value = "success"; // success, error, warning, info
    }

}
//open modal alert
const addUserSuccess = () => {

    showAlert.value = true;
    alertMessage.value = "تم إضافة المستخدم بنجاح";
    alertType.value = "success"; // success, error, warning, info
}

const openUserModalUpdateWithData = (user) => {
    selectedUser.value = user;
    openModalUpdate.value = true;
};


const filteredUsers = computed(() => {
    if (!search.value) return usersNoFilter.value;
    // Filter users based on search input
    return usersNoFilter.value.filter(user =>
        user.national_id.toLowerCase().includes(search.value.toLowerCase()) || user.serial_number.toLowerCase().includes(search.value.toLowerCase())
    );
});

import { usePage } from '@inertiajs/vue3'
const userAuth = usePage().props.auth.user
</script>

<style scoped>
.modal {
    position: fixed;
    z-index: 999;
    top: 20%;
    left: 50%;
    width: 300px;
    margin-left: -150px;
}
</style>
