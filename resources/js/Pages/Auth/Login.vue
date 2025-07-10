<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div class="flex min-h-screen bg-gradient-to-br from-gray-100 to-gray-200">
        <!-- Left side: Decorative panel with logo - 40% on desktop, hidden on mobile -->
        <div class="hidden lg:block lg:w-2/5 xl:w-[30%] bg-gradient-to-br from-teal-600 to-teal-800 relative overflow-hidden">
            <!-- Decorative arcs -->
            <div class="absolute inset-0">
                <!-- Top-right decorative arc -->
                <svg class="absolute right-0 top-0 h-64 w-64" viewBox="0 0 200 200" fill="none">
                    <path 
                        d="M200,0 Q100,0 100,100 Q100,200 0,200 L0,0 Z" 
                        fill="rgba(255,255,255,0.1)"
                    ></path>
                </svg>
                
                <!-- Bottom-left decorative arc -->
                <svg class="absolute left-0 bottom-0 h-64 w-64" viewBox="0 0 200 200" fill="none">
                    <path 
                        d="M0,200 Q100,200 100,100 Q100,0 200,0 L0,0 Z" 
                        fill="rgba(255,255,255,0.1)"
                    ></path>
                </svg>
                
                <!-- Main background shape -->
                <svg class="absolute left-0 top-0 h-full w-full" viewBox="0 0 800 800" preserveAspectRatio="none">
                    <path 
                        d="M0,0 L800,0 L800,800 Q400,650 0,800 Z" 
                        fill="currentColor" 
                        class="text-teal-700 opacity-50"
                    ></path>
                </svg>
            </div>
            
            <!-- Enhanced circular logo in center -->
            <div class="absolute flex items-center justify-center w-full h-full">
                <div class="relative w-48 h-48 rounded-full bg-white/90 border-6 border-teal-300 flex items-center justify-center shadow-xl">
                    <img 
                        src="/storage/images/pride_logo_vertical.png"
                        alt="Pride Logo" 
                        class="w-40 h-40 object-contain p-4"
                    />
                </div>
            </div>
            
            <div class="absolute bottom-0 inset-x-0 pb-12 text-center text-white">
                <h2 class="text-3xl font-bold">Welcome to Loan Tracker</h2>
                <p class="mt-3 px-6 text-xl text-teal-100">Streamlining Loan Lead Management Across Branches</p>
            </div>
        </div>
        
        <!-- Right side: Login form container -->
        <div class="flex w-full lg:w-3/5 xl:w-[70%] justify-center items-center p-6">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
                <!-- Logo and brand name -->
                <div class="flex flex-col items-center mb-10">
                    <img 
                        src="/storage/images/pride_logo_horizontal.png" 
                        alt="Pride Logo" 
                        class="h-20 w-auto mb-4"
                    />
                    <h1 class="text-2xl font-bold text-teal-900 text-center">PRIDE LOAN TRACKER</h1>
                    <p class="text-xs font-medium text-gray-600 tracking-wider text-center mt-1 uppercase">
                         LEADS MANAGEMENT SYSTEM
                    </p>
                </div>
                
                <h2 class="text-xl font-semibold text-gray-800 mb-8 text-center">
                    Sign In to Your Account
                </h2>

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <InputLabel for="email" value="Email Address" class="block text-sm font-medium text-gray-700" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Enter your email"
                                required
                                autofocus
                                autocomplete="username"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <InputLabel for="password" value="Password" class="block text-sm font-medium text-gray-700" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-teal-500 focus:border-teal-500"
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <Checkbox v-model:checked="form.remember" name="remember" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded" />
                            <span class="ml-2 block text-sm text-gray-700">Remember me</span>
                        </div>

                        <div class="text-sm">
                            <Link 
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="font-medium text-teal-600 hover:text-teal-500"
                            >
                                Forgot password?
                            </Link>
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-teal-700 to-teal-600 hover:from-teal-800 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                        >
                            <template v-if="form.processing">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Signing in...
                            </template>
                            <template v-else>
                                Sign in
                            </template>
                        </button>
                    </div>
                </form>
                
                <div class="mt-10 text-center text-xs text-gray-500 space-y-2">
                    <p>Copyright &copy; {{ new Date().getFullYear() }} Pride Bank Ltd. All rights reserved.</p>
                    <p class="text-[11px] text-gray-400">
                        Permission to use, copy, modify, and distribute this software and its documentation for any purpose is prohibited unless authorized in writing by the Managing Director.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
