<template>
  <footer id="footer">
    <div class="container">
      &copy 2017 - Unicloud<br>
      <a href="https://www.facebook.com/uniCloud.pjt/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a> <a href="https://twitter.com/Unicloud_corn" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
    </div>
  </footer>
</template>

<script>
import config from '../locale/config';

const lang = config(window.lang);

export default {
  name: 'footer',
  data() {
    return {
      lang,
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  footer, #footer {
    color: black;
    height: 60px;
    background-color: #bfbfbf;
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
