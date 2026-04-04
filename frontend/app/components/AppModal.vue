<template>
  <Teleport to="body">
    <Transition name="modal">
      <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="emit('close')" />
        <div class="modal-card relative w-full rounded-xl border border-white/[0.06] bg-surface-light p-6 text-white shadow-2xl" :class="sizeClasses[size]">
          <div v-if="title" class="flex items-center gap-3">
            <slot name="icon" />
            <h2 class="font-display text-[16px] font-bold uppercase tracking-wider">{{ title }}</h2>
          </div>
          <div :class="title ? 'mt-4' : ''">
            <slot />
          </div>
          <div v-if="$slots.footer" class="mt-5 flex gap-3">
            <slot name="footer" />
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  open: boolean
  title?: string
  size?: 'sm' | 'md' | 'lg'
}>(), { size: 'md' })

const emit = defineEmits<{ close: [] }>()

const sizeClasses: Record<string, string> = { sm: 'max-w-sm', md: 'max-w-md', lg: 'max-w-lg' }

watch(() => props.open, (v) => {
  document.body.style.overflow = v ? 'hidden' : ''
})

onMounted(() => {
  const onEsc = (e: KeyboardEvent) => { if (e.key === 'Escape' && props.open) emit('close') }
  document.addEventListener('keydown', onEsc)
  onUnmounted(() => document.removeEventListener('keydown', onEsc))
})
</script>

<style scoped>
.modal-enter-active, .modal-leave-active { transition: opacity 0.2s ease; }
.modal-enter-active .modal-card, .modal-leave-active .modal-card { transition: transform 0.2s ease, opacity 0.2s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
.modal-enter-from .modal-card { transform: scale(0.95); opacity: 0; }
</style>
