<template>
  <div>
    <div class="col-12 text-center">
      <b-jumbotron>
        <template #header>Transactions</template>
        <template #lead>
          Manual input for purchase transactions
        </template>
        <hr class="my-4">
        <b-button v-if="!editMode" class="add-button" variant="success" @click="addRowHandler">Enter Purchase</b-button>
        <b-button v-if="editMode" variant="warning" @click="cancelAdd">Cancel</b-button>
      </b-jumbotron>
    </div>
    <div class="overflow-auto">
      <p class="mt-3">Current Page: {{ currentPage }} of {{ pageCount }}</p>
      <b-pagination
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
          first-text="⏮"
          prev-text="⏪"
          next-text="⏩"
          last-text="⏭"
          class="mt-4"
      ></b-pagination>
      <b-table
          :items="transactions"
          :fields="fields"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          :per-page="perPage"
          :current-page="currentPage"
          responsive="sm"
      >
        <template #cell(product_id)="data">
          <b-form-input v-if="transactions[data.index].isEdit" type="number"
                        v-model="transactions[data.index].product_id"></b-form-input>
          <span v-else>{{ data.value }}</span>
        </template>
        <template #cell(transaction_type)="data">
          <b-form-input readonly v-if="transactions[data.index].isEdit" type="text" value="Purchase"></b-form-input>
          <span v-else>{{ data.value }}</span>
        </template>
        <template #cell(qty)="data">
          <b-form-input v-if="transactions[data.index].isEdit" type="number"
                        v-model="transactions[data.index].qty"></b-form-input>
          <span v-else>{{ data.value }}</span>
        </template>
        <template #cell(price)="data">
          <b-form-input v-if="transactions[data.index].isEdit" type="number"
                        v-model="transactions[data.index].price"></b-form-input>
          <span v-else>{{ data.value }}</span>
        </template>
        <template #cell(edit)="data">
          <b-button v-if="transactions[data.index].isEdit" @click="recordPurchase(data)">Save</b-button>
        </template>
      </b-table>
    </div>
  </div>
</template>

<script>
export default {
  name: "Transactions",
  data() {
    return {
      sortBy: 'product_id',
      sortDesc: false,
      perPage: 10,
      currentPage: 1,
      editMode: false,
      fields: [
        {key: 'product_id', sortable: true},
        {key: 'transaction_date', sortable: true},
        {key: 'transaction_type', sortable: true},
        {key: 'product_descr', sortable: false},
        {key: 'qty', sortable: false},
        {key: 'price', sortable: false},
        {key: 'edit', label: ''}
      ],
      transactions: []
    }
  },
  mounted() {
    this.getTransactions()
  },
  computed: {
    rows() {
      return this.transactions.length;
    },
    pageCount() {
      return Math.round(this.transactions.length / this.perPage);
    }
  },
  methods: {
    async getTransactions() {
      await this.axios.get('/api/transactions').then(response => {
        this.transactions = response.data
      }).catch(error => {
        console.log(error)
        this.transactions = []
      })
    },
    recordPurchase(data) {
      this.transactions[data.index].isEdit = !this.transactions[data.index].isEdit;
      this.createPurchase(this.transactions[data.index].product_id, this.transactions[data.index].qty, this.transactions[data.index].price);
      this.getTransactions();
    },
    inputHandler(value, index, key) {
      this.transactions[index][key] = value;
      this.$set(this.transactions, index, this.transactions[index]);
      this.$emit("input", this.transactions);
    },
    addRowHandler() {
      this.editMode = true;
      const newRow = this.fields.reduce((a, c) => ({...a, [c.key]: null}), {})
      newRow.isEdit = true;
      this.transactions.unshift(newRow);
      this.$emit('input', this.transactions);
    },
    cancelAdd() {
      this.transactions.splice(0, 1);
      this.editMode = false;
    },
    createPurchase(productId, qty, price) {
      this.axios.put(`/api/purchases/create/${productId}/${qty}/${price}`).then(response => {
        this.getTransactions();
      }).catch(error => {
        console.log(error);
      })
    },
  }
}
</script>
