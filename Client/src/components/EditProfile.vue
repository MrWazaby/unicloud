<template>
  <div class="env">
    <app-header></app-header>
    <div id="content" class="container">
      <spiner v-if="loading"></spiner>
      <div v-else>
        <h3>Modifier votre profil</h3>
        <router-link to="/profile"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ lang.back }}</router-link><br>
        <transition name="custom-classes-transition" enter-active-class="animated slideInUp">
          <div v-bind:class="'six columns offset-by-three ' + errorType" v-if="error">
            {{ lang.registerError[errorCode] }}<br>
          </div>
        </transition>
        <div class="six columns offset-by-three">
          <h4>{{ lang.editPassword }}</h4>
          <label for="oldpass">{{ lang.registerOldPass }}</label>
          <input class="u-full-width" id="oldpass" type="password" v-model="$data.oldpass">
          <label for="pass">{{ lang.registerPass }}</label>
          <input class="u-full-width" id="pass" type="password" v-model="$data.pass">
          <label for="pass2">{{ lang.registerPass2 }}</label>
          <input class="u-full-width" id="pass2" type="password" v-model="$data.pass2">
          <button v-on:click="updatePass()">{{ lang.editPasswordButton}}</button>
        </div>
        <div class="six columns offset-by-three separator">
          <h4>{{ lang.editData }}</h4>
          <label for="lastName">{{ lang.registerLastName }}</label>
          <input class="u-full-width" placeholder="Doe" id="lastName" type="text" v-model="userInfo.lastName">
          <label for="firstName">{{ lang.registerFirstName }}</label>
          <input class="u-full-width" placeholder="John" id="firstName" type="text" v-model="userInfo.firstName">
          <label for="promo">{{ lang.registerPromo }}</label>
          <select class="u-full-width" id="promo" v-model="userInfo.promo" v-on:keyup.enter="register()">
            <template v-for="promo in promos">
              <option v-bind:value="promo.name">{{ promo.name }}</option>
            </template>
          </select>
          <label for="studentId">{{ lang.registerStudentId }}</label>
          <input class="u-full-width" placeholder="2014XXXX" id="studentId" type="text" v-model="userInfo.idUser">
          <button v-on:click="updateData()">{{ lang.editDataButton }}</button>
        </div>
        <div class="six columns offset-by-three separator">
          <h4>{{ lang.editAvatar }}</h4>
          <label for="avatar">{{ lang.avatar }} (max 600*600, 1Mo)</label>
          <input type="file" name="avatar" id="avatar" v-on:change="updateAvatar($event)">
          <br><br>
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

const userInfo = {};

const lang = config(window.lang);

export default {
  name: 'profile',
  components: {
    appHeader: AppHeader,
    spiner: Spiner,
  },
  data() {
    return {
      lang,
      userInfo,
      loading: true,
      error: false,
      errorCode: 0,
      errorType: 'error',
      promos: [],
    };
  },
  params: {
    pass: String,
    pass2: String,
    oldpass: String,
  },
  methods: {
    updatePass() {
      this.$data.loading = true;
      axios.patch('/api/register/0', {
        action: 'pass',
        token: window.apiToken,
        oldpass: this.$data.oldpass,
        pass: this.$data.pass,
        pass2: this.$data.pass2,
      })
      .then((response) => {
        this.$data.loading = false;
        this.$data.errorCode = response.data;
        if (response.data === 7) {
          this.$data.errorType = 'success';
          this.$data.pass = '';
          this.$data.pass2 = '';
          this.$data.oldpass = '';
        } else this.$data.errorType = 'error';
        this.$forceUpdate();
        window.scrollTo(0, 0);
        this.$data.error = true;
      });
    },
    updateData() {
      this.$data.loading = true;
      axios.patch('/api/register/0', {
        action: 'data',
        token: window.apiToken,
        lastName: this.$data.userInfo.lastName,
        firstName: this.$data.userInfo.firstName,
        promo: this.$data.userInfo.promo,
        studentId: this.$data.userInfo.idUser,
      })
      .then((response) => {
        this.$data.loading = false;
        this.$data.errorCode = response.data;
        if (response.data === 8) {
          this.$data.errorType = 'success';
        } else this.$data.errorType = 'error';
        this.$forceUpdate();
        window.scrollTo(0, 0);
        this.$data.error = true;
      });
    },
    updateAvatar(event) {
      this.$data.loading = true;
      const data = new FormData();
      data.append('token', window.apiToken);
      data.append('_method', 'PATCH');
      data.append('action', 'avatar');
      data.append('avatar', event.target.files[0]);
      axios.post('/api/register/0', data).then((response) => {
        this.$data.loading = false;
        this.$data.errorCode = response.data;
        if (response.data === 9) {
          this.$data.errorType = 'success';
        } else this.$data.errorType = 'error';
        this.$forceUpdate();
        window.scrollTo(0, 0);
        this.$data.error = true;
      });
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

      axios.get('/api/promos')
      .then((response2) => {
        this.$data.loading = false;
        this.$data.promos = response2.data;
      });
    });
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .env {
    flex: 1;
  }

  #content {
      margin-top: 20px;
  }

  .error {
    color: red;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
  }

  .success {
    color: green;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
  }

  .separator {
    border-top: 1px solid black;
    margin-top: 20px;
    padding-top: 15px;
  }

  h3 {
    font-size: 25px;
    text-align: center;
  }

  h4 {
    font-size: 20px;
    text-align: center;
  }

  .about {
    margin-top: 80px;
  }

  a {
    color: black;
    text-decoration: none;
  }

  a:hover {
    color: rgb(65, 65, 65);
  }
</style>
