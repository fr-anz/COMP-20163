<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink } from 'vue-router'
import OrderSummary from '../components/cart/OrderSummary.vue'

const fulfillment = ref('shipping')
</script>

<template>
  <div class="page-heading"><h1>Lorem ipsum</h1><p>Lorem ipsum dolor sit amet consectetur adipiscing elit.</p></div>
  <div class="commerce-layout">
    <form class="checkout-form" @submit.prevent>
      <section aria-labelledby="contact-heading">
        <h2 id="contact-heading">Lorem ipsum</h2>
        <div class="field-grid">
          <label>Lorem ipsum<input name="name" aria-label="Full name" autocomplete="name" placeholder="Lorem ipsum"></label>
          <label>Lorem ipsum<input name="email" aria-label="Email address" type="email" autocomplete="email" placeholder="Lorem ipsum"></label>
          <label class="field-wide">Lorem ipsum<input name="phone" aria-label="Phone number" type="tel" autocomplete="tel" placeholder="Lorem ipsum"></label>
        </div>
      </section>
      <fieldset class="fulfillment-options">
        <legend>Lorem ipsum dolor sit amet.</legend>
        <label :class="{ selected: fulfillment === 'shipping' }"><input v-model="fulfillment" aria-label="Domestic shipping" type="radio" name="fulfillment" value="shipping">Lorem ipsum<span>Lorem ipsum</span></label>
        <label :class="{ selected: fulfillment === 'pickup' }"><input v-model="fulfillment" aria-label="Store pickup" type="radio" name="fulfillment" value="pickup">Lorem ipsum<span>Lorem ipsum</span></label>
      </fieldset>
      <section v-if="fulfillment === 'shipping'" aria-labelledby="address-heading">
        <h2 id="address-heading">Lorem ipsum</h2>
        <div class="field-grid">
          <label class="field-wide">Lorem ipsum<input name="street" aria-label="Street address" autocomplete="street-address" placeholder="Lorem ipsum"></label>
          <label>Lorem ipsum<input name="city" aria-label="City or municipality" autocomplete="address-level2" placeholder="Lorem ipsum"></label>
          <label>Lorem ipsum<input name="province" aria-label="Province" autocomplete="address-level1" placeholder="Lorem ipsum"></label>
          <label>Lorem ipsum<input name="postcode" aria-label="Postal code" autocomplete="postal-code" placeholder="Lorem ipsum"></label>
          <label>Lorem ipsum<input aria-label="Country" value="Lorem ipsum" readonly></label>
        </div>
      </section>
      <section v-else class="pickup-info" aria-labelledby="pickup-heading">
        <h2 id="pickup-heading">Lorem ipsum</h2>
        <p>Lorem ipsum</p><p class="muted">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut.</p>
      </section>
      <p class="muted small">Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod.</p>
      <RouterLink class="text-link" to="/bag"><span aria-hidden="true">←</span> Lorem ipsum</RouterLink>
    </form>
    <OrderSummary :shipping="fulfillment === 'shipping' ? 120 : 0">
      <button class="button button-primary full-width" disabled>Lorem ipsum dolor sit amet.</button>
      <p class="small">Lorem ipsum dolor sit amet consectetur adipiscing elit.</p>
    </OrderSummary>
  </div>
</template>
