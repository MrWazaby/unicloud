<template>
  <div class="env">
    <div id="content" class="container">
      <div class="eight columns about">
        <spiner v-if="loading"></spiner>
        <div v-else>
          <h3>{{ data.course.name }}</h3>
          <router-link v-bind:to="'/hub/' + data.course.id"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> {{ lang.back }}</router-link><br>
          <br>
          <transition name="custom-classes-transition" enter-active-class="animated slideInUp">
            <div class="error" v-if="error">
              {{ lang.createError }}
            </div>
          </transition>
          <input type="hidden" name="_token" id="csrf-token" v-bind:value="$data.csrfToken" />
          <label for="title">{{ lang.sheetTitle }}</label>
          <input class="u-full-width" id="title" type="text" v-model="$data.title"><br>
          <label for="content">{{ lang.sheetContent }}</label>
          <textarea name="content" id="content" v-model="$data.content"></textarea><br>
          <a href="https://www.markdownguide.org/basic-syntax" target="_blank">{{ lang.helpMD }}</a><br>
          <br>
          <label><input type="checkbox" v-model="isQuizz"> {{ lang.isQuizz }}</label><br>
          <div v-if="isQuizz">
            <label for="score">{{ lang.createScore }}</label>
            <input class="u-full-width" id="score" type="text" v-model="$data.score"><br>
            <div v-for="(question, index) in questionsForm">
              <hr>
              <label>{{ lang.question }} #{{ index + 1 }}</label>
              <input class="u-full-width" type="text" v-model="questions[index]"><br>
              <label>{{ lang.goodAnswer }}</label>
              <input class="u-full-width" type="text" v-model="goodAnswer[index]"><br>
              <label for="content">{{ lang.badAnswers }}</label>
              <textarea name="content" class="u-full-width" v-model="badAnswers[index]"></textarea><br>
            </div>
            <span class="addQuestion" v-on:click="addQuestion()"><i class="fa fa-plus" aria-hidden="true"></i> {{ lang.addQuestion }}</span><br>
            <br>
          </div>
          <button v-on:click="postSheet()">{{ lang.createThisSheet }}</button><br>
          <br>
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
      error: false,
      isQuizz: false,
      questionsForm: [],
      questions: [],
      goodAnswer: [],
      badAnswers: [],
      score: 0,
    };
  },
  params: {
    title: String,
    content: String,
  },
  methods: {
    postSheet() {
      this.$data.loading = true;
      axios.post('/api/sheetsquizzs', {
        token: window.apiToken,
        id_course: this.$route.params.course,
        title: this.$data.title,
        content: this.$data.content,
        isQuizz: this.$data.isQuizz,
        questions: this.$data.questions,
        goodAnswer: this.$data.goodAnswer,
        badAnswers: this.$data.badAnswers,
        score: this.$data.score,
      })
      .then((response) => {
        this.$data.loading = false;
        if (response.data === 0) this.$data.error = true;
        else {
          this.$router.push(`/hub/${this.$data.data.course.id}/${response.data}`);
        }
      });
    },
    addQuestion() {
      this.$data.questionsForm.push('');
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

  a, .addQuestion {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  a:hover, .addQuestion:hover {
    color: rgb(65, 65, 65);
  }

  textarea {
    width: 100%;
    height: 200px;
  }

  .error {
    color: red;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: left;
  }
</style>
