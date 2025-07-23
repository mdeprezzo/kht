<template>
  <Modal :show="show">
    <div class="relative w-full rounded-3xl bg-white p-6 lg:p-10">
      <div class="flex justify-between items-center mb-4">
        <h4 class="text-lg font-medium text-gray-800">
          <span v-if="!form.id">Aggiungi utente</span>
          <span v-else>Modifica utente</span>
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

      <template v-if="form.role != '' && form.role != 'admin' && form.id">
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
          <li class="me-2">
            <button 
              @click="switchTab('data')"
              class="inline-block p-4 rounded-t-lg transition-all"
              :class="{
                'active bg-gray-100 text-blue-600': currentTab === 'data',
                'hover:text-gray-600 hover:bg-gray-50': currentTab != 'favorite'
              }"
            >Dati utente</button>
          </li>
          <li class="me-2">
            <button 
              @click="switchTab('favorite')"
              class="inline-block p-4 rounded-t-lg transition-all"
              :class="{
                'active bg-gray-100 text-blue-600': currentTab === 'favorite',
                'hover:text-gray-600 hover:bg-gray-50': currentTab != 'favorite'
              }"
            >Preferiti</button>
          </li>
        </ul>
      </template>

      <div class="tab-content py-4">
        <div 
          class="tab-item transition-all" 
          :class="{
            'block': currentTab === 'data',
            'hidden': currentTab != 'data',
          }"
        >
          <div class="grid grid-cols-1 gap-4">
            <div>
              <InputLabel for="name" value="Nome" />
              <TextInput
                  id="name"
                  type="text"
                  placeholder="Nome"                    
                  class="w-full"
                  v-model="form.name"
              />   
              <InputError class="mt-2" :message="form.errors.name" />
            </div>           

            <div>
              <InputLabel for="email" value="Email" />
              <TextInput
                  id="email"
                  type="email"
                  placeholder="Email"  
                  class="w-full"       
                  v-model="form.email"           
              />       
              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
              <InputLabel for="role" value="Ruolo" />
              <select 
                v-model="form.role"
                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 w-full"
              >
                <option value="">- Seleziona il ruolo utente -</option>
                <option v-for="role in roles" :value="role" :key="role">{{ role }}</option>
              </select>
              <InputError class="mt-2" :message="form.errors.role" />
            </div>
            
            <div>
              <InputLabel for="password" value="Password" />
              <TextInput
                  id="password"
                  type="password"
                  placeholder="Password"     
                  class="w-full"       
                  v-model="form.password"        
              />  
              <InputError class="mt-2" :message="form.errors.password" />
            </div>
            
            <div>
              <InputLabel for="password_confirmation" value="Conferma password" />
              <TextInput
                  id="password_confirmation"
                  type="password"
                  placeholder="Conferma password"                    
                  class="w-full"
                  v-model="form.password_confirmation"
              />            
            </div>
          </div>

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
        <div 
          class="tab-item transition-all" 
          :class="{
            'block': currentTab === 'favorite',
            'hidden': currentTab != 'favorite',
          }"
        >
          <BaseTable 
            :headers="headers"
            :paginatedItems="books" 
            @change="changePage" 
            :actions="false"
          >
            <template #cover="{ item }">
              <template v-if="item.media.length > 0">
                <img :src="item.media[0].original_url" class="w-20 h-20 rounded-full shadow-md object-cover" :alt="item.title" />
              </template>
            </template>
          </BaseTable>
        </div>
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
import BaseTable from '@/Components/BaseTable.vue';

defineExpose({ close, open })
const emit = defineEmits(['close', 'success']);

const roles = computed(() => usePage().props.roles);

const searchQuery = ref('')
const books = ref({
  data: []
})
const currentTab = ref('data')
const show = ref(false)
const form = useForm({
  id: null,
  name: '',
  email: '',
  role: '',
  password: '',
  password_confirmation: '',
})

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

function close() {
  show.value = false
  currentTab.value = 'data'
  form.reset()
  books.value.data = []

  emit('close')
}

const changePage = async (page) => {
  const response = await axios.get(page)
  books.value = response.data.books
}

async function open(item = null) {
  if (item) {
    const response = await axios.get(route('api.users.show', { user: item.id, searchQuery: searchQuery.value }))
    form.id = response.data.user.id
    form.name = response.data.user.name
    form.email = response.data.user.email
    form.role = response.data.user.roles[0].name

    books.value = response.data.books
  }

  show.value = !show.value
}

const save = () => {
  if (!form.id) {
    form.post(
      route('admin.users.store'),
      {
        onSuccess: () => {
          close();
          emit('success')
        }
      }
    )
  } else {
    form.put(
      route('admin.users.update', form.id),
      {
        onSuccess: () => {
          close();
          emit('success')
        }
      }
    )    
  }
}

const switchTab = (tab) => {
  currentTab.value = tab
}
</script>