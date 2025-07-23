<template>
  <Head title="Lista libri" />

  <AuthenticatedLayout>
      <template #header>
          <h2
              class="text-xl font-semibold leading-tight text-gray-800"
          >
              Lista libri
          </h2>
      </template>

      <div class="py-12">
          <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
              <div
                  class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
              >
                  <div class="p-6 text-gray-900">
                      <div class="flex justify-between items-center">
                          <TextInput
                              type="text"
                              placeholder="Cerca..."
                              class="mt-1" 
                              v-model="searchQuery"                       
                          />
                          <div>
                              <PrimaryButton @click="openUserFormDialog()">Aggiungi libro</PrimaryButton>
                          </div>
                      </div>

                      <BaseTable 
                          :headers="headers"
                          :paginatedItems="books" 
                          @change="changePage" 
                      >
                          <template #cover="{ item }">
                            <template v-if="item.cover">
                              <img :src="item.cover" class="w-20 h-20 rounded-full shadow-md object-cover" :alt="item.title" />
                            </template>
                          </template>

                          <template #actions="{ item }">
                              <div class="flex items-center justify-end space-x-2">
                                  <PencilIcon 
                                    class="cursor-pointer hover:text-blue-500 text-gray-700"
                                    @click="openUserFormDialog(item)"
                                  />

                                  <TrashIcon 
                                    @click="openBookDeleteFormDialog(item)"
                                    class="cursor-pointer hover:text-red-500 text-gray-700"
                                  />
                              </div>
                          </template>
                      </BaseTable>
                  </div>
              </div>
          </div>
      </div>

      <BookFormDialog ref="bookFormDialog" />
      <BookDeleteFormDialog ref="bookDeleteFormDialog" />
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { useSearch } from '@/composables/useSearch'
import { PaginatedResponse } from '@/types/pagination.d';
import { Book } from '@/types/book.d';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseTable from '@/Components/BaseTable.vue';
import PencilIcon from '@/Components/Icons/PencilIcon.vue';
import TrashIcon from '@/Components/Icons/TrashIcon.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import BookFormDialog from './BookFormDialog.vue';
import BookDeleteFormDialog from './BookDeleteFormDialog.vue'

const books = computed<PaginatedResponse<Book>>(
    () => usePage().props.books as PaginatedResponse<Book>
);

const bookDeleteFormDialog = ref<any | null>(null)
const bookFormDialog = ref<any | null>(null)
const headers = ref([
  {
    label: 'ID',
    key: 'id'
  },
  {
    label: 'COVER',
    key: 'cover'
  },
  {
    label: 'TITOLO',
    key: 'title',
  },
  {
    label: 'PREZZO',
    key: 'price',
  },     
]);

// search
const { searchQuery } = useSearch()

const changePage = (page: string) => {
  router.visit(page)
}

const openUserFormDialog = (item = null) => {
  bookFormDialog.value.open(item)
}

const openBookDeleteFormDialog = (item = null) => {
  bookDeleteFormDialog.value.open(item)
}
</script>