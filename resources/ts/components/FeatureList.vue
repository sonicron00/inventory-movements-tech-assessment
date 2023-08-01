<template>
  <v-card class="mx-auto" tile style="text-align:left;">
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title><v-chip class="ma-2" color="#007bff" text-color="white">Additional Functionality</v-chip></v-list-item-title>
        <v-list-item-subtitle v-for="point in functionalityPoints" v-bind:key="point.subTitle">
          <b-icon-file-check/> {{ point.subTitle }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-list-item>
      <v-list-item-content>
        <v-list-item-title><v-chip class="ma-2" color="#007bff" text-color="white">UI Improvements</v-chip></v-list-item-title>
        <v-list-item-subtitle v-for="point in interfacePoints" v-bind:key="point.subTitle">
          <b-icon-file-check/> {{ point.subTitle }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-list-item>
      <v-list-item-content>
        <v-list-item-title><v-chip class="ma-2" color="#007bff" text-color="white">Infrastructure / General</v-chip></v-list-item-title>
        <v-list-item-subtitle v-for="point in pipelinePoints" v-bind:key="point.subTitle">
          <b-icon-file-check/> {{ point.subTitle }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

  </v-card>
</template>
<script>
export default {
  name: "FeatureList",
  data() {
    return {
      functionalityPoints: [
        {"subTitle": "Dashboard with interactive inventory trend graph (more to illustrate the cool back end stuff I've done here!)" },
        {"subTitle": "Implementation of VUEX store on a modular basis (not necessary for app size but just showcasing!)" },
        {"subTitle": "Implement Typescript" },
        {"subTitle": "Transaction search facility with paginated results" },
        {"subTitle": "Ability to enter new products with opening quantity" },
        {"subTitle": "Newly input transactions appear at the top of the table" },
        {"subTitle": "Ability to toggle in and out of input modes" },
      ],
      interfacePoints: [
        {"subTitle": "General look and feel revamp (particularly around data inputs)" },
        {"subTitle": "Implementation of Vuetify components" },
        {"subTitle": "Side navigation" },
        {"subTitle": "New bonus section (here!)" },
      ],
      pipelinePoints: [
        {"subTitle": "Application UPGRADED to PHP 8.1 and Laravel 10" },
        {"subTitle": "Application now hosted in AWS (EC2)" },
        {"subTitle": "Automated deploy into the EC2 instance via GitHub Actions" },
        {"subTitle": "Bug fix from original submission (product names in transaction list)" },
        {"subTitle": "Component refactoring to remove duplication" },
      ]
    }
  },
  //@TODO - TYPESCRIPT !!!!
}
</script>

<style scoped>

.v-list-item__subtitle {
  font-size: 18px;
}

</style>