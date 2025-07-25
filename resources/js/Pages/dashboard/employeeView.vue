<template>
    <Layout>
        <!-- btn show create employee modal -->

        <!-- show employees table if role admin or employee -->
        <div class="p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold mb-2 hidden md:block">
                    الموظفين
                </h1>
                <p class="text-muted-foreground">إدارة بيانات الموظفين</p>
            </div>
            <div class="flex flex-col md:flex-row justify-between gap-4 md:items-center mb-6">

                <!-- bottons -->
                <button @click="showAddUEmployeeModal = true"
                    class="inline-flex mt-3 mr-3 items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 h-10 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-plus ml-2 h-4 w-4">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 12h8"></path>
                        <path d="M12 8v8"></path>
                    </svg>إضافة موظف جديد
                </button>
            </div>
            <div class="rounded-lg border bg-card shadow-sm">
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm">
                        <thead class="[&_tr]:border-b bg-muted/50">
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">

                                <th
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    الاسم
                                </th>
                                <th
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    البريد الاليكتروني
                                </th>



                                <th
                                    class="h-12 px-4 align-middle text-muted-foreground [&:has([role=checkbox])]:pr-0 text-right font-bold">
                                    حذف
                                </th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <tr v-for="employee in employees"
                                class="border-b data-[state=selected]:bg-muted hover:bg-muted/50 transition-colors">
                                <!-- name -->
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 font-medium">
                                    {{ employee.name }}
                                </td>
                                <!-- email -->
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 font-medium">
                                    {{ employee.email }}
                                </td>

                                <!-- delete user -->
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                                    <button @click="destroy(employee.id)"
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
        <!-- modal create employee  -->
        <createemploye v-if="showAddUEmployeeModal" @closeModalCreate="showAddUEmployeeModal = false" />
    </Layout>


</template>
<script setup>
import Layout from "@/Layouts/AppLayout.vue";
import createemploye from "@/components/home/modals/createemploye.vue";
import { router } from '@inertiajs/vue3';

import { ref } from "vue";
const showAddUEmployeeModal = ref(false);
const props = defineProps([
    "employees"
]);

// const employeesNoFilter = ref(props.employees);
// const filteredEmployees = computed(() => {
//     if (!search.value) return employeeNoFilter.value;
//     // Filter users based on search input
//     return employeesNoFilter.value.filter(employee =>
//         user.national_id.toLowerCase().includes(search.value.toLowerCase()) || user.serial_number.toLowerCase().includes(search.value.toLowerCase())
//     );
// });
const destroy = (id) => {

    router.post(`/remove-employee/${id}`, {}, {
        onSuccess: () => {
            location.reload();
        }
    });
    showAlert.value = true;
    alertMessage.value = "تم الحذف بنجاح";


}




</script>