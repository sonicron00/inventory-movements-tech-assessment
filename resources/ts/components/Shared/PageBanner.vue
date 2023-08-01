<template>
  <v-container>
    <div class="col-12 text-center">
      <b-jumbotron>
        <template #header>{{ title }}</template>
        <template #lead>
          {{ subtitle }}
        </template>
        <hr class="my-4" v-if="actions">
        <v-list-item-action v-for="action in actions" :key="action">
          <v-btn @click="click(action)">{{action}}</v-btn>
        </v-list-item-action>
      </b-jumbotron>
    </div>
  </v-container>
</template>
<script>

export default {
  name: "Welcome.vue",
  props: {
    title: String,
    subtitle: String,
    actions: []
  },
  methods: {
    click(action) {
      this.$emit('clickAction', action);
    }
  }
}

</script>

<style>
.jumbotron {
  border-radius: 12px;
  background-color: #8c9eff;
}
</style>