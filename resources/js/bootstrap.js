import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// resources/js/bootstrap.js

// Import DataTables and DataTables Buttons
import 'datatables.net-bs4';
import 'datatables.net-buttons-bs4';
import 'jszip';
import 'pdfmake/build/pdfmake';
import 'pdfmake/build/vfs_fonts';

// Optionally import DataTables Buttons styling
import 'datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css';

