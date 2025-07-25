<template>
    <div class="min-h-screen bg-gray-50" dir="rtl">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                            <Crown class="w-5 h-5 text-white" />
                        </div>
                        <h1 class="text-xl font-bold text-gray-900">نظام ولاء المحلات</h1>
                    </div>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <button @click="goToSettings"
                            class="flex items-center px-3 py-2 text-gray-600 hover:text-gray-900 rounded-md">
                            <Settings class="w-4 h-4 ml-2" />
                            الإعدادات
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
                <!-- Top Restaurants -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold flex items-center">
                            <BarChart3 class="w-5 h-5 ml-2" />
                            المحلات الأكثر نشاطاً
                        </h2>
                        <p class="text-gray-600 text-sm mt-1">المحلات مرتبة حسب عدد الزيارات </p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div v-for="(restaurant, index) in topRestaurants" :key="index"
                                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3 space-x-reverse">
                                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-bold text-orange-600">#{{ index + 1 }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ restaurant.name }}</p>
                                        <p class="text-sm text-gray-500">{{ restaurant.visits_count }} زيارة</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    {{ restaurant.status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h2 class="text-lg font-semibold">الإجراءات السريعة</h2>
                        <p class="text-gray-600 text-sm mt-1">الوصول السريع للوظائف الأساسية</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <button @click="goToRestaurants"
                            class="w-full flex items-center justify-start px-4 py-3 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                            <Store class="w-4 h-4 ml-2" />
                            إدارة المحلات
                        </button>
                        <button @click="goToCustomers"
                            class="w-full flex items-center justify-start px-4 py-3 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                            <Users class="w-4 h-4 ml-2" />
                            إدارة العملاء
                        </button>
                        <button @click="goToQRGenerator"
                            class="w-full flex items-center justify-start px-4 py-3 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                            <QrCode class="w-4 h-4 ml-2" />
                            إنشاء QR جديد
                        </button>
                        <button @click="goToReports"
                            class="w-full flex items-center justify-start px-4 py-3 border border-gray-300 rounded-md hover:bg-gray-50 transition">
                            <BarChart3 class="w-4 h-4 ml-2" />
                            التقارير والإحصائيات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Store, Users, TrendingUp, Settings, QrCode, LogOut, BarChart3, Crown } from 'lucide-vue-next'
const props = defineProps(['statistics', 'bestRestaurants'])

console.log(props.statistics);
console.log(props.bestRestaurants);

const stats = ref([
    {
        title: "إجمالي المحلات",
        value: props.statistics.restaurants,
        description: "مطعم مسجل",
        icon: Store,
        color: "text-blue-600",
    },
    {
        title: "إجمالي العملاء",
        value: props.statistics.customers,
        description: "عميل نشط",
        icon: Users,
        color: "text-green-600",
    },
    {
        title: "الزيارات اليوم",
        value: props.statistics.visits,
        description: "زيارة جديدة",
        icon: TrendingUp,
        color: "text-orange-600",
    },
])

const topRestaurants = ref(props.bestRestaurants)

const goToSettings = () => {
    window.location.href = '#settings'
}

const goToRestaurants = () => {
    window.location.href = '/admin/dashboard/management/'
}

const goToCustomers = () => {
    window.location.href = '#customers'
}

const goToQRGenerator = () => {
    window.location.href = '#qr-generator'
}

const goToReports = () => {
    window.location.href = '#reports'
}

const logout = () => {
    // fetch by post to this link /admin/logout
    fetch('/admin/logout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
        .then(() => {
            window.location.href = '/admin/login'
        })
}
</script>