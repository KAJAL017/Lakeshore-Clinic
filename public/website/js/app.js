/**
 * Lakeshore Clinic - Website Application
 * Core JavaScript utilities and initialization
 */

(function() {
    'use strict';

    window.LakeshoreClinic = window.LakeshoreClinic || {};

    LakeshoreClinic.showToast = function(message, type) {
        type = type || 'info';
        var container = document.getElementById('public-toast-container');
        if (!container) return;

        var toast = document.createElement('div');
        toast.className = 'flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg text-sm font-medium max-w-sm animate-slide-in';

        var colors = {
            success: 'bg-emerald-50 text-emerald-800 border border-emerald-200',
            error: 'bg-red-50 text-red-800 border border-red-200',
            warning: 'bg-amber-50 text-amber-800 border border-amber-200',
            info: 'bg-blue-50 text-blue-800 border border-blue-200'
        };

        var icons = {
            success: '<svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
            error: '<svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>',
            warning: '<svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>',
            info: '<svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>'
        };

        toast.className += ' ' + (colors[type] || colors.info);
        toast.innerHTML = (icons[type] || icons.info) + '<span>' + message + '</span>';

        container.appendChild(toast);

        setTimeout(function() {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(function() { toast.remove(); }, 300);
        }, 5000);
    };

    LakeshoreClinic.ajax = function(options) {
        var defaults = {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            onSuccess: function() {},
            onError: function() {}
        };

        var config = Object.assign({}, defaults, options);
        if (typeof config.body === 'object' && !(config.body instanceof FormData)) {
            var formData = new FormData();
            Object.keys(config.body).forEach(function(key) {
                formData.append(key, config.body[key]);
            });
            config.body = formData;
        }

        fetch(config.url, {
            method: config.method,
            headers: config.headers,
            body: config.body
        })
        .then(function(response) {
            return response.json().then(function(data) {
                if (response.ok) {
                    config.onSuccess(data);
                } else {
                    config.onError(data);
                }
            });
        })
        .catch(function(error) {
            config.onError({ message: 'A network error occurred. Please try again.' });
        });
    };

    LakeshoreClinic.setButtonLoading = function(button, loading) {
        if (!button) return;
        if (loading) {
            button.dataset.originalHtml = button.innerHTML;
            button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Loading...';
            button.disabled = true;
        } else {
            button.innerHTML = button.dataset.originalHtml || button.innerHTML;
            button.disabled = false;
        }
    };

    window.showToast = LakeshoreClinic.showToast;
})();
