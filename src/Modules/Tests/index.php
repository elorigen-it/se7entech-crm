<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Definición de Personalidad de Marca</title>
    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #F59E0B;
            --dark: #1F2937;
            --light: #F3F4F6;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9fafb;
        }
        h1 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }
        .form-section {
            background-color: white;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-left: 4px solid var(--primary);
        }
        h2 {
            color: var(--primary);
            margin-top: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: inherit;
            transition: border 0.3s;
        }
        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        .checkbox-group, .radio-group {
            margin-bottom: 20px;
        }
        .checkbox-item, .radio-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .checkbox-item input, .radio-item input {
            width: auto;
            margin-right: 10px;
            margin-bottom: 0;
        }
        .custom-option {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        .custom-option input {
            flex: 1;
            margin-left: 10px;
        }
        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px 28px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            margin: 40px auto 0;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #4338CA;
        }
        .required:after {
            content: " *";
            color: #EF4444;
        }
        .form-note {
            font-size: 0.9rem;
            color: #6B7280;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        @media (max-width: 600px) {
            body {
                padding: 15px;
            }
            .form-section {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <h1>Definición de Personalidad de Marca</h1>
    
    <form id="brandPersonalityForm" action="<?php echo $this->base_url . '/modules/tests/index.php/postbrand';?>" method="post">
        <!-- Sección 1: Identidad Básica -->
        <div class="form-section">
            <h2>1. Identidad Básica</h2>
            
            <label for="brandName" class="required">Nombre de la marca</label>
            <input type="text" id="brandName" name="brandName" required placeholder="Ej: Mi Marca">
            
            <label for="industry" class="required">Rubro/Industria</label>
            <input type="text" id="industry" name="industry" required placeholder="Ej: Tecnología, Moda, Educación, Salud">
            
            <label for="brandDescription" class="required">Descripción breve</label>
            <p class="form-note">Completa: "Somos [quién son] que ayudamos a [qué necesidad resuelven] a través de [qué ofrecen]"</p>
            <textarea id="brandDescription" name="brandDescription" required placeholder="Ej: Somos una consultoría digital que ayudamos a pequeñas empresas a incrementar sus ventas a través de estrategias de marketing personalizadas"></textarea>
        </div>
        
        <!-- Sección 2: Propósito de Marca -->
        <div class="form-section">
            <h2>2. Propósito de Marca</h2>
            
            <label class="required">Objetivo principal con la comunicación</label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="goalCommunity" name="goals[]" value="community">
                    <label for="goalCommunity">Construir comunidad</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="goalSales" name="goals[]" value="sales">
                    <label for="goalSales">Generar ventas/conversiones</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="goalAuthority" name="goals[]" value="authority">
                    <label for="goalAuthority">Posicionamiento de autoridad</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="goalEducate" name="goals[]" value="educate">
                    <label for="goalEducate">Educar/informar</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="goalOther" name="goals[]" value="other">
                    <label for="goalOther">Otro:</label>
                    <input type="text" id="goalOtherText" name="goalOtherText" placeholder="Describe tu objetivo" style="display: none;">
                </div>
            </div>
            
            <label class="required">Atributos clave (elige 3-5)</label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="attrInnovative" name="attributes[]" value="innovative">
                    <label for="attrInnovative">Innovador</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="attrEmpathetic" name="attributes[]" value="empathetic">
                    <label for="attrEmpathetic">Cercano/empático</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="attrLuxury" name="attributes[]" value="luxury">
                    <label for="attrLuxury">Lujoso/exclusivo</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="attrFun" name="attributes[]" value="fun">
                    <label for="attrFun">Divertido</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="attrReliable" name="attributes[]" value="reliable">
                    <label for="attrReliable">Confiable/seguro</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="attrRebel" name="attributes[]" value="rebel">
                    <label for="attrRebel">Rebelde/atrevido</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="attrOther" name="attributes[]" value="other">
                    <label for="attrOther">Otros:</label>
                    <input type="text" id="attrOtherText" name="attrOtherText" placeholder="Escribe tus atributos" style="display: none;">
                </div>
            </div>
        </div>
        
        <!-- Sección 3: Público Objetivo -->
        <div class="form-section">
            <h2>3. Público Objetivo</h2>
            
            <label for="targetDemographic" class="required">Demográfico principal</label>
            <input type="text" id="targetDemographic" name="targetDemographic" required placeholder="Ej: Mujeres 25-40, Startups en crecimiento, Padres millennials">
            
            <label class="required">Estilo de comunicación que conecta con ellos</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="commFormal" name="communicationStyle" value="formal">
                    <label for="commFormal">Formal/profesional</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="commRelaxed" name="communicationStyle" value="relaxed">
                    <label for="commRelaxed">Relajado/coloquial</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="commMotivational" name="communicationStyle" value="motivational">
                    <label for="commMotivational">Motivacional/inspirador</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="commHumor" name="communicationStyle" value="humor">
                    <label for="commHumor">Humorístico/desenfadado</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="commOther" name="communicationStyle" value="other">
                    <label for="commOther">Otro:</label>
                    <input type="text" id="commOtherText" name="commOtherText" placeholder="Describe el estilo" style="display: none;">
                </div>
            </div>
        </div>
        
        <!-- Sección 4: Personalidad de Marca -->
        <div class="form-section">
            <h2>4. Personalidad de Marca</h2>
            
            <label class="required">Si tu marca fuera una persona, sería:</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="personaExpert" name="brandPersona" value="expert">
                    <label for="personaExpert">Un experto confiable</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="personaFriend" name="brandPersona" value="friend">
                    <label for="personaFriend">Un amigo cercano</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="personaMentor" name="brandPersona" value="mentor">
                    <label for="personaMentor">Un mentor inspirador</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="personaInnovator" name="brandPersona" value="innovator">
                    <label for="personaInnovator">Un innovador visionario</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="personaOther" name="brandPersona" value="other">
                    <label for="personaOther">Otro:</label>
                    <input type="text" id="personaOtherText" name="personaOtherText" placeholder="Describe la personalidad" style="display: none;">
                </div>
            </div>
            
            <label class="required">Tono de voz preferido</label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="toneEmotional" name="tones[]" value="emotional">
                    <label for="toneEmotional">Emocional/empático</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="toneDirect" name="tones[]" value="direct">
                    <label for="toneDirect">Directo/práctico</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="toneSophisticated" name="tones[]" value="sophisticated">
                    <label for="toneSophisticated">Sofisticado/elegante</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="toneProvocative" name="tones[]" value="provocative">
                    <label for="toneProvocative">Irreverente/provocativo</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="toneOther" name="tones[]" value="other">
                    <label for="toneOther">Otro:</label>
                    <input type="text" id="toneOtherText" name="toneOtherText" placeholder="Describe el tono" style="display: none;">
                </div>
            </div>
        </div>
        
        <!-- Sección 5: Estilo Visual -->
        <div class="form-section">
            <h2>5. Estilo Visual</h2>
            
            <label>Paleta de estilo (elige hasta 2 principales)</label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="styleMinimalist" name="styles[]" value="minimalist">
                    <label for="styleMinimalist">Minimalista</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="styleVibrant" name="styles[]" value="vibrant">
                    <label for="styleVibrant">Vibrante/colorido</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="styleRetro" name="styles[]" value="retro">
                    <label for="styleRetro">Retro/vintage</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="styleFuturistic" name="styles[]" value="futuristic">
                    <label for="styleFuturistic">Futurista/tech</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="styleOrganic" name="styles[]" value="organic">
                    <label for="styleOrganic">Orgánico/natural</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="styleOther" name="styles[]" value="other">
                    <label for="styleOther">Otro:</label>
                    <input type="text" id="styleOtherText" name="styleOtherText" placeholder="Describe tu estilo" style="display: none;">
                </div>
            </div>
            
            <label>Tratamiento de imágenes</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="imagesClean" name="imageTreatment" value="clean">
                    <label for="imagesClean">Solo visuales limpios (sin texto)</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="imagesInspirational" name="imageTreatment" value="inspirational">
                    <label for="imagesInspirational">Imágenes con frases inspiradoras</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="imagesEducational" name="imageTreatment" value="educational">
                    <label for="imagesEducational">Imágenes con datos/educativos</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="imagesOther" name="imageTreatment" value="other">
                    <label for="imagesOther">Otro:</label>
                    <input type="text" id="imagesOtherText" name="imagesOtherText" placeholder="Describe tu enfoque" style="display: none;">
                </div>
            </div>
        </div>
        
        <!-- Sección 6: Contenido Prioritario -->
        <div class="form-section">
            <h2>6. Contenido Prioritario</h2>
            
            <label>Formatos que mejor representan tu marca (elige hasta 3)</label>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <input type="checkbox" id="contentEducational" name="contentTypes[]" value="educational">
                    <label for="contentEducational">Educativo (guías, tips)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="contentEntertainment" name="contentTypes[]" value="entertainment">
                    <label for="contentEntertainment">Entretenimiento (humor, trends)</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="contentBTS" name="contentTypes[]" value="bts">
                    <label for="contentBTS">Behind the scenes</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="contentTestimonials" name="contentTypes[]" value="testimonials">
                    <label for="contentTestimonials">Testimonios/clientes reales</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="contentPromotions" name="contentTypes[]" value="promotions">
                    <label for="contentPromotions">Promociones/ofertas</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" id="contentOther" name="contentTypes[]" value="other">
                    <label for="contentOther">Otro:</label>
                    <input type="text" id="contentOtherText" name="contentOtherText" placeholder="Describe el formato" style="display: none;">
                </div>
            </div>
        </div>
        
        <!-- Sección 7: Lo Que NO Somos -->
        <div class="form-section">
            <h2>7. Lo Que NO Somos</h2>
            
            <label for="avoidWords">Palabras o conceptos que NO quieres asociar a tu marca</label>
            <input type="text" id="avoidWords" name="avoidWords" placeholder="Ej: barato, masivo, tradicional">
            
            <label for="avoidBrands">Marcas/competidores cuyo estilo NO te identifica</label>
            <input type="text" id="avoidBrands" name="avoidBrands" placeholder="Ej: [Nombre de marca] porque...">
        </div>
        
        <!-- Sección 8: Diferenciadores Clave -->
        <div class="form-section">
            <h2>8. Diferenciadores Clave</h2>
            
            <label for="uniqueValue" class="required">¿Qué te hace único?</label>
            <p class="form-note">Fórmula: "Somos los únicos que [valor] para [audiencia] porque [razón]"</p>
            <textarea id="uniqueValue" name="uniqueValue" required placeholder="Ej: Somos los únicos que ofrecemos diseño web en 24 horas para emprendedores porque tenemos un sistema de trabajo ágil y especializado"></textarea>
            
            <label for="distinctiveElement">Elemento distintivo recurrente (color, símbolo, estilo)</label>
            <input type="text" id="distinctiveElement" name="distinctiveElement" placeholder="Ej: Nuestro morado característico, un ícono de hoja, fotos con sombras largas...">
        </div>
        
        <!-- Sección 9: Adaptaciones Culturales -->
        <div class="form-section">
            <h2>9. Adaptaciones Culturales</h2>
            
            <label>¿Incluir modismos o referencias locales?</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="localYes" name="localReferences" value="yes">
                    <label for="localYes">Sí</label>
                    <input type="text" id="localExamples" name="localExamples" placeholder="¿Cuáles? Ej: modismos, festividades..." style="display: none; margin-left: 20px;">
                </div>
                <div class="radio-item">
                    <input type="radio" id="localNo" name="localReferences" value="no">
                    <label for="localNo">No</label>
                </div>
            </div>
            
            <label>¿Aprovechar fechas/eventos específicos?</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="eventsYes" name="specialEvents" value="yes">
                    <label for="eventsYes">Sí</label>
                    <input type="text" id="eventsExamples" name="eventsExamples" placeholder="¿Cuáles? Ej: Navidad, Día de la Madre..." style="display: none; margin-left: 20px;">
                </div>
                <div class="radio-item">
                    <input type="radio" id="eventsNo" name="specialEvents" value="no">
                    <label for="eventsNo">No</label>
                </div>
            </div>
        </div>
        
        <!-- Sección 10: Referencias e Inspiración -->
        <div class="form-section">
            <h2>10. Referencias e Inspiración</h2>
            
            <label for="admiredBrands">Marcas que admiras (aunque no sean de tu rubro)</label>
            <input type="text" id="admiredBrands" name="admiredBrands" placeholder="Ej: Apple, Patagonia, Glossier...">
            
            <label for="communicationExample">Ejemplo de comunicación que te gustaría emular</label>
            <textarea id="communicationExample" name="communicationExample" placeholder="Ej: 'Me encanta cómo [marca] usa un tono [descriptivo] en sus [canales] para hablar de [tema]'"></textarea>
        </div>
        
        <button type="submit">Enviar Formulario</button>
    </form>

    <script>
        // Mostrar campos de texto cuando se selecciona "Otro"
        document.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => {
            input.addEventListener('change', function() {
                const otherTextId = this.id + 'Text';
                const otherTextElement = document.getElementById(otherTextId);
                
                if (otherTextElement) {
                    otherTextElement.style.display = this.checked ? 'block' : 'none';
                    if (this.checked) otherTextElement.focus();
                }
            });
        });

        // Manejar campos de adaptaciones culturales
        document.getElementById('localYes').addEventListener('change', function() {
            document.getElementById('localExamples').style.display = this.checked ? 'block' : 'none';
        });
        
        document.getElementById('eventsYes').addEventListener('change', function() {
            document.getElementById('eventsExamples').style.display = this.checked ? 'block' : 'none';
        });

        // // Validación básica del formulario
        // document.getElementById('brandPersonalityForm').addEventListener('submit', function(e) {
        //     let valid = true;
            
        //     // Validar campos requeridos
        //     document.querySelectorAll('[required]').forEach(field => {
        //         if (!field.value.trim()) {
        //             field.style.borderColor = '#EF4444';
        //             valid = false;
        //         }
        //     });
            
        //     if (!valid) {
        //         e.preventDefault();
        //         alert('Por favor completa todos los campos requeridos');
        //     } else {
        //         alert('Formulario enviado con éxito. ¡Gracias!');
        //         // Aquí iría la lógica para procesar el formulario
        //     }
        // });
    </script>
</body>
</html>