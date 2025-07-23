<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dettaglio libro
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                    <div class="space-y-4">
                        <img class="rounded-t-lg h-80 w-full object-cover shadow-sm sm:rounded-lg" :src="book.cover" :alt="book.title" />
                        <template v-if="$page.props.auth.user && can.toggle_favorites">
                            <SecondaryButton @click="toggleFavorite" class="w-full justify-center space-x-2" :disabled="form.processing">
                                <component :is="favoriteIcon" />
                                <span v-if="!isInFavoritesList">Aggiungi ai preferiti</span>
                                <span v-else>Rimuovi dai preferiti</span>
                            </SecondaryButton>
                        </template>
                    </div>

                    <div class="col-span-2 overflow-hidden bg-white shadow-sm sm:rounded-lg sm:p-8 p-4">
                        <div class="mb-6 flex justify-between items-center">
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-2">{{ book.title }}</h1>
                            <p class="border border-gray-400 bg-gray-100 rounded-md inline-block px-5 py-2 text-sm text-center">
                                <span class="block">Prezzo</span>
                                <span class="font-semibold ">€ {{ book.price }}</span>
                            </p>
                        </div>

                        <p class="">{{ book.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { computed, markRaw } from 'vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { Book } from '@/types/book.d';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import HearthOutlineIcon from '@/Components/Icons/HearthOutlineIcon.vue';
import HearthIcon from '@/Components/Icons/HearthIcon.vue';

const can = computed<any>(() => usePage().props.can);

const book = computed<Book>(
    () => usePage().props.book as Book
);

const isInFavoritesList = computed(() => usePage().props.isInFavoritesList)
const favoriteIcon = computed(() => {
    return isInFavoritesList.value ? markRaw(HearthIcon) : markRaw(HearthOutlineIcon)
})

const form = useForm({})

const toggleFavorite = () => {
    if (!isInFavoritesList.value) {
        form.post(
            route('favorites.store', { book: book.value.id }),
            {
                only: ['book', 'isInFavoritesList']
            }
        )
    } else {
        form.delete(
            route('favorites.destroy', { book: book.value.id }),
            {
                only: ['book', 'isInFavoritesList']
            }
        )        
    } 
}
</script>
