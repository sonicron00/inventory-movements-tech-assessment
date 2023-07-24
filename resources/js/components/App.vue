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
  <!--
  <v-app>
  <main>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <router-link to="/" class="navbar-brand" href="#">Figured x Ryan - 2023 GLOW-UP
        </router-link>
        <div class="collapse navbar-collapse">
          <div class="navbar-nav">
            <router-link exact-active-class="active" to="/bonus" class="nav-item nav-link">NEW 2023 Update</router-link>
            <router-link exact-active-class="active" to="/" class="nav-item nav-link">Product Application</router-link>
            <router-link exact-active-class="active" to="/products" class="nav-item nav-link">Product Admin</router-link>
            <router-link exact-active-class="active" to="/transactions" class="nav-item nav-link">Transactions</router-link>
            <router-link exact-active-class="active" to="/bonus" class="nav-item nav-link">Bonus</router-link>
          </div>
        </div>
      </div>
    </nav>
    <div class="container mt-5">
      <router-view></router-view>
    </div>
  </main>
    </v-app>
    -->
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