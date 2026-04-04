<template>
  <div class="flex min-h-screen flex-col bg-surface font-body text-gray-100">
    <AppNav />
    <main class="flex-1">
      <slot />
    </main>
    <AppFooter />
  </div>
</template>
