<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Products</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
              <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Quantity</th>
                <th v-if="canApply">Calculate application value</th>
                <th v-if="canEdit"></th>
              </tr>
              </thead>
              <tbody v-if="products.length > 0">
              <tr v-for="(product,key) in products" :key="key">
                <td>{{ product.productID }}</td>
                <td>{{ product.description }}</td>
                <td>{{ product.quantity }}</td>
                <td v-if="canApply">
                  <input type="number">
                  <button type="button" @click="applyQuantity(product.productID)" class="btn btn-danger">Calculate</button>
                  <input type="text" readonly="true">
                </td>
                <td v-if="canEdit">
                  if we want to edit
                </td>
              </tr>
              </tbody>
              <tbody v-else>
              <tr>
                <td colspan="4" align="center">No Products Found.</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "products",
  props: ["canEdit", "canApply"],
  data() {
    return {
      products: [],
    }
  },
  mounted() {
    this.getProducts()
  },
  methods: {
    async getProducts() {
      await this.axios.get('/api/products').then(response => {
        this.products = response.data
      }).catch(error => {
        console.log(error)
        this.products = []
      })
    },
    applyQuantity(id) {
      this.axios.get(`/api/products/apply/${id}`).then(response => {
        alert(response.data)
      }).catch(error => {
        console.log(error);
      })
    }
  }
}
</script>