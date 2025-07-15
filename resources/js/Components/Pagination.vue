<template>
    <!-- Pagination -->
    <template v-if="paginationData?.total > 20">
      <div class="px-6 py-4 border-t border-white/[0.05]">
        <div class="flex items-center justify-between">
          <button
            @click="prevPage"
            :disabled="paginatedItems.current_page === 1"
            class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 sm:px-3.5 disabled:pointer-events-none disabled:opacity-30"
          >
            <svg
              width="20"
              height="20"
              viewBox="0 0 20 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fillRule="evenodd"
                clipRule="evenodd"
                d="M2.58301 9.99868C2.58272 10.1909 2.65588 10.3833 2.80249 10.53L7.79915 15.5301C8.09194 15.8231 8.56682 15.8233 8.85981 15.5305C9.15281 15.2377 9.15297 14.7629 8.86018 14.4699L5.14009 10.7472L16.6675 10.7472C17.0817 10.7472 17.4175 10.4114 17.4175 9.99715C17.4175 9.58294 17.0817 9.24715 16.6675 9.24715L5.14554 9.24715L8.86017 5.53016C9.15297 5.23717 9.15282 4.7623 8.85983 4.4695C8.56684 4.1767 8.09197 4.17685 7.79917 4.46984L2.84167 9.43049C2.68321 9.568 2.58301 9.77087 2.58301 9.99715C2.58301 9.99766 2.58301 9.99817 2.58301 9.99868Z"
                fill="currentColor"
              />
            </svg>
          </button>

          <span class="block text-sm font-medium text-gray-400 sm:hidden">
            Pagina {{ paginatedItems.current_page }} di {{ paginatedItems.total }}
          </span>

          <ul class="hidden items-center gap-0.5 sm:flex">
            <li v-for="(link, index) in innerLinks" :key="index">
              <template v-if="paginatedItems.current_page == link.label">
                <span
                  :class="[
                    'flex h-10 w-10 items-center justify-center rounded-lg text-theme-sm font-medium',
                    paginatedItems.current_page == link.label
                      ? 'bg-gray-500 text-white disabled:pointer-events-none'
                      : 'hover:bg-gray-500/[0.08] hover:text-brand-500 text-gray-400 hover:text-gray-500',
                  ]"
                >
                  {{ link.label }}
                </span>
              </template>
              <template v-else>
                <button
                  @click="goToPage(link.url)"
                  :class="[
                    'flex h-10 w-10 items-center justify-center rounded-lg text-theme-sm font-medium',
                    paginatedItems.current_page == link.label
                      ? 'bg-gray-500 text-white'
                      : 'hover:bg-gray-500/[0.08] hover:text-brand-500 text-gray-400 hover:text-gray-500',
                  ]"
                >
                  {{ link.label }}
                </button>
              </template>
            </li>
          </ul>

          <button
            @click="nextPage"
            :disabled="paginatedItems.current_page === paginatedItems.last_page"
            class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 sm:px-3.5 disabled:pointer-events-none disabled:opacity-30"
          >
            <svg
              width="20"
              height="20"
              viewBox="0 0 20 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fillRule="evenodd"
                clipRule="evenodd"
                d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z"
                fill="currentColor"
              />
            </svg>
          </button>
        </div>
      </div>
    </template>  
</template>

<script setup>
import { computed } from 'vue'
import { cloneDeep } from 'lodash'

const props = defineProps({
  paginatedItems: Object,
})

const emit = defineEmits(['change'])
const innerLinks = computed(() => {
  if (props.paginatedItems.links && props.paginatedItems.links.length > 2) {
    const tmpLinks = cloneDeep(props.paginatedItems.links)
    tmpLinks.shift()
    tmpLinks.pop()
    return tmpLinks
  } else {
    return []
  }
})

const paginationData = computed(() => props.paginatedItems ?? { total: 0 })

const prevPage = () => {
  emit('change', props.paginatedItems.prev_page_url)
}

const nextPage = () => {
  emit('change', props.paginatedItems.next_page_url)
}

const goToPage = (page) => {
  emit('change', page)
}
</script>