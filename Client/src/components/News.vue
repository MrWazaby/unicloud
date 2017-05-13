<template>
  <div class="four columns aboutRight">
    <div class="rightContainer">
      <h3>{{ lang.news }}</h3>
      <spiner v-if="loading"></spiner>
      <div v-else>
        {{ content }}
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Spiner from './Spiner';
import config from '../locale/config';

const lang = config(window.lang);

export default {
  name: 'classes',
  components: {
    spiner: Spiner,
  },
  data() {
    return {
      lang,
      loading: true,
      content: '',
    };
  },
  mounted() {
    axios.get('/api/news')
    .then((response) => {
      this.$data.loading = false;
      this.$data.content = response.data.content;
    });
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .rightContainer {
    margin-top: 80px;
    background-color: #bfbfbf;
    padding: 20px;
    margin-bottom: 20px;
  }

  .aboutRight {
    text-align: justify;
  }

  h3 {
    font-size: 25px;
    text-align: center;
  }
</style>
