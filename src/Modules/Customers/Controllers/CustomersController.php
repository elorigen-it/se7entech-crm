<?php

namespace Se7entech\Contractnew\Modules\Customers\Controllers;

use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
use Se7entech\Contractnew\Modules\Customers\Models\BrandRulesModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Rakit\Validation\Validator;
use Se7entech\Contractnew\Providers\OpenAIProvider;
use Exception;

class CustomersController {
    public $data = array(
        'errors' => array(),
        'last_data' => array(),
        'current' => array(),
        'success' => null,
        'session' => array(),
        'records' => array(),
        'users' => array() // Si necesitas lista de usuarios/agentes
    );

    public function __construct(Session $session) {
        global $base_url;
        $this->base_url = $base_url;
        $this->session = $session;
        $this->data['records'] = $this->getCustomers();
        
        // Si necesitas cargar usuarios/agentes para dropdowns
        // $this->data['users'] = $this->getUsers(); 
        
        foreach ($this->session->getFlashBag()->all() as $type => $messages) {
            if($type === 'last_data') {
                $this->data['last_data'] = $messages[0];
                continue;
            }
            foreach($messages as $message) {
                array_push($this->data['session'], '<div class="alert alert-'.$type.' p-2" role="alert">'.$message.'</div>');
            }
        }
    }

    public function index() {
        include __DIR__ . '/../index.php';
    }

    public function getById($params) {
        $id = $params['id'];
        if($id) {
            $record = CustomersModel::getById($id);
            if($record) {
                $this->data['current'] = $record;
                include __DIR__ . '/../single.php';
            } else {
                $flashes = $this->session->getFlashBag();
                $flashes->add('warning', 'Customer not found');
                header('location: /modules/customers/');
            }  
        } else {
            $flashes = $this->session->getFlashBag();
            $flashes->add('warning', 'Bad Request');
            header('location: ' . $this->base_url . '/modules/customers/');
        }
    }

    private function _validateData($data) {
        $validator = new Validator;
        
        $validation = $validator->make($data, [
            'type' => 'required|in:customer,lead',
            'name' => 'required|min:3',
            'email' => 'nullable|email',
            'phone' => 'nullable|min:8',
            'status' => 'required|in:active,inactive'
        ]);
        
        $validation->setAliases([
            'type' => 'Customer Type',
            'name' => 'Customer Name'
        ]);
        
        $validation->validate();

        return $validation;
    }

    public function postCustomer() {
        $request = Request::createFromGlobals();
        if($request->request->get('save')) {
            $validation = $this->_validateData($request->request->all());

            if ($validation->fails()) {
                $errors = $validation->errors();
                $this->data['errors'] = $errors;
                $messages = $errors->all('<span>:message</span>');
                $flashes = $this->session->getFlashBag();
                
                foreach($messages as $msg) {
                    $flashes->add('danger', $msg);
                }
                $flashes->add('last_data', $request->request->all());
            } else {
                // Procesar imagen si existe
                $imagePath = null;
                if ($request->files->has('image') && $request->files->get('image')) {
                    $imagePath = $this->handleImageUpload($request->files->get('image'));
                    echo var_dump($imagePath);
                }
                
                // Preparar datos para el modelo
                $customerData = $request->request->all();
                if ($imagePath) {
                    $customerData['image'] = $imagePath;
                }

                $currentUserEmail = $this->session->get('email');

                if ($currentUserEmail) {
                    $customerData['agent_email'] = $currentUserEmail;
                }

                $res = CustomersModel::create($customerData);
                $flashes = $this->session->getFlashBag();
                
                if($res) {
                    $this->data['success'] = true;
                    $flashes->add('success', '<span>New customer created</span>');
                } else {
                    $this->data['success'] = false;
                    $flashes->add('warning', '<span>Error saving customer</span>');
                }
            }

            header('location: ' . $this->base_url . '/modules/customers/');
        }
    }

    public function updateCustomer($params) {
        $request = Request::createFromGlobals();
        $id = $params['id'];
        
        if($request->request->get('save')) {
            $validation = $this->_validateData($request->request->all());
            
            if ($validation->fails()) {
                $errors = $validation->errors();
                $this->data['errors'] = $errors;
                $messages = $errors->all('<span>:message</span>');
                $flashes = $this->session->getFlashBag();
                
                foreach($messages as $msg) {
                    $flashes->add('danger', $msg);
                }
                $flashes->add('last_data', $request->request->all());
            } else {
                // Procesar imagen si existe
                $imagePath = null;
                if ($request->files->has('image') && $request->files->get('image')) {
                    $imagePath = $this->handleImageUpload($request->files->get('image'));
                    
                    // Eliminar imagen anterior si existe
                    $currentCustomer = CustomersModel::getById($id);
                    if ($currentCustomer && $currentCustomer['image']) {
                        $this->deleteImage($currentCustomer['image']);
                    }
                }
                
                // Preparar datos para el modelo
                $customerData = $request->request->all();

                // Verificar si se debe eliminar la imagen
                $removeImage = $request->request->get('remove_image');
                $currentCustomer = CustomersModel::getById($id);

                if ($removeImage) {
                    // Eliminar imagen si existe
                    if ($currentCustomer && !empty($currentCustomer['image'])) {
                        $this->deleteImage($currentCustomer['image']);
                    }
                    $customerData['image'] = null;
                } elseif ($imagePath) {
                    // Si se subió una nueva imagen
                    $customerData['image'] = $imagePath;
                } else {
                    // Mantener la imagen actual
                    if ($currentCustomer && !empty($currentCustomer['image'])) {
                        $customerData['image'] = $currentCustomer['image'];
                    }
                }
                
                $res = CustomersModel::update($id, $customerData);
                $flashes = $this->session->getFlashBag();
                
                if($res) {
                    $this->data['success'] = true;
                    $flashes->add('success', '<span>Customer updated</span>');
                } else {
                    $this->data['success'] = false;
                    $flashes->add('warning', '<span>Error updating customer</span>');
                }
            }

            header('location: ' . $this->base_url . '/modules/customers/');
        }
    }

    public function getCustomers() {
        return CustomersModel::getAll();
    }

    public function delete($params) {
        $request = Request::createFromGlobals();
        $id = $request->request->get('id');
        
        if($id) {
            // Eliminar imagen asociada si existe
            $customer = CustomersModel::getById($id);
            if ($customer && $customer['image']) {
                $this->deleteImage($customer['image']);
            }
            
            $result = CustomersModel::delete($id);
            echo json_encode(array('success' => $result));
        }
    }

    private function handleImageUpload($file) {
        $uploadDir = __DIR__ . '/../../../../uploads/customers/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $file->move($uploadDir, $fileName);
        
        return '/uploads/customers/' . $fileName;
    }

    private function deleteImage($imagePath) {
        $fullPath = __DIR__ . '/../../../..' . $imagePath;
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function generateBrandRulesForm($params) {
        $request = Request::createFromGlobals();
        $customerId = $params['customerId'];
        $customer = CustomersModel::getById($customerId);
        if (!$customer) {
            echo json_encode(array('success' => false, 'message' => 'Customer not found'));
            return;
        }
        
        //return form to generate brand rules
        include __DIR__ . '/../generate_brand_rules_form.php';

    }

    public function generateBrandRules($params)
    {
        $customerId = $params['customerId'];
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
        $prompt .= "Devuelve en formato html dentro de un <div>\n";


        try {
            $openAI = new OpenAIProvider();
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $prompt]
            ];

            $response = $openAI->chatCompletion($messages);

            $responseContent = $response['choices'][0]['message']['content'];
            // echo var_dump($responseContent);
            // exit;
            require __DIR__ . '/../brand_rules_results.php';

        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
            $result['message'] = 'Error en el test de chat completion';
            echo var_dump($result);
        }            
    }

    public function confirmBrandRules($params) {
        $request = Request::createFromGlobals();
        $customerId = $params['customerId'];
        $customer = CustomersModel::getById($customerId);
        if (!$customer) {
            echo json_encode(array('success' => false, 'message' => 'Customer not found'));
            return;
        }
        
        // Procesar el formulario de confirmación de reglas de marca
        $ruleName = htmlspecialchars($request->get('rule_name'));
        $ruleContent = filter_input(INPUT_POST, 'brand_identity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $success = BrandRulesModel::addBrandRuleToCustomer($customerId, $ruleName, $ruleContent);
        // Aquí podrías guardar las reglas generadas en la base de datos o en un archivo
        // Por simplicidad, solo se muestra un mensaje de éxito
        if($success){
            $this->session->getFlashBag()->add('success', 'Brand rules confirmed successfully for customer: ' . $customer['name']);
        }
        
        echo json_encode(array(
            'success' => $success,
            'message' => 'Brand rules confirmed successfully',
            'customerId' => $customerId,
            'ruleName' => $ruleName,
            'ruleContent' => $ruleContent
        ));
    }

    public function generateContentForm($params){
        $customerId = $params['customerId'];
        $customer = CustomersModel::getById($customerId);
        $brandRules = BrandRulesModel::getBrandRulesByCustomerId($customerId);

        if (!$customer) {
            echo json_encode(array('success' => false, 'message' => 'Customer not found'));
            return;
        }
        
        // Mostrar el formulario para generar contenido
        include __DIR__ . '/../generate_content_form.php';
    }

    private function calculatePublications($frequency, $postsPerWeek, $duration, $preferredDays = []) {
        $weeklyPosts = 0;
        $totalPosts = 0;
        
        // Calcular publicaciones por semana según frecuencia
        switch ($frequency) {
            case 'daily':
                $weeklyPosts = count($preferredDays);
                break;
                
            case 'weekly':
                if (strpos($postsPerWeek, '-') !== false) {
                    list($min, $max) = explode('-', $postsPerWeek);
                    $weeklyPosts = (int)$max; // Tomamos el valor máximo del rango
                } elseif ($postsPerWeek == '10+') {
                    $weeklyPosts = 10; // Asumimos 10 como mínimo para "10+"
                } else {
                    $weeklyPosts = (int)$postsPerWeek;
                }
                break;
                
            case 'monthly':
                if (strpos($postsPerWeek, '-') !== false) {
                    list($min, $max) = explode('-', $postsPerWeek);
                    $weeklyPosts = (int)$max; // Para mensual, primero calculamos semanal
                } elseif ($postsPerWeek == '10+') {
                    $weeklyPosts = 10;
                } else {
                    $weeklyPosts = (int)$postsPerWeek;
                }
                break;
                
            default:
                $weeklyPosts = 0;
        }
        
        // Calcular el total según duración
        switch ($duration) {
            case '1-month':
                $totalPosts = $weeklyPosts * 4; // 4 semanas
                break;
                
            case '3-months':
                $totalPosts = $weeklyPosts * 13; // 13 semanas (3 meses)
                break;
                
            case '6-months':
                $totalPosts = $weeklyPosts * 26; // 26 semanas (6 meses)
                break;
                
            case '1-year':
                $totalPosts = $weeklyPosts * 52; // 52 semanas (1 año)
                break;
                
            default:
                $totalPosts = $weeklyPosts * 4; // Por defecto 1 mes
        }
        
        // Ajuste especial para frecuencia mensual
        if ($frequency == 'monthly') {
            // Para mensual, dividimos el total ya que postsPerWeek realmente significa postsPerMonth
            $totalPosts = ceil($totalPosts / 4);
        }
        
        return $totalPosts;
    }
    public function generateContentPlan($params)
    {
        $customerId = $params['customerId'];
        $request = Request::createFromGlobals()->request;
        
        // Recoger y sanitizar datos básicos
        $brandRulesId = htmlspecialchars($request->get('brandRules'));
        $brandRules = BrandRulesModel::getById($brandRulesId);
        if (!$brandRules) {
            echo json_encode(array('success' => false, 'message' => 'Brand rules not found'));
            return;
        }
        $brandRulesContent = html_entity_decode($brandRules['rule_content'], ENT_QUOTES, 'UTF-8');
        $frequency = htmlspecialchars($request->get('frequency'));
        $postCount = htmlspecialchars($request->get('postCount'));
        $startDate = htmlspecialchars($request->get('startDate'));
        $duration = htmlspecialchars($request->get('duration'));
        
        // Procesar arrays (checkbox)
        $days = $request->all('days');
        $days = is_array($days) ? array_map('htmlspecialchars', $days) : [];
        $platforms = $request->all('platforms');
        $platforms = is_array($platforms) ? array_map('htmlspecialchars', $platforms) : [];
        $formats = $request->all('formats');
        $formats = is_array($formats) ? array_map('htmlspecialchars', $formats) : [];
        
        // Procesar campos condicionales "Otro"
        $otherPlatform = htmlspecialchars($request->get('platformOtherText'));
        $otherFormat = htmlspecialchars($request->get('formatOtherText'));
        
        // Procesar tiempos
        $morningTime = htmlspecialchars($request->get('morningTime'));
        $afternoonTime = htmlspecialchars($request->get('afternoonTime'));
        $eveningTime = htmlspecialchars($request->get('eveningTime'));
        $weekendTime = htmlspecialchars($request->get('weekendTime'));
        
        // Procesar porcentajes de contenido
        $contentEducational = htmlspecialchars($request->get('contentEducational'));
        $contentPromotional = htmlspecialchars($request->get('contentPromotional'));
        $contentEntertainment = htmlspecialchars($request->get('contentEntertainment'));
        $contentCommunity = htmlspecialchars($request->get('contentCommunity'));
        $contentTrends = htmlspecialchars($request->get('contentTrends'));
        $contentOther = htmlspecialchars($request->get('contentOther'));
        
        // Procesar temáticas
        $mainThemes = htmlspecialchars($request->get('mainThemes'));
        $keywords = htmlspecialchars($request->get('keywords'));
        $hashtags = htmlspecialchars($request->get('hashtags'));
        
        // Procesar recursos
        $resources = htmlspecialchars($request->get('resources'));
        $contentRequirements = htmlspecialchars($request->get('contentRequirements'));
        $specialDates = htmlspecialchars($request->get('specialDates'));

        $totalPosts = $this->calculatePublications($frequency, $postCount, $duration, $days);

        // echo var_dump($totalPosts);
        // exit;

        // Construir el prompt para IA
        $systemPrompt = "";
        $prompt = "";
        
        $systemPrompt .= "Eres un experto en estrategia de contenido para redes sociales. 
        Tu tarea es crear un plan detallado de contenido para redes sociales lista para implementar basado en los parámetros proporcionados.\n";
        $systemPrompt .= "Debes crear ". $totalPosts ." publicaciones exactamente, de manera variada con los copys exactos, descripciones de imagenes y lineamientos para los diseñadores y editores en cada post.\n";
        $systemPrompt .= "Tambien utiliza la informacion de las reglas de marca proporcionadas para generar contenido especifico que se debe publicar en cada plataforma.\n";
        $systemPrompt .= "Debes seguir las reglas de contenido y la personalidad de la marca\n";
        
        // $systemPrompt .= "- Formatos y horarios de publicación\n";
        // $systemPrompt .= "El formato de respuesta debe ser claro, estructurado y listo para implementar.\n";
        // $systemPrompt .= "Multiplica las publicaciones por semana por la cantidad de semanas del plan, asegurando que el contenido cubra todo el periodo solicitado por el usuario.\n\n";
        // $systemPrompt .= "No te estoy pidiendo ejemplos, te estoy pidiendo el calendario definitivo completo de publicacion.\n";
        $systemPrompt .= "Las reglas obligatorias para el formato de contenido y la personalidad de la marca estan en este texto html: $brandRulesContent\n\n";
        
        // Información básica
        $prompt .= "INFORMACIÓN BÁSICA:\n";
        $prompt .= "- Frecuencia de publicación: $frequency\n";
        $prompt .= "- Cantidad de publicaciones por semana: $postCount\n";
        $prompt .= "- Fecha de inicio: $startDate\n";
        $prompt .= "- Duración del plan: $duration\n\n";
        
        // Horarios y días
        $prompt .= "HORARIOS Y DÍAS:\n";
        if (!empty($days)) {
            $prompt .= "- Días preferidos: " . implode(", ", $days) . "\n";
        }
        $prompt .= "- Horario mañana: $morningTime\n";
        $prompt .= "- Horario tarde: $afternoonTime\n";
        $prompt .= "- Horario noche: $eveningTime\n";
        $prompt .= "- Horario fines de semana: $weekendTime\n\n";
        
        // Plataformas
        $prompt .= "PLATAFORMAS:\n";
        if (!empty($platforms)) {
            $prompt .= "- Plataformas objetivo: " . implode(", ", $platforms);
            if (!empty($otherPlatform)) {
                $prompt .= ", $otherPlatform";
            }
            $prompt .= "\n\n";
        }
        
        // Distribución de contenido
        $prompt .= "DISTRIBUCIÓN DE CONTENIDO:\n";
        $prompt .= "- Educativo: $contentEducational%\n";
        $prompt .= "- Promocional: $contentPromotional%\n";
        $prompt .= "- Entretenimiento: $contentEntertainment%\n";
        $prompt .= "- Comunidad: $contentCommunity%\n";
        $prompt .= "- Trends/Actualidad: $contentTrends%\n";
        $prompt .= "- Otros: $contentOther%\n\n";
        
        // Temáticas
        $prompt .= "TEMÁTICAS:\n";
        $prompt .= "- Principales: $mainThemes\n";
        if (!empty($keywords)) {
            $prompt .= "- Palabras clave: $keywords\n";
        }
        if (!empty($hashtags)) {
            $prompt .= "- Hashtags: $hashtags\n";
        }
        $prompt .= "\n";
        
        // Formatos y recursos
        $prompt .= "RECURSOS Y FORMATOS:\n";
        $prompt .= "- Nivel de recursos: $resources\n";
        if (!empty($formats)) {
            $prompt .= "- Formatos preferidos: " . implode(", ", $formats);
            if (!empty($otherFormat)) {
                $prompt .= ", $otherFormat";
            }
            $prompt .= "\n";
        }
        if (!empty($contentRequirements)) {
            $prompt .= "- Requerimientos específicos: $contentRequirements\n";
        }
        $prompt .= "\n";
        
        // Eventos especiales
        if (!empty($specialDates)) {
            $prompt .= "FECHAS ESPECIALES:\n";
            $prompt .= "$specialDates\n\n";
        }
        
        // Instrucción final para la IA
        // $prompt .= "INSTRUCCIÓN PARA LA IA:\n";
        // $prompt .= "Basado en esta información, desarrolla:\n";
        // $prompt .= "1. Un calendario editorial detallado por semanas, incluyendo fechas específicas. Asegurandote de que abarcas todo el tiempo solicitado por el usuario\n";
        // // $prompt .= "2. Ideas de contenido específicas para cada plataforma seleccionada\n";
        // // $prompt .= "3. Recomendaciones de formatos según los recursos disponibles\n";
        // // $prompt .= "4. Sugerencias de horarios de publicación óptimos\n";
        // // $prompt .= "5. Ideas para aprovechar fechas especiales\n";
        // // $prompt .= "6. Estrategias para aumentar el engagement\n";
        // // $prompt .= "7. Ejemplos concretos de posts para cada tipo de contenido\n\n";
        // $prompt .= "El contenido debe ser claro, estructurado y fácil de seguir. Desarrolla todos los copys con su calendario editorial con fechas específicas, ideas de contenido para cada plataforma, recomendaciones de formatos y horarios de publicación.\n";
        
        // $prompt .= "Tambien incluye los guiones para videos, imagenes y texto que se van a publicar, asi como instrucciones graficas para que el equipo de diseño y edicion sepa donde colocar cada elemento.";
        // $prompt .= "Es importante que el contenido abarque la totalidad del tiempo solicitado por el usuario, asegurando que cada semana tenga contenido relevante y variado.\n";
        // $prompt .= "Crea un plan de contenido completo para" . $duration . " con una frecuencia de " . $frequency . " y " . $postCount . " publicaciones por semana.\n";
        $prompt .= "El formato de respuesta debe ser en HTML, organizado en secciones claras con títulos descriptivos.";


        try {
            $openAI = new OpenAIProvider();
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $prompt]
            ];

            $response = $openAI->chatCompletion($messages);

            $responseContent = $response['choices'][0]['message']['content'];
            
            require __DIR__ . '/../content_plan_results.php';

        } catch (Exception $e) {
            $result['error'] = $e->getMessage();
            $result['message'] = 'Error al generar el plan de contenido';
            echo var_dump($result);
        }            
    }
}