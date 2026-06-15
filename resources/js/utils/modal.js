function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        modal.querySelector('[data-modal-close]')?.focus();
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function confirmAction(message, callback) {
    const dialog = document.getElementById('confirmation-dialog');
    if (dialog) {
        dialog.classList.remove('hidden');
        dialog.querySelector('.confirm-message').textContent = message;
        dialog.querySelector('.confirm-btn').onclick = function () {
            callback();
            dialog.classList.add('hidden');
        };
        dialog.querySelector('.cancel-btn').onclick = function () {
            dialog.classList.add('hidden');
        };
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-modal-open]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const target = this.getAttribute('data-modal-open');
            openModal(target);
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            const modal = this.closest('[id^="modal-"]');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (e.target.hasAttribute('data-modal-backdrop')) {
            e.target.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"]:not(.hidden)').forEach(function (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }
    });
});

window.openModal = openModal;
window.closeModal = closeModal;
window.confirmAction = confirmAction;
