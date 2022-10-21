import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import AdvancedSearch from './pages/AdvancedSearch.vue';
import SingleProfile from './pages/SingleProfile.vue';
import HomePage from './pages/HomePage.vue';

//routing
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'homepage',
            component: HomePage
        },
        {
            path: '/advanced-search/:specialization_slug',
            name: 'advanced-search',
            component: AdvancedSearch
        },
        {
            path: '/single-profile/:user_slug',
            name: 'single-profile',
            component: SingleProfile
        }
    ]
});

export default router;