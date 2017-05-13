<template>
  <div class="env">
    <app-header></app-header>
    <div id="content" class="container">
      <h3>{{ lang.loginTitle }}</h3>
      <spiner v-if="loading"></spiner>
      <div v-else>
        <transition name="custom-classes-transition" enter-active-class="animated slideInUp">
          <div class="six columns offset-by-three error" v-if="error">
            {{ lang.loginError }}
          </div>
        </transition>
        <div class="six columns offset-by-three">
          <label for="login">{{ lang.login }}</label>
          <input class="u-full-width" placeholder="test@mailbox.com" id="login" type="email" v-model="$data.log" v-on:keyup.enter="login()"><br>
          <label for="password">{{ lang.password }}</label>
          <input class="u-full-width" id="password" type="password" v-model="$data.password" v-on:keyup.enter="login()"><br>
          <br>
          <button v-on:click="login()">{{ lang.connect }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import AppHeader from './AppHeader';
import Spiner from './Spiner';
import config from '../locale/config';

const lang = config(window.lang);

export default {
  name: 'home',
  components: {
    appHeader: AppHeader,
    spiner: Spiner,
  },
  data() {
    return {
      lang,
      error: false,
      loading: true,
    };
  },
  props: {
    log: String,
    password: String,
  },
  methods: {
    getCookieToken() {
      const value = `; ${document.cookie}`;
      const parts = value.split('; token=');
      if (parts.length === 2) return parts.pop().split(';').shift();
      return undefined;
    },
    login() {
      this.$data.loading = true;
      axios.post('/api/login', {
        login: this.$data.log,
        password: this.$data.password,
      })
      .then((response) => {
        const d = new Date();
        this.$data.loading = false;
        if (response.data.valid) {
          window.apiToken = response.data.token;
          d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
          document.cookie = `token=${response.data.token};expires=${d.toUTCString()};path=/`;
          this.$router.push('/hub');
        } else this.$data.error = true;
      });
    },
  },
  mounted() {
    this.$data.error = false;
    axios.get('/api/token')
    .then((response) => {
      this.loading = false;
      this.$data.csrfToken = response.data;
    });

    if (this.getCookieToken() !== undefined) {
      window.apiToken = this.getCookieToken();
      axios.get('/api/profile', {
        params: {
          token: window.apiToken,
        },
      })
      .then((response) => {
        this.$data.loading = false;
        if (response.data.valid === false) {
          window.apiToken = undefined;
          document.cookie = 'token=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
          this.$forceUpdate();
        }
      });
    }
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
