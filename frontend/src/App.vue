<script setup lang="ts">
import { nextTick, ref, watch } from 'vue'
import { RouterLink, RouterView, useRoute } from 'vue-router'

const route = useRoute()
const menuOpen = ref(false)
const menuButton = ref<HTMLButtonElement | null>(null)

function closeMenu() {
  if (!menuOpen.value) return
  menuOpen.value = false
  menuButton.value?.focus()
}

function leaveMenu(event: FocusEvent) {
  const control = event.currentTarget as HTMLElement
  if (!control.contains(event.relatedTarget as Node | null)) menuOpen.value = false
}

function skipToContent() {
  const main = document.querySelector<HTMLElement>('main')
  main?.focus({ preventScroll: true })
  main?.scrollIntoView()
}

watch(() => route.path, async () => {
  menuOpen.value = false
  await nextTick()
  document.querySelector<HTMLElement>('main')?.focus({ preventScroll: true })
})
</script>

<template>
  <a class="skip-link" href="#main" aria-label="Skip to content" @click.prevent="skipToContent">Lorem ipsum</a>
  <div class="store-shell" @keydown.esc="closeMenu">
    <header class="masthead">
      <RouterLink class="wordmark" to="/" aria-label="Secondhand home">Lorem ipsum</RouterLink>
    </header>
    <div class="page-shell">
      <main id="main" tabindex="-1"><RouterView /></main>
      <footer class="site-footer">
        <div class="footer-links"><RouterLink to="/shop">Lorem ipsum</RouterLink><RouterLink :to="{ path: '/', hash: '#about' }">Lorem ipsum</RouterLink><RouterLink :to="{ path: '/', hash: '#faqs' }">Lorem ipsum</RouterLink><RouterLink :to="{ path: '/', hash: '#pickup' }">Lorem ipsum</RouterLink></div>
        <div><p>Lorem ipsum</p><p class="muted">Lorem ipsum<br>Lorem ipsum</p></div>
        <div><RouterLink to="/checkout">Lorem ipsum <span aria-hidden="true">↗</span></RouterLink><p id="preview-note" class="muted">Lorem ipsum dolor sit amet.<br>Lorem ipsum</p></div>
      </footer>
    </div>
    <div class="floating-navigation" :class="{ 'is-open': menuOpen }">
      <div class="menu-control" @focusout="leaveMenu">
        <button ref="menuButton" class="utility-button menu-toggle" :class="{ 'is-open': menuOpen }" :aria-label="menuOpen ? 'Close Menu' : 'Open Menu'" :aria-expanded="menuOpen" aria-controls="site-menu" @click="menuOpen = !menuOpen">
          <span class="menu-symbol" aria-hidden="true">{{ menuOpen ? '×' : '=' }}</span>
          Lorem ipsum
        </button>
        <nav v-show="menuOpen" id="site-menu" class="menu-panel" aria-label="Main navigation" @click="closeMenu">
          <RouterLink to="/" aria-label="Home" :class="{ selected: route.path === '/' && !route.hash }" :aria-current="route.path === '/' && !route.hash ? 'page' : 'false'">Lorem ipsum</RouterLink>
          <RouterLink to="/shop" aria-label="Shop" :class="{ selected: route.path.startsWith('/shop') }" :aria-current="route.path.startsWith('/shop') ? 'page' : 'false'">Lorem ipsum</RouterLink>
          <RouterLink :to="{ path: '/', hash: '#about' }" aria-label="Our store" :class="{ selected: route.hash === '#about' }" :aria-current="route.hash === '#about' ? 'location' : 'false'">Lorem ipsum</RouterLink>
          <RouterLink :to="{ path: '/', hash: '#lookbook' }" aria-label="Lookbook" :class="{ selected: route.hash === '#lookbook' }" :aria-current="route.hash === '#lookbook' ? 'location' : 'false'">Lorem ipsum</RouterLink>
          <RouterLink :to="{ path: '/', hash: '#faqs' }" aria-label="FAQs" :class="{ selected: route.hash === '#faqs' }" :aria-current="route.hash === '#faqs' ? 'location' : 'false'">Lorem ipsum</RouterLink>
          <RouterLink :to="{ path: '/', hash: '#pickup' }" aria-label="Pickup" :class="{ selected: route.hash === '#pickup' }" :aria-current="route.hash === '#pickup' ? 'location' : 'false'">Lorem ipsum</RouterLink>
          <RouterLink class="mobile-bag" to="/bag" aria-label="Sample bag with 1 item" :class="{ selected: route.path === '/bag' }">Lorem ipsum <span class="bag-count">1</span></RouterLink>
        </nav>
      </div>
      <label class="floating-search">
        <span class="sr-only">Search collection (placeholder)</span>
        <span class="search-symbol" aria-hidden="true"><svg viewBox="0 0 20 20" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8.5" cy="8.5" r="4.5" /><path d="m12 12 4 4" /></svg></span>
        <input type="search" placeholder="Lorem ipsum" disabled aria-describedby="preview-note">
        <span class="search-arrow" aria-hidden="true">→</span>
      </label>
      <RouterLink class="utility-button bag-control" to="/bag" aria-label="Sample bag with 1 item">Lorem ipsum <span class="bag-count">1</span></RouterLink>
    </div>
  </div>
</template>
