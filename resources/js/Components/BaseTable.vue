<template>
  <div>
    <div
      class="flex flex-col gap-2 px-5 mb-4 sm:flex-row sm:items-center sm:justify-between sm:px-6"
    >
      <template v-if="title">
        <h3 class="text-lg font-semibold text-gray-800">{{ title }}</h3>
      </template>
    </div>

    <div class="overflow-hidden">
      <div class="max-w-full overflow-x-auto">
        <table class="min-w-full">
          <thead>
            <tr class="border-y border-gray-200">
              <th
                v-for="header in headers"
                :key="`th-${header.key}`"
                scope="col"
                class="px-4 py-3 font-normal text-start text-theme-sm text-gray-900"
              >
                {{ header.label }}
              </th>                               
              <th scope="col" class="relative px-4 py-3 capitalize">
                <span class="sr-only">Azioni</span>
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <template v-if="mappedItems?.length > 0">
              <tr v-for="item in mappedItems" :key="item.id">
                <td 
                  :key="`td-${header.key}`"
                  v-for="header in headers"
                  class="px-4 py-4 whitespace-nowrap"
                >
                  <slot :name="header.key" v-if="$slots[header.key]" :item="item"></slot>
                  <template v-else>
                    <div class="text-sm text-gray-500">
                      {{ get(item, header.key) }}
                    </div>
                  </template>
                </td>
                <template v-if="actions">
                  <td class="px-4 py-4 text-sm font-medium text-right whitespace-nowrap">
                    <slot name="actions" :item="item"></slot>
                  </td>
                </template>
              </tr>
            </template>
            <template v-else>
              <tr>
                <td class="px-4 py-4 whitespace-nowrap text-center text-gray-400" :colspan="headers.length + 1">Nessun risultato</td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <template v-if="paginationData?.meta?.total > props.paginatedItems?.meta?.per_page">
      <div class="px-6 py-4 border-t border-white/[0.05]">
        <div class="flex items-center justify-between">
          <span class="block text-sm font-medium text-gray-400">
            Pagina {{ paginatedItems.meta.current_page }} di {{ paginatedItems.meta.total }}
          </span>
          
          <Pagination
            :paginatedItems="paginatedItems"
            @change="goToPage"
          />
        </div>
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { cloneDeep, get } from 'lodash'
import { PaginatedResponse } from '@/types/pagination';

import Pagination from './Pagination.vue'

const props = withDefaults(
  defineProps<{
    headers: any[];
    paginatedItems: PaginatedResponse<any>;
    items?: any[];
    title?: string | null;
    actions?: boolean;
  }>(),
  {
    actions: true,
  }
);

const emit = defineEmits(['change'])
const innerLinks = computed(() => {
  if (props.paginatedItems.links && props.paginatedItems?.meta?.links?.length > 2) {
    const tmpLinks = cloneDeep(props.paginatedItems.meta.links)
    tmpLinks.shift()
    tmpLinks.pop()
    return tmpLinks
  } else {
    return []
  }
})

const mappedItems = computed(() => props.paginatedItems?.data ?? props.items)

const paginationData = computed(
  () => props.paginatedItems ?? {
      data: [],
      meta: {
        total: 0,
        per_page: 20,
        links: []
      }
    }
)

const goToPage = (page: string) => {
  emit('change', page)
}
</script>

<style scoped>
/* Add any additional styles here */
</style>
