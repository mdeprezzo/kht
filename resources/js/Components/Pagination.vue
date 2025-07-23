<template>
    <!-- Pagination -->
    <template v-if="paginationData?.total > paginationData.per_page">
      <div class="px-6 py-4 border-t border-white/[0.05]">
        <div class="flex items-center justify-between">
          <span class="block text-sm font-medium text-gray-400 sm:hidden">
            Pagina {{ paginationData.current_page }} di {{ paginationData.total }}
          </span>

          <nav aria-label="Page navigation example">
            <ul class="inline-flex -space-x-px text-base h-10">
              <li>
                <button
                  @click="prevPage"
                  :disabled="paginationData.current_page === 1"                
                  class="disabled:pointer-events-none disabled:opacity-45 flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
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
              </li>
              <li v-for="(link, index) in innerLinks" :key="index">
                <template v-if="paginatedItems.current_page == link.label">
                  <span
                    class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 opacity-45"
                  >{{ link.label }}</span>
                </template>
                <template v-else>
                  <button
                    type="button"
                    @click="goToPage(link.url)"
                    class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                  >
                    {{ link.label }}
                  </button>
                </template>
              </li>
              <li>
                <button
                  type="button"
                  @click="nextPage"
                  :disabled="paginationData.current_page === paginationData.last_page"                
                  class="disabled:pointer-events-none disabled:opacity-45 flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
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
              </li>
            </ul>
          </nav>          
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