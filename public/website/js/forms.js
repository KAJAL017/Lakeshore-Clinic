/**
 * Lakeshore Clinic - Forms
 * Form validation, AJAX submission, and loading states
 */

(function() {
    'use strict';

    document.querySelectorAll('form[data-ajax="true"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var btn = form.querySelector('[type="submit"]');
            if (btn) {
                btn.dataset.originalHtml = btn.innerHTML;
                btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Submitting...';
                btn.disabled = true;
            }

            var formData = new FormData(form);
            var action = form.getAttribute('action') || window.location.href;
            var method = form.getAttribute('method') || 'POST';

            fetch(action, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(response) {
                return response.json().then(function(data) {
                    return { ok: response.ok, data: data };
                });
            })
            .then(function(result) {
                if (result.ok) {
                    if (typeof window.showToast === 'function') {
                        window.showToast(result.data.message || 'Operation completed successfully.', 'success');
                    }
                    form.reset();
                } else {
                    if (typeof window.showToast === 'function') {
                        window.showToast(result.data.message || 'Something went wrong. Please try again.', 'error');
                    }
                    if (result.data.errors) {
                        Object.keys(result.data.errors).forEach(function(field) {
                            var input = form.querySelector('[name="' + field + '"]');
                            if (input) {
                                input.classList.add('border-red-400');
                                var errorEl = document.createElement('p');
                                errorEl.className = 'text-red-500 text-xs mt-1 form-error';
                                errorEl.textContent = result.data.errors[field][0];
                                input.parentNode.appendChild(errorEl);
                            }
                        });
                    }
                }
            })
            .catch(function() {
                if (typeof window.showToast === 'function') {
                    window.showToast('A network error occurred. Please try again.', 'error');
                }
            })
            .finally(function() {
                if (btn) {
                    btn.innerHTML = btn.dataset.originalHtml || 'Submit';
                    btn.disabled = false;
                }
            });
        });
    });

    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('reset', function() {
            form.querySelectorAll('.form-error').forEach(function(el) { el.remove(); });
            form.querySelectorAll('.border-red-400').forEach(function(el) {
                el.classList.remove('border-red-400');
            });
        });
    });

    document.querySelectorAll('input, textarea, select').forEach(function(input) {
        input.addEventListener('input', function() {
            this.classList.remove('border-red-400');
            var error = this.parentNode.querySelector('.form-error');
            if (error) error.remove();
        });
    });
})();
