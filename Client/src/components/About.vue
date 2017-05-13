<template>
  <div class="env">
    <app-header></app-header>
    <div id="content" class="container">
      <div class="eight columns about">
        <h3>{{ lang.about }}</h3>
        <div v-html="lang.aboutContent"></div>
      </div>
      <div class="four columns aboutRight">
        <h3>{{ lang.aboutLinks }}</h3>
        <a href="https://github.com/MrWazaby/unicloud" target="_blank"><img class="u-max-full-width github" src="../assets/github.png"></a><br>
        <a href="http://groupe-efrei.fr" target="_blank"><img class="u-max-full-width efrei" src="../assets/efrei.png"></a>
      </div>
    </div>
  </div>
</template>

<script>
import AppHeader from './AppHeader';
import config from '../locale/config';

const lang = config(window.lang);

export default {
  name: 'about',
  components: {
    appHeader: AppHeader,
  },
  data() {
    return {
      lang,
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .env {
      flex: 1;
  }

  #content {
    text-align: justify;
  }

  h3 {
    margin-top: 80px;
    font-size: 25px;
    text-align: center;
  }

  .aboutRight {
    text-align: center;
  }

  .aboutRight .github {
    max-width: 100px;
  }

  .aboutRight .efrei {
    max-width: 200px;
    margin-top: 20px;
  }
</style>
