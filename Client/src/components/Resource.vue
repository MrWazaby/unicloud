<template>
  <div class="env">
    <div id="content" class="container">
      <div class="twelve columns about">
        <h3>{{ data.sheets.title }}</h3>
        <router-link v-bind:to="'/hub/' + data.course.id"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ lang.back }}</router-link>
        <div class="markdown-body" v-html="data.sheets.content"></div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import snarkdown from 'snarkdown';
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
    axios.get('/api/sheetsquizzs', {
      params: {
        token: window.apiToken,
        id: this.$route.params.id,
      },
    })
    .then((response) => {
      if (response.data.valid === false) {
        window.apiToken = undefined;
        this.$forceUpdate();
        this.$router.push('/');
      } else {
        this.$data.data = response.data;
        this.$data.data.sheets.content = snarkdown(this.$data.data.sheets.content);
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

  .markdown-body {
    background-color: #ebebeb;
    padding: 45px;
    border: 1px solid black;
    margin-top: 20px;
  }

</style>
