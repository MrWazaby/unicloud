<template>
  <footer id="footer">
    <div class="container">
      &copy 2017 - Unicloud<br>
      <a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a> <a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
    </div>
  </footer>
</template>

<script>
import config from '../locale/config';
import langFr from '../locale/fr';
import langEn from '../locale/en';

let lang;
let langConf = config;

if (langConf === 'en') lang = langEn;
if (langConf === 'fr') lang = langFr;

export default {
  name: 'footer',
  data() {
    return {
      lang,
    };
  },
  methods: {
    changeLang(choice) {
      langConf = choice;
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  footer, #footer {
    color: black;
    height: 60px;
    background-color: #599494;
    text-align: center;
    padding-top: 20px;
  }

  a {
    color: black;
    font-size: 20px;
    margin-left: 5px;
    margin-right: 5px;
  }
</style>
