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
  Tooltip,
  Chip
} from '@mui/material';
import PictureAsPdfIcon from '@mui/icons-material/PictureAsPdf';
import ReceiptIcon from '@mui/icons-material/Receipt';

export function init() {
  const App = () => {
    const [isLoading, setIsLoading] = useState(true);
    const [invoices, setInvoices] = useState([]);

    useEffect(() => {
      if (window.SE7ENTECH && window.SE7ENTECH.invoices) {
        setInvoices(window.SE7ENTECH.invoices);
      }
      setTimeout(() => setIsLoading(false), 500);
    }, []);

    const handlePrint = (id) => {
      const url = `${window.SE7ENTECH.base_url}/print_invoice.php?invoice_id=${id}`;
      window.open(url, '_blank');
    };

    return isLoading ? (
      <Box sx={{ display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: 300 }}>
        <CircularProgress sx={{ color: '#0daea8' }} />
      </Box>
    ) : (
      <Box sx={{ p: 1 }}>
        <Box sx={{ mb: 4, display: 'flex', alignItems: 'center', gap: 2 }}>
          <ReceiptIcon sx={{ fontSize: 32, color: '#0daea8' }} />
          <Typography variant="h5" sx={{ fontWeight: 600, color: '#2c646c' }}>
            My Invoices
          </Typography>
        </Box>

        {invoices.length === 0 ? (
          <Paper sx={{ p: 4, textAlign: 'center', borderRadius: 2 }}>
            <Typography variant="body1" color="textSecondary">
              No invoices found.
            </Typography>
          </Paper>
        ) : (
          <TableContainer component={Paper} sx={{ borderRadius: 2, boxShadow: '0 4px 20px rgba(0,0,0,0.05)', overflow: 'hidden' }}>
            <Table sx={{ minWidth: 650 }} aria-label="invoices table">
              <TableHead sx={{ backgroundColor: '#0daea8' }}>
                <TableRow>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>ID</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>Concept</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>Date of Issue</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>Due Date</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>Total</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>Paid</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>Amount Due</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>Status</TableCell>
                  <TableCell sx={{ color: 'white', fontWeight: 'bold' }}>Actions</TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {invoices.map((inv) => {
                  const total = parseFloat(inv.order_total_after_tax || 0);
                  const paid = parseFloat(inv.order_amount_paid || 0);
                  const due = parseFloat(inv.order_total_amount_due || 0);
                  let statusLabel = 'Unpaid';
                  let statusColor = 'error';

                  if (due <= 0) {
                    statusLabel = 'Paid';
                    statusColor = 'success';
                  } else if (paid > 0) {
                    statusLabel = 'Partially Paid';
                    statusColor = 'warning';
                  }

                  return (
                    <TableRow
                      key={inv.order_id}
                      sx={{ 
                        '&:last-child td, &:last-child th': { border: 0 },
                        '&:hover': { backgroundColor: 'rgba(13, 174, 168, 0.05)', transition: 'background-color 0.3s' }
                      }}
                    >
                      <TableCell component="th" scope="row" sx={{ fontWeight: 600 }}>
                        #00{inv.order_id}
                      </TableCell>
                      <TableCell sx={{ maxWidth: 200, whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }} title={inv.order_concept}>
                        {inv.order_concept}
                      </TableCell>
                      <TableCell>{inv.order_date}</TableCell>
                      <TableCell>{inv.duesdate}</TableCell>
                      <TableCell sx={{ fontWeight: 600 }}>${total.toFixed(2)}</TableCell>
                      <TableCell sx={{ color: '#2c646c' }}>${paid.toFixed(2)}</TableCell>
                      <TableCell sx={{ fontWeight: 600, color: due > 0 ? '#d32f2f' : '#2e7d32' }}>${due.toFixed(2)}</TableCell>
                      <TableCell>
                        <Chip label={statusLabel} color={statusColor} size="small" sx={{ fontWeight: 600 }} />
                      </TableCell>
                      <TableCell>
                        <Tooltip title="View / Print Invoice">
                          <Button
                            variant="contained"
                            size="small"
                            startIcon={<PictureAsPdfIcon />}
                            onClick={() => handlePrint(inv.order_id)}
                            sx={{ 
                              backgroundColor: '#0daea8', 
                              '&:hover': { backgroundColor: '#0b938e' },
                              textTransform: 'none',
                              borderRadius: 1.5,
                              fontWeight: 600
                            }}
                          >
                            Print
                          </Button>
                        </Tooltip>
                      </TableCell>
                    </TableRow>
                  );
                })}
              </TableBody>
            </Table>
          </TableContainer>
        )}
      </Box>
    );
  };

  const container = document.getElementById('invoices-app');
  if (container) {
    ReactDOM.createRoot(container).render(<App />);
  }
}

export function cleanup() {
  console.log('Cleaning up invoices route');
}
