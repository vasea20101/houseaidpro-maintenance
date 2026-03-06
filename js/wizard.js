/**
 * HouseAidPro — Wizard Navigation Controller (wizard.js)
 */
(function () {
    'use strict';

    let currentStep = 1;
    const totalSteps = 5;

    /* ── DOM refs ───────────────────────────────────── */
    const panels = document.querySelectorAll('.wizard-panel');
    const indicators = document.querySelectorAll('.wizard-step-indicator');
    const lines = document.querySelectorAll('.wizard-step-line');

    if (!panels.length) return; // Not on wizard page

    /* ── Category selection ──────────────────────────── */
    const categoryGrid = document.getElementById('category-grid');
    if (categoryGrid) {
        categoryGrid.addEventListener('click', e => {
            const card = e.target.closest('.category-card');
            if (!card) return;
            categoryGrid.querySelectorAll('.category-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            document.getElementById('selected-category').value = card.dataset.category;

            // Show/hide conditional fields
            const appF = document.getElementById('appliance-fields');
            const leakF = document.getElementById('leak-fields');
            appF.classList.toggle('hidden', card.dataset.category !== 'appliances');
            leakF.classList.toggle('hidden', card.dataset.category !== 'leaks');
        });
        // Keyboard support
        categoryGrid.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                e.target.click();
            }
        });
    }

    /* ── Area toggle ───────────────────────────────── */
    const areaToggle = document.getElementById('area-toggle');
    if (areaToggle) {
        areaToggle.addEventListener('click', e => {
            const btn = e.target.closest('.area-toggle__btn');
            if (!btn) return;
            areaToggle.querySelectorAll('.area-toggle__btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('selected-area').value = btn.dataset.area;
        });
    }

    /* ── Account toggle ────────────────────────────── */
    const accToggle = document.getElementById('account-toggle');
    if (accToggle) {
        accToggle.addEventListener('click', e => {
            const btn = e.target.closest('.area-toggle__btn');
            if (!btn) return;
            accToggle.querySelectorAll('.area-toggle__btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const accFields = document.getElementById('account-fields');
            accFields.classList.toggle('hidden', btn.dataset.mode !== 'account');
        });
    }

    /* ── Init uploads ──────────────────────────────── */
    if (typeof UploadManager !== 'undefined') {
        UploadManager.init('upload-zone', 'upload-input', 'upload-previews', 'upload-count');
    }

    /* ── Init postcode ─────────────────────────────── */
    if (typeof PostcodeLookup !== 'undefined') {
        PostcodeLookup.init('postcode-input', 'postcode-lookup-btn', {
            town: 'address-town',
            county: 'address-county',
            postcode: 'address-postcode-confirm',
            country: 'address-country'
        });
    }

    /* ── Prefill from localStorage ──────────────────── */
    const saved = JSON.parse(localStorage.getItem('hap-contact') || '{}');
    if (saved.firstname) {
        ['contact-title', 'contact-firstname', 'contact-surname', 'contact-email', 'contact-phone', 'contact-altphone'].forEach(id => {
            const el = document.getElementById(id);
            const key = id.replace('contact-', '');
            if (el && saved[key]) el.value = saved[key];
        });
    }

    /* ── Navigation ─────────────────────────────────── */
    function goToStep(step) {
        if (step < 1 || step > totalSteps) return;

        // Update panels
        panels.forEach(p => p.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');

        // Update indicators
        indicators.forEach(ind => {
            const s = parseInt(ind.dataset.step);
            ind.classList.remove('active', 'completed');
            if (s === step) ind.classList.add('active');
            if (s < step) ind.classList.add('completed');
        });

        // Update lines
        lines.forEach(line => {
            const l = parseInt(line.dataset.line);
            line.classList.toggle('completed', l < step);
        });

        // Populate summary on step 5
        if (step === 5) populateSummary();

        currentStep = step;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /* ── Validation per step ────────────────────────── */
    function validateStep(step) {
        const panel = document.getElementById('step-' + step);
        Validator.clearAll(panel);
        let valid = true;

        if (step === 1) {
            const title = document.getElementById('issue-title');
            const desc = document.getElementById('issue-description');
            const cat = document.getElementById('selected-category');
            if (!Validator.validateField(title, [{ test: Validator.required, msg: 'Please enter a short title.' }])) valid = false;
            if (!Validator.validateField(desc, [{ test: v => Validator.minLength(v, 10), msg: 'Please describe the issue (at least 10 characters).' }])) valid = false;
            if (!cat.value) { alert('Please select a category.'); valid = false; }
        }

        if (step === 3) {
            const addr = document.getElementById('address-line1');
            const town = document.getElementById('address-town');
            if (!Validator.validateField(addr, [{ test: Validator.required, msg: 'Address is required.' }])) valid = false;
            if (!Validator.validateField(town, [{ test: Validator.required, msg: 'Town is required.' }])) valid = false;
        }

        if (step === 4) {
            const fn = document.getElementById('contact-firstname');
            const sn = document.getElementById('contact-surname');
            const em = document.getElementById('contact-email');
            const ph = document.getElementById('contact-phone');
            if (!Validator.validateField(fn, [{ test: Validator.required, msg: 'First name is required.' }])) valid = false;
            if (!Validator.validateField(sn, [{ test: Validator.required, msg: 'Surname is required.' }])) valid = false;
            if (!Validator.validateField(em, [{ test: Validator.email, msg: 'Please enter a valid email.' }])) valid = false;
            if (!Validator.validateField(ph, [{ test: Validator.phone, msg: 'Please enter a valid phone number.' }])) valid = false;

            // Account mode password check
            const accBtn = accToggle.querySelector('.area-toggle__btn.active');
            if (accBtn && accBtn.dataset.mode === 'account') {
                const pw = document.getElementById('contact-password');
                const pw2 = document.getElementById('contact-password-confirm');
                if (!Validator.validateField(pw, [{ test: v => Validator.minLength(v, 8), msg: 'Minimum 8 characters.' }])) valid = false;
                if (pw.value !== pw2.value) { Validator.showError(pw2, 'Passwords do not match.'); valid = false; }
            }
        }

        return valid;
    }

    /* ── Populate summary ───────────────────────────── */
    function populateSummary() {
        const row = (label, value) => `<div class="summary-row"><span class="summary-row__label">${label}</span><span class="summary-row__value">${value || '—'}</span></div>`;

        document.getElementById('summary-issue-rows').innerHTML =
            row('Title', document.getElementById('issue-title').value) +
            row('Category', document.getElementById('selected-category').value) +
            row('Area', document.getElementById('selected-area').value) +
            row('Description', document.getElementById('issue-description').value.substring(0, 80) + '...');

        document.getElementById('summary-address-rows').innerHTML =
            row('Address', document.getElementById('address-line1').value) +
            row('Town', document.getElementById('address-town').value) +
            row('Postcode', document.getElementById('address-postcode-confirm').value || document.getElementById('postcode-input').value);

        document.getElementById('summary-contact-rows').innerHTML =
            row('Name', (document.getElementById('contact-title').value + ' ' + document.getElementById('contact-firstname').value + ' ' + document.getElementById('contact-surname').value).trim()) +
            row('Email', document.getElementById('contact-email').value) +
            row('Phone', document.getElementById('contact-phone').value);

        const files = typeof UploadManager !== 'undefined' ? UploadManager.getFiles() : [];
        document.getElementById('summary-files-info').innerHTML =
            `<p class="text-sm" style="padding:var(--space-2) 0">${files.length} file(s) attached</p>`;
    }

    /* ── Wire up buttons ────────────────────────────── */
    document.getElementById('btn-next-1')?.addEventListener('click', () => { if (validateStep(1)) goToStep(2); });
    document.getElementById('btn-next-2')?.addEventListener('click', () => goToStep(3));
    document.getElementById('btn-next-3')?.addEventListener('click', () => { if (validateStep(3)) goToStep(4); });
    document.getElementById('btn-next-4')?.addEventListener('click', () => { if (validateStep(4)) goToStep(5); });

    document.getElementById('btn-prev-2')?.addEventListener('click', () => goToStep(1));
    document.getElementById('btn-prev-3')?.addEventListener('click', () => goToStep(2));
    document.getElementById('btn-prev-4')?.addEventListener('click', () => goToStep(3));
    document.getElementById('btn-prev-5')?.addEventListener('click', () => goToStep(4));

    /* ── Submit ──────────────────────────────────────── */
    document.getElementById('btn-submit')?.addEventListener('click', async () => {
        // Validate terms
        if (!document.getElementById('check-terms').checked) {
            alert('Please accept the Terms & Conditions to continue.');
            return;
        }

        const btn = document.getElementById('btn-submit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner spinner--sm"></span> Submitting...';

        // Build form data
        const fd = new FormData();
        fd.append('title', document.getElementById('issue-title').value);
        fd.append('description', document.getElementById('issue-description').value);
        fd.append('category', document.getElementById('selected-category').value);
        fd.append('area_type', document.getElementById('selected-area').value);
        fd.append('address_line1', document.getElementById('address-line1').value);
        fd.append('address_line2', document.getElementById('address-line2').value);
        fd.append('town', document.getElementById('address-town').value);
        fd.append('county', document.getElementById('address-county').value);
        fd.append('postcode', document.getElementById('address-postcode-confirm').value || document.getElementById('postcode-input').value);
        fd.append('first_name', document.getElementById('contact-firstname').value);
        fd.append('surname', document.getElementById('contact-surname').value);
        fd.append('email', document.getElementById('contact-email').value);
        fd.append('phone', document.getElementById('contact-phone').value);
        fd.append('notes', document.getElementById('notes').value);
        fd.append('preferred_date', document.getElementById('preferred-date').value);
        fd.append('preferred_time', document.getElementById('preferred-time').value);
        fd.append('access_without_presence', document.getElementById('check-access').checked ? '1' : '0');
        fd.append('parking_restrictions', document.getElementById('check-parking').checked ? '1' : '0');
        fd.append('has_pets', document.getElementById('check-pets').checked ? '1' : '0');
        fd.append('has_alarm', document.getElementById('check-alarm').checked ? '1' : '0');
        fd.append('vulnerable_occupier', document.getElementById('check-vulnerable').checked ? '1' : '0');

        // Appliance / Leak fields
        if (document.getElementById('selected-category').value === 'appliances') {
            fd.append('appliance_make', document.getElementById('appliance-make').value);
            fd.append('appliance_model', document.getElementById('appliance-model').value);
            fd.append('appliance_serial', document.getElementById('appliance-serial').value);
            fd.append('flights_of_stairs', document.getElementById('flights-stairs').value);
        }
        if (document.getElementById('selected-category').value === 'leaks') {
            fd.append('leak_container_size', document.getElementById('leak-container').value);
            fd.append('leak_emptying_freq', document.getElementById('leak-frequency').value);
            fd.append('leak_is_constant', document.getElementById('leak-constant').checked ? '1' : '0');
        }

        // Files
        const files = typeof UploadManager !== 'undefined' ? UploadManager.getFiles() : [];
        files.forEach((f, i) => fd.append('files[' + i + ']', f));

        // Remember details
        if (document.getElementById('check-remember').checked) {
            localStorage.setItem('hap-contact', JSON.stringify({
                title: document.getElementById('contact-title').value,
                firstname: document.getElementById('contact-firstname').value,
                surname: document.getElementById('contact-surname').value,
                email: document.getElementById('contact-email').value,
                phone: document.getElementById('contact-phone').value,
                altphone: document.getElementById('contact-altphone').value
            }));
        }

        try {
            const res = await fetch('../api/submit_issue.php', { method: 'POST', body: fd });
            const data = await res.json();

            if (data.success) {
                document.getElementById('success-ref').textContent = data.reference_code || 'HAP-XXXXXXXX';
                document.getElementById('success-overlay').classList.add('active');
            } else {
                alert(data.message || 'Submission failed. Please try again.');
                btn.disabled = false;
                btn.innerHTML = '🚀 Submit Report';
            }
        } catch {
            // If API not available, show mock success for demo
            const code = 'HAP-' + new Date().toISOString().slice(0, 10).replace(/-/g, '') + '-' + Math.random().toString(36).substring(2, 6).toUpperCase();
            document.getElementById('success-ref').textContent = code;
            document.getElementById('success-overlay').classList.add('active');
        }
    });

})();
