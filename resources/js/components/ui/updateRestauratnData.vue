<template> <!-- update restaurant -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg max-w-md w-full p-6" dir="rtl">
            <h2 class="text-lg font-semibold mb-4">تعديل محل </h2>
            <p class="text-gray-600 text-sm mb-6">أدخل بيانات محل الجديد لإضافته إلى النظام</p>

            <form @submit.prevent="handleAddRestaurant" class="space-y-4">

                <!-- email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني </label>
                    <input v-model="updateRestaurant.email" placeholder="البريد الإلكتروني"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div>
                <!-- phone number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"> رقم الهاتف
                    </label>
                    <input v-model="updateRestaurant.phone_number" placeholder="09000••••••••"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div>
                <!-- password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"> كلمة المرور

                    </label>
                    <input v-model="updateRestaurant.password" placeholder="••••••••"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div>
                <!-- name of owner -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">اسم مدير المحل</label>
                    <input v-model="updateRestaurant.owner_name" placeholder="أحمد محمد"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">اسم المحل</label>
                    <input v-model="updateRestaurant.restaurant_name" placeholder="مطعم الأصالة"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                    <input v-model="updateRestaurant.address" placeholder="الرياض، حي النخيل"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div>
                <div class="flex gap-2 pt-4">
                    <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-md">
                        إضافة المحل
                    </button>
                    <button type="button" @click="closeshowUpdateDialog"
                        class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-50">
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, defineEmits } from 'vue';
const props = defineProps(['restaurantData'])

const showAddDialogUpdate = ref(true);
const emit = defineEmits(['showUpdateDialog'])


const updateRestaurant = useForm({
    restaurant_name: '',
    address: '',
    owner_name: '',
    email: '',
    phone_number: '',
    password: '',
})
// update restaurant data
const handleAddRestaurant = () => {
    updateRestaurant.post(route('restaurant.update', props.restaurantData.id), {
        onSuccess: () => {
            showAddDialogUpdate.value = false;
            closeshowUpdateDialog();
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
}
// add emit showUpdateDialog
const closeshowUpdateDialog = () => {
    emit('showUpdateDialog', false)
}
</script>