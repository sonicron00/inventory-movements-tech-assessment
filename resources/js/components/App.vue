<template>
  <v-app>
    <AppBar />
    <v-main>
      <v-container fluid>
        <router-view :key="$route.fullPath"></router-view>
        <v-footer
            app
            bottom
            fixed
            padless
            dark
            class="primary"
        >
          <v-col class="text-center" cols="12">
            &copy; {{ new Date().getFullYear() }} —
            <strong>Ryan Smith</strong>
          </v-col>
        </v-footer>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import AppBar from "./Shared/AppBar.vue";
export default {
  name: "App",
  components: {
    AppBar
  },
}
</script>