<?php
    namespace Se7entech\Contractnew\Modules\AdminAIRequests;

    global $base_url, $con;

    require_once __DIR__ . '/../../../config/config.php';
    require_once __DIR__ . '/../../../connection.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once __DIR__ . '/../../../layout/head.php';?>
        <style>
            .badge-draft {
                background-color: #ffe69c;
                color: #856404;
            }
            .badge-submitted {
                background-color: #c3e6cb;
                color: #155724;
            }
            /* Chat bubble styling */
            .chat-history-container {
                max-height: 450px;
                overflow-y: auto;
                background-color: #f8f9fe;
                padding: 20px;
                border-radius: 8px;
                display: flex;
                flex-direction: column;
                gap: 15px;
                border: 1px solid #e9ecef;
            }
            .chat-bubble {
                max-width: 80%;
                padding: 12px 16px;
                border-radius: 12px;
                font-size: 0.9rem;
                line-height: 1.4;
                box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            }
            .chat-bubble-user {
                align-self: flex-end;
                background: linear-gradient(135deg, #5e72e4 0%, #324cdd 100%);
                color: white;
                border-bottom-right-radius: 0;
            }
            .chat-bubble-assistant {
                align-self: flex-start;
                background-color: white;
                color: #2b354e;
                border-bottom-left-radius: 0;
                border: 1px solid #e9ecef;
            }
            .chat-bubble-meta {
                font-size: 0.75rem;
                color: rgba(255,255,255,0.7);
                margin-top: 5px;
                text-align: right;
            }
            .chat-bubble-assistant .chat-bubble-meta {
                color: #8898aa;
            }
            .spec-preview-box {
                max-height: 400px;
                overflow-y: auto;
                background-color: #fafbfc;
                border: 1px solid #e9ecef;
                padding: 20px;
                border-radius: 8px;
                font-size: 0.9rem;
                line-height: 1.6;
            }
        </style>
    </head>
    <body class="">
        <?php include __DIR__ . '/../../../sidebar.php'; ?>
        <div class="main-content">
            <?php include __DIR__ . '/../../../nav.php'; ?>
            
            <div class="header bg-gradient-info pb-6 pt-5 pt-md-8">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="text-white mb-1"><i class="ni ni-spaceship mr-2"></i> Requerimientos de Proyecto IA</h2>
                            <p class="text-light mb-0">Revisión y auditoría de especificaciones técnicas levantadas con el Asistente IA conversacional.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header border-0 bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">Lista de Requerimientos Recibidos</h3>
                                </div>
                            </div>
                            <div class="card-body py-4" style="overflow-x:hidden;">
                                <table id="admin-ai-requests-table" class="table table-bordered table-striped display responsive" style="width:100%">
                                    <thead style="background:#5e72e4;color:white;">
                                        <tr>
                                            <th width="8%">ID</th>
                                            <th width="20%">Cliente/Empresa</th>
                                            <th width="25%">Proyecto (Título)</th>
                                            <th width="12%">Progreso</th>
                                            <th width="10%">Estado</th>
                                            <th width="12%">Última Actualización</th>
                                            <th width="13%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(count($this->data['records'])): ?>
                                            <?php foreach($this->data['records'] as $record): 
                                                $customerName = htmlspecialchars($record['customer_business_name'] ?: $record['customer_name'] ?: 'Cliente Desconocido');
                                                $statusClass = $record['status'] === 'submitted' ? 'badge-submitted' : 'badge-draft';
                                                $statusText = $record['status'] === 'submitted' ? 'Enviado' : 'Borrador';
                                            ?>
                                                <tr>
                                                    <td><strong>#AI-<?php echo $record['id']; ?></strong></td>
                                                    <td>
                                                        <span class="d-block font-weight-bold text-dark"><?php echo $customerName; ?></span>
                                                        <small class="text-muted"><?php echo htmlspecialchars($record['customer_email']); ?></small>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($record['subject'] ?: 'Sin título registrado'); ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="mr-2 font-weight-bold"><?php echo $record['progress']; ?>%</span>
                                                            <div class="progress" style="width: 70px; height: 5px; margin-bottom: 0;">
                                                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo $record['progress']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $record['progress']; ?>%;"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                                    </td>
                                                    <td><?php echo date('d/m/Y H:i', strtotime($record['updated_at'])); ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-primary btn-sm" 
                                                                    data-toggle="modal" 
                                                                    data-target="#specModal" 
                                                                    data-id="<?php echo $record['id']; ?>"
                                                                    data-subject="<?php echo htmlspecialchars($record['subject']); ?>"
                                                                    data-summary="<?php echo htmlspecialchars($record['summary']); ?>"
                                                                    data-details="<?php echo htmlspecialchars($record['details']); ?>"
                                                                    title="Ver especificación completa">
                                                                <i class="fa fa-file-text"></i> Detalle
                                                            </button>
                                                            <button class="btn btn-info btn-sm" 
                                                                    data-toggle="modal" 
                                                                    data-target="#chatModal" 
                                                                    data-id="<?php echo $record['id']; ?>"
                                                                    title="Ver transcripción de chat">
                                                                <i class="fa fa-comments"></i> Chat
                                                            </button>
                                                            <?php if (!empty($record['pdf_path'])): ?>
                                                                <a href="<?php echo $this->base_url . '/' . $record['pdf_path']; ?>" 
                                                                   target="_blank" 
                                                                   class="btn btn-danger btn-sm" 
                                                                   title="Descargar PDF Oficial">
                                                                    <i class="fa fa-file-pdf-o"></i> PDF
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between"></div>
            </footer>
        </div>

        <!-- Spec Detail Modal -->
        <div class="modal fade" id="specModal" tabindex="-1" role="dialog" aria-labelledby="specModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold text-primary" id="specModalLabel">Especificación Técnica Levantada</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-secondary">
                        <div class="card shadow-sm border-0 mb-3 bg-white">
                            <div class="card-body">
                                <h5 class="card-title text-muted mb-1 font-weight-bold">Título del Proyecto</h5>
                                <h3 id="modal-spec-subject" class="font-weight-bold text-dark"></h3>
                            </div>
                        </div>
                        
                        <div class="card shadow-sm border-0 mb-3 bg-white">
                            <div class="card-body">
                                <h5 class="card-title text-muted mb-1 font-weight-bold">Resumen Ejecutivo</h5>
                                <p id="modal-spec-summary" class="text-justify text-dark" style="font-size:0.95rem; font-style:italic;"></p>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 bg-white">
                            <div class="card-body">
                                <h5 class="card-title text-muted mb-2 font-weight-bold">Especificaciones Detalladas</h5>
                                <div id="modal-spec-details" class="spec-preview-box text-dark"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Transcript Modal -->
        <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title font-weight-bold text-primary" id="chatModalLabel">Transcripción de Chat del Asistente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-secondary">
                        <div id="chat-loading" class="text-center py-4">
                            <i class="fa fa-spinner fa-spin fa-2x text-primary mb-2"></i>
                            <p class="text-muted mb-0">Cargando transcripción del chat...</p>
                        </div>
                        <div id="chat-history-wrapper" style="display:none;">
                            <div class="chat-history-container" id="chat-bubbles-list"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include __DIR__ . '/../../../layout/footer_scripts.php';?>
        
        <script>
            function formatMarkdown(text) {
                if (!text) return '<em class="text-muted">No hay especificaciones detalladas registradas aún.</em>';
                // Simple custom markdown-to-html compiler
                return text
                    .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;") // Escape tags
                    .replace(/\\n/g, '\n')
                    .replace(/### (.*?)\r?\n/g, '<h5 class="text-primary mt-3 font-weight-bold" style="color:#5e72e4; margin-top:16px;">$1</h5>')
                    .replace(/## (.*?)\r?\n/g, '<h4 class="text-primary mt-4 font-weight-bold" style="color:#5e72e4; margin-top:20px;">$1</h4>')
                    .replace(/# (.*?)\r?\n/g, '<h3 class="text-primary mt-4 font-weight-bold" style="color:#5e72e4; margin-top:24px;">$1</h3>')
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/- (.*?)\r?\n/g, '<li>$1</li>')
                    .replace(/(<li>.*?<\/li>)+/gs, '<ul style="padding-left: 20px;">$0</ul>')
                    .replace(/\n/g, '<br>');
            }

            $(document).ready(function(){
                // Initialize datatable
                $('#admin-ai-requests-table').DataTable({
                    responsive: true,
                    order: [[ 0, "desc" ]], // Order by ID descending
                });

                // Handle Spec Detail Modal events
                $('#specModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var subject = button.data('subject') || 'Sin título';
                    var summary = button.data('summary') || 'Sin resumen registrado';
                    var details = button.data('details') || '';

                    var modal = $(this);
                    modal.find('#modal-spec-subject').text(subject);
                    modal.find('#modal-spec-summary').text(summary);
                    modal.find('#modal-spec-details').html(formatMarkdown(details));
                });

                // Handle Chat Modal events
                $('#chatModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');

                    var modal = $(this);
                    modal.find('#chat-loading').show();
                    modal.find('#chat-history-wrapper').hide();
                    modal.find('#chat-bubbles-list').empty();

                    $.ajax({
                        url: '<?php echo $this->base_url; ?>/modules/admin-ai-requests/index.php/chat-history/' + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            modal.find('#chat-loading').hide();
                            if (res.success) {
                                var bubblesHtml = '';
                                if (res.history && res.history.length > 0) {
                                    res.history.forEach(function(msg) {
                                        var isUser = msg.role === 'user';
                                        var roleName = isUser ? 'Cliente' : 'Asistente IA';
                                        var bubbleClass = isUser ? 'chat-bubble-user' : 'chat-bubble-assistant';
                                        
                                        bubblesHtml += '<div class="chat-bubble ' + bubbleClass + '">';
                                        bubblesHtml += '<div>' + formatMarkdown(msg.content) + '</div>';
                                        bubblesHtml += '<div class="chat-bubble-meta">' + roleName + '</div>';
                                        bubblesHtml += '</div>';
                                    });
                                } else {
                                    bubblesHtml = '<p class="text-muted text-center py-3">No hay historial de chat registrado para este requerimiento.</p>';
                                }
                                modal.find('#chat-bubbles-list').html(bubblesHtml);
                                modal.find('#chat-history-wrapper').show();
                                
                                // Scroll chat container to bottom
                                setTimeout(function() {
                                    var chatContainer = modal.find('.chat-history-container')[0];
                                    if (chatContainer) {
                                        chatContainer.scrollTop = chatContainer.scrollHeight;
                                    }
                                }, 100);
                            } else {
                                modal.find('#chat-bubbles-list').html('<p class="text-danger text-center py-3">Error al obtener el historial: ' + res.error + '</p>');
                                modal.find('#chat-history-wrapper').show();
                            }
                        },
                        error: function() {
                            modal.find('#chat-loading').hide();
                            modal.find('#chat-bubbles-list').html('<p class="text-danger text-center py-3">Error de conexión al cargar la conversación.</p>');
                            modal.find('#chat-history-wrapper').show();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
