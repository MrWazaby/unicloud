<template>
  <div class="env">
    <app-header></app-header>
    <div id="content" class="container">
      <div class="five columns subContent">
        <div class="five columns">
          <img class="u-max-full-width github" src="../assets/defaultAvatar.png"></a>
        </div>
        <div class="seven columns">
          {{ userInfo.firstName }} {{ userInfo.lastName }}<br>
          {{ userInfo.mail }}<br>
          ({{ userInfo.idUser }})<br>
          {{ userInfo.promo }}<br>
          <router-link to="/register">{{ lang.editProfile }}</router-link>
        </div>
      </div>
      <div class="seven columns subContent">
        <h3>{{ lang.stats }}</h3>
        <div class="stats">
          {{ lang.revisionsPrct }} ... %<br>
          {{ lang.quizzPrct }} ...%<br>
          {{ lang.quizzCreated }} ...%<br>
          {{ lang.methodCreated }} ...%<br>
          {{ lang.postsCreated }} ...%<br>
        </div>
        <h3>{{ lang.rewards }}</h3>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import AppHeader from './AppHeader';
import config from '../locale/config';
import langFr from '../locale/fr';
import langEn from '../locale/en';

let lang;
let langConf = config;

const userInfo = {};

if (langConf === 'en') lang = langEn;
if (langConf === 'fr') lang = langFr;

export default {
  name: 'profile',
  components: {
    appHeader: AppHeader,
  },
  data() {
    return {
      lang,
      userInfo,
    };
  },
  methods: {
    changeLang(choice) {
      langConf = choice;
    },
  },
  mounted() {
    axios.get('/api/profile', {
      params: {
        token: window.apiToken,
      },
    })
    .then((response) => {
      if (response.data.valid === false) {
        window.apiToken = undefined;
        this.$forceUpdate();
        this.$router.push('/');
      } else {
        this.$data.userInfo = response.data;
        this.$forceUpdate();
      }
    });
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .env {
    flex: 1;
  }

  .subContent {
    margin-top: 50px;
    border: 2px solid black;
    padding: 5px;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
  }

  h3 {
    font-size: 25px;
    text-align: center;
  }

  .stats {
    margin-left: 10px;
    margin-bottom: 10px;
  }
</style>
