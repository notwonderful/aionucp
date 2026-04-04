<template>
  <div class="rich-editor" :class="{ 'rich-editor--focused': isFocused }">
    <div v-if="toolbar" class="rich-editor__toolbar">
      <div class="flex flex-wrap items-center gap-0.5">
        <button type="button" @click="editor?.chain().focus().toggleBold().run()"
          :class="btnClass(editor?.isActive('bold'))">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M8 11h4.5a2.5 2.5 0 000-5H8v5zm10 4.5a4.5 4.5 0 01-4.5 4.5H6V4h6.5a4.5 4.5 0 013.256 7.606A4.498 4.498 0 0118 15.5zM8 13v5h5.5a2.5 2.5 0 000-5H8z"/></svg>
        </button>
        <button type="button" @click="editor?.chain().focus().toggleItalic().run()"
          :class="btnClass(editor?.isActive('italic'))">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M15 20H7v-2h2.927l2.116-12H9V4h8v2h-2.927l-2.116 12H15z"/></svg>
        </button>
        <button type="button" @click="editor?.chain().focus().toggleStrike().run()"
          :class="btnClass(editor?.isActive('strike'))">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M17.154 14c.23.516.346 1.09.346 1.72 0 1.342-.524 2.392-1.571 3.147C14.88 19.622 13.433 20 11.586 20c-1.64 0-3.263-.381-4.87-1.144V16.6c1.52.877 3.075 1.316 4.666 1.316 2.551 0 3.83-.732 3.839-2.197a2.21 2.21 0 00-.648-1.603l-.12-.117H3v-2h18v2h-3.846zM7.556 11c-.159-.424-.238-.904-.238-1.44 0-1.45.525-2.57 1.575-3.36C9.943 5.4 11.353 5 13.125 5c1.467 0 2.907.333 4.32 1l-.96 2.06c-1.167-.533-2.286-.8-3.36-.8-2.378 0-3.567.742-3.567 2.226 0 .382.107.723.322 1.023l.2.265H7.556z"/></svg>
        </button>

        <div class="mx-1 h-5 w-px bg-white/[0.06]" />

        <button type="button" @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()"
          :class="btnClass(editor?.isActive('heading', { level: 2 }))">
          <span class="text-[11px] font-bold">H2</span>
        </button>
        <button type="button" @click="editor?.chain().focus().toggleHeading({ level: 3 }).run()"
          :class="btnClass(editor?.isActive('heading', { level: 3 }))">
          <span class="text-[11px] font-bold">H3</span>
        </button>

        <div class="mx-1 h-5 w-px bg-white/[0.06]" />

        <button type="button" @click="editor?.chain().focus().toggleBulletList().run()"
          :class="btnClass(editor?.isActive('bulletList'))">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M8 4h13v2H8zM4.5 6.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 7a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 6.9a1.5 1.5 0 110-3 1.5 1.5 0 010 3zM8 11h13v2H8zm0 7h13v2H8z"/></svg>
        </button>
        <button type="button" @click="editor?.chain().focus().toggleOrderedList().run()"
          :class="btnClass(editor?.isActive('orderedList'))">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M8 4h13v2H8zM5 3v3h1v1H3V6h1V4H3V3zM3 14v-2.5h2V11H3v-1h3v2.5H4v.5h2v1zm2 5.5H3v-1h2V18H3v-1h3v4H3v-1h2zM8 11h13v2H8zm0 7h13v2H8z"/></svg>
        </button>
        <button type="button" @click="editor?.chain().focus().toggleBlockquote().run()"
          :class="btnClass(editor?.isActive('blockquote'))">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/></svg>
        </button>
        <button type="button" @click="editor?.chain().focus().toggleCode().run()"
          :class="btnClass(editor?.isActive('code'))">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M24 12l-5.657 5.657-1.414-1.414L21.172 12l-4.243-4.243 1.414-1.414L24 12zM2.828 12l4.243 4.243-1.414 1.414L0 12l5.657-5.657L7.07 7.757 2.828 12z"/></svg>
        </button>

        <div class="mx-1 h-5 w-px bg-white/[0.06]" />

        <button type="button" @click="setLink"
          :class="btnClass(editor?.isActive('link'))">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M18.364 15.536L16.95 14.12l1.414-1.414a5 5 0 00-7.071-7.071L9.879 7.05 8.464 5.636 9.88 4.222a7 7 0 019.9 9.9l-1.415 1.414zm-2.828 2.828l-1.415 1.414a7 7 0 01-9.9-9.9l1.415-1.414L7.05 9.88l-1.414 1.414a5 5 0 007.071 7.071l1.414-1.414 1.415 1.414zm-.708-10.607l1.415 1.414-7.071 7.072-1.415-1.415 7.071-7.07z"/></svg>
        </button>
        <button type="button" @click="triggerImageUpload"
          :class="btnClass(false)">
          <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor"><path d="M21 15v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3m4-4l4-4 4 4m-4-4v12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <span v-if="uploading" class="ml-1 text-[10px] text-white/25">Uploading...</span>
      </div>
    </div>

    <EditorContent :editor="editor" />
    <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="handleFileSelect" />
  </div>
</template>

<script setup lang="ts">
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'

const props = withDefaults(defineProps<{
  modelValue?: string
  placeholder?: string
  toolbar?: boolean
}>(), {
  modelValue: '',
  placeholder: 'Write something...',
  toolbar: true,
})

const emit = defineEmits<{
  'update:modelValue': [value: string]
}>()

const { $api, fetchCsrfCookie } = useApi()
const isFocused = ref(false)
const uploading = ref(false)
const fileInput = ref<HTMLInputElement | null>(null)

const editor = useEditor({
  immediatelyRender: false,
  content: props.modelValue,
  extensions: [
    StarterKit,
    Placeholder.configure({ placeholder: props.placeholder }),
    Link.configure({ openOnClick: false }),
    Image.configure({ inline: false, allowBase64: false }),
  ],
  editorProps: {
    attributes: { class: 'rich-editor__content' },
    handleDrop: (view, event, _slice, moved) => {
      if (moved || !event.dataTransfer?.files.length) return false
      const file = event.dataTransfer.files[0]
      if (file?.type.startsWith('image/')) {
        event.preventDefault()
        uploadAndInsert(file)
        return true
      }
      return false
    },
    handlePaste: (_view, event) => {
      const file = event.clipboardData?.files[0]
      if (file?.type.startsWith('image/')) {
        event.preventDefault()
        uploadAndInsert(file)
        return true
      }
      return false
    },
  },
  onUpdate: ({ editor: e }) => emit('update:modelValue', e.getHTML()),
  onFocus: () => { isFocused.value = true },
  onBlur: () => { isFocused.value = false },
})

watch(() => props.modelValue, (val) => {
  if (editor.value && editor.value.getHTML() !== val) {
    editor.value.commands.setContent(val, false)
  }
})

async function uploadAndInsert(file: File) {
  if (uploading.value) return
  uploading.value = true
  try {
    await fetchCsrfCookie()
    const formData = new FormData()
    formData.append('image', file)
    const res = await $api<{ url: string }>('/uploads/image', {
      method: 'POST',
      body: formData,
    })
    editor.value?.chain().focus().setImage({ src: res.url }).run()
  } catch {
    /* upload failed silently */
  } finally {
    uploading.value = false
  }
}

function triggerImageUpload() {
  fileInput.value?.click()
}

function handleFileSelect(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0]
  if (file) uploadAndInsert(file)
  if (fileInput.value) fileInput.value.value = ''
}

function btnClass(active?: boolean) {
  return [
    'flex h-7 w-7 items-center justify-center rounded transition-colors',
    active ? 'bg-red-600/20 text-red-400' : 'text-white/30 hover:bg-white/[0.06] hover:text-white/60',
  ]
}

function setLink() {
  if (!editor.value) return
  if (editor.value.isActive('link')) {
    editor.value.chain().focus().unsetLink().run()
    return
  }
  const url = window.prompt('URL')
  if (url) {
    editor.value.chain().focus().setLink({ href: url }).run()
  }
}

onBeforeUnmount(() => editor.value?.destroy())
</script>

<style scoped>
.rich-editor {
  border-radius: 0.5rem;
  border: 1px solid rgba(255 255 255 / 0.06);
  background: rgba(255 255 255 / 0.03);
  transition: all 0.3s;
}
.rich-editor--focused {
  border-color: rgba(239 68 68 / 0.3);
  background: rgba(255 255 255 / 0.05);
  box-shadow: 0 0 0 1px rgba(239 68 68 / 0.2);
}
.rich-editor__toolbar {
  padding: 0.375rem;
  border-bottom: 1px solid rgba(255 255 255 / 0.04);
}
:deep(.rich-editor__content) {
  padding: 0.75rem 1rem;
  min-height: 80px;
  font-size: 14px;
  color: white;
  outline: none;
}
:deep(.rich-editor__content p.is-editor-empty:first-child::before) {
  content: attr(data-placeholder);
  color: rgba(255 255 255 / 0.15);
  pointer-events: none;
  float: left;
  height: 0;
}
:deep(.rich-editor__content h2) { font-size: 1.25rem; font-weight: 700; margin: 0.75rem 0 0.25rem; }
:deep(.rich-editor__content h3) { font-size: 1.1rem; font-weight: 600; margin: 0.75rem 0 0.25rem; }
:deep(.rich-editor__content ul) { list-style: disc; padding-left: 1.5rem; }
:deep(.rich-editor__content ol) { list-style: decimal; padding-left: 1.5rem; }
:deep(.rich-editor__content blockquote) {
  border-left: 3px solid rgba(239 68 68 / 0.3);
  padding-left: 1rem;
  color: rgba(255 255 255 / 0.5);
  margin: 0.5rem 0;
}
:deep(.rich-editor__content code) {
  background: rgba(255 255 255 / 0.06);
  border-radius: 0.25rem;
  padding: 0.1rem 0.3rem;
  font-size: 0.85em;
}
:deep(.rich-editor__content pre) {
  background: rgba(255 255 255 / 0.04);
  border-radius: 0.5rem;
  padding: 0.75rem 1rem;
  margin: 0.5rem 0;
  overflow-x: auto;
}
:deep(.rich-editor__content pre code) {
  background: none;
  padding: 0;
}
:deep(.rich-editor__content a) {
  color: rgb(239 68 68);
  text-decoration: underline;
  text-underline-offset: 2px;
}
:deep(.rich-editor__content p) { margin: 0.25rem 0; }
:deep(.rich-editor__content img) {
  max-width: 100%;
  height: auto;
  border-radius: 0.5rem;
  margin: 0.5rem 0;
}
</style>
