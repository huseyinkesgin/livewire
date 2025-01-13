import './bootstrap';

import focus from '@alpinejs/focus';
import Swal from 'sweetalert2';
import tableFeatures from './mixins/tableFeatures';
import './sweetalert';

window.Swal = Swal;

Alpine.plugin(focus);
Alpine.data('tableFeatures', tableFeatures);

// Test if SweetAlert2 is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('SweetAlert2 test:', window.Swal ? 'Loaded' : 'Not loaded');
});

