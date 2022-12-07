<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Inventory</h4>
          </div>
          <div class="card-body">
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
                <p v-if="products[data.index].showPrice">Value: ${{ products[data.index].calculatedPrice }}</p>
                <button v-if="products[data.index].showPrice" @click="applyQuantity(data)"
                        type="button"
                        class="btn btn-primary">Apply
                </button>
                <p v-if="products[data.index].invalidQty">Quantity must be greater than zero</p>
                <p v-if="products[data.index].insufficientQty">Quantity to be applied exceeds the quantity on hand</p>
              </template>
              <template #cell(edit)="data">
                <b-button @click="editRowHandler(data)">
                  <span v-if="!products[data.index].isEdit">Edit</span>
                  <span v-else>Save</span>
                </b-button>
              </template>
            </b-table>
            <b-button v-if="canEdit" class="add-button" variant="success" @click="addRowHandler">Add Item</b-button>
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
    inputHandler(value, index, key) {
      this.products[index][key] = value;
      this.$set(this.products, index, this.products[index]);
      this.$emit("input", this.products);
    },
    addRowHandler() {
      const newRow = this.fields.reduce((a, c) => ({...a, [c.key]: null}), {})
      newRow.isEdit = true;
      this.products.unshift(newRow);
      this.$emit('input', this.products);
    },
    async getProducts() {
      await this.axios.get('/api/products').then(response => {
        this.products = response.data;
        this.products = this.products.map(item => ({...item, isEdit: false}));
      }).catch(error => {
        console.log(error)
        this.products = [];
      })
    },
    createOrUpdateProduct(description, id) {
      let payloadId = 0;
      if (id != null) {
        payloadId = id;
      } // If we pass 0 we will create a new item
      this.axios.put(`/api/products/edit/${description}/${payloadId}`).then(response => {
        this.getProducts();
      }).catch(error => {
        console.log(error);
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
      this.axios.get(`/api/products/preapply/${this.products[data.index].productID}/${this.products[data.index].requestedQuantity}`).then(response => {
        this.products[data.index].calculatedPrice = response.data;
        this.products[data.index].showPrice = true;
        this.$refs.productTable.refresh();
      }).catch(error => {
        console.log(error);
      })
    },
    applyQuantity(data) {
      this.axios.put(`/api/products/apply/${this.products[data.index].productID}/${this.products[data.index].requestedQuantity}`).then(response => {
        this.getProducts();
        this.products[data.index].showPrice = false;
      }).catch(error => {
        console.log(error);
      })
    },
    quantityChanged(data) {
      this.products[data.index].showPrice = false;
      this.products[data.index].invalidQty = false;
      this.products[data.index].insufficientQty = false;
      this.$refs.productTable.refresh();
    }
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