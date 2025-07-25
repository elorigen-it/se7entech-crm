import React, {useEffect, useState}  from 'react';
import ReactDOM from 'react-dom/client';
import Accordion from '@mui/material/Accordion';
import AccordionActions from '@mui/material/AccordionActions';
import AccordionSummary from '@mui/material/AccordionSummary';
import AccordionDetails from '@mui/material/AccordionDetails';
import Typography from '@mui/material/Typography';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import Button from '@mui/material/Button';
import Paper from '@mui/material/Paper';
import { Box, Divider } from '@mui/material';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import CardActionArea from '@mui/material/CardActionArea';
import IconButton from '@mui/material/IconButton';
import StickyNote2Icon from '@mui/icons-material/StickyNote2';
import Chip from '@mui/material/Chip';
import Stack from '@mui/material/Stack';
import TimelapseIcon from '@mui/icons-material/Timelapse';
import QueryBuilderIcon from '@mui/icons-material/QueryBuilder';
import CalendarMonthIcon from '@mui/icons-material/CalendarMonth';
import LinearProgress from '@mui/material/LinearProgress';
import Modal from '@mui/material/Modal';
import CircularProgress from '@mui/material/CircularProgress';


export function init() {

  const App = () => {
    const [modalOpen, setModalOpen] = useState(false);
    const [modalContent, setModalContent] = useState(''); 
    const [isLoading, setIsLoading] = useState(true);
    const handleCloseModal = () => {
      setModalOpen(false)
    }
    const handleOpenModal = (id) => {
      setModalContent(id);
      setModalOpen(true)
    }

    useEffect(() => {
      setTimeout(() => setIsLoading(false), 2000);
    }, []);

    return (isLoading ? (
      <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: 200 }}>
        <CircularProgress />
      </Box>
      ) : <div> 
      {SE7ENTECH.projects.map((project, index) => {
      return <Accordion key={index}>
        <AccordionSummary
        expandIcon={<ExpandMoreIcon />}
        aria-controls="panel1-content"
        id="panel1-header"
        sx={[{
          backgroundColor: '#0daea8', 
          color: 'white', 
          border:'none',             
        }, {
          '&:focus':{
          border:'none',
          outline: 'none'
          }
        }]}
        >
        <Typography component="span">{project.name}</Typography>
        </AccordionSummary>
        <AccordionDetails
        sx={{backgroundColor: '#2c646c', color: 'white', border:'none', p:0}}
        >
        <Box sx={{display: 'flex', flexDirection:'row', justifyContent: 'flex-start', flexWrap:'wrap'}}>
          {
          project.tasks.map((task, i) => {
            // Calculate progress percentage (capped at 100)                    
            const progressAlpha = Math.round((task.total_time / task.estimated_time || 0) * 100); 
            const progress = Math.min(
              100,
              Math.round(((task.total_time / task.estimated_time) || 0) * 100)
            );
            let progressColor = 'primary';
            if (progress >= 100) {
              progressColor = 'error';
            } else if (progress >= 90) {
              progressColor = 'warning';
            } else if (progress > 0) {
              progressColor = 'success';
            } else {
              progressColor = 'primary';
            }

            return <Box sx={{display:'inline-flex'}} p={2} key={i}>
            <Card sx={{ maxWidth: 300, pb:0 }}>
              <CardContent>
              <Typography gutterBottom variant="h6" component="div">
              {task.name}
              </Typography>
              <Stack direction={'row'}>
              {task.task_categories && task.task_categories.length > 0 && task.task_categories.split(',').map((cat, idx) => (
              <Chip key={idx} label={cat.trim()} color="primary" size="small" sx={{mr: 0.5}} />
              ))}
              </Stack>
              <Divider sx={{mb:1, pt:1}}/>
              <Box>
              <Stack direction={'row'} alignItems={'center'} justifyContent={'flex-start'} flexWrap={"wrap"}>
              <IconButton onClick={() => handleOpenModal(task.description)} size="small" sx={[{'&:focus': {outline:'none'}}]}>
              <StickyNote2Icon /> 
              </IconButton>
              {task.status === 'created' && (
              <Chip size="small" icon={<TimelapseIcon color='warning'/>} label="Created" variant="outlined" />
              )}
              {task.status === 'started' && (
              <Chip size="small" icon={<TimelapseIcon color='info'/>} label="Started" variant="outlined" />
              )}
              {task.status === 'paused' && (
              <Chip size="small" icon={<TimelapseIcon color='warning'/>} label="Paused" variant="outlined" />
              )}
              {task.status === 'finished' && (
              <Chip size="small" icon={<TimelapseIcon color='success'/>} label="Finished" variant="outlined" />
              )}
              <Chip size="small" icon={<QueryBuilderIcon color="secondary" />} label={`${task.total_time}h (actual)`} variant="outlined" />
              <Chip size="small" icon={<QueryBuilderIcon color="disabled" />} label={`${task.estimated_time}h (estimado)`} variant="outlined" />
              </Stack>
              <Divider sx={{mt:1, mb:1}}/>
              <Chip size="small" icon={<CalendarMonthIcon color="disabled" />} label={`${task.deadline}`} variant="outlined" />
              </Box>
              </CardContent>
              <Box sx={{mt:2, mb:0, pb:0} }>
              <Typography
                level="body-xs"
                sx={{ fontWeight: 'sm', fontSize: '0.75rem', color: 'text.secondary' }}
                >
                {`${Number(progressAlpha)}%`}
              </Typography>
              <LinearProgress sx={{height:20 }} color={progressColor} variant="determinate" value={progress} />                  
              </Box>
            </Card>
            </Box>
          })
          }
        </Box>
        <Paper elevation={3} square sx={{minHeight: 150, p:2}}> 
          <Stack direction="column">
          <Typography variant='h6'>Totales</Typography>
          <Divider />
          <Typography variant='p'>Tareas: {project.tasks.length}</Typography>
          <Typography variant='p'>Horas estimadas: {
            project.tasks.reduce((acc, task) => acc + (task.estimated_time || 0), 0)
            }
          </Typography>                  
          <Typography variant='p'>Horas actuales: {                  
            project.tasks.reduce((acc, task) => acc + (task.total_time || 0), 0)
            }
          </Typography>
          </Stack>

        </Paper>

        </AccordionDetails>
      </Accordion>
      })}
      
      {/* <Accordion>
      <AccordionSummary
        expandIcon={<ExpandMoreIcon />}
        aria-controls="panel1-content"
        id="panel1-header"
        sx={[{
        backgroundColor: '#0daea8', 
        color: 'white', 
        border:'none',             
        }, {
        '&:focus':{
          border:'none',
          outline: 'none'
        }
        }]}
      >
        <Typography component="span">Marketing Septiembre 2024</Typography>
      </AccordionSummary>
      <AccordionDetails>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
        malesuada lacus ex, sit amet blandit leo lobortis eget.
      </AccordionDetails>
      </Accordion>
      <Accordion>
      <AccordionSummary
        expandIcon={<ExpandMoreIcon />}
        aria-controls="panel1-content"
        id="panel1-header"
        sx={[{
        backgroundColor: '#0daea8', 
        color: 'white', 
        border:'none',             
        }, {
        '&:focus':{
          border:'none',
          outline: 'none'
        }
        }]}
      >
        <Typography component="span">Sitio web loscanicos.com</Typography>
      </AccordionSummary>
      <AccordionDetails>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
        malesuada lacus ex, sit amet blandit leo lobortis eget.
      </AccordionDetails>
      <AccordionActions>
        <Button>Cancel</Button>
        <Button>Agree</Button>
      </AccordionActions>
      </Accordion> */}
      <Modal
      open={modalOpen}
      onClose={handleCloseModal}
      aria-labelledby="modal-modal-title"
      aria-describedby="modal-modal-description"
      >
      <Box sx={{p:2, width:'80%', height:'80vh', background: 'white', margin: '2em auto', overflowY: 'auto'}} id="modal-content">
        <span dangerouslySetInnerHTML={{ __html: modalContent }} />
      </Box>
      </Modal>
    </div>)
  }

  const container = document.getElementById('tasks-app');
  if (container) {
      ReactDOM.createRoot(container).render(<App />);
  }
}
// Opcional: limpieza al salir de la ruta
export function cleanup() {
  console.log('Limpiando recursos de home');
}