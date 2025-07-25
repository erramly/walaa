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
                        <Users class="w-6 h-6 text-orange-500" />
                        <h1 class="text-xl font-bold text-gray-900">سجل العملاء</h1>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats -->
            <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">إجمالي العملاء</h3>
                        <Users class="h-4 w-4 text-blue-600" />
                    </div>
                    <div class="text-2xl font-bold">{{ stats.totalCustomers }}</div>
                    <p class="text-xs text-gray-500 mt-1">عميل مسجل</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">يستحقون هدايا</h3>
                        <Gift class="h-4 w-4 text-orange-600" />
                    </div>
                    <div class="text-2xl font-bold">{{ stats.eligibleForGift }}</div>
                    <p class="text-xs text-gray-500 mt-1">عميل يستحق هدية</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">زيارات اليوم</h3>
                        <Calendar class="h-4 w-4 text-green-600" />
                    </div>
                    <div class="text-2xl font-bold">{{ stats.totalVisitsToday }}</div>
                    <p class="text-xs text-gray-500 mt-1">زيارة جديدة</p>
                </div>
            </div> -->

            <!-- Search -->
            <!-- <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <div class="relative">
                        <Search class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
                        <input v-model="searchTerm" placeholder="البحث بالاسم أو رقم الجوال..."
                            class="w-full pr-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                    </div>
                </div>
            </div> -->

            <!-- Customers List -->
            <!-- <div class="space-y-4">
                <div v-for="customer in filteredCustomers" :key="customer.id"
                    class="bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                    <Users class="w-6 h-6 text-orange-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ customer.name }}</h3>
                                    <div class="flex items-center space-x-2 space-x-reverse text-sm text-gray-500">
                                        <Phone class="w-4 h-4" />
                                        <span dir="ltr">{{ customer.phone }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 space-x-reverse">
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">الزيارات الحالية</p>
                                    <p class="text-lg font-bold text-orange-600">{{ customer.visits }}/{{ visitsRequired
                                        }}</p>
                                </div>

                                <div class="text-center">
                                    <p class="text-sm text-gray-500">إجمالي الزيارات</p>
                                    <p class="text-lg font-bold text-gray-900">{{ customer.totalVisits }}</p>
                                </div>

                                <div class="text-center">
                                    <p class="text-sm text-gray-500">آخر زيارة</p>
                                    <p class="text-sm font-medium text-gray-900">{{ customer.lastVisit }}</p>
                                </div>

                                <span v-if="customer.canClaimGift"
                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full flex items-center">
                                    <Gift class="w-4 h-4 ml-1" />
                                    يستحق هدية
                                </span>
                            </div>
                        </div>

                        
                        <div class="mt-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>التقدم نحو الهدية التالية</span>
                                <span>{{ customer.visits }}/10</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full transition-all duration-300"
                                    :style="{ width: `${Math.min((customer.visits / 10) * 100, 100)}%` }"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ customer.visits >= 10
                                    ? 'العميل يستحق وجبة مجانية!'
                                    : `${10 - customer.visits} زيارة متبقية للحصول على وجبة مجانية`
                                }}
                            </p>
                        </div>


                    </div>
                </div>
            </div> -->
            <!-- real data for resturant cleints-->
            <div class="space-y-4">
                <div v-for="customer in giftGroups" :key="customer.id"
                    class="bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 space-x-reverse">
                                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                    <Users class="w-6 h-6 text-orange-600" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ customer.customer.name }}</h3>
                                    <div class="flex items-center space-x-2 space-x-reverse text-sm text-gray-500">
                                        <Phone class="w-4 h-4" />
                                        <span dir="ltr">{{ customer.customer.phone }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 space-x-reverse">
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">الزيارات الحالية</p>
                                    <p class="text-lg font-bold text-orange-600">{{
                                        customer.Groups[customer.Groups.length - 1] }}/{{ visitsRequired
                                        }}</p>
                                </div>

                                <div class="text-center">
                                    <p class="text-sm text-gray-500">إجمالي الزيارات</p>
                                    <p class="text-lg font-bold text-gray-900">{{customer.Groups.reduce((total, num) =>
                                        total + num, 0)}}</p>
                                </div>

                                <div class="text-center">
                                    <p class="text-sm text-gray-500">آخر زيارة</p>
                                    <p class="text-sm font-medium text-gray-900">{{
                                        customer.customer.last_visit_date.split(' ')[0] }}
                                    </p>
                                </div>

                                <span v-if="customer.Groups[customer.Groups.length - 1] == visitsRequired"
                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full flex items-center">
                                    <Gift class="w-4 h-4 ml-1" />
                                    يستحق هدية
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>التقدم نحو الهدية التالية</span>
                                <span>{{ customer.Groups[customer.Groups.length - 1] }}/{{ visitsRequired }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full transition-all duration-300"
                                    :style="{ width: `${Math.min((customer.Groups[customer.Groups.length - 1] / visitsRequired) * 100, 100)}%` }">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ customer.Groups[customer.Groups.length - 1] == visitsRequired
                                    ? `العميل يستحق ${restaurant.gift_title}!`
                                    : `${visitsRequired - customer.Groups[customer.Groups.length - 1]} زيارة متبقية للحصول
                                على ${restaurant.gift_title}`
                                }}
                            </p>
                        </div>


                    </div>
                </div>
            </div>
            <!-- No Results -->
            <div v-if="filteredCustomers.length === 0" class="text-center py-12">
                <Users class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد نتائج</h3>
                <p class="text-gray-500">لم يتم العثور على عملاء يطابقون البحث</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Users, Search, ArrowRight, Gift, Calendar, Phone } from 'lucide-vue-next'
const props = defineProps(['restaurant', 'giftGroups', 'totalVisits', 'totalGifts'])

console.log(props.restaurant);
console.log(props.giftGroups);
console.log(props.totalVisits);
console.log(props.totalGifts);

//console.log(props.owner, props.todayVisitsCount, props.customersCount, props.eligibleCustomersCount);


const searchTerm = ref('')
const visitsRequired = ref(props.restaurant.reward_settings.visits_required)

const customers = ref([
    {
        id: 1,
        name: "أحمد محمد",
        phone: "0501234567",
        visits: 8,
        totalVisits: 23,
        lastVisit: "2024-01-15",
        canClaimGift: false,
    },
    {
        id: 2,
        name: "فاطمة أحمد",
        phone: "0507654321",
        visits: 10,
        totalVisits: 15,
        lastVisit: "2024-01-14",
        canClaimGift: true,
    },
    {
        id: 3,
        name: "محمد علي",
        phone: "0551122334",
        visits: 3,
        totalVisits: 8,
        lastVisit: "2024-01-13",
        canClaimGift: false,
    },
    {
        id: 4,
        name: "نورا سالم",
        phone: "0559988776",
        visits: 12,
        totalVisits: 28,
        lastVisit: "2024-01-12",
        canClaimGift: true,
    },
    {
        id: 5,
        name: "خالد يوسف",
        phone: "0544332211",
        visits: 6,
        totalVisits: 12,
        lastVisit: "2024-01-11",
        canClaimGift: false,
    },
])

const filteredCustomers = computed(() => {
    return customers.value.filter(customer =>
        customer.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
        customer.phone.includes(searchTerm.value)
    )
})

const stats = computed(() => ({
    totalCustomers: customers.value.length,
    eligibleForGift: customers.value.filter(c => c.canClaimGift).length,
    totalVisitsToday: 23,
}))

const goBack = () => {
    window.location.href = '/owner/dashboard/'
}
</script>