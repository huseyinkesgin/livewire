import Swal from 'sweetalert2';

// Make sure Swal is available globally
window.Swal = Swal;

// Listen for Livewire event
document.addEventListener('livewire:initialized', () => {
    Livewire.on('show-message', (eventData) => {
        console.log('Livewire show-message event received:', eventData);
        const data = eventData[0]; // Get the first item from the array
        const { type, message } = data;

        if (type === 'success') {
            console.log('Showing success message');
            Swal.fire({
                title: 'Başarılı!',
                text: message,
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        } else if (type === 'error') {
            console.log('Showing error message');
            Swal.fire({
                title: 'Hata!',
                html: message,
                icon: 'error',
                confirmButtonText: 'Tamam',
                confirmButtonColor: '#dc2626'
            });
        }
    });
}); 