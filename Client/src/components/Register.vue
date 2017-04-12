<template>
  <div class="env">
    <app-header></app-header>
    <div id="content" class="container">
      <h3>{{ lang.registerTitle }}</h3>
      {{ lang.registerMessage }}
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
  name: 'register',
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
    text-align: center;
  }

  h3 {
    margin-top: 80px;
    font-size: 25px;
  }

  label {
    text-align: left;
  }
</style>
