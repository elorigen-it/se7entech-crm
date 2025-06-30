import React, {useState}  from 'react';
import ReactDOM from 'react-dom/client'
import {DndContext} from '@dnd-kit/core';
import {CSS} from '@dnd-kit/utilities';

import {Draggable} from '../src/pages/tasks/Draggable.jsx';
import {Droppable} from '../src/pages/tasks/Droppable.jsx';
import { Box, Grid, Paper, Typography } from '@mui/material';

// const style = {
//   transform: CSS.Translate.toString(transform),
// }

export function init() {
    // Lógica exclusiva para la página de inicio
    console.log('Cargado: Página de tasks');

    function App() {
        const [isDropped, setIsDropped] = useState(false);
        const draggableMarkup = (
            <Draggable>Drag me</Draggable>
        );
        
        return (<>        
            <Grid container columns={12} spacing={2} sx={{ minHeight: '80vh', p: 2, width:'100%' }}>
                <Grid item size={{xs: 12}}>
                    <Typography variant="h4" gutterBottom>
                        Task Board
                    </Typography>
                </Grid>
                <Grid item size={{xs:4}}>
                    <Paper elevation={3} sx={{ p: 2, minHeight: 400, bgcolor: '#f4f5f7' }}>
                        <Typography variant="h6" gutterBottom>
                            To Do
                        </Typography>
                        <DndContext onDragEnd={handleDragEnd}>
                            {!isDropped ? draggableMarkup : null}
                            <Droppable>
                                {isDropped ? draggableMarkup : 'Drop here'}
                            </Droppable>
                        </DndContext>
                    </Paper>
                </Grid>
                <Grid item size={{xs:4}}>
                    <Paper elevation={3} sx={{ p: 2, minHeight: 400, bgcolor: '#f4f5f7' }}>
                        <Typography variant="h6" gutterBottom>
                            In Progress
                        </Typography>
                    </Paper>
                </Grid>
                <Grid item size={{xs:4}}>
                    <Paper elevation={3} sx={{ p: 2, minHeight: 400, bgcolor: '#f4f5f7' }}>
                        <Typography variant="h6" gutterBottom>
                            Done
                        </Typography>
                    </Paper>
                </Grid>
            </Grid>
            {/* <DndContext onDragEnd={handleDragEnd}>
                {!isDropped ? draggableMarkup : null}
                <Droppable>
                    {isDropped ? draggableMarkup : 'Drop here'}
                </Droppable>
            </DndContext> */}
        </>
        );
        
        function handleDragEnd(event) {
            if (event.over && event.over.id === 'droppable') {
                setIsDropped(true);
            }
        }
    }

    const container = document.getElementById('app');
    if (container) {
        ReactDOM.createRoot(document.getElementById('app')).render(<App />);
    }
}

// Opcional: limpieza al salir de la ruta
export function cleanup() {
  console.log('Limpiando recursos de home');
}