<template>
  <div class="env">
    <app-header></app-header>
    <transition name="custom-classes-transition" enter-active-class="animated fadeIn">
      <classes v-if="showClasses"></classes>
      <courses v-if="showCourses"></courses>
      <resource v-if="showMethod"></resource>
      <create v-if="showCreate"></create>
    </transition>
  </div>
</template>

<script>
import AppHeader from './AppHeader';
import Classes from './Classes';
import Courses from './Courses';
import Resource from './Resource';
import Create from './Create';

export default {
  name: 'hub',
  components: {
    appHeader: AppHeader,
    classes: Classes,
    courses: Courses,
    resource: Resource,
    create: Create,
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
      showCreate: false,
    };
  },
  methods: {
    fetchData() {
      if (this.$route.params.course !== undefined) {
        if (this.$route.params.id !== undefined) {
          if (this.$route.params.id === 'create') {
            this.$data.showClasses = false;
            this.$data.showMethod = false;
            this.$data.showCourses = false;
            this.$data.showCreate = true;
          } else {
            this.$data.showClasses = false;
            this.$data.showMethod = true;
            this.$data.showCourses = false;
            this.$data.showCreate = false;
          }
        } else {
          this.$data.showClasses = false;
          this.$data.showMethod = false;
          this.$data.showCourses = true;
          this.$data.showCreate = false;
        }
      } else {
        this.$data.showClasses = true;
        this.$data.showMethod = false;
        this.$data.showCourses = false;
        this.$data.showCreate = false;
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
