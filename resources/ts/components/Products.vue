<template>
  <v-container>
    <PageBanner v-if="canEdit" title="Inventory" subtitle="Inventory product management" :actions="actionButtons"
                @clickAction="actionClick"></PageBanner>
    <v-card v-if="editMode">
      <v-card-text>
        <v-text-field label="Product description" v-model="newProductDescription"></v-text-field>
        <v-text-field label="Opening quantity" type="number" v-model="newProductQty"></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-btn color="primary" block @click="saveProduct()">Save Product</v-btn>
      </v-card-actions>
    </v-card>
    <b-alert
        :show="this.invalidQty"
        variant="warning"
    ><p>Quantity must be greater than zero</p>
    </b-alert>
    <b-alert
        :show="this.insufficientQty"
        variant="warning"
    ><p>Quantity to be applied exceeds the quantity on hand</p>
    </b-alert>
    <v-data-table v-if="products.length > 1"
      :headers="headers"
      :items="products"
      :loading="isLoading"
      class="elevation-0">
      <template v-if="this.canEdit" v-slot:[`item.description`]="{ item }">
        <v-text-field v-if="item.isEdit" type="text" v-model="newProductDescription"></v-text-field>
        <span v-else>{{ item.description }}</span>
      </template>
      <template v-if="this.canEdit" v-slot:[`item.actions`]="{ item }">
        <v-btn v-if="!item.isEdit" @click="editRowHandler(item.productID, item.isEdit ?? false, item.description)">Edit</v-btn>
        <v-btn v-if="item.isEdit" color="#78be20" @click="editRowHandler(item.productID, item.isEdit ?? false, item.description)">Save Changes</v-btn>
        <v-btn v-if="item.isEdit" @click="cancelEditRow(item.productID)">Cancel</v-btn>
      </template>
      <template v-if="this.canApply" v-slot:[`item.apply`]="{ item }">
        <v-btn v-if="!item.isEdit && item.quantity > 0" @click="editRowHandler(item.productID, item.isEdit ?? false)">Apply</v-btn>
        <v-text-field v-if="item.isEdit" type="number" v-model="requestedQuantity"></v-text-field>
        <v-btn v-if="item.isEdit && (item.calculatedPrice == 0 || !item.calculatedPrice)" @click="getPriceForQuantity(item.productID, item.quantity)">Calculate</v-btn>
        <v-card v-if="item.calculatedPrice > 0" class="mx-auto" max-width="344" variant="outlined">
          <v-card-text>
            <div>
              <div class="text-overline mb-1">Application Value</div>
              <div class="text-h6 mb-1">NZD$ {{  item.calculatedPrice }}</div>
            </div>
          </v-card-text>
          <v-card-actions>
            <v-btn color="#78be20" @click="applyQuantity(item.productID)">Confirm Application</v-btn>
            <v-btn v-if="item.isEdit" @click="cancelEditRow(item.productID)">Cancel</v-btn>
          </v-card-actions>
        </v-card>
      </template>
    </v-data-table>
  </v-container>
</template>

<script lang="ts">
import { mapActions, mapGetters, mapMutations } from "vuex";
import PageBanner from "./Shared/PageBanner.vue";
export default {
  name: "products",
  props: ["canEdit", "canApply"],
  components: {PageBanner},
  data() {
    return {
      newProductDescription: '',
      newProductQty: 0,
      calculatedPrice: 0,
      requestedQuantity: 0,
      invalidQty: false,
      insufficientQty: false,
      isLoading: false,
      editMode: false,
      showBanner: true,
      headers: [
        { text: "ID", value: "productID", sortable: true },
        { text: "Description", value: "description"},
        { text: "Quantity (Units)", value: "quantity", sortable: true  },
        {text: "", value: "actions"},
        {text: "", value: "apply"}
      ]
    }
  },
  computed: {
    ...mapGetters("products", {
      products: "getProducts",
    }),
    actionButtons() {
      if (!this.editMode) {
        return ['Add New Product']
      }
      return ['Cancel']
    }
  },
  mounted() {
    if (!this.products.isLoaded) {
      this.loadProducts();
    }
  },
  methods: {
    ...mapActions("products", ["loadProducts", "createOrUpdateProduct", "calcPriceForQuantity", "commitApplication"]),
    ...mapMutations("products", ["editProduct"]),
    actionClick(value) {
      if (value === 'Add New Product') {
        this.addRowHandler();
      }
      if (value === 'Cancel') {
        this.cancelAdd();
      }
    },
    editRowHandler(productID, isEdit, descr?) {
      if (isEdit) {
        this.createOrUpdateProduct({"description": this.newProductDescription, "productID": productID});
        this.newProductDescription = '';
        return;
      }
      this.newProductDescription = descr;
      this.editProduct(productID);
    },
    cancelEditRow(productID) {
      this.newProductDescription = '';
      this.requestedQuantity = 0;
      this.editProduct(productID);
    },
    cancelAdd() {
      this.editMode = false;
    },
    inputHandler(value, index, key) {
      this.products[index][key] = value;
      this.$set(this.products, index, this.products[index]);
      this.$emit("input", this.products);
    },
    addRowHandler() {
      this.editMode = true;
    },
    saveProduct() {
      this.createOrUpdateProduct({"productID": 0,"description": this.newProductDescription, "qty": this.newProductQty});
      this.newProductDescription = '';
      this.newProductQty = 0;
      this.editMode = false;
    },
    getPriceForQuantity(productID, quantity) {
      this.invalidQty = false;
      this.insufficientQty = false;
      if (this.requestedQuantity <= 0) {
        this.invalidQty = true;
        return;
      }
      if (this.requestedQuantity > quantity) {
        this.insufficientQty = true;
        return;
      }
      this.calcPriceForQuantity({"productID": productID, "requestedQuantity": this.requestedQuantity});

    },
    applyQuantity(productID) {
      this.commitApplication({"productID": productID, "quantity": this.requestedQuantity});
      this.requestedQuantity = 0;
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