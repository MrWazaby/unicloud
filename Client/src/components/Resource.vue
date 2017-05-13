<template>
  <div class="env">
    <div id="content" class="container">
      <div class="twelve columns about">
        <spiner v-if="loading"></spiner>
        <div v-else>
          <h3>{{ data.sheets.title }}</h3>
          <router-link v-bind:to="'/hub/' + data.course.id"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ lang.back }}</router-link><br>
          <router-link v-bind:to="'/profile/' + data.sheets.author"> {{ lang.author }}</router-link><br>
          <div class="markdown-body" v-html="data.sheets.content"></div><br>
          <br>
          <div v-if="data.sheets.quizz">
            <h3>{{ lang.startQuizz }}</h3>
            <strong>{{ lang.quizzScore }}</strong> {{score}}/{{total}}<br>
            <span v-if="score == total">{{ lang.quizzValid }}</span><br><br>
            <div v-for="(question, index) in data.questions">
              <strong>{{ question }}</strong><br>
              <div v-for="answer in data.answers[index]">
                <label><input type="radio" v-bind:name="index" v-bind:value="answer" v-model="answers[index]"> {{ answer }}</label><br>
              </div>
              <br>
            </div>
            <button v-on:click="sendQuizz()">{{ lang.submitQuizz }}</button><br>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import snarkdown from 'snarkdown';
import Spiner from './Spiner';
import config from '../locale/config';

const lang = config(window.lang);

const data = {};
data.course = {};
data.sheets = {};

export default {
  name: 'classes',
  components: {
    spiner: Spiner,
  },
  data() {
    return {
      lang,
      data,
      show: {},
      loading: true,
      answers: {},
      score: 0,
      total: 0,
    };
  },
  mounted() {
    axios.get('/api/sheetsquizzs', {
      params: {
        token: window.apiToken,
        id: this.$route.params.id,
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
        if (response.data.questions) this.$data.total = Object.keys(response.data.questions).length;
        this.$data.data.sheets.content = snarkdown(this.$data.data.sheets.content);
        this.$forceUpdate();
      }
    });
  },
  methods: {
    sendQuizz() {
      this.$data.loading = true;
      axios.patch(`/api/sheetsquizzs/${this.$route.params.id}`, {
        token: window.apiToken,
        answers: this.$data.answers,
      })
      .then((response) => {
        this.$data.loading = false;
        this.$data.score = response.data;
      });
    },
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

  label {
    margin: 0;
    display: inline;
  }
</style>
