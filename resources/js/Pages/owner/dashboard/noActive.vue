<template>
    
    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-red-50 flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="rounded-lg bg-card text-card-foreground shadow-lg border-0" data-v0-t="card">
                <div class="flex flex-col space-y-1.5 p-6 text-center pb-4">
                    <div class="mx-auto mb-4 w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center"><svg
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-triangle-alert w-8 h-8 text-orange-600">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                            <path d="M12 9v4"></path>
                            <path d="M12 17h.01"></path>
                        </svg></div>
                    <h3 class="tracking-tight text-2xl font-bold text-gray-900">حسابك غير مفعل</h3>
                    <p class="text-gray-600 text-base">يجب تفعيل حسابك للوصول إلى جميع الميزات</p>
                </div>
                <div class="p-6 pt-0 space-y-6">
                    <div class="relative w-full rounded-lg border p-4 [&amp;&gt;svg+div]:translate-y-[-3px] [&amp;&gt;svg]:absolute [&amp;&gt;svg]:left-4 [&amp;&gt;svg]:top-4 [&amp;&gt;svg]:text-foreground [&amp;&gt;svg~*]:pl-7 text-foreground border-orange-200 bg-orange-50"
                        role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-mail h-4 w-4 text-orange-600">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                        <div class="text-sm [&amp;_p]:leading-relaxed text-orange-800 text-right">عليك التواصل معنا عبر
                            الدعم الفني للتفعيل حسابك</div>
                    </div>
                    <div class="space-y-3"><button
                            class="ring-offset-background focus-visible:outline-hidden inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:text-accent-foreground border h-10 px-4 py-2 w-full border-gray-300 text-slate-100 bg-orange-500"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-phone w-4 h-4 mr-2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>تواصل مع الدعم الفني</button></div>
                    <div class="text-center space-y-2"></div>
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-500 text-center">هل تحتاج مساعدة؟ <a
                                href="mailto:support@example.com" class="text-orange-600 hover:underline">راسلنا على
                                support@example.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>