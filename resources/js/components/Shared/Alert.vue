<template>
  <b-alert
      :show="dismissCountDown"
      dismissible
      variant="warning"
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged"
  >
    <p>This alert will dismiss after {{ dismissCountDown }} seconds...</p>
    <b-progress
        variant="warning"
        :max="dismissSecs"
        :value="dismissCountDown"
        height="4px"
    ></b-progress>
  </b-alert>
</template>

<script>
export default {
  name: "Alert.vue",
  props: ["dismissCountDown"],
  data() {
    return {
      dismissSecs: 10,
    }
  },
  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
  }
}
</script>