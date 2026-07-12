import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('confirm', {
        show: false,
        message: '',
        confirmText: 'Ya',
        cancelText: 'Batal',
        type: 'danger',
        formId: null,
        open(message, formId, options = {}) {
            this.message = message;
            this.formId = formId;
            this.confirmText = options.confirmText || 'Ya';
            this.cancelText = options.cancelText || 'Batal';
            this.type = options.type || 'danger';
            this.show = true;
        },
        confirm() {
            const form = document.getElementById(this.formId);
            if (form) form.submit();
            this.show = false;
        },
        cancel() {
            this.show = false;
        },
    });

    Alpine.store('loading', {
        show: false,
        start() {
            this.show = true;
        },
        finish() {
            this.show = false;
        },
    });
});

document.addEventListener('submit', (e) => {
    Alpine.store('loading').start();
});

window.addEventListener('pageshow', () => {
    Alpine.store('confirm').show = false;
    Alpine.store('loading').finish();
});

Alpine.start();
