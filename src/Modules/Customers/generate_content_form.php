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
            .day-checkbox {
                display: inline-block;
                margin-right: 15px;
            }
        </style>
    </head>
    <body class="content-creator-form">
        <?php include ('../../sidebar.php'); ?>
        <div class="main-content">
            <?php include ('../../nav.php'); ?>
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 text-white d-inline-block mb-0">Generador de Contenido</h6>
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
                                        <h3 class="mb-0">Planificación de Contenidos</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="contentPlanForm" action="<?php echo $this->base_url . '/modules/customers/index.php/'.$customerId.'/content-creator/generate';?>" method="POST">
                                    <!-- Sección 1: Selección de Reglas -->
                                    <!-- Slide de configuración de la API (temperatura y modelo) -->
                                    <div class="pl-lg-4 mb-4">
                                        <h6 class="heading-small text-muted mb-4">Configuración de la API</h6>                                        
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="apiModel">
                                                        Modelo <span class="required">*</span>
                                                    </label>
                                                    <select class="form-control noselecttwo" id="apiModel" name="apiModel" required>
                                                        <option value="gpt-3.5-turbo">GPT-3.5 Turbo</option>
                                                        <option value="gpt-4">GPT-4</option>
                                                        <option value="gpt-4.1">GPT-4.1</option>
                                                        <option value="gpt-4o">GPT-4o</option>
                                                        <option value="gpt-4o-mini">GPT-4o Mini</option>
                                                        <option value="o1">GPT-o1</option>
                                                        <option value="o3">GPT-o3</option>
                                                        <option value="o4-mini">GPT-o4 Mini</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="apiTemperature">
                                                        Temperatura <span class="required">*</span>
                                                        <small class="form-text text-muted">Controla la creatividad de la IA (0 = determinista, 1 = creativo)</small>
                                                    </label>
                                                    <input type="range" class="form-control-range" id="apiTemperature" name="apiTemperature" min="0" max="1" step="0.01" value="0.7" oninput="validateTemperature(this)">
                                                    <span id="tempValue">0.7</span>
                                                </div>
                                            </div>
                                            <div class="w-100 d-block d-lg-none"></div>
                                            <!-- Para md: dos filas de 2 columnas, para lg: una fila de 4 columnas -->
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="apiTopP">
                                                        Top-p <span class="required">*</span>
                                                        <small class="form-text text-muted">Controla la diversidad de las respuestas (1 = más diverso, 0 = menos diverso)</small>
                                                    </label>
                                                    <input type="range" class="form-control-range" id="apiTopP" name="apiTopP" min="0" max="1" step="0.01" value="1" oninput="document.getElementById('topPValue').textContent = this.value">
                                                    <span id="topPValue">1</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="apiFrequencyPenalty">
                                                        Frequency Penalty
                                                        <small class="form-text text-muted">Penaliza palabras repetidas en la respuesta (-2 = mínima penalización, 0 = valor por defecto, 2 = máxima penalización)</small>
                                                    </label>
                                                    <input type="range" class="form-control-range" id="apiFrequencyPenalty" name="apiFrequencyPenalty" min="-2" max="2" step="0.01" value="0" oninput="document.getElementById('frequencyPenaltyValue').textContent = this.value">
                                                    <span id="frequencyPenaltyValue">0</span>
                                                </div>
                                            </div>
                                            <div class="w-100 d-block d-md-none"></div>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="apiPresencePenalty">
                                                        Presence Penalty
                                                        <small class="form-text text-muted">Penaliza la aparición de nuevos temas en la respuesta (-2 = mínima penalización, 0 = valor por defecto, 2 = máxima penalización)</small>
                                                    </label>
                                                    <input type="range" class="form-control-range" id="apiPresencePenalty" name="apiPresencePenalty" min="-2" max="2" step="0.01" value="0" oninput="document.getElementById('presencePenaltyValue').textContent = this.value">
                                                    <span id="presencePenaltyValue">0</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4" id="maxTokensWrapper">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="apiMaxTokens">
                                                        Máx. Tokens <span class="required">*</span>
                                                        <small class="form-text text-muted">Límite máximo de tokens generados por la IA (máx recomendado: 4096 para GPT-3.5, 8192 para GPT-4)</small>
                                                    </label>
                                                    <input type="range" class="form-control-range" id="apiMaxTokens" name="apiMaxTokens" min="256" max="32768" step="1" value="1024" oninput="document.getElementById('maxTokensValue').textContent = this.value">
                                                    <span id="maxTokensValue">1024</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-4" id="effortReasoningWrapper" style="display: none;">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="apiReasoningEffort">
                                                        Reasoning Effort <span class="required">*</span>
                                                        <small class="form-text text-muted">Nivel de esfuerzo de razonamiento de la IA (válido solo para modelos GPT-o)</small>
                                                    </label>
                                                    <select class="form-control" id="apiReasoningEffort" name="apiReasoningEffort" required>
                                                        <option value="low">Low</option>
                                                        <option value="medium" selected>Medium</option>
                                                        <option value="high">High</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">1. Reglas de Marca</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="brandRules">Selecciona las reglas de marca a aplicar <span class="required">*</span></label>
                                                    <select class="form-control" id="brandRules" name="brandRules" required>
                                                        <?php if(count($brandRules) == 0):?>
                                                            <option value="" disabled>No hay reglas de marca disponibles</option>
                                                        <?php else :?>
                                                            <option value="" disabled>Selecciona una regla de marca</option>
                                                            <?php foreach ($brandRules as $rule):?>
                                                                <option value="<?php echo $rule['id'];?>"><?php echo $rule['rule_name'];?></option>
                                                            <?php endforeach;?>  
                                                        <?php endif;?>                                                  
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <!-- Sección: Idioma principal de generación -->
                                    <div class="pl-lg-4 mb-4">
                                        <h6 class="heading-small text-muted mb-4">Idioma principal de generación</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="language">
                                                        Selecciona el idioma principal <span class="required">*</span>
                                                    </label>
                                                    <select class="form-control noselecttwo" id="language" name="language" required>
                                                        <option value="">-- Selecciona idioma --</option>
                                                        <option value="es" selected>Español</option>
                                                        <option value="en">Inglés</option>
                                                        <option value="pt">Portugués</option>
                                                        <option value="fr">Francés</option>
                                                        <option value="de">Alemán</option>
                                                        <option value="it">Italiano</option>
                                                        <option value="other">Otro</option>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-6" id="languageOtherContainer" style="display: none;"    >
                                                <div class="form-group">
                                                    <label class="form-control-label" for="language">
                                                        Selecciona el otro idioma <span class="required">*</span>
                                                    </label>
                                                    <input type="text" id="languageOther" name="languageOther" class="form-control mt-2" placeholder="Especifica idioma" style="display: none;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sección 2: Estrategia de Contenido -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">2. Estrategia de Contenido</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Frecuencia de publicación <span class="required">*</span></label>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="frequencyDaily" name="frequency" value="daily" required>
                                                        <label class="custom-control-label" for="frequencyDaily">Diaria</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="frequencyWeekly" name="frequency" value="weekly">
                                                        <label class="custom-control-label" for="frequencyWeekly">Semanal</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="frequencyMonthly" name="frequency" value="monthly">
                                                        <label class="custom-control-label" for="frequencyMonthly">Mensual</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="postCount">Cantidad de publicaciones por semana <span class="required">*</span></label>
                                                    <select class="form-control" id="postCount" name="postCount" required>
                                                        <option value="">-- Selecciona cantidad --</option>
                                                        <option value="1-2">1-2 publicaciones</option>
                                                        <option value="3-5">3-5 publicaciones</option>
                                                        <option value="6-7">6-7 publicaciones</option>
                                                        <option value="8-10">8-10 publicaciones</option>
                                                        <option value="10+">Más de 10 publicaciones</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Días de publicación preferidos</label>
                                                    <div>
                                                        <div class="day-checkbox">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="dayMonday" name="days[]" value="monday">
                                                                <label class="custom-control-label" for="dayMonday">Lunes</label>
                                                            </div>
                                                        </div>
                                                        <div class="day-checkbox">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="dayTuesday" name="days[]" value="tuesday">
                                                                <label class="custom-control-label" for="dayTuesday">Martes</label>
                                                            </div>
                                                        </div>
                                                        <div class="day-checkbox">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="dayWednesday" name="days[]" value="wednesday">
                                                                <label class="custom-control-label" for="dayWednesday">Miércoles</label>
                                                            </div>
                                                        </div>
                                                        <div class="day-checkbox">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="dayThursday" name="days[]" value="thursday">
                                                                <label class="custom-control-label" for="dayThursday">Jueves</label>
                                                            </div>
                                                        </div>
                                                        <div class="day-checkbox">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="dayFriday" name="days[]" value="friday">
                                                                <label class="custom-control-label" for="dayFriday">Viernes</label>
                                                            </div>
                                                        </div>
                                                        <div class="day-checkbox">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="daySaturday" name="days[]" value="saturday">
                                                                <label class="custom-control-label" for="daySaturday">Sábado</label>
                                                            </div>
                                                        </div>
                                                        <div class="day-checkbox">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="daySunday" name="days[]" value="sunday">
                                                                <label class="custom-control-label" for="daySunday">Domingo</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Horarios preferidos de publicación</label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Mañana (8am - 12pm)</label>
                                                                <input type="time" class="form-control" name="morningTime" value="09:00">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Tarde (12pm - 6pm)</label>
                                                                <input type="time" class="form-control" name="afternoonTime" value="15:00">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Noche (6pm - 10pm)</label>
                                                                <input type="time" class="form-control" name="eveningTime" value="19:00">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Fines de semana</label>
                                                                <input type="time" class="form-control" name="weekendTime" value="11:00">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 3: Redes Sociales -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">3. Plataformas de Redes Sociales</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Selecciona las plataformas objetivo <span class="required">*</span></label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformFacebook" name="platforms[]" value="facebook">
                                                                <label class="custom-control-label" for="platformFacebook">Facebook</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformInstagram" name="platforms[]" value="instagram">
                                                                <label class="custom-control-label" for="platformInstagram">Instagram</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformTwitter" name="platforms[]" value="twitter">
                                                                <label class="custom-control-label" for="platformTwitter">Twitter</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformLinkedin" name="platforms[]" value="linkedin">
                                                                <label class="custom-control-label" for="platformLinkedin">LinkedIn</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformTiktok" name="platforms[]" value="tiktok">
                                                                <label class="custom-control-label" for="platformTiktok">TikTok</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformPinterest" name="platforms[]" value="pinterest">
                                                                <label class="custom-control-label" for="platformPinterest">Pinterest</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformYoutube" name="platforms[]" value="youtube">
                                                                <label class="custom-control-label" for="platformYoutube">YouTube</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformBlog" name="platforms[]" value="blog">
                                                                <label class="custom-control-label" for="platformBlog">Blog Corporativo</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="platformOther" name="platforms[]" value="other">
                                                                <label class="custom-control-label" for="platformOther">Otra</label>
                                                                <input type="text" id="platformOtherText" name="platformOtherText" class="form-control mt-2" placeholder="Especifica plataforma" style="display: none;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 4: Tipos de Contenido -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">4. Tipos de Contenido</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Distribución de tipos de contenido <span class="required">*</span></label>
                                                    <small class="form-text text-muted">Define el porcentaje aproximado para cada tipo (la suma debe ser 100%)</small>
                                                    
                                                    <div class="row mt-3">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="contentEducational">Educativo (guías, tips)</label>
                                                                <input type="number" id="contentEducational" name="contentEducational" class="form-control" min="0" max="100" value="30">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="contentPromotional">Promocional (productos/servicios)</label>
                                                                <input type="number" id="contentPromotional" name="contentPromotional" class="form-control" min="0" max="100" value="20">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="contentEntertainment">Entretenimiento</label>
                                                                <input type="number" id="contentEntertainment" name="contentEntertainment" class="form-control" min="0" max="100" value="20">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="contentCommunity">Construcción de comunidad</label>
                                                                <input type="number" id="contentCommunity" name="contentCommunity" class="form-control" min="0" max="100" value="15">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="contentTrends">Trends/Actualidad</label>
                                                                <input type="number" id="contentTrends" name="contentTrends" class="form-control" min="0" max="100" value="10">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="contentOther">Otros</label>
                                                                <input type="number" id="contentOther" name="contentOther" class="form-control" min="0" max="100" value="5">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="progress">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-dark" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <small id="totalPercentage" class="form-text text-muted text-right">Total: 100%</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 5: Temáticas y Palabras Clave -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">5. Temáticas y Palabras Clave</h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="mainThemes">Temáticas principales (separadas por comas) <span class="required">*</span></label>
                                                    <textarea id="mainThemes" name="mainThemes" class="form-control" required rows="2" placeholder="Ej: sostenibilidad, innovación tecnológica, bienestar laboral"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="keywords">Palabras clave principales</label>
                                                    <input type="text" id="keywords" name="keywords" class="form-control" placeholder="Ej: marketing digital, transformación digital, growth hacking">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="hashtags">Hashtags recurrentes</label>
                                                    <input type="text" id="hashtags" name="hashtags" class="form-control" placeholder="Ej: #MarketingDigital #Innovación #Negocios">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 6: Recursos y Requerimientos -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">6. Recursos y Requerimientos</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Disponibilidad de recursos</label>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="resourcesHigh" name="resources" value="high">
                                                        <label class="custom-control-label" for="resourcesHigh">Alta (equipo creativo interno)</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="resourcesMedium" name="resources" value="medium">
                                                        <label class="custom-control-label" for="resourcesMedium">Media (algunos recursos externos)</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mb-3">
                                                        <input type="radio" class="custom-control-input" id="resourcesLow" name="resources" value="low">
                                                        <label class="custom-control-label" for="resourcesLow">Baja (solo contenido básico)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="contentRequirements">Requerimientos específicos de contenido</label>
                                                    <textarea id="contentRequirements" name="contentRequirements" class="form-control" rows="3" placeholder="Ej: Necesitamos incluir el logo en todas las imágenes, usar solo fotos originales..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label">Formatos preferidos</label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="formatImages" name="formats[]" value="images" checked>
                                                                <label class="custom-control-label" for="formatImages">Imágenes</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="formatVideos" name="formats[]" value="videos">
                                                                <label class="custom-control-label" for="formatVideos">Videos</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="formatCarousels" name="formats[]" value="carousels">
                                                                <label class="custom-control-label" for="formatCarousels">Carruseles</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="formatStories" name="formats[]" value="stories">
                                                                <label class="custom-control-label" for="formatStories">Stories/Reels</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="formatBlogs" name="formats[]" value="blogs">
                                                                <label class="custom-control-label" for="formatBlogs">Artículos/Blogs</label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox mb-3">
                                                                <input type="checkbox" class="custom-control-input" id="formatOther" name="formats[]" value="other">
                                                                <label class="custom-control-label" for="formatOther">Otro</label>
                                                                <input type="text" id="formatOtherText" name="formatOtherText" class="form-control mt-2" placeholder="Especifica formato" style="display: none;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">

                                    <!-- Sección 7: Calendario y Eventos -->
                                    <div class="pl-lg-4">
                                        <h6 class="heading-small text-muted mb-4">7. Calendario y Eventos</h6>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="startDate">Fecha de inicio <span class="required">*</span></label>
                                                    <input type="date" id="startDate" name="startDate" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="duration">Duración del plan</label>
                                                    <select class="form-control" id="duration" name="duration">
                                                        <option value="1-month">1 mes</option>
                                                        <option value="3-months" selected>3 meses</option>
                                                        <option value="6-months">6 meses</option>
                                                        <option value="1-year">1 año</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="specialDates">Fechas especiales a considerar</label>
                                                    <textarea id="specialDates" name="specialDates" class="form-control" rows="3" placeholder="Ej: Lanzamiento de producto 15/10, Black Friday, Navidad..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" id="submitContentBtn" class="btn btn-primary mt-4">Generar Plan de Contenidos</button>
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
            var modelMaxTokens = <?php echo json_encode($modelMaxTokens); ?>;
            var modelCostsPerMillionTokens = <?php echo json_encode($modelCostsPerMillionTokens); ?>;
            
            function validateTemperature(_this) {
                const apiModelSelect = document.getElementById('apiModel');
                if (apiModelSelect.value.startsWith('o')){
                    _this.value = '1';
                    document.getElementById('tempValue').textContent = '1.0';
                }else{
                    document.getElementById('tempValue').textContent = _this.value;
                }
            }                                 
            window.addEventListener('DOMContentLoaded', function() {
                const languageSelect = document.getElementById('language');
                const apiModelSelect = document.getElementById('apiModel');
                const apiMaxTokensInput = document.getElementById('apiMaxTokens');
                const maxTokensValueSpan = document.getElementById('maxTokensValue');

                apiMaxTokensInput.addEventListener('change', function() {
                    const selectedModel = apiModelSelect.value;
                    const maxTokens = parseInt(this.value) || 0;
                    const costPerMillion = modelCostsPerMillionTokens[selectedModel] || 0;
                    const approxCost = ((maxTokens / 1000000) * costPerMillion).toFixed(4);
                    maxTokensValueSpan.innerHTML = `${this.value} <span style="color:#e55353;font-weight:bold;">(~$${approxCost}</span><span style="color:#e55353;">)</span>`;
                    // maxTokensValueSpan.textContent = this.value;
                });

                if (window.jQuery && typeof $(apiModelSelect).select2 === 'function') {
                    $(apiModelSelect).val('gpt-4.1').trigger('change');
                    $(apiModelSelect).select2({
                        width: '100%',
                        placeholder: '-- Selecciona el modelo --',
                        allowClear: true
                    }).on('change', function(e) {
                        const effortReasoningWrapper = document.getElementById('effortReasoningWrapper');
                        const maxTokensWrapper = document.getElementById('maxTokensWrapper');

                        if (apiModelSelect.value.startsWith('o')) {
                            effortReasoningWrapper.style.display = 'block';
                            maxTokensWrapper.style.display = 'none';
                            document.getElementById('apiTemperature').value = '1';
                            document.getElementById('tempValue').textContent = '1.0';
                        } else {
                            effortReasoningWrapper.style.display = 'none';
                            maxTokensWrapper.style.display = 'block';                            
                        }
                        function updateMaxTokensRange() {
                            const selectedModel = apiModelSelect.value;
                            const maxTokens = modelMaxTokens[selectedModel] || 4096;
                            apiMaxTokensInput.max = maxTokens;
                            if (parseInt(apiMaxTokensInput.value) > maxTokens) {
                                apiMaxTokensInput.value = maxTokens;
                                maxTokensValueSpan.textContent = maxTokens;
                            }
                        }
                        updateMaxTokensRange();
                        maxTokensValueSpan.textContent = apiMaxTokensInput.value;
                    });
                }

                if (window.jQuery && typeof $(languageSelect).select2 === 'function') {
                    $(languageSelect).select2({
                        width: '100%',
                        placeholder: '-- Selecciona idioma --',
                        allowClear: true
                    }).on('change', function(e) {
                        const otherInput = document.getElementById('languageOther');
                        const otherInputContainer = document.getElementById('languageOtherContainer');
                        if (this.value === 'other') {
                            otherInput.style.display = 'block';
                            otherInput.required = true;
                            otherInput.focus();
                            otherInputContainer.style.display = 'block';
                        } else {
                            otherInput.style.display = 'none';
                            otherInput.required = false;
                            otherInput.value = '';
                            otherInputContainer.style.display = 'none';
                        }
                    });
                }

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

                // Validar que la suma de porcentajes sea 100%
                const percentageInputs = document.querySelectorAll('input[name^="content"]');
                percentageInputs.forEach(input => {
                    input.addEventListener('change', updateTotalPercentage);
                    input.addEventListener('keyup', updateTotalPercentage);
                });

                function updateTotalPercentage() {
                    let total = 0;
                    percentageInputs.forEach(input => {
                        const value = parseInt(input.value) || 0;
                        total += value;
                    });
                    
                    document.getElementById('totalPercentage').textContent = `Total: ${total}%`;
                    
                    if (total !== 100) {
                        document.getElementById('totalPercentage').classList.add('text-danger');
                        document.getElementById('submitContentBtn').disabled = true;
                    } else {
                        document.getElementById('totalPercentage').classList.remove('text-danger');
                        document.getElementById('submitContentBtn').disabled = false;
                    }
                }

                 // Manejar envío del formulario
                document.querySelector('#submitContentBtn').addEventListener('click', function(event) {
                    event.preventDefault();
                    event.target.disabled = true;
                    const form = document.getElementById('contentPlanForm');
                    
                    if (!form.checkValidity()) {
                        form.reportValidity();
                        event.target.disabled = false;
                        return;
                    }

                    // Validar porcentajes
                    let total = 0;
                    percentageInputs.forEach(input => {
                        total += parseInt(input.value) || 0;
                    });
                    
                    if (total !== 100) {
                        alert('La suma de los porcentajes de tipos de contenido debe ser exactamente 100%');
                        event.target.disabled = false;
                        return;
                    }

                    // Si todo es válido, enviar el formulario
                    form.submit();
                });

                const today = new Date();
                today.setDate(today.getDate() + 2);
                const dateStr = today.toISOString().split('T')[0];
                document.getElementById('startDate').value = dateStr;
                
                // Inicializar el cálculo de porcentajes
                updateTotalPercentage();
            });
            
        </script>
    </body>
</html>