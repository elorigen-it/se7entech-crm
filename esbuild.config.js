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
esbuild.context({
  entryPoints: ['app/main.js'],
  bundle: true,
  loader: { '.js': 'jsx' },
  outfile: 'build/app-bundle.js',
  sourcemap: true,
  plugins
}).then( async ctx => {
  await ctx.watch().then(() => {
    console.log('🔄 Watch iniciado');
  }).catch(console.error);  
}).catch(console.error);