<template>
  <Modal :show="show">
    <div class="relative w-full rounded-3xl bg-white p-6 lg:p-10">
      <div class="flex justify-between items-center mb-6">
        <h4 class="text-lg font-medium text-gray-800">
          <span v-if="!form.id">Aggiungi libro</span>
          <span v-else>Modifica libro</span>
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

      <form>
        <div class="grid grid-cols-1 gap-4">
          <template v-if="book">
            <div class="flex justify-center">
              <img :src="book.cover" class="max-w-full h-40 object-cover" :alt="book.title" />
            </div>
          </template>
          <div>
            <InputLabel for="title" value="Titolo" />
            <TextInput
                id="name"
                type="text"
                placeholder="Titolo"                    
                class="w-full"
                v-model="form.title"
            />   
            <InputError class="mt-2" :message="form.errors.title" />
          </div>           

          <div>
            <InputLabel for="description" value="Descrizione" />
            <textarea
                id="description"
                placeholder="Descrizione"  
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full"
                v-model="form.description"           
            ></textarea>       
            <InputError class="mt-2" :message="form.errors.description" />
          </div>

          <div>
            <InputLabel for="price" value="Prezzo" />
            <TextInput
                id="price"
                type="number"
                placeholder="Prezzo"  
                class="w-full"       
                v-model="form.price"           
            />       
            <InputError class="mt-2" :message="form.errors.price" />
          </div>          

          <div>
            <InputLabel for="cover" value="Cover" />
            <FileInput @selected="setSelectedFile" />
          </div>
        </div>
      </form>

      <div class="flex items-center justify-between w-full gap-3 mt-6">
        <SecondaryButton
          @click="close"
          :disabled="form.processing"
        >
          Annulla
        </SecondaryButton>
        <PrimaryButton :disabled="form.processing" @click="save">Salva</PrimaryButton>
      </div>        
    </div>
  </Modal>
</template>

<script setup>
import axios from 'axios';
import { computed, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3';

import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import FileInput from '@/Components/FileInput.vue';

defineExpose({ close, open })
const emit = defineEmits(['close', 'success']);

const roles = computed(() => usePage().props.roles);

const show = ref(false)
const book = ref(null)
const form = useForm({
  id: null,
  title: '',
  description: '',
  price: '',
  cover: null,
})

function close() {
  show.value = false
  form.reset()
  emit('close')
}

async function open(item = null) {
  if (item) {
    const response = await axios.get(route('api.books.show', { book: item.id }))
    book.value = response.data.data

    form.id = item.id
    form.title = item.title
    form.description = item.description
    form.price = item.price
  }

  show.value = !show.value
}

const save = () => {
  if (!form.id) {
    form.post(
      route('admin.books.store'),
      {
        onSuccess: () => {
          close();
          emit('success')
        }
      }
    )
  } else {
    form.put(
      route('admin.books.update', form.id),
      {
        onSuccess: () => {
          close();
          emit('success')
        }
      }
    )    
  }
}

const setSelectedFile = (file) => {
  form.cover = file
}

</script>