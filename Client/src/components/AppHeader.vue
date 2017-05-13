<template>
  <header id="header">
    <div class="container">
      <div id="desktop">
        <div class="four columns logo"><router-link to="/">Unicloud</router-link></div>
        <div class="three columns link" v-if="online"><router-link to="/profile">{{ lang.profile }}</router-link></div>
        <div class="three columns link" v-else><router-link to="/register">{{ lang.register }}</router-link></div>
        <div class="three columns link"><router-link to="/about">{{ lang.who_are_we }}</router-link></div>
        <div class="two columns link" v-if="online"><div class="logout" v-on:click="logout()">{{ lang.logout }}</div></router-link></div>
      </div>
      <div id="mobile" class="twelve columns link">
        <div class="logom"><router-link to="/">Unicloud</router-link></div>
        <div class="menum">
          <span v-if="online"><router-link to="/profile"><i class="fa fa-user" aria-hidden="true"></i></router-link></span>
          <span v-else><router-link to="/register"><i class="fa fa-user-plus" aria-hidden="true"></i></router-link></span>
          <span><router-link to="/about"><i class="fa fa-question-circle" aria-hidden="true"></i></router-link></span>
          <span v-if="online"><i v-on:click="logout()" class="fa fa-sign-out" aria-hidden="true"></i></router-link></span>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import config from '../locale/config';

const lang = config(window.lang);

export default {
  name: 'app-header',
  data() {
    return {
      lang,
      online: true,
    };
  },
  methods: {
    updateOnline(value) {
      this.$data.online = value;
    },
    logout() {
      window.apiToken = undefined;
      document.cookie = 'token=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
      document.location.href = '/';
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
    min-height: 100px;
    background-color: #091825;
  }

  .logo {
    font-family: 'Kaushan Script', cursive;
    font-size: 40px;
    margin-top: 15px;
  }

  .logom {
    font-family: 'Kaushan Script', cursive;
    font-size: 30px;
    float: left;
    margin-top: -10px;
    margin-right: 10px;
  }

  a {
    color: white;
    text-decoration: none;
    text-decoration: none;
    cursor: pointer;
  }

  i {
    margin-right: 30px;
    margin-bottom: 10px;
  }

  .link {
    margin-top: 35px;
  }

  #desktop .link a:hover {
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

  #mobile {
    display: none;
  }

  .menum {
    text-align: right;
  }

  @media (max-width: 730px) {
    #desktop {
      display: none;
    }

    #mobile {
      display: block;
    }

    header, #header {
      margin-bottom: -70px;
    }
  }
</style>
