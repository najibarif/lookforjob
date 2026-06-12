/**
 * CV Builder JavaScript Module
 * Handles all CV generation, template switching, editing, saving, and PDF download functionality
 */

class CVBuilder {
    constructor(options = {}) {
        this.currentCvHtml = options.cvHtml || '';
        this.currentTemplate = 'classic';
        this.csrf = options.csrf || '';
        
        // DOM Elements
        this.previewContent = document.getElementById('cv-preview-content');
        this.wysiwygContent = document.getElementById('cv-wysiwyg-content');
        this.emptyState = document.getElementById('cv-empty-state');
        this.loadingSkeleton = document.getElementById('cv-loading');
        this.previewPaper = document.getElementById('cv-preview-paper');
        this.wysiwygEditor = document.getElementById('cv-wysiwyg-editor');
        
        this.init();
    }

    init() {
        if (this.currentCvHtml) {
            this.renderTemplate(this.currentTemplate, this.currentCvHtml, this.previewContent);
            this.renderTemplate(this.currentTemplate, this.currentCvHtml, this.wysiwygContent);
        }
        
        this.attachEventListeners();
    }

    attachEventListeners() {
        // Accordion
        document.querySelectorAll('.form-section-header').forEach(header => {
            header.addEventListener('click', () => this.handleAccordionClick(header));
        });

        // Generate CV
        const generateBtn = document.getElementById('generate-cv-btn');
        if (generateBtn) {
            generateBtn.addEventListener('click', () => this.handleGenerateCv());
        }

        // Template Selector
        const templateSelector = document.getElementById('template-selector');
        if (templateSelector) {
            templateSelector.addEventListener('click', (e) => this.handleTemplateSelect(e));
        }

        // Tab Buttons
        const tabPreview = document.getElementById('tab-preview');
        const tabEdit = document.getElementById('tab-edit');
        if (tabPreview) tabPreview.addEventListener('click', () => this.showPreview());
        if (tabEdit) tabEdit.addEventListener('click', () => this.showEdit());

        // WYSIWYG Input
        if (this.wysiwygContent) {
            this.wysiwygContent.addEventListener('input', () => {
                this.currentCvHtml = this.getCleanHtml(this.wysiwygContent);
            });
        }

        // Save
        const saveBtn = document.getElementById('save-cv-btn');
        if (saveBtn) {
            saveBtn.addEventListener('click', () => this.handleSaveCv());
        }

        // Download PDF
        const downloadBtn = document.getElementById('download-pdf-btn');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', () => this.handleDownloadPdf());
        }

        // Add Education Entry
        const addEduBtn = document.getElementById('add-edu-btn');
        if (addEduBtn) {
            addEduBtn.addEventListener('click', () => this.addEduEntry());
        }

        // Add Experience Entry
        const addExpBtn = document.getElementById('add-exp-btn');
        if (addExpBtn) {
            addExpBtn.addEventListener('click', () => this.addExpEntry());
        }
    }

    addEduEntry() {
        const container = document.getElementById('edu-entries');
        const first = container.querySelector('.edu-entry');
        const clone = first.cloneNode(true);
        // Clear values in the clone
        clone.querySelectorAll('input, textarea').forEach(el => el.value = '');
        // Add remove button
        this._addRemoveBtn(clone, 'edu-entry', container);
        container.appendChild(clone);
        // Show remove btn on all entries if > 1
        this._updateRemoveBtns(container, 'edu-entry');
        // Expand accordion to fit new entry
        const body = document.getElementById('sec-edu');
        if (body) body.style.maxHeight = (body.scrollHeight + 400) + 'px';
    }

    addExpEntry() {
        const container = document.getElementById('exp-entries');
        const first = container.querySelector('.exp-entry');
        const clone = first.cloneNode(true);
        clone.querySelectorAll('input, textarea').forEach(el => el.value = '');
        this._addRemoveBtn(clone, 'exp-entry', container);
        container.appendChild(clone);
        this._updateRemoveBtns(container, 'exp-entry');
        const body = document.getElementById('sec-exp');
        if (body) body.style.maxHeight = (body.scrollHeight + 400) + 'px';
    }

    _addRemoveBtn(entry, cls, container) {
        // Remove existing remove btn if any
        const existing = entry.querySelector('.cv-remove-btn');
        if (existing) existing.remove();

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'cv-remove-btn';
        btn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Hapus';
        btn.addEventListener('click', () => {
            entry.remove();
            this._updateRemoveBtns(container, cls);
        });
        entry.appendChild(btn);
    }

    _updateRemoveBtns(container, cls) {
        const entries = container.querySelectorAll('.' + cls);
        entries.forEach((entry, idx) => {
            let btn = entry.querySelector('.cv-remove-btn');
            if (entries.length > 1) {
                if (!btn) this._addRemoveBtn(entry, cls, container);
            } else {
                if (btn) btn.remove();
            }
        });
    }

    handleAccordionClick(header) {
        const id = header.dataset.target;
        const body = document.getElementById(id);
        const arr = document.getElementById('arrow-' + id);
        const open = !body.classList.contains('collapsed');

        if (open) {
            // Close it
            body.classList.add('collapsed');
            body.style.maxHeight = '0';
            if (arr) arr.classList.remove('rotate-180');
        } else {
            // Open it
            body.classList.remove('collapsed');
            body.style.maxHeight = '600px';
            if (arr) arr.classList.add('rotate-180');
        }
    }

    async handleGenerateCv() {
        // Personal info
        const name     = (document.getElementById('name')?.value || '').trim();
        const email    = (document.getElementById('email')?.value || '').trim();
        const phone    = (document.getElementById('phone')?.value || '').trim();
        const location = (document.getElementById('location')?.value || '').trim();
        const summary  = (document.getElementById('summary')?.value || '').trim();

        // Education — collect all entries
        const eduLines = [];
        document.querySelectorAll('.edu-entry').forEach(entry => {
            const degree    = entry.querySelector('.edu-degree')?.value.trim();
            const school    = entry.querySelector('.edu-school')?.value.trim();
            const yearStart = entry.querySelector('.edu-year-start')?.value.trim();
            const yearEnd   = entry.querySelector('.edu-year-end')?.value.trim();
            const gpa       = entry.querySelector('.edu-gpa')?.value.trim();
            if (degree || school) {
                let line = `${degree || ''}${school ? ' – ' + school : ''}`;
                if (yearStart || yearEnd) line += ` (${yearStart || '?'} – ${yearEnd || 'Sekarang'})`;
                if (gpa) line += `, IPK ${gpa}`;
                eduLines.push(line);
            }
        });

        // Experience — collect all entries
        const expLines = [];
        document.querySelectorAll('.exp-entry').forEach(entry => {
            const position = entry.querySelector('.exp-position')?.value.trim();
            const company  = entry.querySelector('.exp-company')?.value.trim();
            const start    = entry.querySelector('.exp-start')?.value.trim();
            const end      = entry.querySelector('.exp-end')?.value.trim();
            const desc     = entry.querySelector('.exp-desc')?.value.trim();
            if (position || company) {
                let line = `${position || ''}${company ? ' di ' + company : ''}`;
                if (start || end) line += ` (${start || '?'} – ${end || 'Sekarang'})`;
                if (desc) line += `\n  ${desc}`;
                expLines.push(line);
            }
        });

        // Skills
        const skillsTech = (document.getElementById('skills-tech')?.value || '').trim();
        const skillsSoft = (document.getElementById('skills-soft')?.value || '').trim();
        const skillsLang = (document.getElementById('skills-lang')?.value || '').trim();
        const skillsParts = [];
        if (skillsTech) skillsParts.push(`Technical: ${skillsTech}`);
        if (skillsSoft) skillsParts.push(`Soft Skills: ${skillsSoft}`);
        if (skillsLang) skillsParts.push(`Bahasa: ${skillsLang}`);

        const userInput = [
            `Nama: ${name}`,
            `Email: ${email}`,
            `Telepon: ${phone || '-'}`,
            `Lokasi: ${location || '-'}`,
            `Profil Singkat: ${summary || '-'}`,
            `Pendidikan:\n${eduLines.length ? eduLines.map(l => '  - ' + l).join('\n') : '-'}`,
            `Pengalaman Kerja:\n${expLines.length ? expLines.map(l => '  - ' + l).join('\n') : '-'}`,
            `Keahlian: ${skillsParts.length ? skillsParts.join(' | ') : '-'}`,
        ].join('\n');

        const generateBtn = document.getElementById('generate-cv-btn');
        const btnIcon = document.getElementById('btn-icon-sparkle');
        const btnSpinner = document.getElementById('btn-icon-spin');
        const btnLabel = document.getElementById('btn-label');

        if (btnIcon) btnIcon.classList.add('hidden');
        if (btnSpinner) btnSpinner.classList.remove('hidden');
        if (btnLabel) btnLabel.textContent = 'Menyusun CV...';
        if (generateBtn) generateBtn.disabled = true;

        this.showLoading();

        try {
            const response = await fetch('/ajax/generate-cv', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf
                },
                body: JSON.stringify({ user_input: userInput })
            });

            const data = await response.json();

            if (data.success) {
                this.currentCvHtml = data.cv;
                this.renderTemplate(this.currentTemplate, this.currentCvHtml, this.previewContent);
                this.renderTemplate(this.currentTemplate, this.currentCvHtml, this.wysiwygContent);
                this.showPreview();
            } else {
                this.hideLoading();
                alert('Gagal generate CV: ' + (data.error || 'Error'));
            }
        } catch (error) {
            console.error('Error generating CV:', error);
            this.hideLoading();
            alert('Terjadi kesalahan jaringan.');
        } finally {
            if (btnIcon) btnIcon.classList.remove('hidden');
            if (btnSpinner) btnSpinner.classList.add('hidden');
            if (btnLabel) btnLabel.textContent = 'Generate with AI';
            if (generateBtn) generateBtn.disabled = false;
        }
    }

    handleTemplateSelect(event) {
        const card = event.target.closest('.tpl-card');
        if (!card) return;

        document.querySelectorAll('.tpl-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');

        this.currentTemplate = card.dataset.template;

        if (this.currentCvHtml) {
            if (!this.wysiwygEditor.classList.contains('hidden')) {
                this.currentCvHtml = this.getCleanHtml(this.wysiwygContent);
            }
            this.renderTemplate(this.currentTemplate, this.currentCvHtml, this.previewContent);
            this.renderTemplate(this.currentTemplate, this.currentCvHtml, this.wysiwygContent);
        }
    }

    showPreview() {
        this.currentCvHtml = this.getCleanHtml(this.wysiwygContent);
        this.renderTemplate(this.currentTemplate, this.currentCvHtml, this.previewContent);
        this.hideLoading();
        this.emptyState.style.display = 'none';
        this.previewPaper.style.display = 'flex';
        this.wysiwygEditor.classList.add('hidden');

        const tabPreview = document.getElementById('tab-preview');
        const tabEdit = document.getElementById('tab-edit');
        if (tabPreview) tabPreview.classList.add('active');
        if (tabEdit) tabEdit.classList.remove('active');
    }

    showEdit() {
        this.renderTemplate(this.currentTemplate, this.currentCvHtml, this.wysiwygContent);
        this.previewPaper.style.display = 'none';
        this.wysiwygEditor.classList.remove('hidden');

        const tabEdit = document.getElementById('tab-edit');
        const tabPreview = document.getElementById('tab-preview');
        if (tabEdit) tabEdit.classList.add('active');
        if (tabPreview) tabPreview.classList.remove('active');
    }

    async handleSaveCv() {
        const htmlToSave = this.wysiwygEditor.classList.contains('hidden')
            ? this.currentCvHtml
            : this.getCleanHtml(this.wysiwygContent);

        const saveBtn = document.getElementById('save-cv-btn');
        if (saveBtn) {
            saveBtn.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
            saveBtn.disabled = true;
        }

        try {
            await fetch('/ajax/generate-cv', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrf
                },
                body: JSON.stringify({ user_input: '__SAVE_ONLY__', cv_html: htmlToSave })
            });

            this.currentCvHtml = htmlToSave;
            const feedback = document.getElementById('save-feedback');
            if (feedback) {
                feedback.classList.remove('hidden');
                setTimeout(() => feedback.classList.add('hidden'), 2500);
            }
        } catch (error) {
            console.error('Error saving CV:', error);
            alert('Failed to save CV.');
        } finally {
            if (saveBtn) {
                saveBtn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Save CV';
                saveBtn.disabled = false;
            }
        }
    }

    handleDownloadPdf() {
        const downloadBtn = document.getElementById('download-pdf-btn');
        if (downloadBtn) {
            downloadBtn.innerHTML = '<svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Preparing...';
            downloadBtn.disabled = true;
        }

        const element = this.previewPaper.style.display === 'none' ? this.wysiwygContent : this.previewContent;
        const options = {
            margin: [10, 10, 10, 10],
            filename: 'CV-LookForJob.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, logging: false },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(options).from(element).save().then(() => {
            if (downloadBtn) {
                downloadBtn.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Download PDF';
                downloadBtn.disabled = false;
            }
        });
    }

    getCleanHtml(container) {
        let raw = '';
        
        if (container.querySelector('.tpl-modern-sidebar')) {
            raw += container.querySelector('.tpl-modern-sidebar').innerHTML;
            raw += container.querySelector('.tpl-modern-main').innerHTML;
        } else if (container.querySelector('.tpl-creative-header-wrap')) {
            raw += container.querySelector('.tpl-creative-header-wrap').innerHTML;
            raw += container.querySelector('.tpl-creative-body-wrap').innerHTML;
        } else {
            raw = container.innerHTML;
        }
        
        return raw;
    }

    renderTemplate(tpl, html, container) {
        container.className = 'tpl-' + tpl;
        const doc = document.createElement('div');
        doc.innerHTML = html;

        if (tpl === 'modern') {
            const h2Count = doc.querySelectorAll('h2').length;
            let sidebar = '', main = '', sectionCount = 0;
            
            Array.from(doc.childNodes).forEach(node => {
                if (node.tagName === 'H2') sectionCount++;
                if (sectionCount <= (h2Count > 3 ? 2 : 1)) {
                    sidebar += (node.outerHTML || node.textContent);
                } else {
                    main += (node.outerHTML || node.textContent);
                }
            });
            
            container.innerHTML = `<div class="tpl-modern-sidebar">${sidebar}</div><div class="tpl-modern-main">${main}</div>`;
        } else if (tpl === 'creative') {
            let header = '', body = '', inBody = false;
            
            Array.from(doc.childNodes).forEach(node => {
                if (node.tagName === 'H2') inBody = true;
                if (!inBody) {
                    header += (node.outerHTML || node.textContent);
                } else {
                    body += (node.outerHTML || node.textContent);
                }
            });
            
            container.innerHTML = `<div class="tpl-creative-header-wrap">${header}</div><div class="tpl-creative-body-wrap">${body}</div>`;
        } else {
            container.innerHTML = html;
        }
    }

    showLoading() {
        if (this.loadingSkeleton) this.loadingSkeleton.style.display = 'block';
        if (this.emptyState) this.emptyState.style.display = 'none';
    }

    hideLoading() {
        if (this.loadingSkeleton) this.loadingSkeleton.style.display = 'none';
        if (this.emptyState) this.emptyState.style.display = 'none';
    }
}

// Export for use in browser
window.CVBuilder = CVBuilder;

// Initialize - handles both cases: DOM already ready or still loading
// Vite bundles as type="module" (deferred), so DOMContentLoaded may
// have already fired by the time this code runs.
function initCVBuilder() {
    // Only initialize on the CV page
    if (!document.getElementById('cv-page')) return;

    const cvBuilderData = window.cvBuilderData || {};
    window.cvBuilder = new CVBuilder(cvBuilderData);
}

if (document.readyState === 'loading') {
    // DOM not yet ready — wait for it
    document.addEventListener('DOMContentLoaded', initCVBuilder);
} else {
    // DOM already parsed — run immediately
    initCVBuilder();
}
