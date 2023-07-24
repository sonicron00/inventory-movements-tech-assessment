import Vue from 'vue'
import Vuetify from 'vuetify/lib'

Vue.use(Vuetify)

const opts = {    theme: {
        themes: {
            light: {
                primary: "#6200ea",
                secondary: "#e7ebed",
                accent: "#8c9eff",
                error: "#b71c1c",
                info: "#78be20"
            },
            dark: {},
        },
    },}

export default new Vuetify(opts)