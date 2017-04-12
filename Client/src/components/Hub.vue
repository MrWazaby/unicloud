<template>
  <div class="env">
    <app-header></app-header>
    <transition name="custom-classes-transition" enter-active-class="animated fadeIn">
      <classes v-if="showClasses"></classes>
      <courses v-if="showCourses"></courses>
      <resource v-if="showMethod"></resource>
    </transition>
  </div>
</template>

<script>
import AppHeader from './AppHeader';
import Classes from './Classes';
import Courses from './Courses';
import Resource from './Resource';

export default {
  name: 'hub',
  components: {
    appHeader: AppHeader,
    classes: Classes,
    courses: Courses,
    resource: Resource,
  },
  watch: {
    // call again the method if the route changes
    $route: 'fetchData',
  },
  data() {
    return {
      showClasses: true,
      showCourses: false,
      showMethod: false,
    };
  },
  methods: {
    fetchData() {
      if (this.$route.params.course !== undefined) {
        if (this.$route.params.id !== undefined) {
          this.$data.showClasses = false;
          this.$data.showMethod = true;
          this.$data.showCourses = false;
        } else {
          this.$data.showClasses = false;
          this.$data.showMethod = false;
          this.$data.showCourses = true;
        }
      } else {
        this.$data.showClasses = true;
        this.$data.showMethod = false;
        this.$data.showCourses = false;
      }
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .env {
      flex: 1;
  }
</style>
