<script setup lang="ts">
import { RouterLink } from 'vue-router'
import CollectionPreview from '../components/catalog/CollectionPreview.vue'
</script>

<template>
  <CollectionPreview heading="Lorem ipsum" />

  <section class="editorial-strip" aria-label="Store photography layout">
    <div v-for="image in 3" :key="image" class="editorial-placeholder"><span>Lorem ipsum dolor sit amet.</span></div>
  </section>

  <section id="about" class="store-story" aria-labelledby="about-heading">
    <h2 id="about-heading">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore.</h2>
    <div class="story-copy">
      <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Lorem ipsum dolor sit amet.</p>
      <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Lorem ipsum dolor sit amet consectetur adipiscing elit.</p>
      <RouterLink class="subtle-link" to="/shop">Lorem ipsum <span aria-hidden="true">↗</span></RouterLink>
    </div>
  </section>

  <section id="lookbook" class="lookbook" aria-labelledby="lookbook-heading">
    <div class="section-heading"><h2 id="lookbook-heading">Lorem ipsum</h2><p>Lorem ipsum dolor sit amet consectetur.</p></div>
    <div class="lookbook-images"><div v-for="image in 2" :key="image" class="editorial-placeholder"><span>Lorem ipsum dolor sit amet.</span></div></div>
  </section>

  <section id="faqs" class="faq-section" aria-labelledby="faq-heading">
    <div class="faq-copy">
      <h2 id="faq-heading">Lorem ipsum dolor sit amet.</h2>
      <details><summary>Lorem ipsum dolor sit amet consectetur adipiscing elit.</summary><p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut.</p></details>
      <details><summary>Lorem ipsum dolor sit amet consectetur.</summary><p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut.</p></details>
      <details><summary>Lorem ipsum dolor sit amet.</summary><p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do.</p></details>
      <details><summary>Lorem ipsum dolor sit amet consectetur adipiscing.</summary><p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore.</p></details>
    </div>
    <div class="editorial-placeholder faq-image"><span>Lorem ipsum dolor sit amet.</span></div>
  </section>

  <section id="pickup" class="pickup-map" aria-labelledby="pickup-location-heading">
    <span class="map-placeholder-label">Lorem ipsum dolor sit amet.</span>
    <div class="pickup-location-card">
      <h2 id="pickup-location-heading">Lorem ipsum dolor sit amet.</h2>
      <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut.</p>
      <RouterLink class="subtle-link" to="/checkout">Lorem ipsum <span aria-hidden="true">↗</span></RouterLink>
    </div>
  </section>
</template>
