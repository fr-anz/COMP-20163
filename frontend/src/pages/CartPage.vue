<script setup lang="ts">
import { RouterLink } from 'vue-router'
import GarmentPlaceholder from '../components/catalog/GarmentPlaceholder.vue'
import OrderSummary from '../components/cart/OrderSummary.vue'
import { garment } from '../fixtures/garment'
</script>

<template>
  <div class="page-heading"><h1>Lorem ipsum</h1><p>Lorem ipsum dolor sit amet consectetur adipiscing.</p></div>
  <div class="commerce-layout">
    <section aria-label="Sample bag item">
      <article class="cart-item">
        <RouterLink :to="garment.path" :aria-label="`View ${garment.name}`"><GarmentPlaceholder /></RouterLink>
        <div class="cart-item-info">
          <h2><RouterLink :to="garment.path">Lorem ipsum</RouterLink></h2>
          <p>Lorem ipsum dolor sit amet</p>
          <p class="muted small">Lorem ipsum<br>Lorem ipsum dolor sit amet consectetur.</p>
          <button class="remove-button" disabled aria-describedby="cart-note">Lorem ipsum</button>
        </div>
        <p class="line-price">Lorem ipsum</p>
      </article>
      <p id="cart-note" class="muted small">Lorem ipsum dolor sit amet consectetur adipiscing elit sed.</p>
      <RouterLink class="text-link" to="/shop"><span aria-hidden="true">←</span> Lorem ipsum</RouterLink>
    </section>
    <OrderSummary>
      <RouterLink class="button button-primary" to="/checkout">Lorem ipsum <span aria-hidden="true">↗</span></RouterLink>
    </OrderSummary>
  </div>
</template>
