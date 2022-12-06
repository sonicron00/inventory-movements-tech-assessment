<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Purchase History</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
              <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Product ID</th>
                <th>Product Description</th>
                <th>Quantity applied</th>
              </tr>
              </thead>
              <tbody v-if="purchases.length > 0">
              <tr v-for="(purchases,key) in purchases" :key="key">
                <td>{{ purchases.productID }}</td>
                <td>{{ purchases.description }}</td>
                <td>{{ purchases.quantity }}</td>
              </tr>
              </tbody>
              <tbody v-else>
              <tr>
                <td colspan="4" align="center">No Purchases Found.</td>
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
  name: "purchases",
  data() {
    return {
      purchases: [],
    }
  },
  mounted() {
    this.getPurchases()
  },
  methods: {
    async getPurchases() {
      await this.axios.get('/api/purchases').then(response => {
        this.purchases = response.data
      }).catch(error => {
        console.log(error)
        this.purchases = []
      })
    }
  }
}
</script>