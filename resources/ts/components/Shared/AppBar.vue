<template>
  <div>
    <v-app-bar color="deep-purple accent-4" app clipped-left dense dark>
      <v-toolbar-title>Figured x Ryan - 2023 GLOW-UP</v-toolbar-title>
    </v-app-bar>
    <v-navigation-drawer
        app
        clipped
        permanent
    >
      <sidebar-menu :menu="menu" :show-child=child>
        <span slot="dropdown-icon"></span>
      </sidebar-menu>
    </v-navigation-drawer>

  </div>
</template>

<script>
import {SidebarMenu} from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

export default {
  name: "AppBar",
  components: {SidebarMenu},
  data() {
    return {
      child: true,
      group: null,
      hover: false,
      menu: [
        {
          header: 'Main Navigation',
          hiddenOnCollapse: true
        },
        {
          href: '/',
          title: 'Home'
        },
        {
          title: 'Original Assessment',
          child: [
            {
              href: '/landing',
              title: 'Product Application Calculator',
              hiddenOnCollapse: false
            },
            {
              href: '/products',
              title: 'Product Management'
            },
            {
              href: '/transactions',
              title: 'Transactions'
            },
          //  {
          //    href: '/bonus',
          //    title: 'Bonus'
          //  }
          ]
        },
        {
          title: 'Bonus Area',
          badge: {
            text: 'new',
            class: 'vsm--badge_default'
          },
          child: [
            {
              href: '/new-bonus',
              title: 'New Info',
              hiddenOnCollapse: false
            }
          ]
        }
      ]
    }
  },
}
</script>

<style scoped>
.v-toolbar__title {
  font-weight: 900;
  font-size: 27px;
}
</style>