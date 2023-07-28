<template>
  <v-container>
    <v-row>
      <h2>Inventory Dashboard</h2>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card>
          <v-card-title>
            <v-icon
                class="mr-5"
                size="64"
            >
            </v-icon>
            <v-layout
                column
                align-start
            >
              <strong>Trend Line - Monthly Units on Hand</strong>
              <div>
                <v-container fluid grid-list-xl>
                  <v-layout wrap align-center>
                    <v-flex xs6 sm6 d-flex>
                      <v-select
                          v-model="selectedProduct"
                          id="selectedProduct"
                          :items="products"
                          item-value="id"
                          item-text="description"
                          return-object
                          label="All products"
                          solo
                          hint="Select a product"
                          persistent-hint=true
                          @change="refreshGraph"
                      ></v-select>
                    </v-flex>
                    <v-flex xs6 sm4 d-flex>
                      <v-text-field
                          v-model="selectedMonths"
                          label="Months to display"
                          single-line
                          type="number"
                          hint="Number of months to show history"
                          persistent-hint=true
                          solo
                          @change="refreshGraph"
                      />
                    </v-flex>
                  </v-layout>
                </v-container>
              </div>
            </v-layout>

            <v-spacer></v-spacer>

            <v-btn icon class="align-self-start" size="28">
              <v-icon>mdi-arrow-right-thick</v-icon>
            </v-btn>
          </v-card-title>

          <v-sheet color="transparent">
            <v-sparkline
                :key="String(avg)"
                :smooth="16"
                :gradient="['#f72047', '#ffd200', '#1feaea']"
                :line-width="3"
                :value="datedValues"
                :labels="months"
                auto-draw
                stroke-linecap="round"
                gradient-direction="bottom"
                label-size="3"
            >
            </v-sparkline>
          </v-sheet>
        </v-card>
      </v-col>

    </v-row>
  </v-container>
</template>

<script>


export default {
  name: "Home",
  data: () => ({
    selectedMonths: 12,
    selectedProduct: null,
    products: [],
    datedValues: [],
    months: [],
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
        this.months = response.data.months;
        this.datedValues = response.data.data;
      }).catch(error => {
        console.log(error)
      })
    },
    async getProducts() {
      await this.axios.get('/api/products').then(response => {
        this.products = response.data;
        this.products.unshift({'productID': null, 'description': 'Select all'});
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
