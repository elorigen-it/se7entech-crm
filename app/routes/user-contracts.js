import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom/client';
import { 
  Box, 
  Typography, 
  Button, 
  Paper, 
  Table, 
  TableBody, 
  TableCell, 
  TableContainer, 
  TableHead, 
  TableRow, 
  CircularProgress,
  Tooltip
} from '@mui/material';
import PictureAsPdfIcon from '@mui/icons-material/PictureAsPdf';
import DescriptionIcon from '@mui/icons-material/Description';

export function init() {
  const App = () => {
    const [isLoading, setIsLoading] = useState(true);
    const [contracts, setContracts] = useState([]);

    useEffect(() => {
      if (window.SE7ENTECH && window.SE7ENTECH.contracts) {
        setContracts(window.SE7ENTECH.contracts);
      }
      setTimeout(() => setIsLoading(false), 500);
    }, []);

    const handlePrint = (id) => {
      const url = `${window.SE7ENTECH.base_url}/print.php?id=${id}`;
      window.open(url, '_blank');
    };

    return isLoading ? (
      <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: 300 }}>
        <CircularProgress sx={{ color: '#0daea8' }} />
      </Box>
    ) : (
      <Box sx={{ p: 1 }}>
        <Box sx={{ mb: 4, display: 'flex', alignItems: 'center', gap: 2 }}>
          <DescriptionIcon sx={{ fontSize: 32, color: '#0daea8' }} />
          <Typography variant="h5" sx={{ fontWeight: 600, color: '#2c646c' }}>
            My Contracts
          </Typography>
        </Box>

        {contracts.length === 0 ? (
          <Paper sx={{ p: 4, textAlign: 'center', borderRadius: 2 }}>
            <Typography variant="body1" color="textSecondary">
              No contracts found.
            </Typography>
          </Paper>
        ) : (
          <TableContainer component={Paper} sx={{ borderRadius: 2, boxShadow: '0 4px 20px rgba(0,0,0,0.05)', overflowX: 'auto' }}>
            <Table sx={{ minWidth: 650 }} aria-label="contracts table">
              <TableHead sx={{ backgroundColor: '#0daea8' }}>
                <TableRow>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold', whiteSpace: 'nowrap' }}>ID</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold', whiteSpace: 'nowrap' }}>Date Start</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold', whiteSpace: 'nowrap' }}>Date End</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold', whiteSpace: 'nowrap' }}>Representative</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold', whiteSpace: 'nowrap' }}>Company</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold', whiteSpace: 'nowrap' }}>Total Value</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold', whiteSpace: 'nowrap' }}>Actions</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {contracts.map((contract) => (
                  <TableRow
                    key={contract.id}
                    sx={{ 
                      '&:last-child td, &:last-child th': { border: 0 },
                      '&:hover': { backgroundColor: 'rgba(13, 174, 168, 0.05)', transition: 'background-color 0.3s' }
                    }}
                  >
                    <TableCell component="th" scope="row" sx={{ fontWeight: 600, whiteSpace: 'nowrap' }}>
                      #{contract.id}
                    </TableCell>
                    <TableCell sx={{ whiteSpace: 'nowrap' }}>{contract.contract_date_start}</TableCell>
                    <TableCell sx={{ whiteSpace: 'nowrap' }}>{contract.contract_date_end}</TableCell>
                    <TableCell sx={{ whiteSpace: 'nowrap' }}>{contract.agent_name_1}</TableCell>
                    <TableCell sx={{ whiteSpace: 'nowrap' }}>{contract.company_name_1}</TableCell>
                    <TableCell sx={{ fontWeight: 600, color: '#2c646c', whiteSpace: 'nowrap' }}>
                      ${contract.total_purchase}
                    </TableCell>
                    <TableCell sx={{ whiteSpace: 'nowrap' }}>
                      <Tooltip title="View / Print PDF">
                        <Button
                          variant="contained"
                          size="small"
                          startIcon={<PictureAsPdfIcon />}
                          onClick={() => handlePrint(contract.id)}
                          sx={{ 
                            backgroundColor: '#0daea8', 
                            '&:hover': { backgroundColor: '#0b938e' },
                            textTransform: 'none',
                            borderRadius: 1.5,
                            fontWeight: 600
                          }}
                        >
                          View / Print PDF
                        </Button>
                      </Tooltip>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </TableContainer>
        )}
      </Box>
    );
  };

  const container = document.getElementById('contracts-app');
  if (container) {
    ReactDOM.createRoot(container).render(<App />);
  }
}

export function cleanup() {
  console.log('Cleaning up contracts route');
}
