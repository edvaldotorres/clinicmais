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
import { Button } from '@/shadcn/ui/button';
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/shadcn/ui/pagination';

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/shadcn/ui/alert-dialog';

import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

// Acessando os dados enviados do backend (Inertia)
const { posts } = usePage().props;

// Acessando os posts e os dados de paginação
const currentPage = ref(posts.current_page);
const totalPages = ref(posts.last_page);

// Estado para controlar qual post será deletado
const postToDelete = ref(null);

// Função para trocar de página
const changePage = (page) => {
    if (page < 1 || page > totalPages.value) return;
    router.get(route('posts.index', { page }), {
        preserveState: true,
        preserveScroll: true,
    });
};

// Função para deletar um post e atualizar a listagem
const deletePost = () => {
    if (!postToDelete.value) return;

    router.delete(route('posts.destroy', postToDelete.value), {
        onSuccess: () => {
            postToDelete.value = null;
            // Atualiza a listagem após deletar o post, mantendo a página atual
            router.get(route('posts.index', { page: currentPage.value }), {
                preserveState: true,
                preserveScroll: true,
            });
        },
        onError: () => {
            postToDelete.value = null;
        },
    });
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
                        <h2 class="text-lg font-medium text-gray-900">Informações de Post</h2>
                    </header>

                    <div class="flex justify-end mb-8">
                        <Link :href="route('posts.create')">
                        <Button variant="default" class="px-6 py-3 text-lg">
                            Criar Novo Post
                        </Button>
                        </Link>
                    </div>

                    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="overflow-x-auto">
                                <Table class="w-full border-collapse">
                                    <TableCaption class="text-lg font-semibold mb-4">Lista de posts recentes
                                    </TableCaption>
                                    <TableHeader>
                                        <TableRow class="bg-gray-100">
                                            <TableHead class="p-4 text-left font-bold text-gray-700 border-b">Título
                                            </TableHead>
                                            <TableHead class="p-4 text-left font-bold text-gray-700 border-b">Conteúdo
                                            </TableHead>
                                            <TableHead class="p-4 text-left font-bold text-gray-700 border-b">Opções
                                            </TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <TableRow v-for="(post, index) in posts.data" :key="index"
                                            class="hover:bg-gray-50 transition-colors border-b last:border-none">
                                            <TableCell class="p-4 font-medium text-gray-900">{{ post.title }}
                                            </TableCell>
                                            <TableCell class="p-4 text-gray-700">{{ post.content }}</TableCell>
                                            <TableCell class="p-4 flex space-x-2">
                                                <Link :href="route('posts.edit', post.id)">
                                                <Button variant="outline" class="text-blue-600">Editar</Button>
                                                </Link>

                                                <!-- AlertDialog para confirmar exclusão -->
                                                <AlertDialog>
                                                    <AlertDialogTrigger>
                                                        <Button variant="destructive" @click="postToDelete = post.id">
                                                            Deletar
                                                        </Button>
                                                    </AlertDialogTrigger>
                                                    <AlertDialogContent>
                                                        <AlertDialogHeader>
                                                            <AlertDialogTitle>Tem certeza?</AlertDialogTitle>
                                                            <AlertDialogDescription>
                                                                Esta ação não pode ser desfeita. Isso deletará
                                                                permanentemente o post.
                                                            </AlertDialogDescription>
                                                        </AlertDialogHeader>
                                                        <AlertDialogFooter>
                                                            <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                                            <AlertDialogAction @click="deletePost">Confirmar
                                                            </AlertDialogAction>
                                                        </AlertDialogFooter>
                                                    </AlertDialogContent>
                                                </AlertDialog>
                                            </TableCell>
                                        </TableRow>
                                    </TableBody>
                                </Table>

                                <Pagination v-slot="{ page }" :total="totalPages * 10" :sibling-count="1" show-edges
                                    :default-page="currentPage">
                                    <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                                        <PaginationFirst @click="changePage(1)" />
                                        <PaginationPrev @click="changePage(currentPage - 1)" />

                                        <template v-for="(item, index) in items" :key="index">
                                            <PaginationListItem v-if="item.type === 'page'" :value="item.value"
                                                as-child>
                                                <Button class="w-10 h-10 p-0"
                                                    :variant="item.value === page ? 'default' : 'outline'"
                                                    @click="changePage(item.value)">
                                                    {{ item.value }}
                                                </Button>
                                            </PaginationListItem>
                                            <PaginationEllipsis v-else :key="item.type" :index="index" />
                                        </template>

                                        <PaginationNext @click="changePage(currentPage + 1)" />
                                        <PaginationLast @click="changePage(totalPages)" />
                                    </PaginationList>
                                </Pagination>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
