<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Textarea } from '@/shadcn/ui/textarea';
import { Avatar, AvatarImage, AvatarFallback } from '@/shadcn/ui/avatar';
import { Button } from '@/shadcn/ui/button';
import { ref } from 'vue';

const { post } = usePage().props;

const form = useForm({
    title: post.title,
    content: post.content,
    image: null,
    _method: 'patch'
});

const imagePreview = ref(post.image ? `/storage/images/${post.image}` : null);

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    if (!form.image) {
        delete form.image;
    }

    form.post(route('posts.update', post.id), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: handleSuccess,
        onError: handleError,
    });
};

const handleSuccess = () => {
    form.reset();
    imagePreview.value = null;
};

const handleError = () => {
    if (form.errors.image) {
        form.reset('image');
    }
};
</script>

<template>

    <Head title="Editar Post" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Post</h2>
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
                                <p class="text-gray-600">A imagem representativa deste post</p>
                            </div>
                        </div>

                        <div>
                            <InputLabel for="image" value="Selecionar Nova Imagem" />
                            <Button class="bg-indigo-600 text-white hover:bg-indigo-700 mt-2">
                                <label for="image" class="cursor-pointer">Selecionar Imagem</label>
                                <input type="file" id="image" class="hidden" @change="handleImageChange"
                                    accept="image/*" />
                            </Button>
                            <InputError class="mt-2" :message="form.errors.image" />
                        </div>

                        <form @submit.prevent="submit" class="mt-6 space-y-6" enctype="multipart/form-data">
                            <div>
                                <InputLabel for="title" value="Título" />
                                <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title"
                                    required autofocus />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div>
                                <InputLabel for="content" value="Conteúdo" />
                                <Textarea id="content" class="mt-1 block w-full" v-model="form.content" required
                                    rows="6" />
                                <InputError class="mt-2" :message="form.errors.content" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>
                                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Salvo.</p>
                                </Transition>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
