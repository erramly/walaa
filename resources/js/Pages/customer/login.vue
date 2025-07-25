<template>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center p-4"
        dir="rtl">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="text-center space-y-2 p-8 pb-6">
                <div class="mx-auto w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                    <User class="w-8 h-8 text-white" />
                </div>
                <h1 class="text-2xl font-bold text-gray-900">حسابي</h1>
                <p class="text-gray-600">سجل دخولك أو أنشئ حساب جديد لتتبع نقاط الولاء</p>
            </div>
            <div class="px-8 pb-8">
                <div class="flex mb-6">
                    <button @click="activeTab = 'login'"
                        :class="activeTab === 'login' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700'"
                        class="flex-1 py-2 px-4 rounded-r-md transition">
                        تسجيل الدخول
                    </button>
                    <button @click="activeTab = 'register'"
                        :class="activeTab === 'register' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700'"
                        class="flex-1 py-2 px-4 rounded-l-md transition">
                        حساب جديد
                    </button>
                </div>

                <!-- Login Form -->
                <form v-if="activeTab === 'login'" @submit.prevent="handleLogin" class="space-y-4">
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-medium text-gray-700">رقم الجوال</label>
                        <input id="phone" placeholder="05xxxxxxxx" v-model="loginData.phone_number" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right"
                            dir="ltr" />
                    </div>
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                        <div class="relative">
                            <input id="password" :type="showPassword ? 'text' : 'password'" placeholder="••••••••"
                                v-model="loginData.password" required
                                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute left-0 top-0 h-full px-3 py-2 text-gray-400 hover:text-gray-600">
                                <EyeOff v-if="showPassword" class="h-4 w-4" />
                                <Eye v-else class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center justify-center">
                        <LogIn class="w-4 h-4 ml-2" />
                        تسجيل الدخول
                    </button>
                </form>

                <!-- Register Form -->
                <form v-if="activeTab === 'register'" @submit.prevent="handleRegister" class="space-y-4">
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">الاسم الكامل</label>
                        <input id="name" placeholder="أحمد محمد" v-model="registerData.name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right" />
                    </div>
                    <div class="space-y-2">
                        <label for="registerPhone" class="block text-sm font-medium text-gray-700">رقم الجوال</label>
                        <input id="registerPhone" placeholder="05xxxxxxxx" v-model="registerData.phone_number" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right"
                            dir="ltr" />
                    </div>
                    <div class="space-y-2">
                        <label for="registerPassword" class="block text-sm font-medium text-gray-700">كلمة
                            المرور</label>
                        <input id="registerPassword" type="password" placeholder="••••••••"
                            v-model="registerData.password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right" />
                    </div>
                    <div class="space-y-2">
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700">تأكيد كلمة
                            المرور</label>
                        <input id="confirmPassword" type="password" placeholder="••••••••"
                            v-model="registerData.confirmPassword" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-right" />
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200 flex items-center justify-center">
                        <UserPlus class="w-4 h-4 ml-2" />
                        إنشاء حساب
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { User, Eye, EyeOff, LogIn, UserPlus } from 'lucide-vue-next'
import { router, useForm } from '@inertiajs/vue3'

const activeTab = ref('login')
const showPassword = ref(false)

const loginData = useForm({
    phone_number: '',
    password: '',
})

const registerData = useForm({
    name: '',
    phone_number: '',
    password: '',
    confirmPassword: '',
})

const handleLogin = () => {
    console.log('Customer login:', loginData)
    loginData.post('/customer/login', {

    })
}

const handleRegister = () => {
    console.log('Customer register:', registerData)
    // Here you would typically send the registration data to your backend
    registerData.post('/customer/register', {
        onSuccess: () => {
            router.get('/customer/dashboard');
        },
    })
}
</script>