import type { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/BlankLayout.vue'),
    children: [
      {
        path: '',
        redirect: '/login',
      },
      {
        path: 'login',
        component: () => import('pages/LoginPage.vue'),
      },
    ],
  },
  {
    path: '/orders',
    component: () => import('layouts/OrderLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        component: () => import('src/pages/Order/OrderPage.vue'),
      },
    ],
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
