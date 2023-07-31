<template>
  <v-container>
    <PageBanner title="Transactions" subtitle="Manual input for purchase transactions" :actions="actionButtons"
                @clickAction="actionClick"></PageBanner>
    <div class="col-12 text-center" v-if="dismissCountDown">
      <b-alert
          :show="dismissCountDown"
          dismissible
          variant="success"
          @dismissed="dismissCountDown=0"
          @dismiss-count-down="countDownChanged"
      >
        <p>Transaction successfully recorded!</p>
        <b-progress
            variant="success"
            :max="dismissSecs"
            :value="dismissCountDown"
            height="4px"
        ></b-progress>
      </b-alert>
    </div>
      <v-card v-if="prodInput" class="mx-auto" max-width="344" variant="outlined">
        <v-card-text>
          <v-select
              v-model="selectedProduct"
              id="selectedProduct"
              :items="products"
              item-value="id"
              item-text="description"
              return-object
              solo
              label="Select a product"
          ></v-select>
          <v-text-field label="Purchase quantity" type="number" v-model="purchaseQty"></v-text-field>
          <v-text-field label="Purchase price" type="number" v-model="purchasePrice"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn color="#78be20" :disabled="this.purchasePrice === 0 || this.purchaseQty === 0 || !this.selectedProduct" block @click="recordPurchase">Record purchase</v-btn>
        </v-card-actions>
      </v-card>
    <div class="overflow-auto">
      <p class="mt-3">Current Page: {{ currentPage }} of {{ pageCount }}</p>
      <b-overlay :show="isLoading" rounded="sm">
        <b-form-group>
          <b-input-group size="sm">
            <b-form-input
                id="filter-input"
                v-model="filter"
                type="search"
                placeholder="Search by product name"
            ></b-form-input>
          </b-input-group>
        </b-form-group>
        <b-pagination v-if="this.transactions.length > 1"
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="tran-table"
            class="mt-4"
        ></b-pagination>
        <b-table v-if="this.transactions.length > 1"
            id="tran-table"
            :items="transactions"
            :fields="fields"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :total-rows="rows"
            :per-page="perPage"
            :current-page="currentPage"
            :filter="filter"
            :filter-included-fields="searchFields"
            responsive="sm"
        >
        </b-table>
      </b-overlay>
    </div>
  </v-container>
</template>

<script lang="ts">
import { mapActions, mapGetters } from "vuex";
import PageBanner from "./Shared/PageBanner.vue";
import Alert from './Shared/Alert.vue'

export default {
  name: "Transactions",
  components: {PageBanner, Alert},
  data() {
    return {
      sortBy: 'transaction_date',
      filter: null,
      sortDesc: true,
      perPage: 15,
      currentPage: 1,
      editMode: false,
      dismissSecs: 10,
      dismissCountDown: 0,
      isLoading: false,
      prodInput: false,
      selectedProduct: null,
      purchasePrice: 0,
      purchaseQty: 0,
      searchFields: ["product_descr"],
      fields: [
        {key: 'product_id', sortable: true},
        {key: 'transaction_date', sortable: true},
        {key: 'transaction_type', sortable: true},
        {key: 'product_descr', sortable: false},
        {key: 'qty', sortable: false},
        {key: 'price', sortable: false},
        {key: 'edit', label: ''}
      ],
    }
  },
  mounted() {
    if (!this.transactions.isLoaded) {
      this.loadTransactions();
    }
    if (!this.products.isLoaded) {
      this.loadProducts();
    }
  },
  computed: {
    ...mapGetters("transactions", {
      transactions: "getTransactions",
    }),
    ...mapGetters("products", {
      products: "getProducts",
    }),
    rows() {
      return this.transactions.length;
    },
    pageCount() {
      return Math.ceil(this.transactions.length / this.perPage);
    },
    actionButtons() {
      if (!this.editMode) {
        return ['Enter Purchase']
      }
      return ['Cancel']
    }
  },
  methods: {
    ...mapActions("transactions", ["loadTransactions", "createPurchase"]),
    ...mapActions("products", ["loadProducts"]),
    actionClick(value) {
      if (value === 'Enter Purchase') {
        this.editMode = true;
        this.prodInput = true;
      }
      if (value === 'Cancel') {
        this.cancelAdd();
      }
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    recordPurchase() {
      this.createPurchase({
        "productID": this.selectedProduct.productID,
        "quantity": this.purchaseQty,
        "price": this.purchasePrice,
        "description": this.selectedProduct.description
      });
      this.prodInput = false;
      this.editMode = false;
      this.clearInputs();
      this.dismissCountDown = 10;
    },
    cancelAdd() {
      this.prodInput = false;
      this.editMode = false;
      this.clearInputs();
    },
    clearInputs() {
      this.selectedProduct = null;
      this.purchaseQty = 0;
      this.purchasePrice = 0;
    }
  }
}
</script>
