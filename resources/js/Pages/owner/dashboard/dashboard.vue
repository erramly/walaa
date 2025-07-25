<template>
    <div class="min-h-screen bg-gray-50" dir="rtl">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                            <Store class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">{{ owner.restaurant.name }}</h1>
                            <p class="text-sm text-gray-500">لوحة التحكم</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <button @click="goToLoyaltySettings"
                            class="flex items-center px-3 py-2 text-gray-600 hover:text-gray-900 rounded-md">
                            <Settings class="w-4 h-4 ml-2" />
                            إعدادات الولاء
                        </button>
                        <button @click="goToCustomers"
                            class="flex items-center px-3 py-2 text-gray-600 hover:text-gray-900 rounded-md">
                            <Users class="w-4 h-4 ml-2" />
                            سجل العملاء
                        </button>
                        <button @click="logout"
                            class="flex items-center px-3 py-2 text-gray-600 hover:text-gray-900 rounded-md">
                            <LogOut class="w-4 h-4 ml-2" />
                            تسجيل الخروج
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div v-for="(stat, index) in stats" :key="index" class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">{{ stat.title }}</h3>
                        <component :is="stat.icon" :class="`h-4 w-4 ${stat.color}`" />
                    </div>
                    <div class="text-2xl font-bold">{{ stat.value }}</div>
                    <p class="text-xs text-gray-500 mt-1">{{ stat.description }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- QR Code Section -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold flex items-center">
                            <QrCode class="w-5 h-5 ml-2" />
                            QR Code المحل
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">استخدم هذا الرمز لتسجيل زيارات العملاء</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-center">
                            <div
                                class="w-48 h-48 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <img ref="qrImage" style="width: 190px;height: 190px;" :src="qrcode" alt="">
                                    <!-- <p class="text-sm text-gray-500">QR Code للمطعم</p> -->
                                    <!-- <p class="text-xs text-gray-400 mt-1">ID: REST001</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button @click="handleDownloadQR"
                                class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-md flex items-center justify-center">
                                <Download class="w-4 h-4 ml-2" />
                                تحميل
                            </button>
                            <button @click="handlePrintQR"
                                class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-50 flex items-center justify-center">
                                <Printer class="w-4 h-4 ml-2" />
                                طباعة
                            </button>
                        </div>
                        <!-- <div class="text-center">
                            <button @click="goToCashier" class="text-sm text-orange-600 hover:text-orange-700">
                                فتح واجهة الكاشير
                            </button>
                        </div> -->
                    </div>
                </div>

                <!-- Loyalty Program Settings -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold flex items-center">
                            <Gift class="w-5 h-5 ml-2" />
                            برنامج الولاء
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">إعدادات نظام المكافآت الحالي</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600">عدد الزيارات المطلوبة</span>
                                <span class="px-2 py-1 bg-gray-200 text-gray-800 text-sm rounded">{{
                                    owner.restaurant.reward_settings.visits_required }} زيارة</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600">نوع الهدية</span>
                                <span class="px-2 py-1 bg-orange-100 text-orange-800 text-sm rounded">{{
                                    owner.restaurant.reward_settings.gift_title }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600">حالة البرنامج</span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-sm rounded">نشط</span>
                            </div>
                        </div>
                        <button @click="goToLoyaltySettings"
                            class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-50 flex items-center justify-center">
                            <Settings class="w-4 h-4 ml-2" />
                            تعديل الإعدادات
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow mt-8">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold">الإجراءات السريعة</h2>
                    <p class="text-gray-600 text-sm mt-1">الوصول السريع للوظائف الأساسية</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <button @click="goToCustomers"
                            class="border border-gray-300 text-gray-700 py-3 px-4 rounded-md hover:bg-gray-50 flex items-center justify-center">
                            <Users class="w-4 h-4 ml-2" />
                            عرض سجل العملاء
                        </button>
                        <button @click="goToLoyaltySettings"
                            class="border border-gray-300 text-gray-700 py-3 px-4 rounded-md hover:bg-gray-50 flex items-center justify-center">
                            <Gift class="w-4 h-4 ml-2" />
                            إعدادات برنامج الولاء
                        </button>
                        <button @click="goToCashier"
                            class="bg-orange-500 hover:bg-orange-600 text-white py-3 px-4 rounded-md flex items-center justify-center">
                            <QrCode class="w-4 h-4 ml-2" />
                            فتح واجهة الكاشير
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Store, Users, Calendar, QrCode, Download, Settings, LogOut, Gift, Printer } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3'

// props
const props = defineProps(['owner', 'todayVisitsCount', 'customersCount', 'eligibleCustomersCount'])

// console.log('owner', props.owner);
// console.log('todayVisitsCount', props.todayVisitsCount);
// console.log('customersCount', props.customersCount);
// console.log('eligibleCustomersCount', props.eligibleCustomersCount);
const qrcode = ref('https://i.ibb.co/rKtLKCXM/frame-1.png');
const restaurant = ref({
    name: "مطعم الأصالة",
    email: "alasala@restaurant.com",
    phone: "0501234567",
    address: "الرياض، حي النخيل",
    visitsRequired: 10,
    giftDescription: "وجبة مجانية",
})

const stats = ref([
    {
        title: "زيارات اليوم",
        value: props.todayVisitsCount,
        description: "زيارة جديدة",
        icon: Calendar,
        color: "text-blue-600",
    },
    {
        title: "إجمالي العملاء",
        value: props.customersCount,
        description: "عميل مسجل",
        icon: Users,
        color: "text-green-600",
    },
    {
        title: "الهدايا المستحقة",
        value: props.eligibleCustomersCount,
        description: "عميل يستحق هدية",
        icon: Gift,
        color: "text-orange-600",
    },
])

// const handleDownloadQR = () => {
//     console.log("Downloading QR Code")
// }

// const handlePrintQR = () => {
//     console.log("Printing QR Code")
// }

const goToLoyaltySettings = () => {
    window.location.href = '/owner/dashboard/loyalty-settings'
}

const goToCustomers = () => {
    window.location.href = '/owner/dashboard/clients'
}

const goToCashier = () => {
    window.location.href = '/owner/cashier'
}

const logout = () => {
    router.post('/logout')
    window.location.reload()
}

//================================
const qrImage = ref(null)

const handleDownloadQR = () => {
    if (!qrImage.value) return

    const link = document.createElement('a')
    link.href = qrImage.value.src
    link.download = 'qr-code.png'
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
}

const handlePrintQR = () => {
    if (!qrImage.value) return

    const printWindow = window.open('', '_blank')
    printWindow.document.write(`
      <html>
        <head>
          <title>طباعة QR</title>
          <style>
            body {
              display: flex;
              justify-content: center;
              align-items: center;
              height: 100vh;
              margin: 0;
              background: white;
            }
            img {
              width: 300px;
              height: 300px;
            }
          </style>
        </head>
        <body>
          <img src="${qrImage.value.src}" />
        </body>
      </html>
    `)
    printWindow.document.close()
    printWindow.focus()
    printWindow.print()
    printWindow.close()
}
</script>