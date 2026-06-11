@extends('layouts.main')

@section('title', 'Generator CV AI - Look For Job')
@section('meta_description', 'Susun resume/CV profesional Anda dalam hitungan detik menggunakan teknologi AI Generator gratis dari Look For Job.')

@section('content')
<style>
/* ===================== CSS VARIABLES ===================== */
:root {
    --linear-primary: #10b981;
    --linear-ink: #0f172a;
    --linear-ink-subtle: #64748b;
    --linear-canvas: #f8fafc;
    --linear-surface-1: #ffffff;
    --linear-surface-2: #f1f5f9;
    --linear-surface-3: #e2e8f0;
    --linear-hairline: #e2e8f0;
}
.dark {
    --linear-primary: #10b981;
    --linear-ink: #f8fafc;
    --linear-ink-subtle: #94a3b8;
    --linear-canvas: #020617;
    --linear-surface-1: #0f172a;
    --linear-surface-2: #1e293b;
    --linear-surface-3: #334155;
    --linear-hairline: #334155;
}

/* ===================== PAGE LAYOUT ===================== */
#cv-page { display: flex; min-height: calc(100vh - 64px); }

/* ---- Left Panel ---- */
#cv-left-panel {
    width: 360px; min-width: 320px; max-width: 400px;
    background: var(--linear-surface-1); border-right: 1px solid var(--linear-hairline);
    display: flex; flex-direction: column; overflow-y: auto;
    position: sticky; top: 0; height: calc(100vh - 64px);
}
#cv-left-panel::-webkit-scrollbar { width: 4px; }
#cv-left-panel::-webkit-scrollbar-thumb { background: var(--linear-hairline); border-radius: 2px; }

/* ---- Right Panel ---- */
#cv-right-panel { flex: 1; background: var(--linear-canvas); display: flex; flex-direction: column; overflow: hidden; }

/* ---- Accordion ---- */
.form-section-body { overflow: hidden; transition: max-height 0.3s ease, opacity 0.3s ease; }
.form-section-body.collapsed { max-height: 0 !important; opacity: 0; }

/* ---- Inputs ---- */
.cv-input {
    display: block; width: 100%; border: 1px solid var(--linear-hairline); border-radius: 8px;
    padding: 8px 12px; font-size: 13px; color: var(--linear-ink);
    transition: border-color .15s, box-shadow .15s; outline: none; background: var(--linear-canvas);
}
.cv-input:focus { border-color: var(--linear-primary); box-shadow: 0 0 0 3px rgba(94,106,210,.12); background: var(--linear-surface-2); }
.cv-label { display: block; font-size: 11px; font-weight: 700; color: var(--linear-ink-subtle); text-transform: uppercase; letter-spacing: 0.07em; margin-bottom: 4px; }

/* ---- Template Cards ---- */
.tpl-card { border: 1px solid var(--linear-hairline); border-radius: 10px; cursor: pointer; transition: all .2s; padding: 4px; background: var(--linear-surface-2); width: 92px; flex-shrink: 0; }
.tpl-card:hover { border-color: var(--linear-primary); transform: translateY(-1px); background: var(--linear-surface-3); }
.tpl-card.active { border-color: var(--linear-primary); box-shadow: 0 0 0 3px rgba(94, 106, 210, 0.15); background: var(--linear-surface-3); }
.tpl-card-thumb { height: 52px; border-radius: 6px; overflow: hidden; margin-bottom: 3px; border: 1px solid var(--linear-hairline); background: var(--linear-surface-1); }
.tpl-card p { white-space: nowrap; overflow: visible; text-overflow: clip; width: 100%; text-align: center; }

/* ---- Tabs ---- */
.tab-pill { transition: all .15s; font-size: 12px; font-weight: 600; padding: 5px 14px; border-radius: 20px; color: #64748b; }
.tab-pill.active { background: var(--linear-primary); color: #fff; }

/* ---- Toolbar ---- */
#cv-toolbar { background: var(--linear-surface-1); border-bottom: 1px solid var(--linear-hairline); padding: 10px 20px; display: flex; align-items: center; gap: 12px; flex-shrink: 0; }

/* ---- Preview ---- */
#cv-preview-scroll { flex: 1; overflow-y: auto; padding: 24px; display: flex; justify-content: center; }
#cv-preview-paper { width: 100%; max-width: 800px; background: #fff; box-shadow: 0 4px 24px rgba(0,0,0,.05); border border-slate-200 dark:border-slate-700; border-radius: 4px; min-height: 700px; }
/* Classic & Minimal: add padding via the element itself (they have their own padding in tpl-* CSS) */
/* Modern & Creative: full-bleed header, so no extra wrapper padding */
#cv-preview-content { width: 100%; box-sizing: border-box; word-break: break-word; overflow-wrap: break-word; }

/* ---- WYSIWYG Editor ---- */
#cv-wysiwyg-editor {
    width: 100%; max-width: 800px;
    background: #fff;
    box-shadow: 0 4px 24px rgba(0,0,0,.05); border border-slate-200 dark:border-slate-700;
    border-radius: 4px; min-height: 700px;
    outline: none;
    padding: 0;
}
#cv-wysiwyg-editor:focus-within { box-shadow: 0 0 0 2px #5e6ad2, 0 4px 24px rgba(0,0,0,.05); }

/* WYSIWYG toolbar */
#wysiwyg-toolbar {
    position: sticky; top: 0; z-index: 10;
    background: #1e293b; color: #fff;
    padding: 8px 16px;
    display: flex; align-items: center; gap: 4px; flex-wrap: wrap;
    border-radius: 4px 4px 0 0;
}
.wysiwyg-btn {
    padding: 4px 8px; border-radius: 6px; border: none; background: transparent;
    color: #cbd5e1; cursor: pointer; font-size: 12px; font-weight: 600;
    transition: background .15s;
    display: inline-flex; align-items: center; gap: 4px;
}
.wysiwyg-btn:hover { background: rgba(255,255,255,.12); color: #fff; }
.wysiwyg-sep { width: 1px; height: 20px; background: rgba(255,255,255,.12); margin: 0 4px; }
#cv-wysiwyg-content {
    min-height: 650px; outline: none; box-sizing: border-box;
}
#cv-wysiwyg-content:focus { outline: none; }

/* ---- Templates ---- */
/* Note: padding on tpl-* is used inside WYSIWYG editor; in preview the wrapper adds padding */
.tpl-classic { font-family: 'Georgia', serif; color: #1a1a1a; background: #fff; padding: 60px 72px; }
.tpl-classic h1 { font-size: 2em; font-weight: bold; color: #111827; border-bottom: 3px solid #5e6ad2; padding-bottom: 8px; margin-bottom: 6px; }
.tpl-classic h2 { font-size: .95em; font-weight: bold; border-bottom: 1px solid #d1d5db; padding-bottom: 4px; margin-top: 22px; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1.5px; color: #374151; }
.tpl-classic p, .tpl-classic li { font-size: .9em; line-height: 1.75; margin-bottom: 4px; }
.tpl-classic ul { padding-left: 18px; }

.tpl-modern { font-family: 'Inter', sans-serif; color: #1e293b; background: #fff; display: flex; min-height: 600px; }
.tpl-modern-sidebar { background: #1e293b; color: #fff; width: 220px; min-width: 220px; padding: 40px 24px; flex-shrink: 0; }
.tpl-modern-main { padding: 40px 48px; flex: 1; }
.tpl-modern-sidebar h1 { font-size: 1.4em; font-weight: 800; color: #fff; line-height: 1.3; margin-bottom: 6px; }
.tpl-modern-sidebar h2 { font-size: .65em; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #94a3b8; margin-top: 20px; margin-bottom: 6px; border-bottom: 1px solid rgba(255,255,255,.15); padding-bottom: 3px; }
.tpl-modern-sidebar p, .tpl-modern-sidebar li { font-size: .8em; line-height: 1.6; color: #cbd5e1; }
.tpl-modern-sidebar ul { padding-left: 14px; }
.tpl-modern-main h1 { color: #111827; font-size: 1.9em; font-weight: 800; }
.tpl-modern-main h2 { font-size: .75em; font-weight: 700; color: #5e6ad2; text-transform: uppercase; letter-spacing: 1.5px; border-bottom: 2px solid #e2e8f0; padding-bottom: 3px; margin-top: 22px; margin-bottom: 8px; }
.tpl-modern-main p, .tpl-modern-main li { font-size: .88em; line-height: 1.7; }
.tpl-modern-main ul { padding-left: 16px; }

.tpl-minimal { font-family: 'Inter', sans-serif; color: #374151; background: #fff; padding: 60px 72px; }
.tpl-minimal h1 { font-size: 2.4em; font-weight: 200; letter-spacing: -1.5px; color: #111; margin-bottom: 4px; }
.tpl-minimal h2 { font-size: .68em; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: #9ca3af; margin-top: 32px; margin-bottom: 10px; }
.tpl-minimal p, .tpl-minimal li { font-size: .9em; line-height: 1.85; color: #4b5563; }
.tpl-minimal ul { padding-left: 0; list-style: none; }
.tpl-minimal ul li::before { content: "— "; color: #d1d5db; }

.tpl-creative { font-family: 'Inter', sans-serif; color: #1e293b; background: #fff; padding: 0; }
.tpl-creative-header-wrap { background: linear-gradient(135deg, #10b981, #059669); padding: 48px 60px 36px; color: #fff; }
.tpl-creative-body-wrap { padding: 36px 60px 60px; }
.tpl-creative h1 { font-size: 2.1em; font-weight: 800; color: #fff; margin-bottom: 4px; }
.tpl-creative h2 { font-size: .9em; font-weight: 700; color: #10b981; margin-top: 26px; margin-bottom: 8px; padding-left: 10px; border-left: 4px solid #10b981; }
.tpl-creative p, .tpl-creative li { font-size: .9em; line-height: 1.75; }
.tpl-creative ul { padding-left: 20px; }

/* ---- Empty/Loading ---- */
#cv-empty-state { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; min-height: 500px; color: var(--linear-ink-subtle); }
@keyframes shimmer { 0%,100%{opacity:.4} 50%{opacity:.9} }
.shimmer-line { animation: shimmer 1.5s ease-in-out infinite; background: var(--linear-hairline); border-radius: 4px; }

@media (max-width: 768px) {
    #cv-page { flex-direction: column; }
    #cv-left-panel { width: 100%; max-width: 100%; height: auto; position: relative; border-right: none; border-bottom: 1px solid var(--linear-hairline); }
    #cv-right-panel { height: 70vh; }
}
</style>

<div id="cv-page">

    {{-- ============================================================ --}}
    {{-- LEFT PANEL                                                    --}}
    {{-- ============================================================ --}}
    <div id="cv-left-panel">

        {{-- Header --}}
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex-shrink-0">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-sm font-extrabold text-slate-900 dark:text-white leading-tight">Generator CV AI</h1>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Isi data · AI susun · Download PDF</p>
                </div>
            </div>
        </div>

        {{-- Form Sections --}}
        <div class="flex-1 overflow-y-auto px-5 py-4 space-y-1">

            {{-- Data Diri --}}
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
                            <input type="text" id="name" class="cv-input" required value="{{ Auth::user()->name }}" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="cv-label">Alamat Email</label>
                            <input type="email" id="email" class="cv-input" required value="{{ Auth::user()->email }}" placeholder="john@email.com">
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

            {{-- Profil Singkat --}}
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5" data-target="sec-summary">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Profil Singkat</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform" id="arrow-sec-summary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body collapsed pb-3" id="sec-summary" style="max-height:0;">
                    <textarea id="summary" class="cv-input" rows="3" placeholder="Singkat tentang passion, kepribadian, atau tujuan karir Anda..."></textarea>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 my-1"></div>

            {{-- Pendidikan --}}
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5" data-target="sec-edu">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-violet-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Pendidikan</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform" id="arrow-sec-edu" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body collapsed pb-3" id="sec-edu" style="max-height:0;">
                    <textarea id="education" class="cv-input" rows="3" placeholder="Contoh: S1 Sistem Informasi, Univ. Indonesia (2018-2022), IPK 3.8"></textarea>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 my-1"></div>

            {{-- Pengalaman --}}
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5" data-target="sec-exp">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Pengalaman Kerja</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform" id="arrow-sec-exp" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body collapsed pb-3" id="sec-exp" style="max-height:0;">
                    <textarea id="experience" class="cv-input" rows="4" placeholder="Jabatan, Perusahaan (Tahun - Tahun) — Deskripsi singkat tugas dan pencapaian..."></textarea>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 my-1"></div>

            {{-- Keahlian --}}
            <div class="form-section">
                <button type="button" class="form-section-header w-full flex items-center justify-between py-2.5" data-target="sec-skills">
                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-lg bg-rose-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Keahlian</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform" id="arrow-sec-skills" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="form-section-body collapsed pb-3" id="sec-skills" style="max-height:0;">
                    <input type="text" id="skills" class="cv-input" placeholder="HTML, CSS, JavaScript, Komunikasi, Analisis...">
                </div>
            </div>
        </div>

        {{-- Footer CTA --}}
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
                <span id="btn-label">Generate CV dengan AI</span>
            </button>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" id="save-cv-btn"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-bold text-slate-900 dark:text-white bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-700 rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Simpan CV
                </button>
                <button type="button" id="download-pdf-btn"
                    class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-xs font-bold text-emerald-500 bg-emerald-500/10 hover:bg-emerald-500/20 border border-transparent rounded-xl transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download PDF
                </button>
            </div>
            <div id="save-feedback" class="hidden text-center text-xs font-semibold text-emerald-500 py-1 rounded-lg bg-emerald-500/10">
                CV berhasil disimpan!
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- RIGHT PANEL                                                   --}}
    {{-- ============================================================ --}}
    <div id="cv-right-panel">

        {{-- Toolbar --}}
        <div id="cv-toolbar">
            {{-- Template Selector --}}
            <div class="flex items-center gap-2 flex-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest shrink-0">Template</span>
                <div class="flex gap-2" id="template-selector">

                    {{-- Classic --}}
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

                    {{-- Modern --}}
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

                    {{-- Minimal --}}
                    <div class="tpl-card" data-template="minimal" title="Minimal">
                        <div class="tpl-card-thumb bg-white dark:bg-slate-900" style="padding:6px 6px;">
                            <div style="height:8px;background:#111;border-radius:1px;width:60%;margin-bottom:6px;"></div>
                            <div style="height:2px;background:#e5e7eb;border-radius:1px;margin:2px 0;width:100%;"></div>
                            <div style="height:2px;background:#e5e7eb;border-radius:1px;margin:2px 0;width:90%;"></div>
                            <div style="height:2px;background:#e5e7eb;border-radius:1px;margin:2px 0;width:80%;"></div>
                        </div>
                        <p class="text-center text-[11px] font-semibold text-slate-900 dark:text-white mt-1">Minimal</p>
                    </div>

                    {{-- Creative --}}
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

            {{-- View Toggle --}}
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

        {{-- Preview Scroll Area --}}
        <div id="cv-preview-scroll">

            {{-- PREVIEW PAPER --}}
            <div id="cv-preview-paper">
                <div id="cv-empty-state" @if(Auth::user()->cv_html) style="display:none" @endif>
                    <div class="w-20 h-20 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex items-center justify-center mb-5 shadow-lg">
                        <svg class="w-10 h-10 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-base font-semibold text-slate-900 dark:text-white mb-1">CV Anda akan tampil di sini</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Isi data di panel kiri lalu klik Generate</p>
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

                <div id="cv-preview-content" class="tpl-classic" @if(!Auth::user()->cv_html) style="display:none" @endif>
                    @if(Auth::user()->cv_html)
                        {!! Auth::user()->cv_html !!}
                    @endif
                </div>
            </div>

            {{-- WYSIWYG EDITOR (hidden by default) --}}
            <div id="cv-wysiwyg-editor" class="hidden w-full max-w-3xl">
                {{-- Formatting Toolbar --}}
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
                {{-- Editable content --}}
                <div id="cv-wysiwyg-content" contenteditable="true" class="tpl-classic">
                    @if(Auth::user()->cv_html) {!! Auth::user()->cv_html !!} @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentCvHtml = @json(Auth::user()->cv_html ?? '');
    let currentTemplate = 'classic';
    const CSRF = '{{ csrf_token() }}';

    const previewContent  = document.getElementById('cv-preview-content');
    const wysiwygContent  = document.getElementById('cv-wysiwyg-content');
    const emptyState      = document.getElementById('cv-empty-state');
    const loadingSkeleton = document.getElementById('cv-loading');
    const previewPaper    = document.getElementById('cv-preview-paper');
    const wysiwygEditor   = document.getElementById('cv-wysiwyg-editor');

    if (currentCvHtml) {
        renderTemplate(currentTemplate, currentCvHtml, previewContent);
        renderTemplate(currentTemplate, currentCvHtml, wysiwygContent);
    }

    // ===================== ACCORDION =====================
    document.querySelectorAll('.form-section-header').forEach(header => {
        header.addEventListener('click', () => {
            const id   = header.dataset.target;
            const body = document.getElementById(id);
            const arr  = document.getElementById('arrow-' + id);
            const open = !body.classList.contains('collapsed');
            if (open) {
                body.classList.add('collapsed'); body.style.maxHeight = '0';
                if (arr) arr.style.transform = '';
            } else {
                body.classList.remove('collapsed'); body.style.maxHeight = '500px';
                if (arr) arr.style.transform = 'rotate(180deg)';
            }
        });
    });

    // ===================== GENERATE =====================
    document.getElementById('generate-cv-btn').addEventListener('click', async function () {
        const fields = ['name','email','phone','location','summary','education','experience','skills'];
        const v = {};
        fields.forEach(f => v[f] = (document.getElementById(f)?.value || '').trim());

        const userInput = `Nama: ${v.name}\nEmail: ${v.email}\nTelepon: ${v.phone||'-'}\nLokasi: ${v.location||'-'}\nRingkasan Profil: ${v.summary||'-'}\nPendidikan: ${v.education||'-'}\nPengalaman Kerja: ${v.experience||'-'}\nKeahlian: ${v.skills||'-'}`;

        document.getElementById('btn-icon-sparkle').classList.add('hidden');
        document.getElementById('btn-icon-spin').classList.remove('hidden');
        document.getElementById('btn-label').textContent = 'Menyusun CV...';
        this.disabled = true;
        showLoading();

        try {
            const res  = await fetch('/api/generate-cv', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ user_input: userInput }),
            });
            const data = await res.json();

            if (data.success) {
                currentCvHtml = data.cv;
                renderTemplate(currentTemplate, currentCvHtml, previewContent);
                renderTemplate(currentTemplate, currentCvHtml, wysiwygContent);
                showPreview();
            } else {
                hideLoading();
                alert('Gagal generate CV: ' + (data.error || 'Error'));
            }
        } catch { hideLoading(); alert('Terjadi kesalahan jaringan.'); }
        finally {
            document.getElementById('btn-icon-sparkle').classList.remove('hidden');
            document.getElementById('btn-icon-spin').classList.add('hidden');
            document.getElementById('btn-label').textContent = 'Generate CV dengan AI';
            this.disabled = false;
        }
    });

    // ===================== TEMPLATE =====================
    document.getElementById('template-selector').addEventListener('click', function (e) {
        const card = e.target.closest('.tpl-card');
        if (!card) return;
        document.querySelectorAll('.tpl-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        currentTemplate = card.dataset.template;
        if (currentCvHtml) {
            if (!wysiwygEditor.classList.contains('hidden')) {
                currentCvHtml = getCleanHtml(wysiwygContent);
            }
            renderTemplate(currentTemplate, currentCvHtml, previewContent);
            renderTemplate(currentTemplate, currentCvHtml, wysiwygContent);
        }
    });

    // ===================== TABS =====================
    document.getElementById('tab-preview').addEventListener('click', function () {
        // Sync from wysiwyg → preview
        currentCvHtml = getCleanHtml(wysiwygContent);
        renderTemplate(currentTemplate, currentCvHtml, previewContent);
        showPreview();
        this.classList.add('active');
        document.getElementById('tab-edit').classList.remove('active');
    });

    document.getElementById('tab-edit').addEventListener('click', function () {
        // Render currentCvHtml to wysiwyg
        renderTemplate(currentTemplate, currentCvHtml, wysiwygContent);
        previewPaper.style.display = 'none';
        wysiwygEditor.classList.remove('hidden');
        this.classList.add('active');
        document.getElementById('tab-preview').classList.remove('active');
    });

    // Save wysiwyg changes on input
    wysiwygContent.addEventListener('input', function () {
        currentCvHtml = getCleanHtml(wysiwygContent);
    });

    // ===================== SAVE =====================
    document.getElementById('save-cv-btn').addEventListener('click', async function () {
        // Prioritize current edit state
        const htmlToSave = wysiwygEditor.classList.contains('hidden')
            ? currentCvHtml
            : getCleanHtml(wysiwygContent);

        this.textContent = 'Menyimpan...';
        this.disabled = true;
        try {
            await fetch('/api/generate-cv', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ user_input: '__SAVE_ONLY__', cv_html: htmlToSave }),
            });
            currentCvHtml = htmlToSave;
            const fb = document.getElementById('save-feedback');
            fb.classList.remove('hidden');
            setTimeout(() => fb.classList.add('hidden'), 2500);
        } catch {}
        this.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Simpan CV';
        this.disabled = false;
    });

    // ===================== DOWNLOAD PDF =====================
    document.getElementById('download-pdf-btn').addEventListener('click', function () {
        const el = previewPaper.style.display === 'none' ? wysiwygContent : previewContent;
        const opt = {
            margin: [10,10,10,10], filename: 'CV-LookForJob.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, logging: false },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        this.textContent = 'Menyiapkan...'; this.disabled = true;
        html2pdf().set(opt).from(el).save().then(() => {
            this.innerHTML = '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg> Download PDF';
            this.disabled = false;
        });
    });

    // ===================== HELPERS =====================
    function showLoading() {
        emptyState.style.display = 'none';
        previewContent.style.display = 'none';
        loadingSkeleton.classList.remove('hidden');
    }
    function hideLoading() { loadingSkeleton.classList.add('hidden'); }
    function showPreview() {
        previewPaper.style.display = 'block';
        wysiwygEditor.classList.add('hidden');
        hideLoading();
        emptyState.style.display = 'none';
        previewContent.style.display = 'block';
    }

    function getCleanHtml(container) {
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

    function renderTemplate(tpl, html, container) {
        container.className = 'tpl-' + tpl;
        const d = document.createElement('div');
        d.innerHTML = html;
        
        if (tpl === 'modern') {
            let h2Count = d.querySelectorAll('h2').length;
            let sb = '', mn = '', sc = 0;
            Array.from(d.childNodes).forEach(n => {
                if (n.tagName === 'H2') sc++;
                if (sc <= (h2Count > 3 ? 2 : 1)) sb += (n.outerHTML || n.textContent);
                else mn += (n.outerHTML || n.textContent);
            });
            container.innerHTML = `<div class="tpl-modern-sidebar">${sb}</div><div class="tpl-modern-main">${mn}</div>`;
        } else if (tpl === 'creative') {
            let hw = '', bw = '';
            let inBody = false;
            Array.from(d.childNodes).forEach(n => {
                if (n.tagName === 'H2') inBody = true;
                if (!inBody) hw += (n.outerHTML || n.textContent);
                else bw += (n.outerHTML || n.textContent);
            });
            container.innerHTML = `<div class="tpl-creative-header-wrap">${hw}</div><div class="tpl-creative-body-wrap">${bw}</div>`;
        } else {
            container.innerHTML = html;
        }
    }
});
</script>
@endsection
