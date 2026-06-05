import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import { 
  Box, 
  Typography, 
  Button, 
  Paper, 
  Grid, 
  Card, 
  CardContent, 
  CardActions, 
  LinearProgress, 
  Chip, 
  IconButton, 
  CircularProgress,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogContentText,
  DialogActions
} from '@mui/material';
import AutoAwesomeIcon from '@mui/icons-material/AutoAwesome';
import DeleteIcon from '@mui/icons-material/Delete';
import ChatIcon from '@mui/icons-material/Chat';
import VisibilityIcon from '@mui/icons-material/Visibility';
import PictureAsPdfIcon from '@mui/icons-material/PictureAsPdf';
import AddIcon from '@mui/icons-material/Add';

export function init() {
  const App = () => {
    const [isLoading, setIsLoading] = useState(true);
    const [requests, setRequests] = useState([]);
    const [deleteDialogOpen, setDeleteDialogOpen] = useState(false);
    const [requestToDelete, setRequestToDelete] = useState(null);
    const [isDeleting, setIsDeleting] = useState(false);

    useEffect(() => {
      if (window.SE7ENTECH && window.SE7ENTECH.requests) {
        setRequests(window.SE7ENTECH.requests);
      }
      setTimeout(() => setIsLoading(false), 500);
    }, []);

    const handleCreateNew = () => {
      window.location.href = `${window.SE7ENTECH.base_url}/modules/customer-portal/index.php/ai-request/new`;
    };

    const handleContinueChat = (id) => {
      window.location.href = `${window.SE7ENTECH.base_url}/modules/customer-portal/index.php/ai-request/chat/${id}`;
    };

    const handleViewRequest = (id) => {
      window.location.href = `${window.SE7ENTECH.base_url}/modules/customer-portal/index.php/ai-request/chat/${id}`;
    };

    const handleDownloadPdf = (pdfPath) => {
      const url = `${window.SE7ENTECH.base_url}/${pdfPath}`;
      window.open(url, '_blank');
    };

    const openDeleteDialog = (req, event) => {
      event.stopPropagation();
      setRequestToDelete(req);
      setDeleteDialogOpen(true);
    };

    const closeDeleteDialog = () => {
      setRequestToDelete(null);
      setDeleteDialogOpen(false);
    };

    const handleDeleteConfirm = () => {
      if (!requestToDelete) return;
      setIsDeleting(true);

      $.ajax({
        url: `${window.SE7ENTECH.base_url}/modules/customer-portal/index.php/ai-request/delete/${requestToDelete.id}`,
        type: 'POST',
        dataType: 'json',
        success: function(res) {
          setIsDeleting(false);
          closeDeleteDialog();
          if (res.success) {
            setRequests(prev => prev.filter(r => r.id !== requestToDelete.id));
            if (window.SE7ENTECH) {
              window.SE7ENTECH.requests = window.SE7ENTECH.requests.filter(r => r.id !== requestToDelete.id);
            }
          } else {
            alert('Error: ' + res.error);
          }
        },
        error: function() {
          setIsDeleting(false);
          closeDeleteDialog();
          alert('Error de red al intentar eliminar el borrador.');
        }
      });
    };

    const formatDate = (dateStr) => {
      if (!dateStr) return '';
      const date = new Date(dateStr);
      return date.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    };

    return isLoading ? (
      <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: 300 }}>
        <CircularProgress sx={{ color: '#5e72e4' }} />
      </Box>
    ) : (
      <Box sx={{ p: 1 }}>
        {/* Header Section */}
        <Paper 
          elevation={0}
          sx={{ 
            p: 3, 
            mb: 4, 
            borderRadius: 3, 
            background: 'linear-gradient(135deg, #ffffff 0%, #f6f9fc 100%)',
            boxShadow: '0 4px 20px rgba(0,0,0,0.03)',
            display: 'flex',
            flexDirection: { xs: 'column', sm: 'row' },
            justifyContent: 'space-between',
            alignItems: { xs: 'flex-start', sm: 'center' },
            gap: 2
          }}
        >
          <Box>
            <Typography variant="h4" sx={{ fontWeight: 700, color: '#32325d', mb: 1, display: 'flex', alignItems: 'center', gap: 1.5 }}>
              <AutoAwesomeIcon sx={{ color: '#6f42c1' }} />
              Mis Solicitudes con IA
            </Typography>
            <Typography variant="body2" color="textSecondary">
              Define y elabora requerimientos de software de forma conversacional asistido por nuestra Inteligencia Artificial.
            </Typography>
          </Box>
          <Button
            variant="contained"
            onClick={handleCreateNew}
            startIcon={<AddIcon />}
            sx={{
              background: 'linear-gradient(135deg, #6f42c1 0%, #5e72e4 100%)',
              color: '#fff',
              fontWeight: 600,
              textTransform: 'none',
              px: 3,
              py: 1,
              borderRadius: 2,
              boxShadow: '0 4px 15px rgba(94, 114, 228, 0.2)',
              '&:hover': {
                transform: 'translateY(-1px)',
                boxShadow: '0 6px 20px rgba(94, 114, 228, 0.3)',
              }
            }}
          >
            Nuevo Requerimiento
          </Button>
        </Paper>

        {/* Listings Grid */}
        {requests.length === 0 ? (
          <Paper sx={{ p: 6, textAlign: 'center', borderRadius: 3, boxShadow: '0 4px 20px rgba(0,0,0,0.02)' }}>
            <Box sx={{ mb: 3 }}>
              <AutoAwesomeIcon sx={{ fontSize: 60, color: '#e9ecef' }} />
            </Box>
            <Typography variant="h6" color="textSecondary" sx={{ fontWeight: 600, mb: 1 }}>
              Aún no tienes solicitudes de requerimientos creadas
            </Typography>
            <Typography variant="body2" color="textSecondary" sx={{ mb: 3 }}>
              Haz clic en "Nuevo Requerimiento" para comenzar a describir tu idea con la ayuda de la IA.
            </Typography>
            <Button
              variant="outlined"
              onClick={handleCreateNew}
              startIcon={<AutoAwesomeIcon />}
              sx={{
                color: '#6f42c1',
                borderColor: '#6f42c1',
                textTransform: 'none',
                borderRadius: 2,
                '&:hover': {
                  borderColor: '#5e72e4',
                  backgroundColor: 'rgba(111, 66, 193, 0.04)'
                }
              }}
            >
              Comenzar con IA
            </Button>
          </Paper>
        ) : (
          <Grid container spacing={3}>
            {requests.map((req) => (
              <Grid size={{ xs: 12, md: 6, lg: 4 }} key={req.id}>
                <Card 
                  sx={{ 
                    height: '100%', 
                    display: 'flex', 
                    flexDirection: 'column', 
                    borderRadius: 3,
                    boxShadow: '0 4px 20px rgba(0,0,0,0.03)',
                    border: '1px solid #e9ecef',
                    transition: 'all 0.3s ease',
                    '&:hover': {
                      transform: 'translateY(-4px)',
                      boxShadow: '0 12px 28px rgba(0,0,0,0.08)'
                    }
                  }}
                >
                  <CardContent sx={{ flexGrow: 1, display: 'flex', flexDirection: 'column' }}>
                    {/* Header */}
                    <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', mb: 2 }}>
                      <Typography 
                        variant="h6" 
                        sx={{ 
                          fontWeight: 700, 
                          color: '#32325d', 
                          overflow: 'hidden',
                          textOverflow: 'ellipsis',
                          display: '-webkit-box',
                          WebkitLineClamp: 2,
                          WebkitBoxOrient: 'vertical',
                          lineHeight: 1.3,
                          maxHeight: '2.6em'
                        }}
                      >
                        {req.subject || `Proyecto #${req.id}`}
                      </Typography>
                      <Chip 
                        label={req.status === 'draft' ? 'Borrador' : 'Enviado'}
                        size="small"
                        sx={{
                          fontWeight: 600,
                          fontSize: '0.75rem',
                          backgroundColor: req.status === 'draft' ? 'rgba(251, 99, 64, 0.1)' : 'rgba(45, 206, 137, 0.1)',
                          color: req.status === 'draft' ? '#fb6340' : '#2dce89',
                          border: req.status === 'draft' ? '1px solid rgba(251, 99, 64, 0.2)' : '1px solid rgba(45, 206, 137, 0.2)',
                          height: '24px'
                        }}
                      />
                    </Box>

                    {/* Summary */}
                    <Typography 
                      variant="body2" 
                      color="textSecondary" 
                      sx={{ 
                        mb: 3, 
                        flexGrow: 1,
                        overflow: 'hidden',
                        textOverflow: 'ellipsis',
                        display: '-webkit-box',
                        WebkitLineClamp: 3,
                        WebkitBoxOrient: 'vertical'
                      }}
                    >
                      {req.summary || 'Conversación iniciada. Comienza a definir tu idea con la asistencia del bot de IA...'}
                    </Typography>

                    {/* Progress Bar */}
                    <Box sx={{ mb: 2 }}>
                      <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 0.5 }}>
                        <Typography variant="caption" sx={{ fontWeight: 700, color: '#8898aa' }}>
                          Progreso
                        </Typography>
                        <Typography variant="caption" sx={{ fontWeight: 700, color: '#5e72e4' }}>
                          {req.progress}%
                        </Typography>
                      </Box>
                      <LinearProgress 
                        variant="determinate" 
                        value={req.progress} 
                        sx={{ 
                          height: 6, 
                          borderRadius: 3,
                          backgroundColor: '#e9ecef',
                          '& .MuiLinearProgress-bar': {
                            borderRadius: 3,
                            background: 'linear-gradient(135deg, #11cdef 0%, #1171ef 100%)'
                          }
                        }}
                      />
                    </Box>

                    {/* Meta date */}
                    <Typography variant="caption" color="textSecondary" sx={{ display: 'flex', alignItems: 'center', gap: 0.5 }}>
                      <i className="fa fa-clock-o" /> Actualizado: {formatDate(req.updated_at)}
                    </Typography>
                  </CardContent>

                  {/* Actions */}
                  <CardActions sx={{ px: 3, pb: 3, pt: 0, mt: 'auto', borderTop: '1px solid #f8f9fe' }}>
                    {req.status === 'draft' ? (
                      <>
                        <Button
                          variant="contained"
                          size="small"
                          onClick={() => handleContinueChat(req.id)}
                          startIcon={<ChatIcon />}
                          sx={{
                            flexGrow: 1,
                            backgroundColor: '#6f42c1',
                            backgroundImage: 'linear-gradient(135deg, #6f42c1 0%, #5e72e4 100%)',
                            fontWeight: 600,
                            textTransform: 'none',
                            borderRadius: 1.5,
                            '&:hover': {
                              boxShadow: '0 4px 10px rgba(111, 66, 193, 0.3)'
                            }
                          }}
                        >
                          Continuar Chat
                        </Button>
                        <IconButton 
                          aria-label="delete draft"
                          onClick={(e) => openDeleteDialog(req, e)}
                          sx={{ 
                            color: '#f5365c', 
                            border: '1px solid #f5365c', 
                            borderRadius: 1.5,
                            p: '5px',
                            '&:hover': {
                              backgroundColor: 'rgba(245, 54, 92, 0.08)'
                            }
                          }}
                        >
                          <DeleteIcon />
                        </IconButton>
                      </>
                    ) : (
                      <>
                        <Button
                          variant="outlined"
                          size="small"
                          onClick={() => handleViewRequest(req.id)}
                          startIcon={<VisibilityIcon />}
                          sx={{
                            flexGrow: 1,
                            color: '#5e72e4',
                            borderColor: '#5e72e4',
                            fontWeight: 600,
                            textTransform: 'none',
                            borderRadius: 1.5,
                            '&:hover': {
                              backgroundColor: 'rgba(94, 114, 228, 0.08)',
                              borderColor: '#324cdd'
                            }
                          }}
                        >
                          Ver Especificación
                        </Button>
                        {req.pdf_path && (
                          <Button
                            variant="contained"
                            size="small"
                            onClick={() => handleDownloadPdf(req.pdf_path)}
                            startIcon={<PictureAsPdfIcon />}
                            sx={{
                              backgroundColor: '#f5365c',
                              fontWeight: 600,
                              textTransform: 'none',
                              borderRadius: 1.5,
                              '&:hover': {
                                backgroundColor: '#ec0c38'
                              }
                            }}
                          >
                            PDF
                          </Button>
                        )}
                      </>
                    )}
                  </CardActions>
                </Card>
              </Grid>
            ))}
          </Grid>
        )}

        {/* Delete Confirmation Dialog */}
        <Dialog
          open={deleteDialogOpen}
          onClose={closeDeleteDialog}
          aria-labelledby="alert-dialog-title"
          aria-describedby="alert-dialog-description"
          PaperProps={{
            sx: { borderRadius: 3, p: 1 }
          }}
        >
          <DialogTitle id="alert-dialog-title" sx={{ fontWeight: 700, color: '#32325d' }}>
            {"¿Eliminar requerimiento?"}
          </DialogTitle>
          <DialogContent>
            <DialogContentText id="alert-dialog-description">
              ¿Estás seguro de que deseas eliminar permanentemente el borrador de requerimiento para "<strong>{requestToDelete?.subject || `Proyecto #${requestToDelete?.id}`}</strong>"? Esta acción no se puede deshacer.
            </DialogContentText>
          </DialogContent>
          <DialogActions sx={{ px: 3, pb: 2 }}>
            <Button onClick={closeDeleteDialog} disabled={isDeleting} sx={{ textTransform: 'none', color: '#8898aa', fontWeight: 600 }}>
              Cancelar
            </Button>
            <Button 
              onClick={handleDeleteConfirm} 
              disabled={isDeleting} 
              autoFocus 
              sx={{ 
                textTransform: 'none', 
                backgroundColor: '#f5365c', 
                color: '#fff',
                fontWeight: 600,
                px: 3,
                borderRadius: 1.5,
                '&:hover': {
                  backgroundColor: '#ec0c38'
                }
              }}
            >
              {isDeleting ? 'Eliminando...' : 'Eliminar permanentemente'}
            </Button>
          </DialogActions>
        </Dialog>
      </Box>
    );
  };

  const container = document.getElementById('ai-request-list-app');
  if (container) {
    ReactDOM.createRoot(container).render(<App />);
  }
}

export function cleanup() {
  console.log('Cleaning up ai-request-list route');
}
