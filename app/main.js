import { Router } from './utils/router.js';

// 1. Definir rutas y sus controladores
const routes = {
  '/': () => import('./routes/home.js'),
  '/modules/customer-portal/index.php/tasks': () => import('./routes/user-tasks.js'),
  '/modules/customers/index.php/:id/content-creator/generate': () => import('./routes/content-creator.js'),
  '/modules/customers/index.php/:id/brand-content/view/:id': () => import('./routes/view-brand-content.js'),
  '/modules/customers/index.php/:id/brand-content/edit/:id': () => import('./routes/edit-brand-content.js')  
};

// 2. Inicializar router
const router = new Router(routes);

// 3. Manejar carga inicial y cambios de URL
document.addEventListener('DOMContentLoaded', () => {
  router.resolveCurrentRoute();
});

window.addEventListener('popstate', () => {
  router.resolveCurrentRoute();
});