<template>
  <Head title="Lista utenti" />

  <AuthenticatedLayout>
      <template #header>
          <h2
              class="text-xl font-semibold leading-tight text-gray-800"
          >
              Lista utenti
          </h2>
      </template>

      <div class="py-12">
          <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
              <div
                  class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
              >
                  <div class="p-6 text-gray-900">
                      <div class="flex justify-end">
                          <PrimaryButton @click="openUserFormDialog()">Aggiungi utente</PrimaryButton>
                      </div>

                      <BaseTable 
                          :headers="headers"
                          :paginatedItems="users" 
                          @change="changePage" 
                      >
                          <template #role="{ item }">
                            {{ item.role ?? '---' }}
                          </template>

                          <template #actions="{ item }">
                              <div class="flex items-center justify-end space-x-2">
                                  <PencilIcon 
                                    class="cursor-pointer hover:text-blue-500 text-gray-700"
                                    @click="openUserFormDialog(item)"
                                  />

                                  <TrashIcon 
                                    @click="openUserDeleteFormDialog(item)"
                                    class="cursor-pointer hover:text-red-500 text-gray-700"
                                  />
                              </div>
                          </template>
                      </BaseTable>
                  </div>
              </div>
          </div>
      </div>

      <UserFormDialog ref="userFormDialog" />      
      <UserDeleteFormDialog ref="userDeleteFormDialog" />
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { PaginatedResponse } from '@/types/pagination';
import { User } from '@/types/user';


import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseTable from '@/Components/BaseTable.vue';
import PencilIcon from '@/Components/Icons/PencilIcon.vue';
import TrashIcon from '@/Components/Icons/TrashIcon.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import UserFormDialog from './UserFormDialog.vue';
import UserDeleteFormDialog from './UserDeleteFormDialog.vue';

const users = computed<PaginatedResponse<User>>(
  () => usePage().props.users as PaginatedResponse<User>
);

const userDeleteFormDialog = ref<any |null>(null)
const userFormDialog = ref<any |null>(null)
const headers = ref([
  {
    label: 'ID',
    key: 'id'
  },
  {
    label: 'NOME',
    key: 'name',
  },
  {
    label: 'EMAIL',
    key: 'email',
  }, 
  {
    label: 'RUOLO',
    key: 'role',
  },    
]);

const changePage = (page: string) => {
  router.visit(page)
}

const openUserFormDialog = (item = null) => {
  userFormDialog.value.open(item)
}

const openUserDeleteFormDialog = (item = null) => {
  userDeleteFormDialog.value.open(item)
}
</script>