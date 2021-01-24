import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Dashboard from '@/views/Dashboard'
// import Charts from '@/views/Charts'
// import Widgets from '@/views/Widgets'

// Views - Components
// import Buttons from '@/views/components/Buttons'
// import SocialButtons from '@/views/components/SocialButtons'
// import Cards from '@/views/components/Cards'
// import Forms from '@/views/components/Forms'
// import Modals from '@/views/components/Modals'
// import Switches from '@/views/components/Switches'
// import Tables from '@/views/components/Tables'

// Views - Icons
// import FontAwesome from '@/views/icons/FontAwesome'
// import SimpleLineIcons from '@/views/icons/SimpleLineIcons'

// Views - Pages
import Page404 from '@/views/pages/Page404'
import Page500 from '@/views/pages/Page500'
import Login from '@/views/pages/Login'
import Logout from '@/views/pages/Logout'
import Register from '@/views/pages/Register'


//Views - Utilities
import users from '@/views/utilities/Users'


import store from '../store'
Vue.use(Router)

const router = new Router({
  mode: 'hash', // Demo is living in GitHub.io, so required!
  linkActiveClass: 'open active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      path: '/',
      redirect: 'dashboard',
      name: 'Home',
      component: Full,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard,
          meta: { requiresAuth: true },
        },
        // {
        //   path: 'charts',
        //   name: 'Charts',
        //   component: Charts
        // },
        {
          path: 'accounts',
          name: 'Accounts',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: 'users',
              name: 'Users',
              component: users,
              meta: {requiresAuth: true}
            },
          ]
        },
      ]
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/logout',
      name: 'Logout',
      component: Logout
    },
    {
      path: '*',
      name:'404', 
      component: Page404
    },
  ]
})
export default router
router.beforeEach((to, from, next) => {

  // check if the route requires authentication and user is not logged in
  if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
    // redirect to login page
    next({ name: 'Login' })
    return
  }

// if logged in redirect to dashboard
  if(to.path === '/login' && store.state.isLoggedIn) {
      next({name: from.name})
      return
  }

next()
})
