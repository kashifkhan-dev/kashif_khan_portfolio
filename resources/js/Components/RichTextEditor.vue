<template>
  <div class="rounded-lg border border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 transition-all">
    <!-- Formatting Toolbar -->
    <div class="flex flex-wrap items-center gap-1 p-2 border-b border-neutral-200 dark:border-neutral-800 bg-neutral-100/60 dark:bg-neutral-900/80 text-foreground select-none">
      
      <!-- Text Styles -->
      <button 
        type="button" 
        @click="exec('bold')" 
        title="Bold"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <Bold class="h-4 w-4" />
      </button>

      <button 
        type="button" 
        @click="exec('italic')" 
        title="Italic"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <Italic class="h-4 w-4" />
      </button>

      <button 
        type="button" 
        @click="exec('underline')" 
        title="Underline"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <Underline class="h-4 w-4" />
      </button>

      <button 
        type="button" 
        @click="exec('strikeThrough')" 
        title="Strikethrough"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <Strikethrough class="h-4 w-4" />
      </button>

      <div class="h-4 w-px bg-neutral-300 dark:bg-neutral-800 mx-1"></div>

      <!-- Headings -->
      <button 
        type="button" 
        @click="exec('formatBlock', '<h2>')" 
        title="Heading 2"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground text-xs font-bold transition-colors"
      >
        H2
      </button>

      <button 
        type="button" 
        @click="exec('formatBlock', '<h3>')" 
        title="Heading 3"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground text-xs font-bold transition-colors"
      >
        H3
      </button>

      <div class="h-4 w-px bg-neutral-300 dark:bg-neutral-800 mx-1"></div>

      <!-- Lists -->
      <button 
        type="button" 
        @click="exec('insertUnorderedList')" 
        title="Bullet List"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <List class="h-4 w-4" />
      </button>

      <button 
        type="button" 
        @click="exec('insertOrderedList')" 
        title="Numbered List"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <ListOrdered class="h-4 w-4" />
      </button>

      <div class="h-4 w-px bg-neutral-300 dark:bg-neutral-800 mx-1"></div>

      <!-- Blocks & Links -->
      <button 
        type="button" 
        @click="exec('formatBlock', '<pre>')" 
        title="Code Block"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <Code class="h-4 w-4" />
      </button>

      <button 
        type="button" 
        @click="exec('formatBlock', '<blockquote>')" 
        title="Quote"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <Quote class="h-4 w-4" />
      </button>

      <button 
        type="button" 
        @click="insertLink" 
        title="Insert Link"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <LinkIcon class="h-4 w-4" />
      </button>

      <div class="h-4 w-px bg-neutral-300 dark:bg-neutral-800 mx-1"></div>

      <!-- History & Clear -->
      <button 
        type="button" 
        @click="exec('undo')" 
        title="Undo"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <Undo class="h-4 w-4" />
      </button>

      <button 
        type="button" 
        @click="exec('redo')" 
        title="Redo"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-foreground transition-colors"
      >
        <Redo class="h-4 w-4" />
      </button>

      <button 
        type="button" 
        @click="exec('removeFormat')" 
        title="Clear Formatting"
        class="p-1.5 rounded hover:bg-neutral-200 dark:hover:bg-neutral-800 text-muted-foreground hover:text-rose-500 transition-colors ml-auto"
      >
        <RemoveFormatting class="h-4 w-4" />
      </button>
    </div>

    <!-- Editable Canvas Area -->
    <div
      ref="editorRef"
      contenteditable="true"
      @input="onInput"
      @blur="onInput"
      class="p-3.5 min-h-[180px] max-h-[400px] overflow-y-auto text-xs leading-relaxed text-neutral-900 dark:text-neutral-100 outline-none prose dark:prose-invert max-w-none"
      :data-placeholder="placeholder"
    ></div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { 
  Bold, 
  Italic, 
  Underline, 
  Strikethrough, 
  List, 
  ListOrdered, 
  Code, 
  Quote, 
  Link as LinkIcon, 
  Undo, 
  Redo, 
  RemoveFormatting 
} from 'lucide-vue-next';

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
  placeholder: {
    type: String,
    default: 'Write comprehensive project breakdown, features, architecture...',
  },
});

const emit = defineEmits(['update:modelValue']);

const editorRef = ref(null);

onMounted(() => {
  if (editorRef.value) {
    editorRef.value.innerHTML = props.modelValue || '';
  }
});

watch(() => props.modelValue, (newVal) => {
  if (editorRef.value && editorRef.value.innerHTML !== newVal) {
    editorRef.value.innerHTML = newVal || '';
  }
});

function onInput() {
  if (editorRef.value) {
    emit('update:modelValue', editorRef.value.innerHTML);
  }
}

function exec(command, value = null) {
  if (editorRef.value) {
    editorRef.value.focus();
  }
  document.execCommand(command, false, value);
  onInput();
}

function insertLink() {
  const url = prompt('Enter link URL:');
  if (url) {
    exec('createLink', url);
  }
}
</script>

<style scoped>
[contenteditable=true]:empty:before {
  content: attr(data-placeholder);
  color: #737373;
  pointer-events: none;
  display: block;
}

/* Fix Tailwind CSS Resets for Rich Text Elements */
:deep(ul) {
  list-style-type: disc !important;
  padding-left: 1.5rem !important;
  margin-top: 0.5rem !important;
  margin-bottom: 0.5rem !important;
}

:deep(ol) {
  list-style-type: decimal !important;
  padding-left: 1.5rem !important;
  margin-top: 0.5rem !important;
  margin-bottom: 0.5rem !important;
}

:deep(li) {
  margin-top: 0.15rem !important;
  margin-bottom: 0.15rem !important;
  display: list-item !important;
}

:deep(pre) {
  background-color: #171717 !important;
  color: #818cf8 !important;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
  padding: 0.75rem 1rem !important;
  border-radius: 0.5rem !important;
  border: 1px solid #262626 !important;
  margin-top: 0.75rem !important;
  margin-bottom: 0.75rem !important;
  white-space: pre-wrap !important;
}

:deep(code) {
  background-color: #262626 !important;
  color: #818cf8 !important;
  padding: 0.15rem 0.35rem !important;
  border-radius: 0.25rem !important;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
}

:deep(blockquote) {
  border-left: 3px solid #6366f1 !important;
  padding-left: 0.85rem !important;
  color: #a3a3a3 !important;
  font-style: italic !important;
  margin-top: 0.6rem !important;
  margin-bottom: 0.6rem !important;
}

:deep(h2) {
  font-size: 1.15rem !important;
  font-weight: 700 !important;
  color: #f5f5f5 !important;
  margin-top: 0.75rem !important;
  margin-bottom: 0.35rem !important;
}

:deep(h3) {
  font-size: 1rem !important;
  font-weight: 700 !important;
  color: #e5e5e5 !important;
  margin-top: 0.6rem !important;
  margin-bottom: 0.25rem !important;
}

:deep(a) {
  color: #6366f1 !important;
  text-decoration: underline !important;
}
</style>
