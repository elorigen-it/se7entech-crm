const esbuild = require('esbuild');
// Importa el plugin de CSS Modules
const cssModulesPlugin = require('esbuild-css-modules-plugin');

const plugins = [{
  name: 'my-plugin',
  setup(build) {
    let buildCount = 0;
    build.onEnd(result => {
      const time = new Date().toLocaleTimeString();
      if (buildCount++ === 0) {
        console.log(`[${time}] 🏗️ Primer build completado`);
      } else {
        console.log(`[${time}] 🔄 Rebuild #${buildCount}`);
        if (result.errors.length) {
          console.error('Errores:', result.errors);
        }
        if (result.warnings.length) {
          console.warn('Advertencias:', result.warnings);
        }
      }
    });
  },
}, cssModulesPlugin()];
const isProduction = process.env.ENVIRONMENT === 'production';

const config = {
  entryPoints: ['app/main.js'],
  bundle: true,
  loader: { '.js': 'jsx' },
  outfile: 'build/app-bundle.js',
  sourcemap: true,
  plugins
};

if (isProduction) {
  esbuild.build(config)
    .then(() => {
      console.log('✨ Build de producción completado con éxito');
    })
    .catch((err) => {
      console.error('❌ Error en el build de producción:', err);
      process.exit(1);
    });
} else {
  esbuild.context(config).then( async ctx => {
    await ctx.watch().then(() => {
      console.log('🔄 Watch iniciado');
    }).catch(console.error);  
  }).catch(console.error);
}