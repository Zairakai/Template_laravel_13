<template>
  <RouterView />
</template>

<script setup lang="ts">
  import { onMounted } from 'vue'
  import { useI18nStore } from './stores/i18n'

  const i18n = useI18nStore()

  onMounted(() => {
    const lang = document.documentElement.lang || navigator.language.split('-')[0]
    i18n.loadLocale(lang)
  })
</script>
