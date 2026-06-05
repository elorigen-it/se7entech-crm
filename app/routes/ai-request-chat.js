import React, { useEffect, useState, useRef } from 'react';
import ReactDOM from 'react-dom/client';
import { 
  Box, 
  Typography, 
  Button, 
  Paper, 
  Grid, 
  Card, 
  CardContent, 
  TextField, 
  CircularProgress,
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  Divider,
  Chip,
  IconButton
} from '@mui/material';
import AutoAwesomeIcon from '@mui/icons-material/AutoAwesome';
import SendIcon from '@mui/icons-material/Send';
import MicrophoneIcon from '@mui/icons-material/Mic';
import StopIcon from '@mui/icons-material/Stop';
import LockIcon from '@mui/icons-material/Lock';
import CheckCircleIcon from '@mui/icons-material/CheckCircle';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import WarningAmberIcon from '@mui/icons-material/WarningAmber';
import PictureAsPdfIcon from '@mui/icons-material/PictureAsPdf';
import EditIcon from '@mui/icons-material/Edit';
import PlayArrowIcon from '@mui/icons-material/PlayArrow';
import PauseIcon from '@mui/icons-material/Pause';
import DeleteIcon from '@mui/icons-material/Delete';
import CheckIcon from '@mui/icons-material/Check';
import CloseIcon from '@mui/icons-material/Close';
import CloudUploadIcon from '@mui/icons-material/CloudUpload';
import FolderSharedIcon from '@mui/icons-material/FolderShared';
import VolumeUpIcon from '@mui/icons-material/VolumeUp';
import VolumeOffIcon from '@mui/icons-material/VolumeOff';

export function init() {
  const App = () => {
    const [request, setRequest] = useState(null);
    const [history, setHistory] = useState([]);
    const [progress, setProgress] = useState(0);
    const [status, setStatus] = useState('draft');
    const [subject, setSubject] = useState('');
    const [summary, setSummary] = useState('');
    const [details, setDetails] = useState('');
    const [missingInfo, setMissingInfo] = useState([]);
    
    const [isMuted, setIsMuted] = useState(false);
    const [currentlyTypingIndex, setCurrentlyTypingIndex] = useState(-1);
    const [typedText, setTypedText] = useState('');
    
    const typingIntervalRef = useRef(null);
    
    const speakText = (text) => {
      if (isMuted) return;
      if (!window.speechSynthesis) return;
      
      window.speechSynthesis.cancel();
      
      const cleanText = text
        .replace(/\*\*/g, '')
        .replace(/###/g, '')
        .replace(/- /g, '')
        .replace(/\\n/g, ' ')
        .replace(/\n/g, ' ');
      
      const utterance = new SpeechSynthesisUtterance(cleanText);
      utterance.lang = 'es-ES';
      utterance.rate = 0.95; // Slightly slower speed for a more natural, warm tone
      
      const speak = () => {
        const voices = window.speechSynthesis.getVoices();
        const spanishVoices = voices.filter(voice => voice.lang.startsWith('es'));
        
        if (spanishVoices.length > 0) {
          // Prioritize higher-quality natural, online or Google voices
          let selectedVoice = spanishVoices.find(voice => 
            voice.name.toLowerCase().includes('natural') || 
            voice.name.toLowerCase().includes('online') ||
            voice.name.toLowerCase().includes('google')
          );
          
          if (!selectedVoice) {
            // Fallback to standard es-ES or es-MX
            selectedVoice = spanishVoices.find(voice => voice.lang === 'es-ES' || voice.lang === 'es-MX');
          }
          if (!selectedVoice) {
            selectedVoice = spanishVoices[0];
          }
          
          utterance.voice = selectedVoice;
        }
        window.speechSynthesis.speak(utterance);
      };
      
      if (window.speechSynthesis.getVoices().length === 0) {
        window.speechSynthesis.onvoiceschanged = speak;
      } else {
        speak();
      }
    };
    
    const startTypewriter = (text, index) => {
      if (typingIntervalRef.current) {
        clearInterval(typingIntervalRef.current);
      }
      
      setCurrentlyTypingIndex(index);
      setTypedText('');
      
      speakText(text);
      
      let currentLength = 0;
      typingIntervalRef.current = setInterval(() => {
        currentLength += 2;
        if (currentLength >= text.length) {
          clearInterval(typingIntervalRef.current);
          setCurrentlyTypingIndex(-1);
          setTypedText('');
        } else {
          setTypedText(text.substring(0, currentLength));
        }
      }, 30);
    };
    
    const toggleMute = () => {
      setIsMuted(prev => {
        const nextMuted = !prev;
        if (nextMuted && window.speechSynthesis) {
          window.speechSynthesis.cancel();
        }
        return nextMuted;
      });
    };
    
    const [inputText, setInputText] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [loadingText, setLoadingText] = useState('');
    
    // Recording state
    const [isRecording, setIsRecording] = useState(false);
    const [isPaused, setIsPaused] = useState(false);
    const [audioBlob, setAudioBlob] = useState(null);
    const [audioUrl, setAudioUrl] = useState(null);
    const [recordingTime, setRecordingTime] = useState(0);
    const [isAudioPlaying, setIsAudioPlaying] = useState(false);
    
    const mediaRecorderRef = useRef(null);
    const audioChunksRef = useRef([]);
    const streamRef = useRef(null);
    const timerIntervalRef = useRef(null);
    const audioPlayerRef = useRef(null);

    // Modal state
    const [reviewOpen, setReviewOpen] = useState(false);
    const [formSubject, setFormSubject] = useState('');
    const [formSummary, setFormSummary] = useState('');
    const [formDetails, setFormDetails] = useState('');

    const chatContainerRef = useRef(null);

    useEffect(() => {
      if (window.SE7ENTECH && window.SE7ENTECH.request) {
        const req = window.SE7ENTECH.request;
        setRequest(req);
        setProgress(req.progress);
        setStatus(req.status);
        setSubject(req.subject || '');
        setSummary(req.summary || '');
        setDetails(req.details || '');
        
        // Parse initial history
        try {
          const parsedHistory = JSON.parse(req.chat_history);
          const historyList = Array.isArray(parsedHistory) ? parsedHistory : [];
          setHistory(historyList);
          
          if (historyList.length > 0 && req.status === 'draft') {
            const lastMsg = historyList[historyList.length - 1];
            if (lastMsg.role === 'assistant') {
              speakText(lastMsg.content);
            }
          }
        } catch (e) {
          setHistory([]);
        }
      }
      
      return () => {
        if (typingIntervalRef.current) {
          clearInterval(typingIntervalRef.current);
        }
        if (window.speechSynthesis) {
          window.speechSynthesis.cancel();
        }
      };
    }, []);

    useEffect(() => {
      // Scroll only the chat container internally to the bottom when history changes
      if (chatContainerRef.current) {
        chatContainerRef.current.scrollTo({
          top: chatContainerRef.current.scrollHeight,
          behavior: 'smooth'
        });
      }
    }, [history]);

    const handleBackToList = () => {
      window.location.href = `${window.SE7ENTECH.base_url}/modules/customer-portal/index.php/ai-request`;
    };

    const handleSendText = (e) => {
      if (e) e.preventDefault();
      
      const msg = inputText.trim();
      if (!msg && !audioBlob) return;
      
      setInputText('');

      const formData = new FormData();
      if (msg) {
        formData.append('message', msg);
      }
      if (audioBlob) {
        let ext = 'webm';
        if (audioBlob.type.includes('ogg')) ext = 'ogg';
        else if (audioBlob.type.includes('mp4')) ext = 'mp4';
        else if (audioBlob.type.includes('wav')) ext = 'wav';
        
        formData.append('audio', audioBlob, `audio.${ext}`);
      }

      submitChatTurn(formData);
    };

    const submitChatTurn = (payload) => {
      if (window.speechSynthesis) {
        window.speechSynthesis.cancel();
      }
      if (typingIntervalRef.current) {
        clearInterval(typingIntervalRef.current);
      }
      setCurrentlyTypingIndex(-1);
      setTypedText('');

      setIsLoading(true);
      
      let ajaxData = payload;
      let processData = false;
      let contentType = false;
      setLoadingText('Procesando solicitud y consultando al asistente...');

      $.ajax({
        url: `${window.SE7ENTECH.base_url}/modules/customer-portal/index.php/ai-request/chat/${request.id}`,
        type: 'POST',
        data: ajaxData,
        processData: processData,
        contentType: contentType,
        dataType: 'json',
        success: function(res) {
          setIsLoading(false);
          if (res.success) {
            discardRecording();
            if (res.transcription) {
              setHistory(prev => [...prev, { role: 'user', content: res.transcription }]);
            }
            
            setHistory(prev => {
              const newHistory = [...prev, { role: 'assistant', content: res.reply }];
              const newMsgIndex = newHistory.length - 1;
              startTypewriter(res.reply, newMsgIndex);
              return newHistory;
            });
            
            setProgress(res.progress);
            setSubject(res.structured_document.subject);
            setSummary(res.structured_document.summary);
            setDetails(res.structured_document.details);
            setMissingInfo(res.missing_info_feedback || []);
          } else {
            alert('Error de IA: ' + res.error);
          }
        },
        error: function() {
          setIsLoading(false);
          alert('Error al enviar el mensaje. Por favor intenta de nuevo.');
        }
      });
    };

    // Microphone Recording Controls
    const startRecording = () => {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert('Tu navegador no soporta grabación de audio.');
        return;
      }

      // Stop any active speech and typewriter immediately
      if (window.speechSynthesis) {
        window.speechSynthesis.cancel();
      }
      if (typingIntervalRef.current) {
        clearInterval(typingIntervalRef.current);
      }
      setCurrentlyTypingIndex(-1);
      setTypedText('');

      if (audioUrl) {
        URL.revokeObjectURL(audioUrl);
        setAudioUrl(null);
        setAudioBlob(null);
      }

      navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
          streamRef.current = stream;
          
          let options = {};
          if (MediaRecorder.isTypeSupported('audio/webm')) {
            options = { mimeType: 'audio/webm' };
          } else if (MediaRecorder.isTypeSupported('audio/ogg')) {
            options = { mimeType: 'audio/ogg' };
          } else if (MediaRecorder.isTypeSupported('audio/mp4')) {
            options = { mimeType: 'audio/mp4' };
          }

          const mediaRecorder = new MediaRecorder(stream, options);
          mediaRecorderRef.current = mediaRecorder;
          audioChunksRef.current = [];

          mediaRecorder.ondataavailable = (event) => {
            if (event.data && event.data.size > 0) {
              audioChunksRef.current.push(event.data);
            }
          };

          mediaRecorder.onerror = (event) => {
            console.error('MediaRecorder error:', event.error);
          };

          mediaRecorder.onstop = () => {
            if (audioChunksRef.current.length > 0) {
              const mime = mediaRecorderRef.current.mimeType || 'audio/webm';
              const blob = new Blob(audioChunksRef.current, { type: mime });
              setAudioBlob(blob);
              const url = URL.createObjectURL(blob);
              setAudioUrl(url);
            }
          };

          mediaRecorder.start(1000);
          setIsRecording(true);
          setIsPaused(false);
          
          setRecordingTime(0);
          timerIntervalRef.current = setInterval(() => {
            setRecordingTime(prev => prev + 1);
          }, 1000);
        })
        .catch(err => {
          console.error('Error de micrófono:', err);
          alert('No se pudo acceder al micrófono. Por favor verifica tus permisos.');
        });
    };

    const pauseRecording = () => {
      if (mediaRecorderRef.current && isRecording && !isPaused) {
        mediaRecorderRef.current.pause();
        setIsPaused(true);
        clearInterval(timerIntervalRef.current);
      }
    };

    const resumeRecording = () => {
      if (mediaRecorderRef.current && isRecording && isPaused) {
        mediaRecorderRef.current.resume();
        setIsPaused(false);
        timerIntervalRef.current = setInterval(() => {
          setRecordingTime(prev => prev + 1);
        }, 1000);
      }
    };

    const stopRecording = (isCancelled = false) => {
      if (!mediaRecorderRef.current || !isRecording) return;
      
      clearInterval(timerIntervalRef.current);
      setIsRecording(false);
      setIsPaused(false);

      if (isCancelled) {
        mediaRecorderRef.current.onstop = null;
        setAudioBlob(null);
        if (audioUrl) {
          URL.revokeObjectURL(audioUrl);
          setAudioUrl(null);
        }
      }
      
      mediaRecorderRef.current.stop();
      
      if (streamRef.current) {
        streamRef.current.getTracks().forEach(track => track.stop());
      }
    };

    const cancelRecording = () => {
      stopRecording(true);
    };

    const discardRecording = () => {
      setAudioBlob(null);
      if (audioUrl) {
        URL.revokeObjectURL(audioUrl);
        setAudioUrl(null);
      }
    };

    const formatTimer = (seconds) => {
      const mins = Math.floor(seconds / 60);
      const secs = seconds % 60;
      return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    };

    const togglePlayback = () => {
      if (!audioPlayerRef.current) return;
      if (isAudioPlaying) {
        audioPlayerRef.current.pause();
        setIsAudioPlaying(false);
      } else {
        audioPlayerRef.current.play();
        setIsAudioPlaying(true);
      }
    };

    const handleAudioEnded = () => {
      setIsAudioPlaying(false);
    };

    // Review and Submit modal
    const openReviewModal = () => {
      setFormSubject(subject);
      setFormSummary(summary);
      setFormDetails(details);
      setReviewOpen(true);
    };

    const closeReview = () => {
      setReviewOpen(false);
    };

    const handleConfirmSubmit = (e) => {
      e.preventDefault();
      
      const payload = {
        subject: formSubject.trim(),
        summary: formSummary.trim(),
        details: formDetails.trim()
      };

      if (!payload.subject || !payload.summary || !payload.details) {
        alert('Por favor completa todos los campos.');
        return;
      }

      setReviewOpen(false);
      setIsLoading(true);
      setLoadingText('Generando PDF oficial y enviando correo al administrador...');

      $.ajax({
        url: `${window.SE7ENTECH.base_url}/modules/customer-portal/index.php/ai-request/confirm/${request.id}`,
        type: 'POST',
        data: payload,
        dataType: 'json',
        success: function(res) {
          setIsLoading(false);
          if (res.success) {
            if (res.warning) {
              alert('Éxito con advertencia: ' + res.warning);
            } else {
              alert('¡Requerimiento enviado con éxito a la empresa!');
            }
            window.location.reload();
          } else {
            alert('Error al confirmar: ' + res.error);
          }
        },
        error: function() {
          setIsLoading(false);
          alert('Error al enviar la confirmación final.');
        }
      });
    };

    const formatMarkdown = (text) => {
      if (!text) return '';
      // Simple custom markdown-to-html compiler
      return text
        .replace(/\\n/g, '\n')
        .replace(/### (.*?)\r?\n/g, '<h5 class="text-primary mt-3 font-weight-bold" style="color:#5e72e4; margin-top:16px;">$1</h5>')
        .replace(/## (.*?)\r?\n/g, '<h4 class="text-primary mt-4 font-weight-bold" style="color:#5e72e4; margin-top:20px;">$1</h4>')
        .replace(/# (.*?)\r?\n/g, '<h3 class="text-primary mt-4 font-weight-bold" style="color:#5e72e4; margin-top:24px;">$1</h3>')
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/- (.*?)\r?\n/g, '<li>$1</li>')
        .replace(/(<li>.*?<\/li>)+/gs, '<ul style="padding-left: 20px;">$0</ul>')
        .replace(/\n/g, '<br>');
    };

    return request ? (
      <Box sx={{ p: 1 }}>
        {/* Header wrapper */}
        <Paper 
          elevation={0}
          sx={{ 
            p: 3, 
            mb: 4, 
            borderRadius: 3, 
            background: 'linear-gradient(135deg, #ffffff 0%, #f6f9fc 100%)',
            boxShadow: '0 4px 20px rgba(0,0,0,0.03)',
            display: 'flex',
            justifyContent: 'space-between',
            alignItems: 'center'
          }}
        >
          <Box>
            <Typography variant="h4" sx={{ fontWeight: 700, color: '#32325d', mb: 0.5, display: 'flex', alignItems: 'center', gap: 1 }}>
              <AutoAwesomeIcon sx={{ color: '#6f42c1' }} />
              Requerimiento con IA
            </Typography>
            <Typography variant="body2" color="textSecondary">
              Asistente de requerimientos conversacional
            </Typography>
          </Box>
          <Box sx={{ display: 'flex', alignItems: 'center', gap: 2 }}>
            <Button
              variant="outlined"
              onClick={toggleMute}
              startIcon={isMuted ? <VolumeOffIcon /> : <VolumeUpIcon />}
              sx={{
                color: isMuted ? '#f5365c' : '#2dce89',
                borderColor: isMuted ? '#fbd2da' : '#c7f3e1',
                textTransform: 'none',
                borderRadius: 2,
                '&:hover': {
                  borderColor: isMuted ? '#f5365c' : '#2dce89',
                  backgroundColor: isMuted ? '#fef5f6' : '#f0fbf7'
                }
              }}
            >
              {isMuted ? 'Voz Desactivada' : 'Narrador Activo'}
            </Button>
            <Button
              variant="outlined"
              onClick={handleBackToList}
              startIcon={<ArrowBackIcon />}
              sx={{
                color: '#8898aa',
                borderColor: '#e9ecef',
                textTransform: 'none',
                borderRadius: 2,
                '&:hover': {
                  borderColor: '#cad1d7',
                  backgroundColor: 'rgba(0,0,0,0.02)'
                }
              }}
            >
              Volver a la Lista
            </Button>
          </Box>
        </Paper>

        <Grid container spacing={4}>
          {/* Left panel: Chat UI */}
          <Grid size={{ xs: 12, lg: 7 }}>
            <Card 
              sx={{ 
                borderRadius: 4, 
                boxShadow: '0 4px 25px rgba(0,0,0,0.04)',
                border: '1px solid #e9ecef',
                position: 'relative',
                display: 'flex',
                flexDirection: 'column',
                minHeight: 580
              }}
            >
              {/* Spinner loading overlay */}
              {isLoading && (
                <Box 
                  sx={{ 
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    width: '100%',
                    height: '100%',
                    backgroundColor: 'rgba(255, 255, 255, 0.75)',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    justifyContent: 'center',
                    zIndex: 10,
                    borderRadius: 4
                  }}
                >
                  <CircularProgress sx={{ color: '#5e72e4', mb: 2 }} />
                  <Typography variant="body2" sx={{ fontWeight: 700, color: '#5e72e4' }}>
                    {loadingText}
                  </Typography>
                </Box>
              )}

              {/* Chat Title */}
              <Box 
                sx={{ 
                  p: 3, 
                  borderBottom: '1px solid #e9ecef',
                  display: 'flex',
                  justifyContent: 'space-between',
                  alignItems: 'center'
                }}
              >
                <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5 }}>
                  <AvatarIcon />
                  <Box>
                    <Typography variant="subtitle1" sx={{ fontWeight: 700, color: '#32325d' }}>
                      Chat con Asistente IA
                    </Typography>
                    <Typography variant="caption" color="textSecondary">
                      Describe tu proyecto escribiendo o hablando
                    </Typography>
                  </Box>
                </Box>
                <Chip label={`ID: #AI-${request.id}`} size="small" color="primary" variant="outlined" sx={{ fontWeight: 600 }} />
              </Box>

              {/* Chat Messages scroll area */}
              <Box 
                ref={chatContainerRef}
                sx={{ 
                  flexGrow: 1, 
                  p: 3, 
                  height: 400, 
                  overflowY: 'auto',
                  backgroundColor: '#f8f9fe',
                  display: 'flex',
                  flexDirection: 'column',
                  gap: 2
                }}
              >
                {history.map((msg, index) => (
                  <Box 
                    key={index}
                    sx={{ 
                      display: 'flex',
                      flexDirection: 'column',
                      alignItems: msg.role === 'user' ? 'flex-end' : 'flex-start'
                    }}
                  >
                    <Box 
                      sx={{ 
                        maxWidth: '80%',
                        p: 2,
                        borderRadius: 3,
                        fontSize: '0.875rem',
                        lineHeight: 1.5,
                        boxShadow: '0 2px 10px rgba(0,0,0,0.02)',
                        backgroundColor: msg.role === 'user' ? '#5e72e4' : '#ffffff',
                        color: msg.role === 'user' ? '#ffffff' : '#2b354e',
                        backgroundImage: msg.role === 'user' ? 'linear-gradient(135deg, #5e72e4 0%, #324cdd 100%)' : 'none',
                        borderBottomRightRadius: msg.role === 'user' ? 0 : 3,
                        borderBottomLeftRadius: msg.role === 'assistant' ? 0 : 3
                      }}
                    >
                      {msg.role === 'assistant' && index === currentlyTypingIndex ? typedText : msg.content}
                    </Box>
                  </Box>
                ))}

              </Box>

              {/* Bottom Chat Inputs */}
              <Box sx={{ p: 2, borderTop: '1px solid #e9ecef', backgroundColor: '#ffffff', borderBottomLeftRadius: 16, borderBottomRightRadius: 16 }}>
                {status === 'draft' ? (
                  <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5, width: '100%' }}>
                    {isRecording ? (
                      /* Unified Recording UI replacing text input */
                      <Box sx={{ 
                        display: 'flex', 
                        alignItems: 'center', 
                        width: '100%', 
                        height: 50, 
                        px: 2, 
                        backgroundColor: '#fdf3f5', 
                        borderRadius: 25, 
                        border: '1px solid #fbd2da' 
                      }}>
                        <Box 
                          sx={{ 
                            width: 10, 
                            height: 10, 
                            borderRadius: '50%', 
                            backgroundColor: '#f5365c', 
                            mr: 1.5, 
                            animation: !isPaused ? 'blink 1s infinite' : 'none',
                            '@keyframes blink': {
                              '0%': { opacity: 0.2 },
                              '50%': { opacity: 1 },
                              '100%': { opacity: 0.2 }
                            }
                          }} 
                        />
                        <Typography variant="body2" sx={{ color: '#f5365c', fontWeight: 700, mr: 2 }}>
                          {isPaused ? 'Grabación pausada' : 'Grabando audio...'}
                        </Typography>
                        <Typography variant="body2" sx={{ color: '#f5365c', fontWeight: 700 }}>
                          {formatTimer(recordingTime)}
                        </Typography>
                        <Box sx={{ ml: 'auto', display: 'flex', gap: 1 }}>
                          <IconButton 
                            size="small" 
                            onClick={isPaused ? resumeRecording : pauseRecording} 
                            sx={{ color: '#5e72e4', border: '1px solid #5e72e4', p: '3px' }}
                            title={isPaused ? "Reanudar" : "Pausar"}
                          >
                            {isPaused ? <PlayArrowIcon fontSize="small" /> : <PauseIcon fontSize="small" />}
                          </IconButton>
                          <IconButton 
                            size="small" 
                            onClick={() => stopRecording(false)} 
                            sx={{ color: '#2dce89', border: '1px solid #2dce89', p: '3px' }}
                            title="Finalizar grabación"
                          >
                            <StopIcon fontSize="small" />
                          </IconButton>
                          <IconButton 
                            size="small" 
                            onClick={cancelRecording} 
                            sx={{ color: '#f5365c', border: '1px solid #f5365c', p: '3px' }}
                            title="Cancelar grabación"
                          >
                            <CloseIcon fontSize="small" />
                          </IconButton>
                        </Box>
                      </Box>
                    ) : (
                      /* Normal form input */
                      <form onSubmit={handleSendText} style={{ display: 'flex', width: '100%', alignItems: 'center', gap: 12 }}>
                        {audioUrl ? (
                          <Box sx={{ 
                            display: 'flex', 
                            alignItems: 'center', 
                            flexGrow: 1, 
                            height: 50, 
                            px: 2, 
                            backgroundColor: '#f0f4fe', 
                            borderRadius: 25, 
                            border: '1px solid #d6e4ff' 
                          }}>
                            <audio ref={audioPlayerRef} src={audioUrl} onEnded={handleAudioEnded} style={{ display: 'none' }} />
                            <IconButton onClick={togglePlayback} sx={{ color: '#5e72e4', mr: 1 }}>
                              {isAudioPlaying ? <PauseIcon fontSize="small" /> : <PlayArrowIcon fontSize="small" />}
                            </IconButton>
                            <Typography variant="body2" sx={{ color: '#32325d', fontWeight: 600 }}>
                              Mensaje de voz grabado ({formatTimer(recordingTime)})
                            </Typography>
                            <IconButton onClick={discardRecording} sx={{ ml: 'auto', color: '#f5365c' }} title="Descartar audio">
                              <DeleteIcon fontSize="small" />
                            </IconButton>
                          </Box>
                        ) : (
                          <IconButton 
                            onClick={startRecording}
                            sx={{
                              width: 50,
                              height: 50,
                              backgroundColor: '#eaecfb',
                              color: '#5e72e4',
                              flexShrink: 0,
                              '&:hover': { backgroundColor: '#d6dbf8' }
                            }}
                          >
                            <MicrophoneIcon />
                          </IconButton>
                        )}
                        <TextField 
                          fullWidth 
                          value={inputText}
                          onChange={(e) => setInputText(e.target.value)}
                          placeholder={audioUrl ? "Agrega un comentario a tu audio (opcional)..." : "Escribe tu requerimiento aquí..."}
                          variant="outlined"
                          slotProps={{
                            input: {
                              style: {
                                height: 50,
                                borderRadius: 25,
                                paddingLeft: 20,
                                paddingRight: 20
                              }
                            }
                          }}
                        />
                        <IconButton 
                          type="submit" 
                          disabled={!inputText.trim() && !audioBlob}
                          sx={{
                            width: 50,
                            height: 50,
                            color: '#fff',
                            flexShrink: 0,
                            background: 'linear-gradient(135deg, #6f42c1 0%, #5e72e4 100%)',
                            opacity: (!inputText.trim() && !audioBlob) ? 0.6 : 1,
                            '&:hover': {
                              background: 'linear-gradient(135deg, #5e72e4 0%, #324cdd 100%)',
                            }
                          }}
                        >
                          <SendIcon sx={{ fontSize: 18 }} />
                        </IconButton>
                      </form>
                    )}
                  </Box>
                ) : (
                  <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', py: 2, gap: 1 }}>
                    <LockIcon sx={{ color: '#8898aa', fontSize: 18 }} />
                    <Typography variant="body2" color="textSecondary" sx={{ fontStyle: 'italic' }}>
                      Este requerimiento ha sido enviado y el chat se encuentra bloqueado.
                    </Typography>
                  </Box>
                )}
              </Box>
            </Card>
          </Grid>

          {/* Right panel: Sidebar stats, preview */}
          <Grid size={{ xs: 12, lg: 5 }}>
            {/* MEGA Upload Link Card */}
            {status === 'draft' && (
              <Card 
                sx={{ 
                  borderRadius: 4, 
                  boxShadow: '0 4px 25px rgba(0,0,0,0.04)', 
                  border: '1px solid #e9ecef', 
                  mb: 3,
                  background: request.mega_upload_link 
                    ? 'linear-gradient(135deg, #11cdef 0%, #1171ef 100%)' 
                    : 'linear-gradient(135deg, #f6f9fc 0%, #eaecfb 100%)',
                  color: request.mega_upload_link ? '#ffffff' : '#32325d'
                }}
              >
                <CardContent sx={{ p: 3 }}>
                  <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5, mb: 1.5 }}>
                    <FolderSharedIcon sx={{ fontSize: 24, color: request.mega_upload_link ? '#ffffff' : '#5e72e4' }} />
                    <Typography variant="subtitle1" sx={{ fontWeight: 700 }}>
                      Subir Material del Proyecto
                    </Typography>
                  </Box>
                  {request.mega_upload_link ? (
                    <>
                      <Typography variant="body2" sx={{ mb: 2.5, opacity: 0.9, fontSize: '0.85rem' }}>
                        Utiliza nuestra carpeta segura en MEGA para subir imágenes, videos, logos o documentos de referencia para este requerimiento.
                      </Typography>
                      <Button
                        fullWidth
                        variant="contained"
                        startIcon={<CloudUploadIcon />}
                        onClick={() => window.open(request.mega_upload_link, '_blank')}
                        sx={{
                          py: 1.5,
                          borderRadius: 2,
                          textTransform: 'none',
                          fontWeight: 700,
                          backgroundColor: '#ffffff',
                          color: '#1171ef',
                          '&:hover': {
                            backgroundColor: '#f6f9fc',
                            color: '#1171ef',
                          }
                        }}
                      >
                        Abrir Carpeta de MEGA
                      </Button>
                    </>
                  ) : (
                    <Typography variant="body2" sx={{ opacity: 0.8, fontSize: '0.85rem', fontStyle: 'italic' }}>
                      No tienes un espacio en la nube asignado todavía. Por favor, contáctate con el administrador para que te asigne una carpeta de MEGA.
                    </Typography>
                  )}
                </CardContent>
              </Card>
            )}

            {/* Progress circular indicator card */}
            <Card sx={{ borderRadius: 4, boxShadow: '0 4px 25px rgba(0,0,0,0.04)', border: '1px solid #e9ecef', mb: 3 }}>
              <CardContent sx={{ p: 3 }}>
                <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                  <Box>
                    <Typography variant="subtitle1" sx={{ fontWeight: 700, color: '#32325d', mb: 0.5 }}>
                      Progreso de Recopilación
                    </Typography>
                    <Typography variant="caption" color="textSecondary">
                      Necesitamos un 80% o más para enviar.
                    </Typography>
                  </Box>
                  <Box sx={{ position: 'relative', display: 'inline-flex' }}>
                    <CircularProgress 
                      variant="determinate" 
                      value={100} 
                      size={80} 
                      thickness={5} 
                      sx={{ color: '#e9ecef' }} 
                    />
                    <CircularProgress 
                      variant="determinate" 
                      value={progress} 
                      size={80} 
                      thickness={5} 
                      sx={{ 
                        color: '#5e72e4',
                        position: 'absolute',
                        left: 0,
                        '& .MuiCircularProgress-circle': {
                          strokeLinecap: 'round'
                        }
                      }} 
                    />
                    <Box 
                      sx={{
                        top: 0,
                        left: 0,
                        bottom: 0,
                        right: 0,
                        position: 'absolute',
                        display: 'flex',
                        alignItems: 'center',
                        justifyContent: 'center',
                      }}
                    >
                      <Typography variant="h6" component="div" sx={{ fontWeight: 700, color: '#5e72e4' }}>
                        {progress}%
                      </Typography>
                    </Box>
                  </Box>
                </Box>

                <Box sx={{ mt: 3 }}>
                  {status === 'draft' ? (
                    <Button
                      fullWidth
                      variant="contained"
                      onClick={openReviewModal}
                      startIcon={<EditIcon />}
                      sx={{
                        py: 2,
                        borderRadius: 2,
                        textTransform: 'none',
                        fontWeight: 700,
                        background: 'linear-gradient(135deg, #2dce89 0%, #2dcecc 100%)',
                        boxShadow: '0 4px 15px rgba(45, 206, 137, 0.2)',
                        animation: progress >= 80 ? 'pulse-green-btn 2s infinite' : 'none',
                        '@keyframes pulse-green-btn': {
                          '0%': { boxShadow: '0 0 0 0 rgba(45, 206, 137, 0.6)' },
                          '70%': { boxShadow: '0 0 0 8px rgba(45, 206, 137, 0)' },
                          '100%': { boxShadow: '0 0 0 0 rgba(45, 206, 137, 0)' }
                        },
                        '&:hover': {
                          background: 'linear-gradient(135deg, #24ab71 0%, #24aba9 100%)',
                          boxShadow: '0 6px 20px rgba(45, 206, 137, 0.3)'
                        }
                      }}
                    >
                      Revisar y Enviar Requerimiento
                    </Button>
                  ) : (
                    <Box 
                      sx={{ 
                        p: 2.5, 
                        backgroundColor: 'rgba(45, 206, 137, 0.08)', 
                        border: '1px solid rgba(45, 206, 137, 0.2)',
                        borderRadius: 3, 
                        textAlign: 'center' 
                      }}
                    >
                      <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 1, mb: 1.5 }}>
                        <CheckCircleIcon color="success" />
                        <Typography variant="subtitle2" sx={{ fontWeight: 700, color: '#2dce89' }}>
                          Requerimiento Enviado
                        </Typography>
                      </Box>
                      {request.pdf_path && (
                        <Button
                          variant="contained"
                          color="error"
                          size="small"
                          onClick={() => window.open(`${window.SE7ENTECH.base_url}/${request.pdf_path}`, '_blank')}
                          startIcon={<PictureAsPdfIcon />}
                          sx={{ textTransform: 'none', fontWeight: 600, borderRadius: 1.5 }}
                        >
                          Descargar PDF Oficial
                        </Button>
                      )}
                    </Box>
                  )}
                </Box>
              </CardContent>
            </Card>

            {/* Missing Info Box */}
            {status === 'draft' && missingInfo.length > 0 && progress < 100 && (
              <Card sx={{ borderRadius: 4, boxShadow: '0 4px 25px rgba(0,0,0,0.04)', border: '1px solid #e9ecef', mb: 3 }}>
                <CardContent sx={{ p: 3 }}>
                  <Typography variant="subtitle1" sx={{ fontWeight: 700, color: '#fb6340', mb: 2, display: 'flex', alignItems: 'center', gap: 1 }}>
                    <WarningAmberIcon sx={{ fontSize: 20 }} />
                    Detalles Faltantes para Definir
                  </Typography>
                  <Box sx={{ display: 'flex', flexDirection: 'column', gap: 1 }}>
                    {missingInfo.map((info, idx) => (
                      <Box 
                        key={idx}
                        sx={{ 
                          p: 1.5, 
                          backgroundColor: '#fffdf5', 
                          borderLeft: '4px solid #fb6340', 
                          borderRadius: 1,
                          fontSize: '0.8rem',
                          color: '#8a6d3b'
                        }}
                      >
                        {info}
                      </Box>
                    ))}
                  </Box>
                </CardContent>
              </Card>
            )}

            {/* Live Document Preview Card */}
            <Card sx={{ borderRadius: 4, boxShadow: '0 4px 25px rgba(0,0,0,0.04)', border: '1px solid #e9ecef' }}>
              <Box 
                sx={{ 
                  p: 3, 
                  borderBottom: '1px solid #e9ecef',
                  display: 'flex',
                  justifyContent: 'space-between',
                  alignItems: 'center'
                }}
              >
                <Typography variant="subtitle1" sx={{ fontWeight: 700, color: '#5e72e4' }}>
                  Vista Previa del Requerimiento
                </Typography>
                <Chip 
                  label={status === 'draft' ? 'Borrador' : 'Finalizado'} 
                  size="small" 
                  sx={{ 
                    fontSize: '0.7rem', 
                    fontWeight: 700,
                    backgroundColor: status === 'draft' ? '#e9ecef' : '#d2f4ea',
                    color: status === 'draft' ? '#495057' : '#0f5132'
                  }} 
                />
              </Box>
              <CardContent sx={{ p: 3 }}>
                <Typography variant="h6" sx={{ fontWeight: 700, color: '#32325d', mb: 1 }}>
                  {subject || 'Nuevo Proyecto'}
                </Typography>
                <Typography variant="body2" sx={{ fontStyle: 'italic', color: '#8898aa', mb: 3 }}>
                  {summary || 'Comienza a hablar con el asistente para generar el resumen ejecutivo.'}
                </Typography>
                
                <Box 
                  sx={{ 
                    maxHeight: 350, 
                    overflowY: 'auto',
                    p: 2.5,
                    border: '1px solid #e9ecef',
                    borderRadius: 2,
                    fontSize: '0.85rem',
                    backgroundColor: '#fafbfc',
                    lineHeight: 1.6
                  }}
                  dangerouslySetInnerHTML={{ 
                    __html: formatMarkdown(details) || '<em style="color:#adb5bd;">Las especificaciones técnicas detalladas se irán estructurando aquí a medida que aportes información en el chat.</em>' 
                  }}
                />
              </CardContent>
            </Card>
          </Grid>
        </Grid>

        {/* Review & Edit Specifications Dialog */}
        <Dialog 
          open={reviewOpen} 
          onClose={closeReview}
          maxWidth="md"
          fullWidth
          PaperProps={{
            sx: { borderRadius: 4, p: 1 }
          }}
        >
          <DialogTitle sx={{ fontWeight: 700, color: '#5e72e4' }}>
            Revisar y Editar Especificación Técnica
          </DialogTitle>
          <form onSubmit={handleConfirmSubmit}>
            <DialogContent dividers>
              <Typography variant="body2" color="textSecondary" sx={{ mb: 3 }}>
                Revisa las especificaciones técnicas recopiladas. Puedes editar cualquiera de los campos directamente antes de enviarlas de forma formal.
              </Typography>
              
              <TextField
                fullWidth
                label="Título del Proyecto"
                value={formSubject}
                onChange={(e) => setFormSubject(e.target.value)}
                required
                sx={{ mb: 3 }}
              />
              
              <TextField
                fullWidth
                label="Resumen Ejecutivo"
                value={formSummary}
                onChange={(e) => setFormSummary(e.target.value)}
                multiline
                rows={4}
                required
                sx={{ mb: 3 }}
              />
              
              <TextField
                fullWidth
                label="Especificaciones Detalladas (Markdown)"
                value={formDetails}
                onChange={(e) => setFormDetails(e.target.value)}
                multiline
                rows={12}
                required
                slotProps={{
                  input: {
                    style: {
                      fontFamily: 'monospace',
                      fontSize: '0.8rem',
                      lineHeight: 1.5
                    }
                  }
                }}
              />
            </DialogContent>
            <DialogActions sx={{ px: 3, py: 2 }}>
              <Button onClick={closeReview} sx={{ textTransform: 'none', color: '#8898aa', fontWeight: 600 }}>
                Seguir Conversando
              </Button>
              <Button 
                type="submit" 
                variant="contained"
                sx={{ 
                  textTransform: 'none', 
                  backgroundColor: '#2dce89', 
                  backgroundImage: 'linear-gradient(135deg, #2dce89 0%, #2dcecc 100%)',
                  fontWeight: 600,
                  px: 3.5,
                  borderRadius: 2,
                  boxShadow: '0 4px 15px rgba(45, 206, 137, 0.2)',
                  '&:hover': {
                    background: 'linear-gradient(135deg, #24ab71 0%, #24aba9 100%)'
                  }
                }}
              >
                Confirmar y Enviar a la Empresa
              </Button>
            </DialogActions>
          </form>
        </Dialog>
      </Box>
    ) : (
      <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: 400 }}>
        <CircularProgress sx={{ color: '#5e72e4' }} />
      </Box>
    );
  };

  // Helper avatar icon inside chat
  const AvatarIcon = () => (
    <Box 
      sx={{ 
        width: 40, 
        height: 40, 
        borderRadius: '50%', 
        background: 'linear-gradient(135deg, #6f42c1 0%, #5e72e4 100%)',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        color: '#ffffff',
        boxShadow: '0 4px 10px rgba(94, 114, 228, 0.2)'
      }}
    >
      <AutoAwesomeIcon sx={{ fontSize: 18 }} />
    </Box>
  );

  const container = document.getElementById('ai-request-chat-app');
  if (container) {
    ReactDOM.createRoot(container).render(<App />);
  }
}

export function cleanup() {
  console.log('Cleaning up ai-request-chat route');
}
