<template>
  <div class="env">
    <div id="content" class="container">
      <div class="eight columns about">
        <h3>{{ data.course.name }}</h3>
        <router-link to="/hub/"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ lang.back }}</router-link>
        <h4>{{ lang.sheets }}</h4>
        <div v-for="sheet in data.sheets">
            <router-link v-bind:to="'/hub/' + data.course.id + '/' + sheet.id">{{ sheet.title }}</router-link><br>
        </div>
        <h4>{{ lang.quizzs }}</h4>
        {{ lang.errorQuizzs }}
      </div>

      <div class="four columns aboutRight">
        <div class="rightContainer">
          <h3>{{ lang.news }}</h3>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import config from '../locale/config';
import langFr from '../locale/fr';
import langEn from '../locale/en';

let lang;
let langConf = config;

const data = {};
data.course = {};
data.sheets = {};

if (langConf === 'en') lang = langEn;
if (langConf === 'fr') lang = langFr;

export default {
  name: 'classes',
  data() {
    return {
      lang,
      data,
      show: {},
    };
  },
  methods: {
    changeLang(choice) {
      langConf = choice;
    },
  },
  mounted() {
    axios.get('/api/courses', {
      params: {
        token: window.apiToken,
        id: this.$route.params.course,
      },
    })
    .then((response) => {
      if (response.data.valid === false) {
        window.apiToken = undefined;
        this.$forceUpdate();
        this.$router.push('/');
      } else {
        this.$data.data = response.data;
        this.$forceUpdate();
      }
    });
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  h3 {
    font-size: 25px;
    text-align: center;
  }

  h4 {
    font-size: 20px;
    margin-top: 20px;
  }

  .about {
    margin-top: 80px;
  }

  .aboutRight {
    text-align: justify;
  }

  .rightContainer {
    margin-top: 80px;
    background-color: #599494;
    padding: 20px;
  }

  a {
    color: black;
    text-decoration: none;
  }

  a:hover {
    color: rgb(65, 65, 65);
  }
</style>
