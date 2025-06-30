import Editor from '@toast-ui/editor';
import '@toast-ui/editor/dist/toastui-editor.css';

export function init() {
    // Lógica exclusiva para la página de inicio
    console.log('Cargado: Página de de content creator');
    const bodyClassList = document.body.classList
    if (bodyClassList.contains("content-creator-form")) {
        console.log("Vista de formulario de content creator.")   
    } else if (bodyClassList.contains("content-creator-results")) {
        // Es la vista de resultados o listado
        const container = document.getElementById("generated_content")
        if (container) {
            const editor = new Editor({
                el: container,
                height: '500px',
                initialEditType: 'wysiwyg',
                previewStyle: 'vertical',
                usageStatistics: false,
                customHTMLSanitizer: html => html // Desactiva el escape adicional de caracteres
            });
            
            editor.setMarkdown(document.querySelector('#content').textContent || '');
            
            const planNameInput = document.getElementById('plan_name');
            const customerId = document.getElementById('customerId').value;

            document.getElementById('contentPlanForm').addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted');
                const submitBtn = e.target.querySelector('button[type="submit"]');
                submitBtn.disabled = true;

                if (!planNameInput.value.trim()) {
                    alert('Por favor, ingrese el nombre para el plan de contenido.');
                    planNameInput.focus();
                    submitBtn.disabled = false;
                    return;
                }                    

                const actionUrl = this.action;
                const data = new FormData();
                data.append('generated_content', editor.getMarkdown());
                data.append('plan_name', planNameInput.value);
                data.append('customerId', customerId);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', actionUrl, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        submitBtn.disabled = false;
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                bootbox.alert({
                                    message: response.message,
                                    callback: function () {
                                        window.location.href = `${base_url}/modules/customers/`;
                                    }
                                });
                            } else {
                                bootbox.alert(response.message || 'Error al guardar el plan de contenido.');
                            }
                        } catch (err) {
                            bootbox.alert('Respuesta inesperada del servidor.');
                        }
                    }
                };
                xhr.send(data);
            });
        } else {
            console.log("No se encontró el editor en el formulario.")
        }
        console.log("Vista de resultados de content creator.")
    } else {
        console.log("No se pudo determinar el tipo de página de content creator.")
    }
    
    //   // Ejemplo: cargar componentes dinámicos
    //   import('../components/featured-products.js')
    //     .then(module => module.load());
}