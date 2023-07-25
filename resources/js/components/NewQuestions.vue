<template>
  <div class="accordion" role="tablist">

    <div>
      <b-card no-body class="mb-1" v-for="question in questions"
              v-bind:key="question.answer">
        <b-card-header header-tag="header" class="p-1" role="tab">
          <b-button block v-b-toggle="'accordion-' + question.id" variant="outline-primary">{{  question.question }}</b-button>
        </b-card-header>
        <b-collapse :id="'accordion-' + question.id" accordion="my-accordion" role="tabpanel">
          <b-card-body>
            <b-card-text>{{ question.answer }}</b-card-text>
          </b-card-body>
        </b-collapse>
      </b-card>
    </div>
  </div>

</template>

<script>
export default {
  name: "NewQuestions",
  data() {
    return {
      questions: []
    }
  },
  mounted() {
    this.getQuestions()
  },
  methods: {
    async getQuestions() {
      await this.axios.get('/api/questions').then(response => {
        this.questions = response.data
      }).catch(error => {
        console.log(error)
      })
    },
  }
}
</script>

<style scoped>

.btn-info {
  color: #fff;
  background-color: #17a2b8;
  border-color: #17a2b8;
}

</style>
