import Vue from "vue";
import Router from "vue-router";

// Containers
import Full from "@/containers/Full";

// Views
import Dashboard from "@/views/Dashboard";


// Views - Pages
import Page404 from "@/views/pages/Page404";
import Page500 from "@/views/pages/Page500";
import Login from "@/views/pages/Login";
import Logout from "@/views/pages/Logout";

import ROE from "@/views/References/RequestOrderEntry";
import GRI from "@/views/References/GoodsReceipt";
import POS from "@/views/References/PosEntry";
import ZReading from "@/views/References/z-Reading";
import XReading from "@/views/References/x-Reading"
import UserAccount from "@/views/References/UserAccount"
import product from "@/views/References/Products"
import category from "@/views/References/Categories"

import store from "../store";
Vue.use(Router);

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
        {
          path: 'references',
          name: 'References',
          component: {
            render (c) { return c('router-view') }
          },

          children: [
            {
              path: 'product',
              name: 'Products',
              component: product,
              meta: {requiresAuth: true}
            },
            {
              path: 'category',
              name: 'Category',
              component: category,
              meta: {requiresAuth: true}
            },
            {
              path: 'requestorderentry',
              name: 'Request Order Entry',
              component: ROE,
              meta: {requiresAuth: true}
            },
            {
              path: 'goodsreceipt',
              name: 'Goods Receipt Input',
              component: GRI,
              meta: {requiresAuth: true}
            },
            {
              path: 'zreading',
              name: 'z-Reading',
              component: ZReading,
              meta: {requiresAuth: true}
            },
            {
              path: 'xreading',
              name: 'x-Reading',
              component: XReading,
              meta: {requiresAuth: true}
            },
            {
              path: 'user_account',
              name: 'User Account',
              component: UserAccount,
              meta: {requiresAuth: true}
            },
          ]},
      
      ]
    },
    {
      path: "/login",
      name: "Login",
      component: Login
    },
    {
      path: "/references/posentry",
      name: "POS Entry",
      component: POS
    },
    {
      path: "/logout",
      name: "Logout",
      component: Logout
    },
    {
      path: "*",
      name: "404",
      component: Page404
    },

  ]
});
export default router;
router.beforeEach((to, from, next) => {
  // check if the route requires authentication and user is not logged in
  if (
    to.matched.some(route => route.meta.requiresAuth) &&
    !store.state.isLoggedIn
  ) {
    // redirect to login page
    next({
      name: "Login"
    });
    return;
  }

  // if logged in redirect to dashboard
  if (to.path === "/login" && store.state.isLoggedIn) {
    next({
      name: from.name
    });
    return;
  }

  next();
});