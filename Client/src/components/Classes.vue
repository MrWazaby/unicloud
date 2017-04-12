<template>
  <div class="env">
    <div id="content" class="container">
      <div class="eight columns about">
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

  .aboutRight {
    text-align: justify;
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
