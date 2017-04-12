<template>
  <div class="env">
    <app-header></app-header>
    <div id="content" class="container">
      <h3>{{ lang.loginTitle }}</h3>
      <transition name="custom-classes-transition" enter-active-class="animated slideInUp">
        <div class="six columns offset-by-three error" v-if="error">
          {{ lang.loginError }}
        </div>
      </transition>
      <div class="six columns offset-by-three">
        <input type="hidden" name="_token" id="csrf-token" v-bind:value="$data.csrfToken" />
        <label for="login">{{ lang.login }}</label>
        <input class="u-full-width" placeholder="test@mailbox.com" id="login" type="email" v-model="$data.log" v-on:keyup.enter="login()"><br>
        <label for="password">{{ lang.password }}</label>
        <input class="u-full-width" id="password" type="password" v-model="$data.password" v-on:keyup.enter="login()"><br>
        <br>
        <button v-on:click="login()">{{ lang.connect }}</button>
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

if (langConf === 'en') lang = langEn;
if (langConf === 'fr') lang = langFr;

export default {
  name: 'home',
  components: {
    appHeader: AppHeader,
  },
  data() {
    return {
      lang,
      error: false,
    };
  },
  props: {
    log: String,
    password: String,
  },
  methods: {
    changeLang(choice) {
      langConf = choice;
    },
    login() {
      axios.post('/api/login', {
        login: this.$data.log,
        password: this.$data.password,
      })
      .then((response) => {
        if (response.data.valid) {
          window.apiToken = response.data.token;
          this.$router.push('/hub');
        } else this.$data.error = true;
      });
    },
  },
  mounted() {
    this.$data.error = false;
    axios.get('/api/token')
    .then((response) => {
      this.$data.csrfToken = response.data;
    });

    if (window.apiToken !== undefined) this.$router.push('/hub');
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

  .error {
    color: red;
    font-weight: bold;
    margin-bottom: 20px;
  }
</style>
