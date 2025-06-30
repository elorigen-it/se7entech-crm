<?php

namespace Se7entech\Contractnew\Modules\Tests\Controllers;

use Se7entech\Contractnew\Providers\OpenAIProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Exception;

class TestsController
{
    private OpenAIProvider $openAI;

    public function __construct(Session $session)
    {
        global $base_url;
        $this->base_url = $base_url;
        $this->session = $session;
        $this->openAI = new OpenAIProvider();
    }

    /**
     * Método para manejar la solicitud de pruebas
     */
    public function index()
    {
        // Ejecutar las pruebas y obtener los resultados

        $results = $this->runTests();
        // echo var_dump($results);
        require_once __DIR__ . '/../index.php';
        // Devolver los resultados en el formato adecuado
        // return $this->formatResults($results);
    }

    /**
     * Test básico de chat completion
     */
    public function testChatCompletion(): array
    {
        $result = [
            'success' => false,
            'message' => '',
            'response' => null,
            'error' => null
        ];

        try {
            $messages = [
                ['role' => 'system', 'content' => 'Eres un asistente de pruebas. Responde únicamente con "TEST OK"'],
                ['role' => 'user', 'content' => 'Hola, ¿puedes confirmar que el servicio está funcionando?']
            ];

            $response = $this->openAI->chatCompletion($messages);

            $result['success'] = str_contains($response['choices'][0]['message']['content'], 'TEST OK');
            $result['message'] = $result['success'] 
                ? 'Test de chat completion completado con éxito' 
                : 'La respuesta no contiene el texto esperado';
            $result['response'] = $response;

        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
            $result['message'] = 'Error en el test de chat completion';
        }

        return $result;
    }

    /**
     * Test de generación de embeddings
     */
    public function testEmbeddings(): array
    {
        $result = [
            'success' => false,
            'message' => '',
            'response' => null,
            'error' => null
        ];

        try {
            $text = "Texto de prueba para generación de embeddings";
            $response = $this->openAI->createEmbedding($text);

            $result['success'] = !empty($response['data'][0]['embedding']);
            $result['message'] = $result['success'] 
                ? 'Test de embeddings completado con éxito' 
                : 'No se recibieron embeddings en la respuesta';
            $result['response'] = $response;

        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
            $result['message'] = 'Error en el test de embeddings';
        }

        return $result;
    }

    /**
     * Test completo de todas las funcionalidades
     */
    public function testAll(): array
    {
        return [
            'chat_completion' => $this->testChatCompletion(),
            'embeddings' => $this->testEmbeddings()
        ];
    }

    /**
     * Método para ejecutar pruebas desde navegador o CLI
     */
    public function runTests(): string
    {
        $tests = $this->testAll();
        
        if (php_sapi_name() === 'cli') {
            // Formato para CLI
            $output = "Resultados de las pruebas:\n";
            foreach ($tests as $name => $result) {
                $output .= "\n=== $name ===\n";
                $output .= "Estado: " . ($result['success'] ? "ÉXITO" : "FALLO") . "\n";
                $output .= "Mensaje: " . $result['message'] . "\n";
                if ($result['error']) {
                    $output .= "Error: " . $result['error'] . "\n";
                }
            }
            return $output;
        } else {
            // Formato para navegador
            $output = "<h1>Resultados de las pruebas</h1>";
            foreach ($tests as $name => $result) {
                $statusColor = $result['success'] ? 'green' : 'red';
                $output .= "<div style='margin-bottom: 20px; border: 1px solid $statusColor; padding: 10px;'>";
                $output .= "<h2 style='color: $statusColor;'>" . ucfirst(str_replace('_', ' ', $name)) . "</h2>";
                $output .= "<p><strong>Estado:</strong> <span style='color: $statusColor;'>" . 
                          ($result['success'] ? "ÉXITO" : "FALLO") . "</span></p>";
                $output .= "<p><strong>Mensaje:</strong> " . htmlspecialchars($result['message']) . "</p>";
                if ($result['error']) {
                    $output .= "<p><strong>Error:</strong> <code>" . htmlspecialchars($result['error']) . "</code></p>";
                }
                $output .= "</div>";
            }
            return $output;
        }
    }

    public function postBrand()
    {
        $request = Request::createFromGlobals()->request;
        // Recoger y sanitizar todos los datos del formulario usando $request->get
        $brandName = htmlspecialchars($request->get('brandName'));
        $industry = htmlspecialchars($request->get('industry'));
        $brandDescription = htmlspecialchars($request->get('brandDescription'));
        
        // Procesar arrays (checkbox)
        $goals = $request->all('goals');
        $goals = array_map('htmlspecialchars', $goals);
        $attributes = $request->all('attributes');
        $attributes = is_array($attributes) ? array_map('htmlspecialchars', $attributes) : [];
        $tones = $request->all('tones');
        $tones = is_array($tones) ? array_map('htmlspecialchars', $tones) : [];
        $styles = $request->all('styles');
        $styles = is_array($styles) ? array_map('htmlspecialchars', $styles) : [];
        $contentTypes = $request->all('contentTypes');
        $contentTypes = is_array($contentTypes) ? array_map('htmlspecialchars', $contentTypes) : [];
        
        // Procesar campos condicionales "Otro"
        $otherGoal = htmlspecialchars($request->get('goalOtherText'));
        $otherAttributes = htmlspecialchars($request->get('attrOtherText'));
        $otherCommunication = htmlspecialchars($request->get('commOtherText'));
        $otherPersona = htmlspecialchars($request->get('personaOtherText'));
        $otherTone = htmlspecialchars($request->get('toneOtherText'));
        $otherStyle = htmlspecialchars($request->get('styleOtherText'));
        $otherContent = htmlspecialchars($request->get('contentOtherText'));
        $otherImages = htmlspecialchars($request->get('imagesOtherText'));
        
        // Procesar resto de campos
        $targetDemographic = htmlspecialchars($request->get('targetDemographic'));
        $communicationStyle = htmlspecialchars($request->get('communicationStyle'));
        $brandPersona = htmlspecialchars($request->get('brandPersona'));
        $imageTreatment = htmlspecialchars($request->get('imageTreatment'));
        $avoidWords = htmlspecialchars($request->get('avoidWords'));
        $avoidBrands = htmlspecialchars($request->get('avoidBrands'));
        $uniqueValue = htmlspecialchars($request->get('uniqueValue'));
        $distinctiveElement = htmlspecialchars($request->get('distinctiveElement'));
        $localReferences = htmlspecialchars($request->get('localReferences'));
        $localExamples = htmlspecialchars($request->get('localExamples'));
        $specialEvents = htmlspecialchars($request->get('specialEvents'));
        $eventsExamples = htmlspecialchars($request->get('eventsExamples'));
        $admiredBrands = htmlspecialchars($request->get('admiredBrands'));
        $communicationExample = htmlspecialchars($request->get('communicationExample'));

        $systemPrompt = "";
        $prompt = "";
        // Construir el prompt para IA
        $systemPrompt .= "Eres un experto en marketing digital y redes sociales. Tu tarea es crear una guía de estilo de marca detallada para la marca de $brandName, un negocio de $industry.\n\n";
        $systemPrompt .= "Tu objetivo es generar un conjunto de reglas claras y concisas que guíen la creación de contenido en redes sociales, asegurando consistencia en la comunicación y el estilo visual.\n\n";
        $systemPrompt .= "Las reglas son para proveer al equipo de marketing y diseñadores, debe mantener la informacion sobre el texto principal, maximo de caracteres, cta, y toda la siguiente especificacion: \n";
        $systemPrompt .= "Estas son las reglas de contenido para las redes sociales:\n
            ✔️ Post estáticos (Feed):\n
            Texto principal (grande, llamativo) + Texto secundario (más pequeño con CTA).\n
            Máximo 85 caracteres en total (ambos textos).\n
            CTA obligatorio.\n
            ✔️ Historias (imágenes o animadas):\n
            Historias simples: Misma estructura que Feed (85 caracteres + CTA).\n
            Historias animadas (4-7 slides):\n
            Slide 1: Hook disruptivo.\n
            Slides 2-5: Desarrollo.\n
            Último slide: CTA claro.\n
            Máximo 35 caracteres por slide.\n
            ✔️ Carruseles (Feed):\n
            Misma estructura que historias animadas.\n
            35 caracteres por slide.\n
            ✔️ Videos (Reels/TikTok/Shorts):\n
            Hook en los primeros 3-5 segundos (pregunta, acción, humor, segun personalidad de la marca).\n
            Desarrollo: Storytelling o dato clave (8-12 segundos máximo).\n
            Cierre: CTA directo.\n
            ✔️ Stickers en Historias (encuestas, preguntas, emoji slider):\n
            Frase corta y disruptiva (35 caracteres máximo).\n'
        \n\n";
        
        $systemPrompt .= "Descripción del cliente: $brandDescription\n\n";

        // Sección de Objetivos
        $prompt .= "OBJETIVOS:\n";
        if (!empty($goals)) {
            $prompt .= "- Principales: " . implode(", ", $goals) . "\n";
        }
        if (!empty($otherGoal)) {
            $prompt .= "- Adicional: $otherGoal\n";
        }
        
        // Atributos y personalidad
        $prompt .= "\nPERSONALIDAD DE MARCA:\n";
        $prompt .= "- Atributos clave: " . implode(", ", $attributes);
        if (!empty($otherAttributes)) {
            $prompt .= ", $otherAttributes";
        }
        $prompt .= "\n";
        
        if (!empty($brandPersona)) {
            $personaText = $brandPersona === 'other' ? $otherPersona : $brandPersona;
            $prompt .= "- Personificación: $personaText\n";
        }
        
        if (!empty($tones)) {
            $prompt .= "- Tono de voz: " . implode(", ", $tones);
            if (!empty($otherTone)) {
                $prompt .= ", $otherTone";
            }
            $prompt .= "\n";
        }
        
        // Público objetivo
        $prompt .= "\nPÚBLICO OBJETIVO:\n";
        $prompt .= "- Demográfico principal: $targetDemographic\n";
        if (!empty($communicationStyle)) {
            $commStyleText = $communicationStyle === 'other' ? $otherCommunication : $communicationStyle;
            $prompt .= "- Estilo de comunicación preferido: $commStyleText\n";
        }
        
        // Estilo visual
        $prompt .= "\nESTILO VISUAL:\n";
        if (!empty($styles)) {
            $prompt .= "- Paleta estilística: " . implode(", ", $styles);
            if (!empty($otherStyle)) {
                $prompt .= ", $otherStyle";
            }
            $prompt .= "\n";
        }
        
        if (!empty($imageTreatment)) {
            $imageText = $imageTreatment === 'other' ? $otherImages : $imageTreatment;
            $prompt .= "- Tratamiento de imágenes: $imageText\n";
        }
        
        // Contenido
        $prompt .= "\nCONTENIDO:\n";
        if (!empty($contentTypes)) {
            $prompt .= "- Formatos prioritarios: " . implode(", ", $contentTypes);
            if (!empty($otherContent)) {
                $prompt .= ", $otherContent";
            }
            $prompt .= "\n";
        }
        
        // Restricciones
        $prompt .= "\nRESTRICCIONES:\n";
        if (!empty($avoidWords)) {
            $prompt .= "- Palabras prohibidas: $avoidWords\n";
        }
        if (!empty($avoidBrands)) {
            $prompt .= "- Estilos a evitar: $avoidBrands\n";
        }
        
        // Diferenciadores
        $prompt .= "\nDIFERENCIADORES:\n";
        $prompt .= "- Propuesta única: $uniqueValue\n";
        if (!empty($distinctiveElement)) {
            $prompt .= "- Elemento distintivo: $distinctiveElement\n";
        }
        
        // Adaptaciones culturales
        if (!empty($localReferences) && $localReferences === 'yes' && !empty($localExamples)) {
            $prompt .= "\nADAPTACIÓN CULTURAL:\n";
            $prompt .= "- Modismos/referencias locales: $localExamples\n";
        }
        
        if (!empty($specialEvents) && $specialEvents === 'yes' && !empty($eventsExamples)) {
            $prompt .= "- Eventos/fechas especiales: $eventsExamples\n";
        }
        
        // Referencias
        if (!empty($admiredBrands) || !empty($communicationExample)) {
            $prompt .= "\nREFERENCIAS:\n";
            if (!empty($admiredBrands)) {
                $prompt .= "- Marcas admiradas: $admiredBrands\n";
            }
            if (!empty($communicationExample)) {
                $prompt .= "- Ejemplo a emular: $communicationExample\n";
            }
        }
        
        // Instrucción final para la IA
        // $prompt .= "\nINSTRUCCIÓN PARA LA IA:\n";
        $prompt .= "Basado en esta información, desarrolla en este orden estrictamente:\n";
        $prompt .= "1. Reglas de Contenido para Redes Sociales tal como estas entrenado\n";        
        $prompt .= "3. Reglas de comunicación y tono de voz\n";
        $prompt .= "4. Reglas de uso de imágenes y estilo visual\n";
        $prompt .= "5. Reglas de contenido y formatos prioritarios\n";
        $prompt .= "6. Reglas de diferenciación y adaptación cultural\n";
        $prompt .= "7. Reglas de restricciones y evitación de palabras o marcas\n";
        $prompt .= "8. Reglas de referencias y ejemplos a seguir\n";
        $prompt .= "9. Reglas de eventos y fechas especiales\n";
        $prompt .= "10. Reglas de modismos y referencias locales\n";      
        $prompt .= "11. Respuestas a Comentarios en Reels / Feed\n";
        $prompt .= "12. Respuestas a Mensajes Directos (DM)\n";
        $prompt .= "13. Respuestas a Comentarios en Historias\n";
        $prompt .= "14. Respuestas a Comentarios en Carruseles\n";
        $prompt .= "15. Respuestas a Comentarios en Videos\n";
        $prompt .= "16. Respuestas a Comentarios en Stickers\n";
        $prompt .= "17. Copy para Fechas Especiales";
        $prompt .= "18. Crea un ejemplo de cada uno de los puntos anteriores, incluyendo un ejemplo de post para cada tipo de contenido (Feed, Historias, Carruseles, Videos) y un ejemplo de respuesta a comentarios.\n";
        $prompt .= "Devuelve en formato html";


        try {
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $prompt]
            ];

            $response = $this->openAI->chatCompletion($messages);

            $responseContent = $response['choices'][0]['message']['content'];
            echo $responseContent;

            // $result['success'] = str_contains($response['choices'][0]['message']['content'], 'TEST OK');
            // $result['message'] = $result['success'] 
            //     ? 'Test de chat completion completado con éxito' 
            //     : 'La respuesta no contiene el texto esperado';
            // $result['response'] = $response;

        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
            $result['message'] = 'Error en el test de chat completion';
            echo var_dump($result);
        }
        
        // Mostrar el prompt generado (en un entorno real, aquí lo enviarías a la API de IA)
        // header('Content-Type: text/plain; charset=utf-8');
        // echo "PROMPT GENERADO PARA IA:\n\n";
        // echo $prompt;
        
        // En un caso real, aquí iría la conexión a la API de IA
        // $iaResponse = enviarAIA($prompt);
        // echo $iaResponse;
           
            
    }

    public function getAvailableModels(){
        $models = $this->openAI->getAvailableModels();
        $availableModels = [];
        
        foreach ($models['data'] as $model) {
            if (str_starts_with($model['id'], 'gpt-')) {
                $availableModels[] = [
                    'id' => $model['id'],
                    'name' => $model['id'],
                    'description' => $model['description'] ?? 'No description available'
                ];
            }
        }

        return json_encode($availableModels);
    }

    public function tasks()
    {
        // Aquí puedes implementar la lógica para manejar las tareas
        // Por ejemplo, podrías devolver una lista de tareas pendientes
        include __DIR__ . '/../tasks.php';
    }
}