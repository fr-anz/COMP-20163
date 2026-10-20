<script setup lang="ts">
defineProps<{ shipping?: number }>()
</script>

<template>
  <section class="order-summary" aria-labelledby="summary-title">
    <h2 id="summary-title">Lorem ipsum</h2>
    <dl class="summary-lines">
      <div><dt>Lorem ipsum × 1</dt><dd>Lorem ipsum</dd></div>
      <div><dt>Lorem ipsum</dt><dd>Lorem ipsum</dd></div>
      <div class="summary-total"><dt>Lorem ipsum</dt><dd>Lorem ipsum</dd></div>
    </dl>
    <slot />
    <p class="muted small">Lorem ipsum dolor sit amet consectetur adipiscing.</p>
  </section>
</template>
