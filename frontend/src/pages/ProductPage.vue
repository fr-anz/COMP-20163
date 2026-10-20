<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
import GarmentPlaceholder from '../components/catalog/GarmentPlaceholder.vue'

const showViewer = ref(false)
</script>

<template>
  <RouterLink class="back-link" to="/shop"><span aria-hidden="true">←</span> Lorem ipsum</RouterLink>
  <div class="product-layout">
    <section class="product-media" aria-label="Garment preview">
      <div class="view-switch" role="group" aria-label="Preview type">
        <button aria-label="Image" :aria-pressed="!showViewer" @click="showViewer = false">Lorem ipsum</button>
        <button aria-label="3D space" :aria-pressed="showViewer" @click="showViewer = true">Lorem ipsum</button>
      </div>
      <div v-if="showViewer" class="viewer-placeholder">
        <span class="viewer-symbol" aria-hidden="true">↔</span>
        <h2>Lorem ipsum dolor sit amet.</h2>
        <p>Lorem ipsum<br>Lorem ipsum dolor sit amet consectetur.</p>
      </div>
      <GarmentPlaceholder v-else />
    </section>
    <section class="product-info" aria-labelledby="product-title">
      <h1 id="product-title">Lorem ipsum</h1>
      <p class="product-price">Lorem ipsum</p>
      <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
      <dl class="product-facts">
        <div><dt>Lorem ipsum</dt><dd>Lorem ipsum</dd></div>
        <div><dt>Lorem ipsum</dt><dd>Lorem ipsum</dd></div>
        <div><dt>Lorem ipsum</dt><dd>Lorem ipsum</dd></div>
        <div><dt>Lorem ipsum</dt><dd>Lorem ipsum</dd></div>
        <div><dt>Lorem ipsum</dt><dd>Lorem ipsum</dd></div>
      </dl>
      <button class="button button-primary full-width" disabled aria-describedby="bag-note">Lorem ipsum</button>
      <p id="bag-note" class="muted small">Lorem ipsum dolor sit amet consectetur adipiscing elit.</p>
      <RouterLink class="text-link" to="/bag">Lorem ipsum <span aria-hidden="true">↗</span></RouterLink>
      <details class="measurement-details"><summary>Lorem ipsum</summary><p>Lorem ipsum</p><p class="muted small">Lorem ipsum</p></details>
    </section>
  </div>
</template>
