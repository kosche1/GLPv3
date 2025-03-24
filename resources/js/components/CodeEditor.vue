<template>
    <div class="flex flex-col gap-4 h-full">
      <div
        class="relative w-full flex-1 rounded-lg overflow-hidden border border-neutral-700">
        <div id="editor" class="w-full h-full"></div>
      </div>
      <div class="flex justify-end">
        <button
          @click="submitCode"
          :disabled="isSubmitting"
          class="py-3 px-6 rounded-xl bg-emerald-500 hover:bg-emerald-600 transition-colors duration-300 text-white font-semibold text-center disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ isSubmitting ? "Submitting..." : "Submit Solution" }}
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from "vue";
  import ace from "ace-builds";
  import "ace-builds/src-noconflict/mode-python";
  import "ace-builds/src-noconflict/theme-monokai";
  import "ace-builds/src-noconflict/ext-language_tools";
  import "ace-builds/src-noconflict/ext-beautify";
  
  const props = defineProps({
    initialCode: {
      type: String,
      default: "",
    },
    challengeId: {
      type: String,
      required: true,
    },
    taskId: {
      type: String,
      required: true,
    },
  });
  
  const editor = ref(null);
  const isSubmitting = ref(false);
  
  onMounted(() => {
    const initializeEditor = () => {
      const el = document.getElementById("editor");
      if (!el) {
        console.error("Editor element not found!");
        return;
      }
  
      editor.value = ace.edit(el, {
        maxLines: Infinity,
        minLines: 20,
        fontSize: 14,
        showPrintMargin: false,
        enableBasicAutocompletion: true,
        enableLiveAutocompletion: true,
      });
      editor.value.setTheme("ace/theme/monokai");
      editor.value.session.setMode("ace/mode/python");
      editor.value.setValue(props.initialCode);
      editor.value.clearSelection();
  
      // Force resize and focus
      setTimeout(() => {
        editor.value.resize();
        editor.value.focus(); // Put focus on the editor
      }, 100);
    };
  
    // Retry initialization if the element isn't immediately available
    if (!document.getElementById("editor")) {
      console.log("Editor element not yet available, retrying...");
      setTimeout(initializeEditor, 200); // Try again after 200ms
    } else {
      initializeEditor();
    }
  });
  
  const submitCode = async () => {
    if (isSubmitting.value) return;
  
    isSubmitting.value = true;
    const code = editor.value.getValue();
  
    try {
      const response = await fetch(
        `/api/challenges/${props.challengeId}/tasks/${props.taskId}/submit`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
              .content,
          },
          body: JSON.stringify({ code }),
        }
      );
  
      const data = await response.json();
  
      if (data.success) {
        if (data.nextTaskUrl) {
          window.location.href = data.nextTaskUrl;
        } else {
          window.location.href = `/challenges/${props.challengeId}`;
        }
      } else {
        alert(data.message || "Something went wrong. Please try again.");
      }
    } catch (error) {
      console.error("Error submitting code:", error);
      alert("Failed to submit code. Please try again.");
    } finally {
      isSubmitting.value = false;
    }
  };
  </script>
  
  <style scoped>
  #editor {
    height: 100%;
    width: 100%;
  }
  </style>
  