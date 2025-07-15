<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
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
                    <template v-for="book in books.data" :key="book.id">
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 w-full">
                            <div>
                                <img class="rounded-t-lg h-80 w-full object-cover" :src="book.media[0].original_url" :alt="book.title" />
                            </div>
                            <div class="p-5 space-y-4">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ book.title }}</h5>

                                <template v-if="$page.props.auth.user">
                                    <hr>

                                    <Link 
                                        :href="route('book.show', {book: book.id})" 
                                        class="w-full justify-center inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                                    >Scopri di più</Link>
                                </template>
                            </div>
                        </div>                        
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
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useSearch } from '@/composables/useSearch'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';
import TextInput from '@/Components/TextInput.vue';

// search
const { searchQuery } = useSearch()

const books = computed(() => usePage().props.books);

const changePage = (url) => {
    router.visit(url)
}
</script>