<template>
  <div class="env">
    <app-header></app-header>
    <div id="content" class="container">
      <h3>{{ lang.registerTitle }}</h3>
      <div class="row">
        <spiner v-if="loading"></spiner>
        <div v-else>
          <transition name="custom-classes-transition" enter-active-class="animated slideInUp">
            <div v-bind:class="'six columns offset-by-three ' + errorType" v-if="error">
              {{ lang.registerError[errorCode] }}<br>
              <router-link to="/" class='connectLink' v-if="!displayForm">Connexion</router-link><br>
            </div>
          </transition>
          <div class="six columns offset-by-three" v-if="displayForm">
            <label for="mail">{{ lang.registerMail }}</label>
            <input class="u-full-width" placeholder="test@mailbox.com" id="mail" type="email" v-model="$data.mail" v-on:keyup.enter="register()">
            <label for="mail2">{{ lang.registerMail2 }}</label>
            <input class="u-full-width" placeholder="test@mailbox.com" id="mail2" type="email" v-model="$data.mail2" v-on:keyup.enter="register()">
            <label for="pass">{{ lang.registerPass }}</label>
            <input class="u-full-width" id="pass" type="password" v-model="$data.pass" v-on:keyup.enter="register()">
            <label for="pass2">{{ lang.registerPass2 }}</label>
            <input class="u-full-width" id="pass2" type="password" v-model="$data.pass2" v-on:keyup.enter="register()">
            <label for="lastName">{{ lang.registerLastName }}</label>
            <input class="u-full-width" placeholder="Doe" id="lastName" type="text" v-model="$data.lastName" v-on:keyup.enter="register()">
            <label for="firstName">{{ lang.registerFirstName }}</label>
            <input class="u-full-width" placeholder="John" id="firstName" type="text" v-model="$data.firstName" v-on:keyup.enter="register()">
            <label for="promo">{{ lang.registerPromo }}</label>
            <select class="u-full-width" id="promo" v-model="$data.promo" v-on:keyup.enter="register()">
              <template v-for="promo in promos">
                <option v-bind:value="promo.name">{{ promo.name }}</option>
              </template>
            </select>
            <label for="studentId">{{ lang.registerStudentId }}</label>
            <input class="u-full-width" placeholder="2014XXXX" id="studentId" type="text" v-model="$data.studentId" v-on:keyup.enter="register()">
            <button v-on:click="register()">{{ lang.registerSubmit }}</button>
          </div>
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
  name: 'register',
  components: {
    appHeader: AppHeader,
    spiner: Spiner,
  },
  data() {
    return {
      lang,
      error: false,
      errorCode: 0,
      errorType: 'error',
      displayForm: true,
      loading: true,
      promos: [],
    };
  },
  params: {
    mail: String,
    mail2: String,
    pass: String,
    pass2: String,
    lastName: String,
    firstName: String,
    promo: String,
    studentId: String,
  },
  methods: {
    register() {
      this.$data.loading = true;
      axios.post('/api/register', {
        mail: this.$data.mail,
        mail2: this.$data.mail2,
        pass: this.$data.pass,
        pass2: this.$data.pass2,
        lastName: this.$data.lastName,
        firstName: this.$data.firstName,
        promo: this.$data.promo,
        studentId: this.$data.studentId,
      })
      .then((response) => {
        this.$data.loading = false;
        this.$data.errorCode = response.data;
        if (response.data === 0) {
          this.$data.errorType = 'success';
          this.$data.displayForm = false;
        } else this.$data.errorType = 'error';
        this.$forceUpdate();
        window.scrollTo(0, 0);
        this.$data.error = true;
      });
    },
  },
  mounted() {
    this.$data.error = false;

    axios.get('/api/promos')
    .then((response) => {
      this.$data.loading = false;
      this.$data.promos = response.data;
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

  .success {
    color: green;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .connectLink {
    color: black;
  }

  .connectLink:hover {
    color: rgb(130, 130, 130);
  }
</style>
