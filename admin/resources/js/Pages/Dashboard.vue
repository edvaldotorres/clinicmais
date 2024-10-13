<script setup>
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Pega os dados passados pelo controlador no backend
const { totalPosts, totalComments, totalUsers } = usePage().props;
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid gap-4 md:grid-cols-3">
                    <!-- Total de Posts -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-bold">Total de Posts</h3>
                        <p class="text-2xl">{{ totalPosts }}</p>
                    </div>

                    <!-- Total de Comentários -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-bold">Total de Comentários</h3>
                        <p class="text-2xl">{{ totalComments }}</p>
                    </div>

                    <!-- Total de Usuários -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-bold">Total de Usuários</h3>
                        <p class="text-2xl">{{ totalUsers }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
