<template>
  <div class="env">
    <div id="content" class="container">
      <div class="eight columns about">
        <spiner v-if="loading"></spiner>
        <div v-else>
          <h3>{{ lang.classes }}</h3>
          <div v-for="(classe, index) in data.classes">

            <div class="course" v-on:click="showCourses(classe.id, index)"><span class="dot">{{ classe.showSymb }} </span> {{ classe.name }}</div>
            <transition name="custom-classes-transition" enter-active-class="animated fadeIn">
              <div class="classes" v-if="show[classe.id]">
                <div v-for="course in data.courses[classe.id]">
                  <router-link v-bind:to="'/hub/' + course.id">{{ course.name }}</router-link><br>
                </div>
              </div>
            </transition>

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

const data = {};

const lang = config(window.lang);

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
  methods: {
    showCourses(id, index) {
      this.$data.show[id] = !this.$data.show[id];
      if (this.$data.data.classes[index].showSymb === '+') this.$data.data.classes[index].showSymb = '-';
      else this.$data.data.classes[index].showSymb = '+';
      this.$forceUpdate();
    },
  },
  mounted() {
    axios.get('/api/classes', {
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
        this.$data.data = response.data;
        this.$data.data.classes.forEach((e) => {
          e.showSymb = '+';
        });
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

  .rightContainer {
    margin-top: 80px;
    background-color: #599494;
    padding: 20px;
  }

  .course {
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 5px;
  }

  .course:hover {
    color: rgb(65, 65, 65);
  }

  .classes {
    margin-left: 20px;
  }

  .dot {
    color: #599494;
    font-size: 20px;
  }

  a {
    color: black;
    text-decoration: none;
  }

  a:hover {
    color: rgb(65, 65, 65);
  }
</style>
