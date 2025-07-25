<template>
    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-red-50 flex items-center justify-center p-4" dir="rtl">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="text-center space-y-2 p-8 pb-6">
                <div class="mx-auto w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mb-4">
                    <LogIn class="w-8 h-8 text-white" />
                </div>
                <h1 class="text-2xl font-bold text-gray-900"> مرحبا يا مشرف النظام الكامل</h1>
                <p class="text-gray-600">قم بتسجيل الدخول للوصول إلى لوحة التحكم</p>
            </div>
            <div class="px-8 pb-8">
                <form @submit.prevent="handleLogin" class="space-y-4">
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                        <input id="email" type="email" placeholder="admin@example.com" v-model="adminLoginData.email" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-right" />
                    </div>
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                        <div class="relative">
                            <input id="password" :type="showPassword ? 'text' : 'password'" placeholder="••••••••"
                                v-model="adminLoginData.password" required
                                class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-right" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute left-0 top-0 h-full px-3 py-2 text-gray-400 hover:text-gray-600">
                                <EyeOff v-if="showPassword" class="h-4 w-4" />
                                <Eye v-else class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        تسجيل الدخول
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { LogIn, Eye, EyeOff } from 'lucide-vue-next'
import { router, useForm } from '@inertiajs/vue3'

const showPassword = ref(false)
// useform
const adminLoginData = useForm({
    email: '',
    password: ''
})

const handleLogin = () => {
    console.log('Admin login:', adminLoginData.email)
    console.log('Admin login:', adminLoginData.password)


    adminLoginData.post('/admin/login')


    window.location.href = '#dashboard'
}
</script>