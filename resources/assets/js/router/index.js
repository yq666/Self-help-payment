import Vue from 'vue'
import Router from 'vue-router'
import footer from '../components/footer.vue'
import box from '../components/box.vue'
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'login',
      component: require('../page/login.vue'),
    },
    {
        path: '/article/:id',
        name: 'article',
        component: require('../page/article.vue'),
    },
    {
      path: '/footer',
      name: 'footer',
      component: footer,
      children: [
        {
          path: '/home',
          name: 'home',
          component: require('../page/home.vue'),
          children: []
        },
        {
          path: '/service',
          name: 'service',
          component: require('../page/service.vue'),
        },
        {
          path: '/notice',
          name: 'notice',
          component: require('../page/notice.vue'),
        },
        {
          path: '/personal',
          name: 'personal',
          component: require('../page/personal.vue'),
        }
      ]
    },
    {
        path: '/box',
        name: 'box',
        component: box,
        children: [
            {
                path: '/pay',
                name: 'pay',
                component: require('../servepages/pay.vue'),
            }
        ]
    },
  ]
})
