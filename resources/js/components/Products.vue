<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div class="col-12 text-center">
          <b-jumbotron v-if="canEdit" >
            <template #header>Inventory</template>
            <template #lead>
              Inventory product management
            </template>
            <hr class="my-4">
            <b-button v-if="!editMode" class="add-button" variant="success" @click="addRowHandler">Add Item</b-button>
            <b-button v-if="editMode" variant="warning" @click="cancelAdd">Cancel</b-button>
          </b-jumbotron>
          <div class="card-body">
            <b-overlay :show="isLoading" rounded="sm">
              <b-table ref="productTable" :items="products" :fields="fields">
                <template #cell(description)="data">
                  <b-form-input v-if="products[data.index].isEdit" type="text"
                                v-model="products[data.index].description"></b-form-input>
                  <span v-else>{{ data.value }}</span>
                </template>
                <template #cell(apply)="data">
                  <input type="number" min="0" v-model="products[data.index].requestedQuantity"
                         @change="quantityChanged(data)">
                  <button type="button"
                          @click="getPriceForQuantity(data)"
                          class="btn btn-info">
                    Calculate
                  </button>
                  <h4 v-if="products[data.index].showPrice">Value: ${{ products[data.index].calculatedPrice }}</h4>
                  <button v-if="products[data.index].showPrice" @click="applyQuantity(data)"
                          type="button"
                          class="btn btn-primary">Apply
                  </button>
                  <button v-if="products[data.index].showPrice" @click="quantityChanged(data)"
                          type="button"
                          class="btn btn-danger">Cancel
                  </button>
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
                  <b-button @click="editRowHandler(data)">
                    <span v-if="!products[data.index].isEdit">Edit</span>
                    <span v-else>Save</span>
                  </b-button>
                </template>
              </b-table>
            </b-overlay>
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
      calculatedPrice: 0,
      requestedQuantity: 0,
      isLoading: false,
      editMode: false,
      fields: [
        {key: "productID", label: "ID"},
        {key: "description", label: "Description"},
        {key: "quantity", label: "Quantity (Units)"},
      ],
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

<style>
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
</style>