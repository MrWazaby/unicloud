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
        <a href="https://github.com/MrWazaby/unicloud"><img class="u-max-full-width github" src="../assets/github.png"></a><br>
        <a href="http://groupe-efrei.fr"><img class="u-max-full-width efrei" src="../assets/efrei.png"></a>
      </div>
    </div>
  </div>
</template>

<script>
import AppHeader from './AppHeader';
import config from '../locale/config';
import langFr from '../locale/fr';
import langEn from '../locale/en';

let lang;
let langConf = config;

if (langConf === 'en') lang = langEn;
if (langConf === 'fr') lang = langFr;

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
  methods: {
    changeLang(choice) {
      langConf = choice;
    },
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
