<template>
    <!-- {{ pageWindow.location }} -->
    <nav class="flex items-center justify-between ">
        <div>
            <Link
                v-if="!(route('get-kiddocare-home') == currentUrl)"
                :href="route('get-kiddocare-home')"
                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >Home</Link
            >
        </div>

        <div class="flex gap-4">
            <div v-if="page.props.auth?.user">
                <span class="px-2">{{ page.props.auth.user.name }} </span>
                <Link
                    method="post"
                    :href="route('logout')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Logout
                </Link>
            </div>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Log in
                </Link>
                <Link
                    :href="route('register')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Register
                </Link>
            </template>
        </div>
    </nav>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';

const page: any = usePage();
const currentUrl = window.location.href; // This will give you the full URL, including protocol and pathname


</script>
