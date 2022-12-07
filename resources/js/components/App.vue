<template>
  <main>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <router-link to="/" class="navbar-brand" href="#">Figured Technical Assessment - Inventory Management | Ryan
          Smith 2022
        </router-link>
        <div class="collapse navbar-collapse">
          <div class="navbar-nav">
            <router-link exact-active-class="active" to="/" class="nav-item nav-link">Product Application</router-link>
            <router-link exact-active-class="active" to="/products" class="nav-item nav-link">Product Admin</router-link>
            <router-link exact-active-class="active" to="/transactions" class="nav-item nav-link">Transactions</router-link>
            <router-link exact-active-class="active" to="/" class="nav-item nav-link">Price History</router-link>
            <router-link exact-active-class="active" to="/" class="nav-item nav-link">Bonus</router-link>
          </div>
        </div>
      </div>
    </nav>
    <div class="container mt-5">
      <router-view></router-view>
    </div>
  </main>
</template>

<script>
export default {}
</script>