<?php

namespace Se7entech\Contractnew\Modules\Customers\Controllers;

use Se7entech\Contractnew\Modules\Customers\Models\CustomersModel;
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

    public function generateBrandRules()
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
        
        // Mostrar el prompt generado (en un entorno real, aquí lo enviarías a la API de IA)
        // header('Content-Type: text/plain; charset=utf-8');
        // echo "PROMPT GENERADO PARA IA:\n\n";
        // echo $prompt;
        
        // En un caso real, aquí iría la conexión a la API de IA
        // $iaResponse = enviarAIA($prompt);
        // echo $iaResponse;
           
            
    }
}