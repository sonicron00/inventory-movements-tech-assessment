<template>
  <v-card
      class="mx-auto"
      tile
      style="text-align:left;"
  >
    <v-list-item>
      <v-list-item-content>
        <v-list-item-title>Additional functionality</v-list-item-title>
        <v-list-item-subtitle>Dashboard with interactive inventory trend graph (more to illustrate the cool back end stuff I've done here!)</v-list-item-subtitle>
        <v-list-item-subtitle>Transaction search facility with paginated results</v-list-item-subtitle>
        <v-list-item-subtitle>Newly input transactions appear at the top of the table</v-list-item-subtitle>
        <v-list-item-subtitle>Ability to toggle in and out of input mode for transactions (cancel button)</v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-list-item>
      <v-list-item-content>
        <v-list-item-title>UI improvements</v-list-item-title>
        <v-list-item-subtitle>General look and feel revamp</v-list-item-subtitle>
        <v-list-item-subtitle>Side navigation</v-list-item-subtitle>
        <v-list-item-subtitle>New bonus section (here!)</v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>

    <v-list-item>
      <v-list-item-content>
        <v-list-item-title>Infrastructure</v-list-item-title>
        <v-list-item-subtitle>Application UPGRADED to PHP 8.1 and Laravel 10 </v-list-item-subtitle>
        <v-list-item-subtitle>Application now hosted in AWS (EC2) </v-list-item-subtitle>
        <v-list-item-subtitle>Automated deploy into the EC2 instance via GitHub Actions </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
  </v-card>
</template>
<script>
export default {
  name: "FeatureList"
}
</script>