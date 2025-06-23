<?php
    namespace Se7entech\Contractnew\Modules\Customers;
    
    require('../../config/config.php');
    require('../../connection.php');
?>
<html lang="en">
    <head>
        <?php include_once('../../layout/head.php');?>
        <style>
            .required{
                color:red;
            }
        </style>
    </head>
    <body class="">
        <?php include ('../../sidebar.php'); ?>
        <div class="main-content">
            <?php include ('../../nav.php'); ?>
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 text-white d-inline-block mb-0">Brand Personality</h6>
                                <!-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="#">Brand</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Personality</li>
                                    </ol>
                                </nav> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top navbar -->
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Definición de Personalidad de Marca</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="brandPersonalityForm" action="<?php echo $this->base_url . '/modules/customers/index.php/'. $customerId .'/brand-rules/generate';?>" method="POST">
                                    <!-- Sección 1: Identidad Básica -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">1. Identidad Básica</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="brandName">Nombre de la marca <span class="required">*</span></label>
                                                    <input type="text" id="brandName" name="brandName" class="form-control" required placeholder="Ej: Mi Marca">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="industry">Rubro/Industria <span class="required">*</span></label>
                                                    <input type="text" id="industry" name="industry" class="form-control" required placeholder="Ej: Tecnología, Moda, Educación, Salud">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="brandDescription">Descripción breve <span class="required">*</span></label>
                                                    <small class="form-text text-muted">Completa: "Somos [quién son] que ayudamos a [qué necesidad resuelven] a través de [qué ofrecen]"</small>
                                                    <textarea id="brandDescription" name="brandDescription" class="form-control" required rows="3" placeholder="Ej: Somos una consultoría digital que ayudamos a pequeñas empresas a incrementar sus ventas a través de estrategias de marketing personalizadas"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 2: Propósito de Marca -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">2. Propósito de Marca</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Objetivo principal con la comunicación <span class="required">*</span></label>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="goalCommunity" name="goals[]" value="community">
                                                        <label class="custom-control-label" for="goalCommunity">Construir comunidad</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="goalSales" name="goals[]" value="sales">
                                                        <label class="custom-control-label" for="goalSales">Generar ventas/conversiones</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="goalAuthority" name="goals[]" value="authority">
                                                        <label class="custom-control-label" for="goalAuthority">Posicionamiento de autoridad</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="goalEducate" name="goals[]" value="educate">
                                                        <label class="custom-control-label" for="goalEducate">Educar/informar</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="goalOther" name="goals[]" value="other">
                                                        <label class="custom-control-label" for="goalOther">Otro</label>
                                                        <input type="text" id="goalOtherText" name="goalOtherText" class="form-control mt-2" placeholder="Describe tu objetivo" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Atributos clave (elige 3-5) <span class="required">*</span></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="attrInnovative" name="attributes[]" value="innovative">
                                                                <label class="custom-control-label" for="attrInnovative">Innovador</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="attrEmpathetic" name="attributes[]" value="empathetic">
                                                                <label class="custom-control-label" for="attrEmpathetic">Cercano/empático</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="attrLuxury" name="attributes[]" value="luxury">
                                                                <label class="custom-control-label" for="attrLuxury">Lujoso/exclusivo</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="attrFun" name="attributes[]" value="fun">
                                                                <label class="custom-control-label" for="attrFun">Divertido</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="attrReliable" name="attributes[]" value="reliable">
                                                                <label class="custom-control-label" for="attrReliable">Confiable/seguro</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="attrRebel" name="attributes[]" value="rebel">
                                                                <label class="custom-control-label" for="attrRebel">Rebelde/atrevido</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="attrOther" name="attributes[]" value="other">
                                                        <label class="custom-control-label" for="attrOther">Otros</label>
                                                        <input type="text" id="attrOtherText" name="attrOtherText" class="form-control mt-2" placeholder="Escribe tus atributos" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 3: Público Objetivo -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">3. Público Objetivo</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="targetDemographic">Demográfico principal <span class="required">*</span></label>
                                                    <input type="text" id="targetDemographic" name="targetDemographic" class="form-control" required placeholder="Ej: Mujeres 25-40, Startups en crecimiento, Padres millennials">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Estilo de comunicación que conecta con ellos <span class="required">*</span></label>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="commFormal" name="communicationStyle" value="formal">
                                                        <label class="custom-control-label" for="commFormal">Formal/profesional</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="commRelaxed" name="communicationStyle" value="relaxed">
                                                        <label class="custom-control-label" for="commRelaxed">Relajado/coloquial</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="commMotivational" name="communicationStyle" value="motivational">
                                                        <label class="custom-control-label" for="commMotivational">Motivacional/inspirador</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="commHumor" name="communicationStyle" value="humor">
                                                        <label class="custom-control-label" for="commHumor">Humorístico/desenfadado</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="commOther" name="communicationStyle" value="other">
                                                        <label class="custom-control-label" for="commOther">Otro</label>
                                                        <input type="text" id="commOtherText" name="commOtherText" class="form-control mt-2" placeholder="Describe el estilo" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 4: Personalidad de Marca -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">4. Personalidad de Marca</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Si tu marca fuera una persona, sería: <span class="required">*</span></label>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="personaExpert" name="brandPersona" value="expert">
                                                        <label class="custom-control-label" for="personaExpert">Un experto confiable</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="personaFriend" name="brandPersona" value="friend">
                                                        <label class="custom-control-label" for="personaFriend">Un amigo cercano</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="personaMentor" name="brandPersona" value="mentor">
                                                        <label class="custom-control-label" for="personaMentor">Un mentor inspirador</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="personaInnovator" name="brandPersona" value="innovator">
                                                        <label class="custom-control-label" for="personaInnovator">Un innovador visionario</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="personaOther" name="brandPersona" value="other">
                                                        <label class="custom-control-label" for="personaOther">Otro</label>
                                                        <input type="text" id="personaOtherText" name="personaOtherText" class="form-control mt-2" placeholder="Describe la personalidad" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Tono de voz preferido <span class="required">*</span></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="toneEmotional" name="tones[]" value="emotional">
                                                                <label class="custom-control-label" for="toneEmotional">Emocional/empático</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="toneDirect" name="tones[]" value="direct">
                                                                <label class="custom-control-label" for="toneDirect">Directo/práctico</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="toneSophisticated" name="tones[]" value="sophisticated">
                                                                <label class="custom-control-label" for="toneSophisticated">Sofisticado/elegante</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="toneProvocative" name="tones[]" value="provocative">
                                                                <label class="custom-control-label" for="toneProvocative">Irreverente/provocativo</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="toneOther" name="tones[]" value="other">
                                                        <label class="custom-control-label" for="toneOther">Otro</label>
                                                        <input type="text" id="toneOtherText" name="toneOtherText" class="form-control mt-2" placeholder="Describe el tono" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 5: Estilo Visual -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">5. Estilo Visual</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Paleta de estilo (elige hasta 2 principales)</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="styleMinimalist" name="styles[]" value="minimalist">
                                                                <label class="custom-control-label" for="styleMinimalist">Minimalista</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="styleVibrant" name="styles[]" value="vibrant">
                                                                <label class="custom-control-label" for="styleVibrant">Vibrante/colorido</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="styleRetro" name="styles[]" value="retro">
                                                                <label class="custom-control-label" for="styleRetro">Retro/vintage</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="styleFuturistic" name="styles[]" value="futuristic">
                                                                <label class="custom-control-label" for="styleFuturistic">Futurista/tech</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="styleOrganic" name="styles[]" value="organic">
                                                                <label class="custom-control-label" for="styleOrganic">Orgánico/natural</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="styleOther" name="styles[]" value="other">
                                                        <label class="custom-control-label" for="styleOther">Otro</label>
                                                        <input type="text" id="styleOtherText" name="styleOtherText" class="form-control mt-2" placeholder="Describe tu estilo" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Tratamiento de imágenes</label>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="imagesClean" name="imageTreatment" value="clean">
                                                        <label class="custom-control-label" for="imagesClean">Solo visuales limpios (sin texto)</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="imagesInspirational" name="imageTreatment" value="inspirational">
                                                        <label class="custom-control-label" for="imagesInspirational">Imágenes con frases inspiradoras</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="imagesEducational" name="imageTreatment" value="educational">
                                                        <label class="custom-control-label" for="imagesEducational">Imágenes con datos/educativos</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="imagesOther" name="imageTreatment" value="other">
                                                        <label class="custom-control-label" for="imagesOther">Otro</label>
                                                        <input type="text" id="imagesOtherText" name="imagesOtherText" class="form-control mt-2" placeholder="Describe tu enfoque" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 6: Contenido Prioritario -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">6. Contenido Prioritario</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Formatos que mejor representan tu marca (elige hasta 3)</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="contentEducational" name="contentTypes[]" value="educational">
                                                                <label class="custom-control-label" for="contentEducational">Educativo (guías, tips)</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="contentEntertainment" name="contentTypes[]" value="entertainment">
                                                                <label class="custom-control-label" for="contentEntertainment">Entretenimiento (humor, trends)</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="contentBTS" name="contentTypes[]" value="bts">
                                                                <label class="custom-control-label" for="contentBTS">Behind the scenes</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="contentTestimonials" name="contentTypes[]" value="testimonials">
                                                                <label class="custom-control-label" for="contentTestimonials">Testimonios/clientes reales</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="contentPromotions" name="contentTypes[]" value="promotions">
                                                        <label class="custom-control-label" for="contentPromotions">Promociones/ofertas</label>
                                                    </div>
                                                    <div class="custom-control custom-checkbox mb-3">
                                                        <input type="checkbox" class="custom-control-input" id="contentOther" name="contentTypes[]" value="other">
                                                        <label class="custom-control-label" for="contentOther">Otro</label>
                                                        <input type="text" id="contentOtherText" name="contentOtherText" class="form-control mt-2" placeholder="Describe el formato" style="display: none;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 7: Lo Que NO Somos -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">7. Lo Que NO Somos</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="avoidWords">Palabras o conceptos que NO quieres asociar a tu marca</label>
                                                    <input type="text" id="avoidWords" name="avoidWords" class="form-control" placeholder="Ej: barato, masivo, tradicional">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="avoidBrands">Marcas/competidores cuyo estilo NO te identifica</label>
                                                    <input type="text" id="avoidBrands" name="avoidBrands" class="form-control" placeholder="Ej: [Nombre de marca] porque...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 8: Diferenciadores Clave -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">8. Diferenciadores Clave</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="uniqueValue">¿Qué te hace único? <span class="required">*</span></label>
                                                    <small class="form-text text-muted">Fórmula: "Somos los únicos que [valor] para [audiencia] porque [razón]"</small>
                                                    <textarea id="uniqueValue" name="uniqueValue" class="form-control" required rows="3" placeholder="Ej: Somos los únicos que ofrecemos diseño web en 24 horas para emprendedores porque tenemos un sistema de trabajo ágil y especializado"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="distinctiveElement">Elemento distintivo recurrente (color, símbolo, estilo)</label>
                                                    <input type="text" id="distinctiveElement" name="distinctiveElement" class="form-control" placeholder="Ej: Nuestro morado característico, un ícono de hoja, fotos con sombras largas...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 9: Adaptaciones Culturales -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">9. Adaptaciones Culturales</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">¿Incluir modismos o referencias locales?</label>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="localYes" name="localReferences" value="yes">
                                                        <label class="custom-control-label" for="localYes">Sí</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="localNo" name="localReferences" value="no">
                                                        <label class="custom-control-label" for="localNo">No</label>
                                                    </div>
                                                    <input type="text" id="localExamples" name="localExamples" class="form-control mt-2" placeholder="¿Cuáles? Ej: modismos, festividades..." style="display: none;">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">¿Aprovechar fechas/eventos específicos?</label>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="eventsYes" name="specialEvents" value="yes">
                                                        <label class="custom-control-label" for="eventsYes">Sí</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="eventsNo" name="specialEvents" value="no">
                                                        <label class="custom-control-label" for="eventsNo">No</label>
                                                    </div>
                                                    <input type="text" id="eventsExamples" name="eventsExamples" class="form-control mt-2" placeholder="¿Cuáles? Ej: Navidad, Día de la Madre..." style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 10: Referencias e Inspiración -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">10. Referencias e Inspiración</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="admiredBrands">Marcas que admiras (aunque no sean de tu rubro)</label>
                                                    <input type="text" id="admiredBrands" name="admiredBrands" class="form-control" placeholder="Ej: Apple, Patagonia, Glossier...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="communicationExample">Ejemplo de comunicación que te gustaría emular</label>
                                                    <textarea id="communicationExample" name="communicationExample" class="form-control" rows="3" placeholder="Ej: 'Me encanta cómo [marca] usa un tono [descriptivo] en sus [canales] para hablar de [tema]'"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" id="submit_btn" class="btn btn-primary mt-4">Generar Reglas de Marca</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="row align-items-center justify-content-xl-between"></div>
        </footer>
        <?php include '../../layout/footer_scripts.php';?>
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

            document.querySelector('#submit_btn').addEventListener('click', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario por defecto
                event.target.disabled = true; // Deshabilitar el botón para evitar múltiples envíos
                const form = document.getElementById('brandPersonalityForm');
                
                // Validar campos requeridos
                if (!form.checkValidity()) {
                    form.reportValidity(); // Mostrar mensajes de error
                    event.target.disabled = false; // Rehabilitar el botón si hay errores
                    return;
                }

                // Si todo es válido, enviar el formulario
                form.submit();
            });
        </script>
    </body>
</html>