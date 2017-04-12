<template>
  <header id="header">
    <div class="container">
      <div class="four columns logo"><router-link to="/">Unicloud</a></router-link></div>
      <div class="three columns link" v-if="online"><router-link to="/profile">{{ lang.profile }}</router-link></div>
      <div class="three columns link" v-else><router-link to="/register">{{ lang.register }}</router-link></div>
      <div class="three columns link"><router-link to="/about">{{ lang.who_are_we }}</router-link></div>
      <div class="two columns link" v-if="online"><div class="logout" v-on:click="logout()">{{ lang.logout }}</div></router-link></div>
    </div>
  </header>
</template>

<script>
import config from '../locale/config';
import langFr from '../locale/fr';
import langEn from '../locale/en';

let lang;
let langConf = config;

if (langConf === 'en') lang = langEn;
if (langConf === 'fr') lang = langFr;

export default {
  name: 'app-header',
  data() {
    return {
      lang,
      online: true,
    };
  },
  methods: {
    changeLang(choice) {
      langConf = choice;
    },
    updateOnline(value) {
      this.$data.online = value;
    },
    logout() {
      window.apiToken = undefined;
      this.$forceUpdate();
      this.$router.push('/');
    },
  },
  mounted() {
    if (window.apiToken === undefined) this.$data.online = false;
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  header, #header {
    color: white;
    font-size: 18px;
    height: 100px;
    background-color: #091825;
  }

  .logo {
    font-family: 'Kaushan Script', cursive;
    font-size: 40px;
    margin-top: 15px;
    margin-top:
  }

  a {
    color: white;
    text-decoration: none;
    text-decoration: none;
    cursor: pointer;
  }

  .link {
    margin-top: 35px;
  }

  .link a:hover {
    border-bottom: 1px white solid;
  }

  .logout {
    margin-top: 5px;
    font-size: 13px;
    cursor: pointer;
  }

  .logout:hover {
    text-decoration: underline;
  }
</style>
