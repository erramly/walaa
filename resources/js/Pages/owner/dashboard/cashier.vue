<template>
    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-red-50 p-4" dir="rtl">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <Store class="w-8 h-8 text-white" />
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ restaurant.name }}</h1>
                <p class="text-gray-600">واجهة الكاشير - تسجيل الزيارات</p>
            </div>

            <!-- Notification -->
            <div v-if="notification.type"
                :class="notification.type === 'gift' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' : 'bg-green-50 border-green-200 text-green-800'"
                class="mb-6 p-4 rounded-lg border-2 flex items-center">
                <Gift v-if="notification.type === 'gift'" class="w-6 h-6 ml-2 flex-shrink-0" />
                <CheckCircle v-else class="w-6 h-6 ml-2 flex-shrink-0" />
                <span class="font-medium">{{ notification.message }}</span>
            </div>

            <!-- Main Form -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold flex items-center">
                        <Smartphone class="w-5 h-5 ml-2" />
                        تسجيل زيارة عميل
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">أدخل رقم العميل واضغط تسجيل الزيارة</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700">رقم العميل</label>
                        <input id="phone" v-model="customer_code" @keypress="handleKeyPress"
                            placeholder="05xxxxxxxx"
                            class="w-full px-3 py-3 text-lg text-center border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                            dir="ltr" ref="phoneInput" />
                    </div>

                    <button @click="handleRegisterVisit"
                        class="w-full bg-orange-500 hover:bg-orange-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-medium py-3 px-4 text-lg rounded-md transition duration-200">
                        {{ isLoading ? 'جاري التسجيل...' : 'تسجيل زيارة' }}
                    </button>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3 space-x-reverse">
                            <div
                                class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">1</span>
                            </div>
                            <p class="text-sm text-gray-600">أدخل رقم العميل في الحقل أعلاه</p>
                        </div>

                        <div class="flex items-start space-x-3 space-x-reverse">
                            <div
                                class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">2</span>
                            </div>
                            <p class="text-sm text-gray-600">اضغط "تسجيل زيارة" أو اضغط Enter</p>
                        </div>

                        <div class="flex items-start space-x-3 space-x-reverse">
                            <div
                                class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-bold text-blue-600">3</span>
                            </div>
                            <p class="text-sm text-gray-600">إذا ظهر إشعار الهدية، أخبر العميل بها</p>
                        </div>
                    </div>

                    <div class="mt-6 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center">
                            <AlertTriangle class="w-5 h-5 text-yellow-600 ml-2" />
                            <p class="text-sm text-yellow-800">
                                <strong>مهم:</strong> تأكد من رقم العميل قبل التسجيل
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Smartphone, CheckCircle, Gift, AlertTriangle, Store } from 'lucide-vue-next'
const props = defineProps(['owner', 'restaurant'])
import { router, useForm } from '@inertiajs/vue3'

console.log(props.owner, props.restaurant);

const customer_code = ref('')
const isLoading = ref(false)
const phoneInput = ref(null)
const notification = ref({
    type: null,
    message: ''
})

const restaurant = ref({
    name: props.restaurant.name,
    id: "REST001"
})

const handleRegisterVisit = async () => {
    try {
        const response = await fetch('/owner/cashier/visit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                customer_code: customer_code.value,  // مثلا بيانات النموذج
                // أي بيانات أخرى تريد إرسالها
            }),
        });

        // إذا كان الرد ناجح (HTTP 200-299)
        if (!response.ok) {
            // قراءة رسالة الخطأ من JSON
            const errorData = await response.json();
            // تعامل مع الأخطاء حسب شكل الرد (مثلا رسالة من Laravel)
            alert(errorData.message || 'العميل غير موجود.');
            return;
        }

        // قراءة بيانات الرد (نجاح أو رسالة)
        const data = await response.json();

        // مثلا إذا أرسلت رسالة نجاح من الباكند داخل { success: '...' }
        if (data.success) {
            alert(data.success);
        } else {
            alert('تمت العملية بنجاح.');
        }

    } catch (error) {
        alert('فشل الاتصال بالخادم.');
        console.error(error);
    }
};


const handleKeyPress = (e) => {
    if (e.key === 'Enter') {
        handleRegisterVisit()
    }
}

onMounted(() => {
    // التركيز التلقائي على حقل الإدخال
    if (phoneInput.value) {
        phoneInput.value.focus()
    }
})
</script>