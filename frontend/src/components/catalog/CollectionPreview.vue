<script setup lang="ts">
import { RouterLink } from 'vue-router'
import GarmentPlaceholder from './GarmentPlaceholder.vue'
import { garment } from '../../fixtures/garment'

defineProps<{ heading: string }>()
</script>

<template>
  <section class="collection-preview" aria-labelledby="collection-heading">
    <h1 id="collection-heading">{{ heading }}</h1>
    <div class="collection-filters" role="group" aria-label="Category filter placeholders">
      <button v-for="category in ['All clothing', 'Tops', 'Outerwear', 'Bottoms', 'Accessories']" :key="category" :aria-label="category" disabled>Lorem ipsum</button>
    </div>
    <div class="catalog-grid">
      <article class="product-listing">
        <RouterLink class="product-image-link" :to="garment.path" :aria-label="`View ${garment.name}`"><GarmentPlaceholder /></RouterLink>
        <div class="listing-caption">
          <p class="listing-meta">Lorem ipsum dolor sit amet</p>
          <h2><RouterLink :to="garment.path">Lorem ipsum</RouterLink></h2>
          <p>Lorem ipsum</p>
        </div>
      </article>
    </div>
  </section>
</template>
