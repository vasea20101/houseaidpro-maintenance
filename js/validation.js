/**
 * HouseAidPro — Form Validation (validation.js)
 */
const Validator = (function () {
    'use strict';

    function required(val) { return val.trim().length > 0; }
    function email(val) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val); }
    function phone(val) { return /^[\d\s\+\-\(\)]{7,20}$/.test(val); }
    function postcode(val) { return /^[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2}$/i.test(val.trim()); }
    function minLength(val, n) { return val.trim().length >= n; }

    function showError(input, msg) {
        input.classList.add('error');
        let err = input.parentElement.querySelector('.form-error');
        if (!err) {
            err = document.createElement('span');
            err.className = 'form-error';
            input.parentElement.appendChild(err);
        }
        err.textContent = msg;
    }

    function clearError(input) {
        input.classList.remove('error');
        const err = input.parentElement.querySelector('.form-error');
        if (err) err.remove();
    }

    function clearAll(container) {
        container.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
        container.querySelectorAll('.form-error').forEach(el => el.remove());
    }

    function validateField(input, rules) {
        clearError(input);
        const val = input.value;
        for (const rule of rules) {
            if (rule.test && !rule.test(val)) {
                showError(input, rule.msg);
                return false;
            }
        }
        return true;
    }

    return { required, email, phone, postcode, minLength, showError, clearError, clearAll, validateField };
})();
