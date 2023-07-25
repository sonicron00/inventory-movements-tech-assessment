<template>
  <div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Welcome</h4>
          </div>
          <b-container class="bv-example-row">
            <b-row>
              <b-col><img src="../assets/lomond.png" style="width:100%"></b-col>
              <b-col>
                <p>
                  Hello, welcome, and thank you for reaching this section.
                </p>
                <p>
                  If you've looked around a bit, (thank you again), maybe you've noticed some of the improvements (both cosmetic and functional) that I've build into my original assessment application:
                </p>
                <FeatureList></FeatureList>
              </b-col>
            </b-row>
          </b-container>
          <b-container class="bv-example-row">
            <b-row>
              <b-col>
                <p>All development has remained in the original repository, open source for review - just hit the GitHub logo: <a href="https://github.com/sonicron00/inventory-movements-tech-assessment"><img src="../assets/github-mark.svg" style="width:5%;"></a></p>
              </b-col>
            </b-row>
          </b-container>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import FeatureList from "./FeatureList.vue";
export default {
  name: "NewWelcome",
  components: {FeatureList}
}
</script>
