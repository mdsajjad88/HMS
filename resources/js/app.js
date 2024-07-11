import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Swal from 'sweetalert2';
window.Swal = Swal;

// resources/js/app.js
import toastr from 'toastr';
window.toastr = toastr;
