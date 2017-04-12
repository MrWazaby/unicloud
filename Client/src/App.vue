<template>
    <div id="app">
      <router-view></router-view>
      <app-footer></app-footer>
    </div>
</template>

<script>
import AppFooter from './components/AppFooter';

export default {
  name: 'app',
  components: {
    appFooter: AppFooter,
  },
};
</script>

<style>
  body {
    background-color: #e7e6e3;
  }

  a {
     outline: none;
  }

  #app {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
  }
</style>
