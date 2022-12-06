<template>
  <div class="container mt-5">
    <div class="col-12 text-center">
      <h1>Product Availability - Application</h1>
    </div>
    <div class="container mt-5">
      <Products :can-apply="true" :can-edit="false"></Products>
    </div>
  </div>
</template>

<script>
import Products from "./Products";
export default {
name: "Welcome.vue",
  components: {Products}
}
</script>

<style scoped>

</style>