

<?php $__env->startSection('title', 'AI Resume Builder - LookForJob'); ?>
<?php $__env->startSection('meta_description', 'Create professional resumes in seconds with AI-powered resume builder from LookForJob.'); ?>

<?php $__env->startSection('content'); ?>

<div id="cv-page">

    
    
    
    <div id="cv-left-panel">

        
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex-shrink-0">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-sm font-extrabold text-slate-900 dark:text-white leading-tight">AI Resume Builder</h1>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Fill data · AI generates · Download PDF</p>
                </div>
            </div>
        </div>

        
        <div class="flex-1 overflow-y-auto px-5 py-4 space-y-1">

            
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5 group" data-target="sec-personal">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Data Diri</span>
                        <span class="text-[10px] text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded font-semibold ml-1">Wajib</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform rotate-180" id="arrow-sec-personal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body space-y-3 pb-3" id="sec-personal" style="max-height:400px;">
                    <div class="grid grid-cols-1 gap-3">
                        <div>
                            <label class="cv-label">Nama Lengkap</label>
                            <input type="text" id="name" class="cv-input" required value="<?php echo e(Auth::user()->name); ?>" placeholder="Naufal">
                        </div>
                        <div>
                            <label class="cv-label">Alamat Email</label>
                            <input type="email" id="email" class="cv-input" required value="<?php echo e(Auth::user()->email); ?>" placeholder="naufal@gmail.com">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="cv-label">Telepon</label>
                                <input type="text" id="phone" class="cv-input" placeholder="08xx-xxxx">
                            </div>
                            <div>
                                <label class="cv-label">Kota</label>
                                <input type="text" id="location" class="cv-input" placeholder="Jakarta">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 my-1"></div>

            
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5" data-target="sec-summary">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Short Profile</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform" id="arrow-sec-summary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body collapsed pb-3" id="sec-summary" style="max-height:0;">
                    <div>
                        <label class="cv-label">About You</label>
                        <textarea id="summary" class="cv-input" rows="4" placeholder="Ceritakan tentang passion, kepribadian, dan tujuan karir kamu..."></textarea>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 my-1"></div>

            
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5" data-target="sec-edu">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-violet-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Education</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform" id="arrow-sec-edu" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body collapsed pb-3" id="sec-edu" style="max-height:0;">
                    <div id="edu-entries" class="space-y-4">
                        
                        <div class="edu-entry cv-entry-card">
                            <div class="space-y-2">
                                <div>
                                    <label class="cv-label">Jenjang & Jurusan</label>
                                    <input type="text" class="cv-input edu-degree" placeholder="Contoh: S1 Teknik Informatika">
                                </div>
                                <div>
                                    <label class="cv-label">Institusi / Universitas</label>
                                    <input type="text" class="cv-input edu-school" placeholder="Contoh: Universitas Indonesia">
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="cv-label">Tahun Mulai</label>
                                        <input type="text" class="cv-input edu-year-start" placeholder="2019">
                                    </div>
                                    <div>
                                        <label class="cv-label">Tahun Selesai</label>
                                        <input type="text" class="cv-input edu-year-end" placeholder="2023 / Sekarang">
                                    </div>
                                </div>
                                <div>
                                    <label class="cv-label">IPK / GPA <span class="normal-case font-normal text-slate-400">(Opsional)</span></label>
                                    <input type="text" class="cv-input edu-gpa" placeholder="Contoh: 3.85 / 4.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-edu-btn" class="cv-add-btn mt-3">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Tambah Pendidikan
                    </button>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 my-1"></div>

            
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5" data-target="sec-exp">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Work Experience</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform" id="arrow-sec-exp" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body collapsed pb-3" id="sec-exp" style="max-height:0;">
                    <div id="exp-entries" class="space-y-4">
                        
                        <div class="exp-entry cv-entry-card">
                            <div class="space-y-2">
                                <div>
                                    <label class="cv-label">Posisi / Jabatan</label>
                                    <input type="text" class="cv-input exp-position" placeholder="Contoh: Frontend Developer">
                                </div>
                                <div>
                                    <label class="cv-label">Perusahaan</label>
                                    <input type="text" class="cv-input exp-company" placeholder="Contoh: PT. Teknologi Maju">
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="cv-label">Mulai</label>
                                        <input type="text" class="cv-input exp-start" placeholder="Jan 2022">
                                    </div>
                                    <div>
                                        <label class="cv-label">Selesai</label>
                                        <input type="text" class="cv-input exp-end" placeholder="Des 2023 / Sekarang">
                                    </div>
                                </div>
                                <div>
                                    <label class="cv-label">Deskripsi Tugas</label>
                                    <textarea class="cv-input exp-desc" rows="3" placeholder="Deskripsikan tanggung jawab dan pencapaian kamu..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-exp-btn" class="cv-add-btn mt-3">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Tambah Pengalaman
                    </button>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 my-1"></div>

            
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5" data-target="sec-skills">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-rose-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Skills</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform" id="arrow-sec-skills" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body collapsed pb-3" id="sec-skills" style="max-height:0;">
                    <div class="space-y-2">
                        <div>
                            <label class="cv-label">Technical Skills</label>
                            <input type="text" id="skills-tech" class="cv-input" placeholder="HTML, CSS, JavaScript, Laravel, MySQL...">
                        </div>
                        <div>
                            <label class="cv-label">Soft Skills</label>
                            <input type="text" id="skills-soft" class="cv-input" placeholder="Komunikasi, Kepemimpinan, Problem Solving...">
                        </div>
                        <div>
                            <label class="cv-label">Bahasa <span class="normal-case font-normal text-slate-400">(Opsional)</span></label>
                            <input type="text" id="skills-lang" class="cv-input" placeholder="Bahasa Indonesia (Native), Inggris (Aktif)...">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700 space-y-2 flex-shrink-0">
            <button type="button" id="generate-cv-btn"
                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-white bg-emerald-500 hover:bg-emerald-500-hover rounded-xl shadow-none transition-all duration-200 active:scale-95">
                <svg id="btn-icon-sparkle" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                <svg id="btn-icon-spin" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="btn-label">Generate with AI</span>
            </button>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" id="save-cv-btn"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-bold text-slate-900 dark:text-white bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-700 rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Save CV
                </button>
                <button type="button" id="download-pdf-btn"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-bold text-emerald-500 bg-emerald-500/10 hover:bg-emerald-500/20 border border-transparent rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download PDF
                </button>
            </div>
            <div id="save-feedback" class="hidden text-center text-xs font-semibold text-emerald-500 py-1 rounded-lg bg-emerald-500/10">
                CV saved successfully!
            </div>
        </div>
    </div>

    
    
    
    <div id="cv-right-panel">

        
        <div id="cv-toolbar">
            
            <div class="flex items-center gap-2 flex-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest shrink-0">Template</span>
                <div class="flex gap-2" id="template-selector">

                    
                    <div class="tpl-card active" data-template="classic" title="Classic">
                        <div class="tpl-card-thumb bg-white dark:bg-slate-900">
                            <div style="padding:6px 6px 0; border-bottom:2px solid #5e6ad2; margin-bottom:3px;">
                                <div style="height:5px;background:#111827;border-radius:2px;width:70%;margin-bottom:2px;"></div>
                            </div>
                            <div style="padding:0 6px;">
                                <div style="height:3px;background:#d1d5db;border-radius:2px;margin:2px 0;width:100%;"></div>
                                <div style="height:3px;background:#d1d5db;border-radius:2px;margin:2px 0;width:80%;"></div>
                                <div style="height:3px;background:#d1d5db;border-radius:2px;margin:2px 0;width:90%;"></div>
                            </div>
                        </div>
                        <p class="text-center text-[11px] font-semibold text-slate-900 dark:text-white mt-1">Classic</p>
                    </div>

                    
                    <div class="tpl-card" data-template="modern" title="Modern">
                        <div class="tpl-card-thumb flex">
                            <div style="width:38%;background:#1e293b;padding:5px 4px;flex-shrink:0;">
                                <div style="height:5px;background:#94a3b8;border-radius:1px;margin-bottom:3px;"></div>
                                <div style="height:2px;background:rgba(255,255,255,.3);border-radius:1px;margin:2px 0;"></div>
                                <div style="height:2px;background:rgba(255,255,255,.3);border-radius:1px;margin:2px 0;width:80%;"></div>
                            </div>
                            <div style="flex:1;padding:5px 4px;">
                                <div style="height:4px;background:#111827;border-radius:1px;margin-bottom:4px;width:80%;"></div>
                                <div style="height:2px;background:#d1d5db;border-radius:1px;margin:2px 0;"></div>
                                <div style="height:2px;background:#d1d5db;border-radius:1px;margin:2px 0;width:85%;"></div>
                            </div>
                        </div>
                        <p class="text-center text-[11px] font-semibold text-slate-900 dark:text-white mt-1">Modern</p>
                    </div>

                    
                    <div class="tpl-card" data-template="minimal" title="Minimal">
                        <div class="tpl-card-thumb bg-white dark:bg-slate-900" style="padding:6px 6px;">
                            <div style="height:8px;background:#111;border-radius:1px;width:60%;margin-bottom:6px;"></div>
                            <div style="height:2px;background:#e5e7eb;border-radius:1px;margin:2px 0;width:100%;"></div>
                            <div style="height:2px;background:#e5e7eb;border-radius:1px;margin:2px 0;width:90%;"></div>
                            <div style="height:2px;background:#e5e7eb;border-radius:1px;margin:2px 0;width:80%;"></div>
                        </div>
                        <p class="text-center text-[11px] font-semibold text-slate-900 dark:text-white mt-1">Minimal</p>
                    </div>

                    
                    <div class="tpl-card" data-template="creative" title="Creative">
                        <div class="tpl-card-thumb">
                            <div style="background:linear-gradient(135deg,#10b981,#059669);padding:6px 6px;height:22px;display:flex;align-items:center;">
                                <div style="height:5px;background:rgba(255,255,255,.8);border-radius:1px;width:60%;"></div>
                            </div>
                            <div style="padding:4px 6px;">
                                <div style="height:3px;background:#10b981;border-radius:1px;width:4px;float:left;margin-right:3px;margin-top:2px;"></div>
                                <div style="height:2px;background:#d1d5db;border-radius:1px;margin:2px 0 2px 7px;"></div>
                                <div style="height:2px;background:#d1d5db;border-radius:1px;margin:2px 0;width:85%;clear:both;"></div>
                            </div>
                        </div>
                        <p class="text-center text-[11px] font-semibold text-slate-900 dark:text-white mt-1">Creative</p>
                    </div>

                </div>
            </div>

            
            <div class="flex bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-full p-1 flex-shrink-0 gap-0.5">
                <button id="tab-preview" class="tab-pill active flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Preview
                </button>
                <button id="tab-edit" class="tab-pill flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit CV
                </button>
            </div>
        </div>

        
        <div id="cv-preview-scroll">

            
            <div id="cv-preview-paper">
                <div id="cv-empty-state" <?php if(Auth::user()->cv_html): ?> style="display:none" <?php endif; ?>>
                    <div class="w-20 h-20 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center mb-5 shadow-lg">
                        <svg class="w-10 h-10 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-base font-semibold text-slate-900 dark:text-white mb-1">Your CV will appear here</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Fill in the data on the left panel then click Generate</p>
                </div>

                <div id="cv-loading" class="hidden p-10 space-y-3">
                    <div class="shimmer-line h-7 w-1/2 mb-6"></div>
                    <div class="shimmer-line h-3 w-full"></div>
                    <div class="shimmer-line h-3 w-5/6"></div>
                    <div class="shimmer-line h-3 w-4/5"></div>
                    <div class="shimmer-line h-4 w-1/3 mt-6"></div>
                    <div class="shimmer-line h-3 w-full"></div>
                    <div class="shimmer-line h-3 w-3/4"></div>
                    <div class="shimmer-line h-4 w-1/3 mt-4"></div>
                    <div class="shimmer-line h-3 w-full"></div>
                    <div class="shimmer-line h-3 w-5/6"></div>
                    <div class="shimmer-line h-3 w-4/6"></div>
                </div>

                <div id="cv-preview-content" class="tpl-classic" <?php if(!Auth::user()->cv_html): ?> style="display:none" <?php endif; ?>>
                    <?php if(Auth::user()->cv_html): ?>
                        <?php echo Auth::user()->cv_html; ?>

                    <?php endif; ?>
                </div>
            </div>

            
            <div id="cv-wysiwyg-editor" class="hidden w-full max-w-3xl">
                
                <div id="wysiwyg-toolbar">
                    <button class="wysiwyg-btn" onclick="document.execCommand('bold')" title="Tebal">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M15.6 10.79c.97-.67 1.65-1.77 1.65-2.79 0-2.26-1.75-4-4-4H7v14h7.04c2.09 0 3.71-1.7 3.71-3.79 0-1.52-.86-2.82-2.15-3.42zM10 6.5h3c.83 0 1.5.67 1.5 1.5S13.83 9.5 13 9.5h-3v-3zm3.5 9H10v-3h3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5z"/></svg>
                        Bold
                    </button>
                    <button class="wysiwyg-btn" onclick="document.execCommand('italic')" title="Miring">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4z"/></svg>
                        Italic
                    </button>
                    <button class="wysiwyg-btn" onclick="document.execCommand('underline')" title="Garis bawah">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17c3.31 0 6-2.69 6-6V3h-2.5v8c0 1.93-1.57 3.5-3.5 3.5S8.5 12.93 8.5 11V3H6v8c0 3.31 2.69 6 6 6zm-7 2v2h14v-2H5z"/></svg>
                        Underline
                    </button>
                    <div class="wysiwyg-sep"></div>
                    <button class="wysiwyg-btn" onclick="document.execCommand('insertUnorderedList')" title="Daftar">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M4 10.5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5 1.5-.67 1.5-1.5-.67-1.5-1.5-1.5zm0-6c-.83 0-1.5.67-1.5 1.5S3.17 7.5 4 7.5 5.5 6.83 5.5 6 4.83 4.5 4 4.5zm0 12c-.83 0-1.5.68-1.5 1.5s.68 1.5 1.5 1.5 1.5-.68 1.5-1.5-.67-1.5-1.5-1.5zM7 19h14v-2H7v2zm0-6h14v-2H7v2zm0-8v2h14V5H7z"/></svg>
                        Daftar
                    </button>
                    <div class="wysiwyg-sep"></div>
                    <button class="wysiwyg-btn" onclick="document.execCommand('removeFormat')" title="Hapus format">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 5v.18L8.82 8h2.4l-.72 1.68 2.1 2.1L14.21 8H20V5H6zm-1.47 9L3 16.53 4.47 18l1.69-1.69 1.69 1.69L9.34 16.5l-1.69-1.69 1.69-1.69-1.49-1.5L6.16 13.3 4.53 14z"/></svg>
                        Reset
                    </button>
                    <div class="wysiwyg-sep"></div>
                    <span class="text-[11px] text-slate-400 ml-1">Klik langsung pada teks CV untuk mulai mengedit</span>
                </div>
                
                <div id="cv-wysiwyg-content" contenteditable="true" class="tpl-classic">
                    <?php if(Auth::user()->cv_html): ?> <?php echo Auth::user()->cv_html; ?> <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    // Pass CV data to cv-builder.js (loaded via Vite bundle in app.js)
    window.cvBuilderData = {
        cvHtml: <?php echo json_encode(Auth::user()->cv_html ?? '', 15, 512) ?>,
        csrf: '<?php echo e(csrf_token()); ?>'
    };
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LookForJob\resources\views/cv.blade.php ENDPATH**/ ?>