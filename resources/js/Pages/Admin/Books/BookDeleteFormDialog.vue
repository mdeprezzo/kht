<template>
  <Modal :show="show">
      <div class="relative w-full rounded-3xl bg-white p-6 lg:p-10">
          <div class="flex justify-between items-center mb-6">
              <h4 class="text-lg font-medium text-gray-800">
                  Conferma cancellazione libro
              </h4>

              <!-- close btn -->
              <button
                  type="button"
                  :disabled="form.processing"
                  @click="close"
                  class="group z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-200 text-gray-500 transition-colors hover:bg-gray-300 hover:text-gray-500 m:right-6 sm:top-6 sm:h-11 sm:w-11"
              >
                  <svg
                      class="transition-colors fill-current group-hover:text-gray-600 dark:group-hover:text-gray-200"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                  >
                      <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                          fill=""
                      />
                  </svg>
              </button>
          </div>

        <div class="space-y-4">
          <p class="text-sm text-gray-800">Sei sicuro di voler cancellare il libro <strong>{{ itemToDelete?.title }}</strong>?</p>
        </div>

        <div class="flex items-center justify-end w-full gap-3 mt-6">
          <SecondaryButton
            @click="close"
            :disabled="form.processing"
          >
            Annulla
          </SecondaryButton>
          <PrimaryButton :disabled="form.processing" @click="remove" class="bg-error-500 text-white hover:bg-error-500/15">Elimina</PrimaryButton>
        </div>        
      </div>
  </Modal>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineExpose({ close, open })

const emit = defineEmits(['close']);

const form = useForm({})
const show = ref(false)
const itemToDelete = ref(null)

function close() {
  itemToDelete.value = null
  show.value = !show.value
  emit('close')
}

const remove = () => {
form.delete(route('admin.books.destroy', { user: itemToDelete.value.id }), {
  onFinish: () => close()
})
}

async function open(item = null) {
  itemToDelete.value = item

  show.value = !show.value
}
</script>