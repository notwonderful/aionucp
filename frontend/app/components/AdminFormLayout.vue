<template>
  <form @submit.prevent="$emit('submit')" class="space-y-6">
    <div class="grid gap-6 lg:grid-cols-3">
      <div class="lg:col-span-2 space-y-5">
        <slot name="main" />
      </div>

      <div class="space-y-5">
        <slot name="sidebar" />

        <AlertMessage :message="successMsg" variant="success" />
        <AlertMessage :message="errorMsg" variant="error" />

        <AppButton type="submit" :loading="saving" :loading-text="$t('common.loading')" block>
          {{ item ? saveLabel : createLabel }}
        </AppButton>

        <button v-if="item" type="button" @click="$emit('delete')"
          class="w-full rounded-lg border border-red-500/10 bg-red-600/5 py-2.5 text-[12px] font-bold uppercase tracking-widest text-red-400/60 transition-colors hover:bg-red-600/10 hover:text-red-400">
          {{ deleteLabel }}
        </button>
      </div>
    </div>
  </form>
</template>

<script setup lang="ts">
defineProps<{
  item?: unknown
  saving: boolean
  successMsg: string
  errorMsg: string
  saveLabel: string
  createLabel: string
  deleteLabel: string
}>()

defineEmits<{
  submit: []
  delete: []
}>()
</script>
