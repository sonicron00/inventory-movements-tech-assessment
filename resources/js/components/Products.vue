<template>
  <v-container>
    <PageBanner v-if="canEdit" title="Inventory" subtitle="Inventory product management" :actions="actionButtons"
                @clickAction="actionClick"></PageBanner>
          <div class="card-body">
            <b-overlay :show="isLoading" rounded="sm">
              <b-table ref="productTable" :items="products" :fields="fields">
                <template #cell(description)="data">
                  <v-text-field v-if="products[data.index].isEdit" type="text"
                                v-model="products[data.index].description"></v-text-field>
                  <span v-else>{{ data.value }}</span>
                </template>
                <template #cell(apply)="data">
                  <input type="number" class="tableInput" min="0" v-model="products[data.index].requestedQuantity"
                         @change="quantityChanged(data)">
                  <v-btn
                          elevation="4"
                          @click="getPriceForQuantity(data)"
                    >Calculate
                  </v-btn>
                  <h4 style="padding-top:5px;" v-if="products[data.index].showPrice">Value: ${{ Number(products[data.index].calculatedPrice).toLocaleString("en-US") }}</h4>
                  <v-btn v-if="products[data.index].showPrice" @click="applyQuantity(data)"
                         type="button"
                         >Apply</v-btn>
                  <v-btn v-if="products[data.index].showPrice" @click="quantityChanged(data)"
                          type="button"
                          >Cancel
                  </v-btn>
                  <b-alert
                      :show="products[data.index].invalidQty"
                      variant="warning"
                  ><p>Quantity must be greater than zero</p>
                  </b-alert>
                  <b-alert
                      :show="products[data.index].insufficientQty"
                      variant="warning"
                  ><p>Quantity to be applied exceeds the quantity on hand</p>
                  </b-alert>
                </template>
                <template #cell(edit)="data">
                  <v-btn @click="editRowHandler(data)">
                    <span v-if="!products[data.index].isEdit">Edit</span>
                    <span v-else>Save</span>
                  </v-btn>
                </template>
              </b-table>
            </b-overlay>
          </div>
  </v-container>
</template>

<script>
import PageBanner from "./Shared/PageBanner.vue";
export default {
  name: "products",
  props: ["canEdit", "canApply"],
  components: {PageBanner},
  data() {
    return {
      products: [],
      calculatedPrice: 0,
      requestedQuantity: 0,
      isLoading: false,
      editMode: false,
      showBanner: true,
      fields: [
        {key: "productID", label: "ID"},
        {key: "description", label: "Description"},
        {key: "quantity", label: "Quantity (Units)"},
      ],
    }
  },
  computed: {
    actionButtons() {
      if (!this.editMode) {
        return ['Add New Product']
      }
      return ['Cancel']
    }
  },
  mounted() {
    if (this.canApply) {
      this.fields.push({key: 'apply', label: 'Calculate application value'});
    }
    if (this.canEdit) {
      this.fields.push({key: 'edit', label: ''});
    }
    this.getProducts();
  },
  methods: {
    actionClick(value) {
      if (value === 'Add New Product') {
        this.addRowHandler();
      }
      if (value === 'Cancel') {
        this.cancelAdd();
      }
    },
    editRowHandler(data) {
      if (this.products[data.index].isEdit) {
        this.createOrUpdateProduct(this.products[data.index].description, this.products[data.index].productID);
        this.getProducts();
      }
      this.products[data.index].isEdit = !this.products[data.index].isEdit;
    },
    cancelAdd() {
      this.products.splice(0, 1);
      this.editMode = false;
    },
    inputHandler(value, index, key) {
      this.products[index][key] = value;
      this.$set(this.products, index, this.products[index]);
      this.$emit("input", this.products);
    },
    addRowHandler() {
      this.editMode = true;
      const newRow = this.fields.reduce((a, c) => ({...a, [c.key]: null}), {})
      newRow.isEdit = true;
      this.products.unshift(newRow);
      this.$emit('input', this.products);
    },
    async getProducts() {
      this.isLoading = true;
      await this.axios.get('/api/products').then(response => {
        this.products = response.data;
        this.products = this.products.map(item => ({...item, isEdit: false}));
        this.isLoading = false;
      }).catch(error => {
        console.log(error)
        this.products = [];
        this.isLoading = false;
      })
    },
    createOrUpdateProduct(description, id) {
      this.isLoading = true;
      let payloadId = 0;
      if (id != null) {
        payloadId = id;
      } // If we pass 0 we will create a new item
      this.axios.put(`/api/products/edit/${description}/${payloadId}`).then(response => {
        this.getProducts();
        this.isLoading = false;
        this.editMode = false;
      }).catch(error => {
        console.log(error);
        this.isLoading = false;
      })
    },
    getPriceForQuantity(data) {
      if (this.products[data.index].requestedQuantity <= 0) {
        this.products[data.index].invalidQty = true;
        this.$refs.productTable.refresh();
        return;
      }
      if (this.products[data.index].requestedQuantity > this.products[data.index].quantity) {
        this.products[data.index].insufficientQty = true;
        this.$refs.productTable.refresh();
        return;
      }
      this.isLoading = true;
      this.axios.get(`/api/products/preapply/${this.products[data.index].productID}/${this.products[data.index].requestedQuantity}`).then(response => {
        this.products[data.index].calculatedPrice = response.data;
        this.products[data.index].showPrice = true;
        this.$refs.productTable.refresh();
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
        console.log(error);
      })
    },
    applyQuantity(data) {
      this.isLoading = true;
      this.axios.put(`/api/products/apply/${this.products[data.index].productID}/${this.products[data.index].requestedQuantity}`).then(response => {
        this.getProducts();
        this.products[data.index].showPrice = false;
        this.isLoading = false;
      }).catch(error => {
        this.isLoading = false;
        console.log(error);
      })
    },
    quantityChanged(data) {
      this.products[data.index].showPrice = false;
      this.products[data.index].invalidQty = false;
      this.products[data.index].insufficientQty = false;
      this.$refs.productTable.refresh();
    },
  }
}
</script>

<style scoped>
#app {
  text-align: center;
  margin: 60px;
}

thead, tbody, tfoot, tr, td, th {
  text-align: left;
  width: 100px;
  vertical-align: middle;
}

pre {
  text-align: left;
  color: #d63384;
}

.tableInput {
  border-style: solid;
}

</style>