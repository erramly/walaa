<template> <!-- update restaurant -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-lg max-w-md w-full p-6" dir="rtl">
            <h2 class="text-lg font-semibold mb-4">تعديل محل </h2>
            <p class="text-gray-600 text-sm mb-6">أدخل بيانات محل الجديد لإضافته إلى النظام</p>

            <form @submit.prevent="handleAddRestaurant" class="space-y-4">

                <!-- email -->
                <!-- <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني </label>
                    <input v-model="restaurantData.email" placeholder="البريد الإلكتروني"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div> -->
                <!-- phone number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"> رقم الهاتف
                    </label>
                    <input v-model="updateRestaurant.phone" placeholder="09000••••••••"
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
                    <input v-model="updateRestaurant.restaurant_location" placeholder="الرياض، حي النخيل"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
                    <input v-model="updateRestaurant.password" placeholder="****" type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        />
                </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">عدد الزيارات المطلوبة</label>
                    <input v-model="updateRestaurant.visitsRequired" placeholder="10" type="number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        required />
                </div>
                <div class="flex gap-2 pt-4">
                    <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-md">
                        تعديل المحل
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
import { ref, watch, defineEmits } from 'vue';

// استقبال البيانات من props
const props = defineProps({
    restaurantData: { type: Object, required: true }
});

// الحالة لفتح/إغلاق المودال
const showAddDialogUpdate = ref(true);

// الفورم
const updateRestaurant = useForm({
    restaurant_name: '',
    restaurant_location: '',
    owner_name: '',
    phone: '',
    password: '',
    visitsRequired: ''
});

// ملىء الفورم تلقائياً عند وصول البيانات
watch(
    () => props.restaurantData,
    (data) => {
        if (data) {
            updateRestaurant.restaurant_name = data.restaurant_name || '';
            updateRestaurant.restaurant_location = data.restaurant_location || '';
            updateRestaurant.owner_name = data.owner_name || '';
            updateRestaurant.phone = data.phone || '';
            updateRestaurant.visitsRequired = data.visitsRequired || '';
            updateRestaurant.password = ''; // ترك كلمة السر فارغة حتى لو كانت موجودة
        }
    },
    { immediate: true }
);

// إرسال البيانات
const handleAddRestaurant = () => {
    const original = props.restaurantData;

    const isUnchanged =
        updateRestaurant.restaurant_name === original.restaurant_name &&
        updateRestaurant.restaurant_location === original.restaurant_location &&
        updateRestaurant.owner_name === original.owner_name &&
        updateRestaurant.phone === original.phone &&
        updateRestaurant.visitsRequired === original.visitsRequired &&
        updateRestaurant.password === '';

    if (isUnchanged) {
        alert('لم تقم بأي تعديل');
        return;
    }

    // إذا لم يتم إدخال كلمة مرور جديدة نحذفها من الفورم
    if (!updateRestaurant.password) {
        delete updateRestaurant.password;
    }

    updateRestaurant.post(`/admin/update-restaurant/${original.id}`, {
        onSuccess: () => {
            showAddDialogUpdate.value = false;
            closeshowUpdateDialog();
            window.location.reload(); // يمكنك حذفه لو ما تبي تعيد تحميل الصفحة
        },
        onError: (errors) => {
            console.error(errors);
        }
    });
};

// إرسال حدث لإغلاق المودال
const emit = defineEmits(['showUpdateDialog']);
const closeshowUpdateDialog = () => {
    emit('showUpdateDialog', false);
};
</script>
