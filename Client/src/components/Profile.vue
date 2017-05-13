<template>
  <div class="env">
    <app-header></app-header>
    <div id="content" class="container">
      <div class="five columns subContent">
        <spiner v-if="loading"></spiner>
        <div v-else>
          <div class="five columns">
            <img class="u-max-full-width github" v-bind:src="userInfo.avatar"></a>
          </div>
          <div class="seven columns">
            {{ userInfo.firstName }} {{ userInfo.lastName }}
            <span v-if="userInfo.certified"><i class="fa fa-check-circle" aria-hidden="true"></i></span><br>
            {{ userInfo.mail }}<br>
            ({{ userInfo.idUser }})<br>
            {{ userInfo.promo }}<br>
            <router-link to="/profile/edit" v-if='myProfile'>{{ lang.editProfile }}</router-link>
          </div>
        </div>
      </div>
      <div class="seven columns subContent">
        <spiner v-if="loading"></spiner>
        <div v-else>
          <h3>{{ lang.stats }}</h3>
          <div class="stats">
            {{ lang.revisionsPrct }} {{ userInfo.revisionsPrct }}<br>
            {{ lang.quizzPrct }} {{ userInfo.score }}<br>
            {{ lang.quizzCreated }} {{ userInfo.quizzCreated }}<br>
            {{ lang.methodCreated }} {{ userInfo.methodCreated }}<br>
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
      myProfile: true,
    };
  },
  methods: {
    getProfile() {
      if (this.$route.params.id === undefined) {
        axios.get('/api/profile', {
          params: {
            token: window.apiToken,
          },
        })
        .then((response) => {
          this.$data.loading = false;
          if (response.data.valid === false) {
            window.apiToken = undefined;
            this.$forceUpdate();
            this.$router.push('/');
          } else {
            this.$data.myProfile = true;
            this.$data.userInfo = response.data;
            if (this.$data.userInfo.avatar === '') {
              this.$data.userInfo.avatar = 'http://localhost:8000/avatars/defaultAvatar.png';
            } else {
              this.$data.userInfo.avatar = `http://localhost:8000/avatars/upload/${response.data.avatar}`;
            }
            this.$forceUpdate();
          }
        });
      } else {
        axios.get(`/api/profile/${this.$route.params.id}`, {
          params: {
            token: window.apiToken,
          },
        })
        .then((response) => {
          this.$data.loading = false;
          if (response.data.valid === false) {
            window.apiToken = undefined;
            this.$forceUpdate();
            this.$router.push('/');
          } else {
            this.$data.myProfile = false;
            this.$data.userInfo = response.data;
            if (response.data.avatar === '') {
              this.$data.userInfo.avatar = 'http://localhost:8000/avatars/defaultAvatar.png';
            } else {
              this.$data.userInfo.avatar = `http://localhost:8000/avatars/upload/${response.data.avatar}`;
            }
            this.$forceUpdate();
          }
        });
      }
    },
  },
  mounted() {
    this.getProfile();
  },
  updated() {
    this.getProfile();
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
    word-wrap: break-word;
    margin-bottom: 20px;
  }

  h3 {
    font-size: 25px;
    text-align: center;
  }

  .stats {
    margin-left: 10px;
    margin-bottom: 10px;
  }

  .fa-check-circle {
    color: rgb(83, 178, 255);
  }
</style>
