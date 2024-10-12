<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/shadcn/ui/table';
import { Button } from '@/shadcn/ui/button'; // Importando o botão do ShadCN Vue
import { usePage } from '@inertiajs/vue3'; // Importando para acessar os dados enviados do backend

// Acessando os dados enviados do backend (Inertia)
const { posts } = usePage().props;

// Função para deletar um post (exemplo)
const deletePost = (id) => {
    if (confirm('Tem certeza que deseja deletar este post?')) {
        router.delete(route('posts.destroy', id)); // Assumindo que você tenha uma rota 'posts.destroy' configurada
    }
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Post Information</h2>
                    </header>

                    <!-- Alinhamento do botão à direita e responsivo -->
                    <div class="flex justify-end mb-8">
                        <Link :href="route('posts.create')">
                        <Button variant="default" class="px-6 py-3 text-lg">
                            Ir para Cadastro
                        </Button>
                        </Link>
                    </div>

                    <!-- Tabela de posts -->
                    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <Table class="w-full border-collapse">
                                <TableCaption class="text-lg font-semibold mb-4">A list of your recent posts
                                </TableCaption>
                                <TableHeader>
                                    <TableRow class="bg-gray-100">
                                        <TableHead class="p-4 text-left font-bold text-gray-700 border-b">Title
                                        </TableHead>
                                        <TableHead class="p-4 text-left font-bold text-gray-700 border-b">Content
                                        </TableHead>
                                        <TableHead class="p-4 text-left font-bold text-gray-700 border-b">Options
                                        </TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <!-- Exibição dos posts dinamicamente -->
                                    <TableRow v-for="(post, index) in posts" :key="index"
                                        class="hover:bg-gray-50 transition-colors border-b last:border-none">
                                        <TableCell class="p-4 font-medium text-gray-900">{{ post.title }}</TableCell>
                                        <TableCell class="p-4 text-gray-700">{{ post.content }}</TableCell>
                                        <TableCell class="p-4 flex space-x-2">
                                            <Link :href="route('posts.edit', post.id)">
                                            <Button variant="outline" class="text-blue-600">Editar</Button>
                                            </Link>
                                            <Button variant="destructive" @click="deletePost(post.id)">Deletar</Button>
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
