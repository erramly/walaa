<template>
    <div class="min-h-screen bg-gray-50" dir="rtl">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <User class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">مرحباً، {{ customer.name }}</h1>
                            <p class="text-sm text-gray-500">نقاط الولاء الخاصة بك</p>
                        </div>
                    </div>
                    <!-- this div i want hidden in phone size -->
                    <div class="hidden md:flex items-center space-x-4 space-x-reverse">
                        <!-- <span v-if="eligibleGifts > 0"
                            class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full flex items-center">
                            <Gift class="w-4 h-4 ml-1" />
                            {{ eligibleGifts }} هدية متاحة
                        </span> -->
                        <button @click="logout"
                            class="flex items-center px-3 py-2 text-gray-600 hover:text-gray-900 rounded-md">
                            <LogOut class="w-4 h-4 ml-2" />
                            تسجيل الخروج
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="bg-white rounded-lg shadow p-6 m-4 bg-yellow-100">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-medium text-gray-600"> الرمز الخاص بك هو</h3>
            </div>
            <div class="text-2xl font-bold">{{ customer.customer_code }}</div>
            <p class="text-xs text-gray-500 mt-1"> لتسجيل الزيارات </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">إجمالي الزيارات</h3>
                        <Calendar class="h-4 w-4 text-blue-600" />
                    </div>
                    <div class="text-2xl font-bold">{{ customer.totalVisits }}</div>
                    <p class="text-xs text-gray-500 mt-1">زيارة لجميع المحلات</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">الهدايا المحصلة</h3>
                        <Trophy class="h-4 w-4 text-yellow-600" />
                    </div>
                    <div class="text-2xl font-bold">{{ customer.totalGifts }}</div>
                    <p class="text-xs text-gray-500 mt-1">هدية تم الحصول عليها</p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-medium text-gray-600">هدايا متاحة</h3>
                        <Gift class="h-4 w-4 text-green-600" />
                    </div>
                    <div class="text-2xl font-bold">{{ customer.eligibleGifts }}</div>
                    <p class="text-xs text-gray-500 mt-1">هدية جاهزة للاستلام</p>
                </div>
            </div>

            <!-- Restaurants -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold flex items-center">
                        <Store class="w-5 h-5 ml-2" />
                        المحلات التي زرتها
                    </h2>
                    <p class="text-gray-600 text-sm mt-1">تتبع نقاط الولاء في كل محل</p>
                </div>
                <!-- <div class="p-6">
                    <div class="space-y-6">
                        <div v-for="restaurant in restaurants" :key="restaurant.id"
                            class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ restaurant.name }}</h3>
                                    <p class="text-sm text-gray-500">آخر زيارة: {{ restaurant.lastVisit }}</p>
                                </div>
                                <span v-if="restaurant.canClaimGift"
                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full flex items-center">
                                    <Gift class="w-4 h-4 ml-1" />
                                    هدية جاهزة!
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">التقدم نحو الهدية</span>
                                    <span class="font-medium">{{ restaurant.visits }} / {{ restaurant.visitsRequired }}
                                        زيارة</span>
                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div :class="restaurant.canClaimGift ? 'bg-yellow-500' : 'bg-blue-500'"
                                        class="h-2 rounded-full transition-all duration-300"
                                        :style="{ width: `${Math.min((restaurant.visits / restaurant.visitsRequired) * 100, 100)}%` }">
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">الهدية:</p>
                                        <p class="font-medium text-gray-900">{{ restaurant.giftDescription }}</p>
                                    </div>

                                    <button v-if="restaurant.canClaimGift" @click="handleClaimGift(restaurant.id)"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                                        <Gift class="w-4 h-4 ml-2" />
                                        استلام الهدية
                                    </button>
                                    <div v-else class="text-center">
                                        <p class="text-sm text-gray-500">
                                            {{ restaurant.visitsRequired - restaurant.visits }} زيارة متبقية
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->


                <div class="p-6">
                    <div class="space-y-6">
                        <div v-for="giftGroup in giftGroups" :key="giftGroup.id"
                            class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ giftGroup.restaurant.name }}</h3>
                                    <p class="text-sm text-gray-500">آخر زيارة: {{
                                        giftGroup.restaurant.last_visit_date.split(' ')[0] }}</p>
                                </div>
                                <span
                                    v-if="giftGroup.restaurant.visits_required == giftGroup.Groups[giftGroup.Groups.length - 1]"
                                    class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full flex items-center">
                                    <Gift class="w-4 h-4 ml-1" />
                                    هدية جاهزة!
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">التقدم نحو الهدية</span>
                                    <span class="font-medium">{{ giftGroup.Groups[giftGroup.Groups.length - 1] }} / {{
                                        giftGroup.restaurant.visits_required }}
                                        زيارة</span>
                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div :class="giftGroup.restaurant.visits_required == giftGroup.Groups[giftGroup.Groups.length - 1] ? 'bg-yellow-500' : 'bg-blue-500'"
                                        class="h-2 rounded-full transition-all duration-300"
                                        :style="{ width: `${Math.min((giftGroup.Groups[giftGroup.Groups.length - 1] / giftGroup.restaurant.visits_required) * 100, 100)}%` }">
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">الهدية:</p>
                                        <p class="font-medium text-gray-900">{{ giftGroup.restaurant.gift_title }}</p>
                                    </div>

                                    <button
                                        v-if="giftGroup.restaurant.visits_required == giftGroup.Groups[giftGroup.Groups.length - 1]"
                                        @click="handleClaimGift(giftGroup.restaurant.id)"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                                        <Gift class="w-4 h-4 ml-2" />
                                        استلام الهدية
                                    </button>
                                    <div v-else class="text-center">
                                        <p class="text-sm text-gray-500">
                                            {{ giftGroup.restaurant.visits_required -
                                                giftGroup.Groups[giftGroup.Groups.length - 1] }}
                                            زيارة متبقية
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { User, Gift, Store, LogOut, Trophy, Calendar } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3'
const props = defineProps(['customer', 'visits', 'giftGroups', 'eligibleGifts'])

console.log(props.customer)
console.log(props.visits)
console.log('giftGroups', props.giftGroups)
console.log('eligibleGifts', props.eligibleGifts)

const customer = ref({
    name: props.customer.name,
    phone: "0501234567",
    totalGifts: props.customer.totalGifts,
    totalVisits: props.customer.totalVisits,
    customer_code: props.customer.customer_code,
    eligibleGifts: props.eligibleGifts,
})

const restaurants = ref([
    {
        id: 1,
        name: "مطعم الأصالة",
        visits: 8,
        visitsRequired: 10,
        giftDescription: "وجبة مجانية",
        canClaimGift: false,
        lastVisit: "2024-01-15",
    },
    {
        id: 2,
        name: "بيت الشاورما",
        visits: 8,
        visitsRequired: 8,
        giftDescription: "شاورما مجانية",
        canClaimGift: true,
        lastVisit: "2024-01-14",
    },
])

const eligibleGifts = computed(() => {
    return restaurants.value.filter(r => r.canClaimGift).length
})

const handleClaimGift = (restaurantId) => {
    console.log(`Claiming gift for restaurant ${restaurantId}`)
    // تحديث حالة المطعم بعد استلام الهدية
    const restaurant = restaurants.value.find(r => r.id === restaurantId)
    if (restaurant) {
        restaurant.canClaimGift = false
        restaurant.visits = 0
        customer.value.totalGifts++
    }
}

const logout = () => {
    // handle logout logic by useform
    router.post('/customer/logout', {
        onSuccess: () => {
            router.get('/customer/login');
        },
    })
    //window.location.reload()
}

// داالة تعرف كم لدي العميل من هدية
const getTotalGifts = () => {
    return customer.value.totalGifts
}
</script>