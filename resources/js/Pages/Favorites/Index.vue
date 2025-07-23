<template>
    <Head title="Lista preferiti" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Lista preferiti
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <TextInput
                    type="text"
                    placeholder="Cerca..."
                    class="mb-4 shadow-sm w-full"                   
                    v-model="searchQuery"
                />

                <div class="grid md:grid-cols-3 grid-cols-1 gap-4">
                    <template v-if="books.data.length > 0">
                        <template v-for="book in books.data" :key="book.id">
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                                <div>
                                    <img class="rounded-t-lg h-80 w-full object-cover" :src="book.cover" :alt="book.title" />
                                </div>
                                <div class="p-5 space-y-4">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ book.title }}</h5>

                                    <hr>

                                    <Link 
                                        :href="route('book.show', {book: book.id})" 
                                        class="w-full justify-center inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                                    >Scopri di più</Link>

                                    <SecondaryButton @click="removeTofavorites(book)" :disabled="form.processing" class="w-full justify-center space-x-2">
                                        <HearthIcon />
                                        <span>Rimuovi dai preferiti</span>
                                    </SecondaryButton>                              
                                </div>
                            </div>                        
                        </template>     
                    </template>    
                    <template v-else>
                        <p class="md:col-span-3 text-center">Nessun titolo trovato</p>
                    </template>           
                </div>

                <Pagination 
                    :paginatedItems="books"
                    @change="changePage"
                />              
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { Head, Link, usePage, router, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useSearch } from '@/composables/useSearch'
import { PaginatedResponse } from '@/types/pagination.d';
import { Book } from '@/types/book.d';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import HearthIcon from '@/Components/Icons/HearthIcon.vue';
import Pagination from '@/Components/Pagination.vue';
import TextInput from '@/Components/TextInput.vue';


// search
const { searchQuery } = useSearch()

const books = computed<PaginatedResponse<Book>>(
    () => usePage().props.books as PaginatedResponse<Book>
);

const form = useForm({})

const changePage = (url: string) => {
    router.visit(url)
}

const removeTofavorites = (book: Book) => {
  form.delete(
    route('favorites.destroy', { book: book.id }),
    {
        only: ['books']
    }
  )         
}
</script>