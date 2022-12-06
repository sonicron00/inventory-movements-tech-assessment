<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Application History</h4>
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
              <tbody v-if="applications.length > 0">
              <tr v-for="(applications,key) in applications" :key="key">
                <td>{{ applications.productID }}</td>
                <td>{{ applications.description }}</td>
                <td>{{ applications.quantity }}</td>
              </tr>
              </tbody>
              <tbody v-else>
              <tr>
                <td colspan="4" align="center">No Applications Found.</td>
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
  name: "applications",
  data() {
    return {
      applications: [],
    }
  },
  mounted() {
    this.getApplications()
  },
  methods: {
    async getApplications() {
      await this.axios.get('/api/applications').then(response => {
        this.applications = response.data
      }).catch(error => {
        console.log(error)
        this.applications = []
      })
    }
  }
}
</script>