<template>
    <div class="min-h-screen bg-gray-50" dir="rtl">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <button @click="goBack" class="p-2 hover:bg-gray-100 rounded-md">
                            <ArrowRight class="w-4 h-4" />
                        </button>
                        <Gift class="w-6 h-6 text-orange-500" />
                        <h1 class="text-xl font-bold text-gray-900">إعدادات برنامج الولاء</h1>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="space-y-6">
                <!-- Program Status -->
                <!-- <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold">حالة البرنامج</h2>
                        <p class="text-gray-600 text-sm mt-1">تفعيل أو إيقاف برنامج الولاء</p>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-medium">تفعيل برنامج الولاء</h3>
                                <p class="text-sm text-gray-500">عند التفعيل، سيتمكن العملاء من جمع النقاط</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" v-model="settings.isActive" class="sr-only peer" />
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500">
                                </div>
                            </label>
                        </div>
                    </div>
                </div> -->

                <!-- Reward Settings -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold">إعدادات المكافأة</h2>
                        <p class="text-gray-600 text-sm mt-1">تحديد عدد الزيارات المطلوبة ونوع الهدية</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="space-y-2">
                            <label for="visits-required" class="block text-sm font-medium text-gray-700">عدد الزيارات
                                المطلوبة للحصول على هدية</label>
                            <input id="visits-required" type="number" min="1" max="50"
                                v-model.number="settings.visitsRequired"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-right" />
                            <p class="text-sm text-gray-500">العدد الأدنى: 1، العدد الأقصى: 50</p>
                        </div>

                        <div class="space-y-2">
                            <label for="gift-description" class="block text-sm font-medium text-gray-700">وصف الهدية
                                (مختصر)</label>
                            <input id="gift-title" v-model="settings.giftTitle" placeholder="وجبة مجانية"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-right" />
                        </div>

                        <div class="space-y-2">
                            <label for="gift-details" class="block text-sm font-medium text-gray-700">تفاصيل
                                الهدية</label>
                            <textarea id="gift-details" v-model="settings.giftDescription"
                                placeholder="وصف مفصل للهدية وشروط الاستخدام" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-right"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Additional Settings -->
                <!-- <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold">إعدادات إضافية</h2>
                        <p class="text-gray-600 text-sm mt-1">خيارات متقدمة لبرنامج الولاء</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-medium">إعادة تعيين العداد بعد الهدية</h3>
                                <p class="text-sm text-gray-500">سيبدأ العميل من الصفر بعد الحصول على الهدية</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" v-model="settings.resetAfterGift" class="sr-only peer" />
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-medium">إشعار العميل عند استحقاق الهدية</h3>
                                <p class="text-sm text-gray-500">سيظهر إشعار للكاشير عندما يستحق العميل هدية</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" v-model="settings.notifyCustomer" class="sr-only peer" />
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500">
                                </div>
                            </label>
                        </div>
                    </div>
                </div> -->

                <!-- Preview -->
                <!-- <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold">معاينة للعميل</h2>
                        <p class="text-gray-600 text-sm mt-1">كيف سيظهر برنامج الولاء للعملاء</p>
                    </div>
                    <div class="p-6">
                        <div class="bg-gray-50 p-4 rounded-lg border-2 border-dashed border-gray-300">
                            <div class="text-center">
                                <Gift class="w-8 h-8 text-orange-500 mx-auto mb-2" />
                                <h3 class="font-semibold text-gray-900 mb-1">{{ settings.giftDescription }}</h3>
                                <p class="text-sm text-gray-600 mb-3">{{ settings.giftDetails }}</p>
                                <div class="bg-white p-3 rounded-lg">
                                    <p class="text-sm text-gray-500">تحتاج إلى</p>
                                    <p class="text-2xl font-bold text-orange-600">{{ settings.visitsRequired }}</p>
                                    <p class="text-sm text-gray-500">زيارة للحصول على الهدية</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button @click="updatedRewardSettings"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-md flex items-center">
                        <Save class="w-4 h-4 ml-2" />
                        حفظ الإعدادات
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Gift, ArrowRight, Save } from 'lucide-vue-next'
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['rewardSettings'])
const { visits_required, gift_title, gift_description } = props.rewardSettings;
console.log(props.rewardSettings);

const settings = useForm({
    giftTitle: gift_title,
    giftDescription: gift_description,
    visitsRequired: visits_required,
});



const goBack = () => {
    window.location.href = '/owner/dashboard'
}

const updatedRewardSettings = () => {

    console.log(settings.visitsRequired, settings.giftDescription, settings.giftTitle);

    settings.post('/owner/dashboard/loyalty-settings', {
        onSuccess: () => {
            console.log("تم تحديث إعدادات الولاء بنجاح");
        },
        onError: (errors) => {
            console.error("خطأ في تحديث الإعدادات:", errors);
        }
    });


}
</script>