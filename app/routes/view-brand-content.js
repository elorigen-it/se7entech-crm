import Editor from '@toast-ui/editor';
import '@toast-ui/editor/dist/toastui-editor.css';

export function init() {
    // Lógica exclusiva para la página de inicio
    console.log('Cargado: Página de de brand content view');
    // Es la vista de resultados o listado
    const container = document.getElementById("brand_content")
    if (container) {
        const editor = new Editor({
            el: container,
            height: '500px',
            initialEditType: 'wysiwyg',
            previewStyle: 'vertical',
            usageStatistics: false,
            customHTMLSanitizer: html => html, // Desactiva el escape adicional de caracteres
            readOnly: true // Hace el editor solo lectura
        });
        editor.setMarkdown(document.querySelector('#content').textContent || '');  
        document.querySelector('#readonlyContent').innerHTML = editor.getHTML();
    } else {
        console.log("No se encontró el editor en el formulario.")
    }
    console.log("Vista de resultados de content creator.")
    
    
    //   // Ejemplo: cargar componentes dinámicos
    //   import('../components/featured-products.js')
    //     .then(module => module.load());
}