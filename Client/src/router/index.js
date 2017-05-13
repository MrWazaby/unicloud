import Vue from 'vue';
import Router from 'vue-router';
import Home from '@/components/Home';
import Register from '@/components/Register';
import About from '@/components/About';
import Hub from '@/components/Hub';
import Profile from '@/components/Profile';
import EditProfile from '@/components/EditProfile';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home,
    },
    {
      path: '/register',
      name: 'Register',
      component: Register,
    },
    {
      path: '/about',
      name: 'About',
      component: About,
    },
    {
      path: '/hub',
      name: 'Hub',
      component: Hub,
    },
    {
      path: '/hub/:course',
      name: 'HubCourse',
      component: Hub,
    },
    {
      path: '/hub/:course/:id',
      name: 'HubResource',
      component: Hub,
    },
    {
      path: '/profile',
      name: 'Profile',
      component: Profile,
    },
    {
      path: '/profile/edit',
      name: 'EditProfile',
      component: EditProfile,
    },
    {
      path: '/profile/:id',
      name: 'OtherProfile',
      component: Profile,
    },
    {
      path: '/*',
      redirect: '/',
    },
  ],
});
