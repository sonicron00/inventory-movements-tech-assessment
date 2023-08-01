<template>

  <div>
    <b-card title="Card Title" no-body>
      <b-card-header header-tag="nav">
        <b-nav card-header tabs fill>
          <b-nav-item to="/new-bonus/" exact exact-active-class="active">Welcome</b-nav-item>
          <b-nav-item to="/new-bonus/proposal" exact exact-active-class="active">Proposal
            <span class="badge badge-secondary">Down to business!</span>
          </b-nav-item>
          <b-nav-item to="/new-bonus/questions" exact exact-active-class="active">Questions & Answers</b-nav-item>
        </b-nav>
      </b-card-header>

      <b-card-body>
        <router-view></router-view>
      </b-card-body>
    </b-card>
  </div>
</template>
<script>
export default {
  name: "NewBonus"
}
</script>
<style scoped>
.nav-link {
  font-weight:900;
}
</style>
