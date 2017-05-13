<template>
  <div class="env">
    <div id="content" class="container">
      <div class="eight columns about">
        <spiner v-if="loading"></spiner>
        <div v-else>
          <h3>{{ data.course.name }}</h3>
          <router-link to="/hub/"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ lang.back }}</router-link>
          <span class="create"><router-link v-bind:to="'/hub/' + data.course.id + '/create'"><i class="fa fa-pencil" aria-hidden="true"></i> {{ lang.createSheet }}</router-link></span>
          <h4>{{ lang.sheets }}</h4>
          <div v-for="sheet in data.sheets">
            <span v-if="sheet.certified" >
              <span v-if="!sheet.quizz">
                <router-link v-bind:to="'/hub/' + data.course.id + '/' + sheet.id">{{ sheet.title }}</router-link> <i class="fa fa-check-circle" aria-hidden="true"></i><br>
              </span>
            </span>
          </div>
          <div v-for="sheet in data.sheets">
            <span v-if="!sheet.certified" >
              <span v-if="!sheet.quizz">
                <router-link v-bind:to="'/hub/' + data.course.id + '/' + sheet.id">{{ sheet.title }}</router-link><br>
              </span>
            </span>
          </div>
          <h4>{{ lang.quizzs }}</h4>
          <div v-for="sheet in data.sheets">
            <span v-if="sheet.certified" >
              <span v-if="sheet.quizz">
                <router-link v-bind:to="'/hub/' + data.course.id + '/' + sheet.id">{{ sheet.title }}</router-link> <i class="fa fa-check-circle" aria-hidden="true"></i><br>
              </span>
            </span>
          </div>
          <div v-for="sheet in data.sheets">
            <span v-if="!sheet.certified" >
              <span v-if="sheet.quizz">
                <router-link v-bind:to="'/hub/' + data.course.id + '/' + sheet.id">{{ sheet.title }}</router-link><br>
              </span>
            </span>
          </div>
        </div>
      </div>

      <news></news>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Spiner from './Spiner';
import News from './News';
import config from '../locale/config';

const lang = config(window.lang);

const data = {};
data.course = {};
data.sheets = {};

export default {
  name: 'classes',
  components: {
    spiner: Spiner,
    news: News,
  },
  data() {
    return {
      lang,
      data,
      show: {},
      loading: true,
    };
  },
  mounted() {
    axios.get('/api/courses', {
      params: {
        token: window.apiToken,
        id: this.$route.params.course,
      },
    })
    .then((response) => {
      this.$data.loading = false;
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

  a {
    color: black;
    text-decoration: none;
  }

  a:hover {
    color: rgb(65, 65, 65);
  }

  .create {
    float: right;
  }

  .fa-check-circle {
    color: rgb(83, 178, 255);
  }
</style>
