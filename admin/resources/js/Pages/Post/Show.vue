<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Avatar, AvatarImage, AvatarFallback } from '@/shadcn/ui/avatar';
import { ref } from 'vue';

const { post } = usePage().props;

const imagePreview = ref(post.image ? `/storage/images/${post.image}` : null);

const showComments = ref(true);
</script>

<template>

    <Head title="Visualizar Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Visualizar Post</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <section>
                        <div class="mb-6 flex flex-col items-center space-y-4">
                            <Avatar class="w-64 h-64 rounded-lg">
                                <AvatarImage v-if="imagePreview" :src="imagePreview" alt="Imagem do Post" />
                                <AvatarFallback v-else>NP</AvatarFallback>
                            </Avatar>
                            <div class="text-center">
                                <h3 class="text-lg font-semibold">Imagem do Post</h3>
                                <p class="text-gray-600">Imagem representativa deste post</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h1 class="text-2xl font-semibold mb-4">{{ post.title }}</h1>
                            <p class="text-gray-700">{{ post.content }}</p>
                        </div>

                        <section v-if="showComments" class="mt-10">
                            <h3 class="text-lg font-semibold">Comentários</h3>
                            <ul v-if="post.comments.length">
                                <li v-for="comment in post.comments" :key="comment.id" class="border-b py-2">
                                    <p class="font-semibold">{{ comment.author }}</p>
                                    <p>{{ comment.content }}</p>
                                    <p class="text-sm text-gray-500">{{ new Date(comment.created_at).toLocaleString() }}
                                    </p>
                                </li>
                            </ul>
                            <p v-else class="text-gray-600">Nenhum comentário ainda.</p>
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
