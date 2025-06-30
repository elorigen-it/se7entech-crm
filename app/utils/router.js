export class Router {
  constructor(routes) {
    this.routes = routes;
  }

  async resolveCurrentRoute() {
    const path = window.location.pathname;
    const matchingRoute = this.findMatchingRoute(path);

    if (matchingRoute) {
      const moduleLoader = this.routes[matchingRoute];
      const module = await moduleLoader();
      module.init(); // Ejecuta la lógica específica de la ruta
    } else {
      console.warn(`No se encontró controlador para: ${path}`);
      // Opcional: cargar un módulo 404
    }
  }

  findMatchingRoute(path) {
    return Object.keys(this.routes).find(route => {
      const routeRegex = new RegExp(
        `^${route.replace(/:\w+/g, '\\w+')}$`
      );
      return routeRegex.test(path);
    });
  }

  navigateTo(path) {
    window.history.pushState({}, '', path);
    this.resolveCurrentRoute();
  }
}