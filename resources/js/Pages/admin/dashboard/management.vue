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
                        <Store class="w-6 h-6 text-orange-500" />
                        <h1 class="text-xl font-bold text-gray-900">إدارة المحلات</h1>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Search and Add -->
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="relative flex-1">
                    <Search class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
                    <input v-model="searchTerm" placeholder="البحث عن مطعم..."
                        class="w-full pr-10 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" />
                </div>
                <button @click="showAddDialog = true"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md flex items-center">
                    <Plus class="w-4 h-4 ml-2" />
                    إضافة مطعم جديد
                </button>
            </div>

            <!-- Restaurants Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                <div v-for="restaurant in filteredRestaurants" :key="restaurant.id"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">صاحب المحل: {{ restaurant.owner_name }}
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">{{ restaurant.restaurant_location }}</p>
                                <!-- <p class="text-gray-600 text-sm mt-1">اسم المحل: {{ restaurant.restaurant_name }}</p> -->
                            </div>
                            <span
                                :class="restaurant.is_active != 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                class="px-2 py-1 text-xs rounded-full">
                                {{ restaurant.is_active != 0 ? 'نشط' : 'غير نشط' }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">اسم المحل</p>
                                    <p class="font-semibold text-lg">{{ restaurant.restaurant_name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">إجمالي الزيارات</p>
                                    <p class="font-semibold text-lg">{{ restaurant.visits }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">العملاء</p>
                                    <p class="font-semibold text-lg">{{ restaurant.customers }}</p>
                                </div>
                            </div>

                            <div class="text-sm">
                                <p class="text-gray-500">الزيارات المطلوبة للهدية</p>
                                <p class="font-semibold">{{ restaurant.visitsRequired }} زيارة</p>
                            </div>

                            <div class="text-sm">
                                <p class="text-gray-500">رقم الهاتف</p>
                                <p class="font-semibold">{{ restaurant.phone }}</p>
                            </div>

                            <!--             <div class="flex items-center justify-between pt-4 border-t">
                <button
                  @click="downloadQR(restaurant.name, restaurant.qrCode)"
                  class="flex-1 ml-2 px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50 flex items-center justify-center"
                >
                  <QrCode class="w-4 h-4 ml-1" />
                  QR Code
                </button>
                <button
                  @click="downloadQR(restaurant.name, restaurant.qrCode)"
                  class="px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
                >
                  <Download class="w-4 h-4" />
                </button>
              </div> -->

                            <div class="flex gap-2">
                                <button @click="updateRestaurant(restaurant)"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50 flex items-center justify-center">
                                    <Edit class="w-4 h-4 ml-1" />
                                    تعديل
                                </button>
                                <button @click="handleToggleRestaurantStatus(restaurant.id)"
                                    :class="restaurant.is_active != 0 ? 'text-red-600 bg-red-100 hover:text-red-700' : 'text-green-600 bg-green-100 hover:text-green-700'"
                                    class="px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50 flex items-center">
                                    <Power class="w-4 h-4 ml-1" />
                                    {{ restaurant.is_active != 0 ? 'إيقاف' : 'تفعيل' }}
                                </button>
                                <button @click="handleDeleteRestaurant(restaurant.id)"
                                    class="px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50 text-red-600 hover:text-red-700">
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No Results -->
            <div v-if="restaurants.length === 0" class="text-center py-12">
                <Store class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-medium text-gray-900 mb-2">لا توجد مطاعم</h3>
                <p class="text-gray-500">لم يتم العثور على مطاعم تطابق البحث</p>
            </div>
        </div>

        <!-- Add Restaurant Dialog -->
        <div v-if="showAddDialog"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-lg max-w-md w-full p-6" dir="rtl">
                <h2 class="text-lg font-semibold mb-4">إضافة محل جديد</h2>
                <p class="text-gray-600 text-sm mb-6">أدخل بيانات محل الجديد لإضافته إلى النظام</p>

                <form @submit.prevent="handleAddRestaurant" class="space-y-4">

                    <!-- email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني </label>
                        <input v-model="newRestaurant.email" placeholder="البريد الإلكتروني"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required />
                    </div>
                    <!-- phone number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> رقم الهاتف
                        </label>
                        <input v-model="newRestaurant.phone_number" placeholder="09000••••••••"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required />
                    </div>
                    <!-- password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1"> كلمة المرور

                        </label>
                        <input v-model="newRestaurant.password" placeholder="••••••••"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required />
                    </div>
                    <!-- name of owner -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">اسم مدير المحل</label>
                        <input v-model="newRestaurant.owner_name" placeholder="أحمد محمد"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">اسم المحل</label>
                        <input v-model="newRestaurant.restaurant_name" placeholder="مطعم الأصالة"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                        <input v-model="newRestaurant.address" placeholder="الرياض، حي النخيل"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required />
                    </div>
                    <div class="flex gap-2 pt-4">
                        <button type="submit"
                            class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-md">
                            إضافة المحل
                        </button>
                        <button type="button" @click="showAddDialog = false"
                            class="flex-1 border border-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-50">
                            إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <updateRestauratnData v-if="showUpdateDialog" :restaurantData="restaurantUpdate"
            @showUpdateDialog="showUpdateDialog = false" />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Store, Search, Plus, QrCode, Download, Edit, Trash2, Power, ArrowRight } from 'lucide-vue-next'
import { useForm, router } from '@inertiajs/vue3'
import updateRestauratnData from '../../../components/ui/updateRestauratnData.vue'
const props = defineProps(['restaurants'])
console.log(props.restaurants);

const showUpdateDialog = ref(false)
const searchTerm = ref('')
const showAddDialog = ref(false)
const newRestaurant = useForm({
    restaurant_name: '',
    address: '',
    owner_name: '',
    email: '',
    phone_number: '',
    password: '',
})
const restaurantUpdate = ref({})


const updateRestaurant = (restaurant) => {
    showUpdateDialog.value = true
    restaurantUpdate.value = restaurant

}
const restaurants = ref(props.restaurants)

const filteredRestaurants = computed(() => {
    return restaurants.value.filter(restaurant => {
        if (restaurant.restaurant_name) {
            return restaurant.restaurant_name.toLowerCase().includes(searchTerm.value.toLowerCase())
        }
    })
})
// delete restaurant
const handleDeleteRestaurant = (id) => {
    console.log('Deleting restaurant with ID:', id)

    router.post(`/admin/delete-restaurant/${id}`, {}, {
        onSuccess: () => {
            // إعادة تحميل الصفحة بعد نجاح العملية
            window.location.reload()
        },
        onError: (errors) => {
            console.error('فشل الحذف:', errors)
        }
    })
}

const handleAddRestaurant = () => {

    newRestaurant.post('/admin/signup-for-restaurant', {
        onSuccess: () => {
            showAddDialog.value = false
            newRestaurant.reset()
        },
        onError: () => {
            console.error('Failed to add restaurant')
        }
    })
    newRestaurant.post('/admin/signup-for-restaurant', {
        onSuccess: () => {
            showAddDialog.value = false
            newRestaurant.reset()
        },
        onError: () => {
            console.error('Failed to add restaurant')
        }
    })

}
const handleToggleRestaurantStatus = (id) => {
    router.post(`/admin/toggle-restaurant-status/${id}`, {}, {
        onSuccess: () => {
            window.location.reload()
        },
        onError: (errors) => {
            console.error('فشل تغيير الحالة:', errors)
        }
    })
}

const goBack = () => {
    window.location.href = '/admin/dashboard'
}
</script>