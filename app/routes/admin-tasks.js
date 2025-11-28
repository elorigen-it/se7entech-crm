import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import {
    Box,
    Card,
    CardContent,
    Typography,
    Accordion,
    AccordionSummary,
    AccordionDetails,
    Chip,
    Stack,
    Divider,
    CircularProgress,
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    Paper,
    TextField,
    InputAdornment,
    IconButton,
    Tooltip
} from '@mui/material';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import PersonIcon from '@mui/icons-material/Person';
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import SearchIcon from '@mui/icons-material/Search';
import OpenInNewIcon from '@mui/icons-material/OpenInNew';

export function init() {

    const AdminDashboard = () => {
        const [users, setUsers] = useState([]);
        const [loading, setLoading] = useState(true);
        const [searchTerm, setSearchTerm] = useState('');

        useEffect(() => {
            const fetchData = async () => {
                try {
                    const response = await fetch(`${window.SE7ENTECH.base_url}/modules/tasks/index.php/api/admin-dashboard-data`);
                    const data = await response.json();
                    if (Array.isArray(data)) {
                        setUsers(data);
                    }
                } catch (error) {
                    console.error("Error fetching admin data:", error);
                } finally {
                    setLoading(false);
                }
            };
            fetchData();
        }, []);

        const formatDate = (val) => {
            if (!val) return '-';
            // If it's a timestamp (number or numeric string)
            if (!isNaN(val) && (typeof val === 'number' || !val.includes('-'))) {
                return new Date(parseInt(val) * 1000).toLocaleString();
            }
            // If it's a date string
            return new Date(val).toLocaleString();
        };

        const filteredUsers = users.filter(user =>
            (user.first_name + ' ' + user.last_name).toLowerCase().includes(searchTerm.toLowerCase()) ||
            user.email.toLowerCase().includes(searchTerm.toLowerCase())
        );

        if (loading) {
            return (
                <Box sx={{ display: 'flex', justifyContent: 'center', p: 5 }}>
                    <CircularProgress />
                </Box>
            );
        }

        return (
            <Box sx={{ p: 2 }}>
                {/* Search Filter */}
                <Box sx={{ mb: 3 }}>
                    <TextField
                        fullWidth
                        variant="outlined"
                        placeholder="Search users by name or email..."
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        InputProps={{
                            startAdornment: (
                                <InputAdornment position="start">
                                    <SearchIcon />
                                </InputAdornment>
                            ),
                        }}
                    />
                </Box>

                {filteredUsers.map((user) => (
                    <Accordion key={user.id} sx={{ mb: 2 }}>
                        <AccordionSummary
                            expandIcon={<ExpandMoreIcon />}
                            sx={{ backgroundColor: '#f8f9fe' }}
                        >
                            <Stack direction="row" alignItems="center" spacing={2} sx={{ width: '100%' }}>
                                <PersonIcon color="primary" />
                                <Typography variant="h6" sx={{ flexGrow: 1 }}>
                                    {user.first_name} {user.last_name}
                                </Typography>
                                <Chip
                                    icon={<AccessTimeIcon />}
                                    label={`${user.stats.total_hours} hrs Total`}
                                    color="primary"
                                    variant="outlined"
                                />
                                <Chip
                                    label={`${user.tasks.length} Tasks`}
                                    size="small"
                                />
                            </Stack>
                        </AccordionSummary>
                        <AccordionDetails>
                            <Stack spacing={3}>
                                {/* Daily History Section */}
                                <Box>
                                    <Typography variant="subtitle1" gutterBottom sx={{ fontWeight: 'bold' }}>
                                        Daily Work History
                                    </Typography>
                                    <TableContainer component={Paper} variant="outlined" sx={{ maxHeight: 300 }}>
                                        <Table size="small" stickyHeader>
                                            <TableHead>
                                                <TableRow>
                                                    <TableCell>Date</TableCell>
                                                    <TableCell align="right">Hours Worked</TableCell>
                                                </TableRow>
                                            </TableHead>
                                            <TableBody>
                                                {user.stats.daily_history.length > 0 ? (
                                                    user.stats.daily_history.map((day, idx) => (
                                                        <TableRow key={idx}>
                                                            <TableCell>{day.date}</TableCell>
                                                            <TableCell align="right">{day.hours} h</TableCell>
                                                        </TableRow>
                                                    ))
                                                ) : (
                                                    <TableRow>
                                                        <TableCell colSpan={2} align="center">No activity recorded</TableCell>
                                                    </TableRow>
                                                )}
                                            </TableBody>
                                        </Table>
                                    </TableContainer>
                                </Box>

                                <Divider />

                                {/* Tasks List Section */}
                                <Box>
                                    <Typography variant="subtitle1" gutterBottom sx={{ fontWeight: 'bold' }}>
                                        Assigned Tasks
                                    </Typography>
                                    <TableContainer component={Paper} variant="outlined" sx={{ maxHeight: 300 }}>
                                        <Table size="small" stickyHeader>
                                            <TableHead>
                                                <TableRow>
                                                    <TableCell>Task Name</TableCell>
                                                    <TableCell>Created At</TableCell>
                                                    <TableCell>Finished At</TableCell>
                                                    <TableCell>Status</TableCell>
                                                    <TableCell align="right">Calculated Time</TableCell>
                                                    <TableCell align="right">Custom Time</TableCell>
                                                </TableRow>
                                            </TableHead>
                                            <TableBody>
                                                {user.tasks.length > 0 ? (
                                                    user.tasks.map((task) => (
                                                        <TableRow key={task.id}>
                                                            <TableCell>
                                                                <Stack direction="row" alignItems="center" spacing={1}>
                                                                    <Typography variant="body2">{task.name}</Typography>
                                                                    <Tooltip title="View Task Details">
                                                                        <IconButton
                                                                            size="small"
                                                                            href={`${window.SE7ENTECH.base_url}/modules/tasks/index.php/${task.id}/view`}
                                                                            target="_blank"
                                                                        >
                                                                            <OpenInNewIcon fontSize="small" />
                                                                        </IconButton>
                                                                    </Tooltip>
                                                                </Stack>
                                                            </TableCell>
                                                            <TableCell>{formatDate(task.created_at)}</TableCell>
                                                            <TableCell>{formatDate(task.end_time)}</TableCell>
                                                            <TableCell>
                                                                <Chip
                                                                    label={task.status}
                                                                    size="small"
                                                                    color={task.status === 'finished' ? 'success' : task.status === 'paused' ? 'warning' : 'default'}
                                                                    variant="outlined"
                                                                />
                                                            </TableCell>
                                                            <TableCell align="right">
                                                                {(task.total_time / 3600).toFixed(2)} h
                                                            </TableCell>
                                                            <TableCell align="right">
                                                                {task.custom_total_time ? parseFloat(task.custom_total_time).toFixed(2) : '0.00'} h
                                                            </TableCell>
                                                        </TableRow>
                                                    ))
                                                ) : (
                                                    <TableRow>
                                                        <TableCell colSpan={6} align="center">No tasks assigned.</TableCell>
                                                    </TableRow>
                                                )}
                                            </TableBody>
                                        </Table>
                                    </TableContainer>
                                </Box>
                            </Stack>
                        </AccordionDetails>
                    </Accordion>
                ))}
            </Box>
        );
    }

    const container = document.getElementById('admin-tasks-app');
    if (container) {
        ReactDOM.createRoot(container).render(<AdminDashboard />);
    }
}