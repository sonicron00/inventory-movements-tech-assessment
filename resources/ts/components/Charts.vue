<template>
  <v-container>
    <v-col cols="6">
      <v-card
          class="mx-auto text-xs-center"
          color="green"
          dark
          max-width="600"
      >
        <v-card-text>
          <v-sheet color="rgba(0, 0, 0, .12)">
            <v-sparkline
                :value="value"
                color="rgba(255, 255, 255, .7)"
                height="100"
                padding="24"
                stroke-linecap="round"
                smooth
            >
              <template v-slot:label="item">
                ${{ item.value }}
              </template>
            </v-sparkline>
          </v-sheet>
        </v-card-text>

        <v-card-text>
          <div class="display-1 font-weight-thin">Applications Last 12m</div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions class="justify-center">
          <v-btn block flat>Go to Transactions</v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    <v-col cols="6">
      <v-card
          class="mx-auto text-xs-center"
          color="green"
          dark
          max-width="600"
      >
        <v-card-text>
          <v-sheet color="rgba(0, 0, 0, .12)">
            <v-sparkline
                :value="value"
                color="rgba(255, 255, 255, .7)"
                height="100"
                padding="24"
                stroke-linecap="round"
                smooth
            >
              <template v-slot:label="item">
                ${{ item.value }}
              </template>
            </v-sparkline>
          </v-sheet>
        </v-card-text>

        <v-card-text>
          <div class="display-1 font-weight-thin">Purchases last 12m</div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions class="justify-center">
          <v-btn block flat>Go to Transactions</v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  name: "Charts",
  data: () => ({
    selectedMonths: 12,
    selectedProduct: null,
    products: [],
    value: [
      423,
      446,
      675,
      510,
      590,
      610,
      760
    ],
    datedValues: [],
    months: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"]
  }),
  mounted() {
    this.getProductData();
    this.getProducts();
  },
  computed: {
    avg() {
      const sum = this.datedValues.reduce((acc, cur) => acc + cur, 0)
      const length = this.datedValues.length
      if (!sum && !length) return 0
      return Math.ceil(sum / length)
    }
  },
  methods: {
    refreshGraph() {
      this.getProductData();
    },
    async getProductData() {
      let productId = null;
      if (this.selectedProduct) {
        productId = this.selectedProduct.productID
      }
      let endpoint = '/api/products/monthly/' + this.selectedMonths + '/' + productId;

      await this.axios.get(endpoint).then(response => {
        this.datedValues = response.data;
        console.log(response.data);
      }).catch(error => {
        console.log(error)
      })
    },
    async getProducts() {
      await this.axios.get('/api/products').then(response => {
        this.products = response.data
      }).catch(error => {
        console.log(error)
      })
    }
  }
}
</script>

<style>
.v-sheet--offset {
  top: -24px;
  position: relative;
}
</style>
