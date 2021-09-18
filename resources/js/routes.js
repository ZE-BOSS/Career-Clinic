import login from './views/Admin/site/login.vue';
import register from './views/Admin/site/register.vue';
import dashboard from './views/Admin/admin/dashboard.vue';
import post from './views/Admin/post/index.vue';
import user_login from './views/User/site/login.vue';
import user_register from './views/User/site/register.vue';
import create_user_post from './views/User/post/create.vue';
import user_post from './views/User/post/index.vue';
import create_post from './views/Admin/post/create.vue';
import user from './views/Admin/user/index.vue';
import create_user from './views/Admin/user/create.vue';
import admin from './views/Admin/admin/index.vue';
import create_admin from './views/Admin/admin/create.vue';

export default {
    mode: "history",
    base: "/career-clinic/",
    fallback: true,
    
    routes: [
      {
        name: 'user_post',
        path: '/',
        component: user_post 
      },
      {
        name: 'create_user_post',
        path: '/create_post',
        component: create_user_post
      },
      {
        name: 'user_login',
        path: '/login',
        component: user_login
      },
      {
          name: 'user_register',
          path: '/register',
          component: user_register
      },
      {
          name: 'post',
          path: '/main_controller_panel/post',
          component: post,
          meta: { requiresAuth: true }
      },
      {
        name: 'create_post',
        path: '/main_controller_panel/create_post',
        component: create_post,
        meta: { requiresAuth: true }
      },
      {
          name: 'dashboard',
          path: '/main_controller_panel/',
          component: dashboard,
          meta: { requiresAuth: true }
      },
      {
          name: 'login',
          path: '/main_controller_panel/login',
          component: login,
          meta: { guest: true }
      },
      {
          name: 'sec_reg',
          path: '/main_controller_panel/sec_reg',
          component: register,
          meta: { guest: true }
      },
      {
          name: 'user',
          path: '/main_controller_panel/user',
          component: user,
          meta: { requiresAuth: true }
      },
      {
        name: 'create_user',
        path: '/main_controller_panel/create_user',
        component: create_user,
        meta: { requiresAuth: true }
      },
      {
          name: 'admin',
          path: '/main_controller_panel/admin',
          component: admin,
          meta: { requiresAuth: true }
      },
      {
        name: 'create_admin',
        path: '/main_controller_panel/create_admin',
        component: create_admin,
        meta: { requiresAuth: true }
      },
  ]
}