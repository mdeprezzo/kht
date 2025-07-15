<template>
  <div class="space-y-6">
    <!-- Elements -->
    <div>
      <template v-if="!hideLabel">
        <slot name="label" v-if="$slots.label"></slot>
        <label v-else class="mb-1.5 block text-sm font-medium text-gray-700">
          Upload file
        </label>      
      </template>
      <input
        type="file"
        class="focus:border-ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 shadow-theme-xs transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pl-3.5 file:pr-3 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden focus:file:ring-brand-300"
        @input="$emit('selected', ($event.target as HTMLInputElement).files?.[0])"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
interface FileInputProps {
  hideLabel?: boolean
}

withDefaults(defineProps<FileInputProps>(), {
  hideLabel: true,
})

defineEmits(['selected'])
</script>
