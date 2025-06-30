import Editor from '@toast-ui/editor';
import '@toast-ui/editor/dist/toastui-editor.css';

export function init() {
    // Lógica exclusiva para la página de inicio
    console.log('Cargado: Página de de brand content editor');
    
    var editor;
    const container = document.getElementById("content")

    if (container) {
        editor = new Editor({
            el: container,
            height: '500px',
            initialEditType: 'wysiwyg',
            previewStyle: 'vertical',
            usageStatistics: false,
            customHTMLSanitizer: html => html, // Desactiva el escape adicional de caracteres
            readOnly: true // Hace el editor solo lectura
        });
        editor.setMarkdown(document.querySelector('#_content').textContent || '');          
    } else {
        console.log("No se encontró el editor en el formulario.")
    }
    console.log("Vista de resultados de content creator.")


    const nameInput = document.getElementById('content_name');
    const customerId = document.getElementById('customerId').value;
    const contentId = document.getElementById('contentId').value;

    document.getElementById('brandPersonalityForm').addEventListener('submit', function(e) {
        e.preventDefault();
        e.target.disabled = true; // Disable the form to prevent multiple submissions

        if (!nameInput.value.trim()) {
            alert('Por favor, ingrese el nombre para el plan de contenidos.');
            nameInput.focus();
            e.target.disabled = false;
            return;
        }                    

        const actionUrl = this.action;
        const data = new FormData();
        data.append('content_name', nameInput.value);
        data.append('content', editor.getMarkdown());
        data.append('customerId', customerId);
        data.append('contentId', contentId);

        
        const xhr = new XMLHttpRequest();
        xhr.open('POST', actionUrl, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                // Optionally handle response here
                console.log(xhr);
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        bootbox.alert({
                            message: response.message,
                            callback: function () {
                                window.location.href = `${base_url}/modules/customers/index.php/${customerId}/brand-content/view/${contentId}`;
                            }
                        });
                    } else {
                        bootbox.alert(response.message || 'Error al guardar contenido de marca.');
                    }
                } catch (err) {
                    bootbox.alert('Respuesta inesperada del servidor.');
                }
            }
        };
        xhr.send(data);
    });   
    
    //   // Ejemplo: cargar componentes dinámicos
    //   import('../components/featured-products.js')
    //     .then(module => module.load());
}