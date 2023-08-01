<template>
  <v-container>
  <PageBanner title="Product Availability" subtitle="Application Calculator"></PageBanner>
      <Products :can-apply="true" :can-edit="false"></Products>
  </v-container>
</template>

<script>
import Products from "./Products";
import PageBanner from "./Shared/PageBanner.vue";

export default {
  name: "Welcome.vue",
  components: {Products, PageBanner},
}
</script>
