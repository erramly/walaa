<template>
    <div class="modal">
        <div data-state="open" @click="closeModal"
            class="fixed inset-0 z-50 bg-black/80 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0"
            style="pointer-events: auto;"></div>
        <div role="dialog" id="radix-«r2»"
            class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg sm:max-w-[425px] bg-card"
            tabindex="-1" style="pointer-events: auto;">
            <div class="flex flex-col space-y-1.5 text-center sm:text-left">
                <h2 id="radix-«r3»" class="font-semibold tracking-tight text-xl text-center mb-4">إضافة موظف جديد</h2>
            </div>
            <form @submit.prevent>
                <div class="grid gap-4 py-4">
                    <div class="grid gap-2">
                        <label class="text-sm font-medium leading-none" for="hijriDate"> الاسم</label>
                        <input type="email" id="hijriDate" v-model="form.name" required
                            class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm" name="hijriDate">
                    </div>
                    <div class="grid gap-2">
                        <label class="text-sm font-medium leading-none" for="hijriDate">البريد الاليكتروني</label>
                        <input type="email" id="hijriDate" v-model="form.email" required
                            class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm" name="hijriDate">
                    </div>
                    <div class="grid gap-2">
                        <label class="text-sm font-medium leading-none" for="hijriDate">كلمة السر</label>
                        <input type="text" id="hijriDate" v-model="form.password" required
                            class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm" name="hijriDate">
                    </div>
                    <!-- <div class="grid gap-2">
                        <label class="text-sm font-medium leading-none" for="hijriDate">الدور</label>
                        <select id="hijriDate" required v-model="form.role"
                            class="flex h-10 w-full rounded-md border bg-background px-3 py-2 text-sm" name="hijriDate">
                            <option value="1">موظف</option>
                            <option value="0">مدير</option>
                        </select>
                    </div> -->
                </div>
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white"
                        type="submit" @click="submit">إضافة المستخدم</button>
                </div>
                <button @click="closeModal" type="button"
                    class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-x h-4 w-4">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </form>
        </div>
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3'


const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 1,
})




const props = defineProps({
    openModalCreate: {
        type: Boolean,
        required: true
    }
});

const emit = defineEmits(['closeModalCreate']);

const closeModal = () => {
    emit('closeModalCreate');
};



const submit = () => {

    form.post('/add-employee', {
        onSuccess: () => {
            window.location.reload();
        },
    })
    closeModal();
}



</script>