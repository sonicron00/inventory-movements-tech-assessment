<template>
  <div>
    <div class="container-fluid">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Get to the point: The Proposal</h4>
          </div>
          <div class="card-body">
            <v-card class="mx-auto" tile style="text-align:left;">
              <v-list-item v-for="point in proposalPoints" v-bind:key="point.title">
                <v-list-item-content>
                  <v-list-item-title>{{point.title }}</v-list-item-title>
                  <v-list-item-subtitle>{{ point.subTitle }}</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-card>
          </div>
        </div>
      </div>
    </div>
    <v-btn color="green" v-if="!showCalendar" @click="toggleDiary()">Show availability diary</v-btn>
    <v-btn v-if="showCalendar" @click="toggleDiary()">Close diary</v-btn>
    <Availability v-if="showCalendar"></Availability>
  </div>
</template>
<script lang="ts">
import Availability from "./Availability.vue";
export default {
  name: "NewProposal",
  components: {Availability},
  data() {
    return {
      showCalendar: false,
      proposalPoints: [
        {"title": "Voluntary Trial", "subTitle": "I would like to propose that I complete a three week trial as a Software Developer with Figured." },
        {"title": "Remuneration", "subTitle": "None - this would be a voluntary, unpaid trial." },
        {"title": "Scope", "subTitle": "Ideally, as close to what my original position would have been as possible. With that said, I'm happy to fill any developer gap you may have right now." },
        {"title": "Why though?", "subTitle": "Actions speak louder than words (or a revamped application) and I believe three weeks would give you the opportunity to experience me at my best, and begin to build trust again." },
        {"title": "", "subTitle": "If there is any potential interest, I have prepared a detailed Q&A section - and diary can be opened below." },
      ]
    }
  },
  methods: {
    toggleDiary() {
      this.showCalendar = !this.showCalendar;
    }
  }
}
</script>

<style scoped>

.v-list-item__title {
  font-size: 22px;
}
.v-list-item__subtitle {
  font-size: 18px;
}

html {
  overflow: hidden !important;
}

.v-card {
  display: flex !important;
  flex-direction: column;
}

.v-card__text {
  flex-grow: 1;
  overflow: auto;
}

</style>