/**
 * HouseAidPro — File Upload Handler (upload.js)
 */
const UploadManager = (function () {
    'use strict';

    const MAX_FILES = 10;
    const MAX_SIZE = 10 * 1024 * 1024; // 10MB
    const ALLOWED = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'video/mp4', 'video/quicktime', 'video/webm', 'audio/mpeg', 'audio/wav', 'audio/ogg'];
    let files = [];

    function init(zoneId, inputId, previewsId, countId) {
        const zone = document.getElementById(zoneId);
        const input = document.getElementById(inputId);
        const previews = document.getElementById(previewsId);
        const countEl = document.getElementById(countId);
        if (!zone || !input) return;

        zone.addEventListener('click', () => input.click());
        zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('dragover');
            handleFiles(e.dataTransfer.files, previews, countEl);
        });
        input.addEventListener('change', () => {
            handleFiles(input.files, previews, countEl);
            input.value = '';
        });
    }

    function handleFiles(newFiles, previews, countEl) {
        for (const file of newFiles) {
            if (files.length >= MAX_FILES) { alert('Maximum ' + MAX_FILES + ' files allowed.'); break; }
            if (!ALLOWED.includes(file.type)) { alert(file.name + ' is not a supported file type.'); continue; }
            if (file.size > MAX_SIZE) { alert(file.name + ' exceeds the 10MB limit.'); continue; }
            files.push(file);
            addPreview(file, files.length - 1, previews);
        }
        updateCount(countEl);
    }

    function addPreview(file, idx, container) {
        const div = document.createElement('div');
        div.className = 'upload-preview animate-scaleIn';
        div.dataset.index = idx;

        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.alt = file.name;
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; };
            reader.readAsDataURL(file);
            div.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const vid = document.createElement('video');
            vid.src = URL.createObjectURL(file);
            vid.muted = true;
            div.appendChild(vid);
        } else {
            const placeholder = document.createElement('div');
            placeholder.style.cssText = 'display:flex;align-items:center;justify-content:center;height:100%;color:var(--text-muted);font-size:var(--text-xs);padding:var(--space-2);text-align:center;';
            placeholder.textContent = '🎵 ' + file.name.slice(0, 15);
            div.appendChild(placeholder);
        }

        const info = document.createElement('div');
        info.className = 'upload-preview__info';
        info.textContent = file.name.length > 18 ? file.name.slice(0, 15) + '...' : file.name;
        div.appendChild(info);

        const removeBtn = document.createElement('button');
        removeBtn.className = 'upload-preview__remove';
        removeBtn.innerHTML = '✕';
        removeBtn.type = 'button';
        removeBtn.setAttribute('aria-label', 'Remove ' + file.name);
        removeBtn.addEventListener('click', e => {
            e.stopPropagation();
            files.splice(idx, 1);
            container.innerHTML = '';
            files.forEach((f, i) => addPreview(f, i, container));
            updateCount(document.getElementById('upload-count'));
        });
        div.appendChild(removeBtn);

        // Simulated progress bar
        const prog = document.createElement('div');
        prog.className = 'upload-preview__progress';
        prog.style.width = '0%';
        div.appendChild(prog);
        container.appendChild(div);

        let w = 0;
        const interval = setInterval(() => {
            w += Math.random() * 30 + 10;
            if (w >= 100) { w = 100; clearInterval(interval); }
            prog.style.width = w + '%';
        }, 120);
    }

    function updateCount(el) {
        if (el) el.textContent = files.length + ' of ' + MAX_FILES + ' files selected';
    }

    function getFiles() { return files; }
    function clear() { files = []; }

    return { init, getFiles, clear };
})();
