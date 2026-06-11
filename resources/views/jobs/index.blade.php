@extends('layouts.main')

@section('title', 'Cari Lowongan Kerja - Look For Job')

@section('content')
<div class="bg-linear-canvas min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="bg-linear-surface-1 rounded-3xl p-8 mb-8 border border-linear-hairline relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-linear-primary/10 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-linear-ink mb-2">Temukan Lowongan <span class="text-linear-primary">Terbaik</span></h1>
                    <p class="text-linear-ink-muted">Menampilkan hasil untuk pencarian Anda.</p>
                </div>
                
                <form method="GET" action="{{ url('/jobs') }}" class="flex-1 max-w-xl flex gap-3" onsubmit="this.location.value = document.getElementById('sidebar-location').value">
                    <!-- Pertahankan lokasi saat mencari dari bar atas -->
                    <input type="hidden" name="location" value="{{ $location }}">
                    <div class="flex-1 relative">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-linear-ink-subtle"></i>
                        <input type="text" name="keyword" id="top-keyword" value="{{ $keyword }}" placeholder="Cari posisi..." class="w-full pl-11 pr-4 py-3 bg-linear-surface-2 border-transparent rounded-2xl focus:bg-linear-surface-3 focus:ring-1 focus:ring-linear-primary focus:border-linear-primary text-linear-ink text-sm transition-all">
                    </div>
                    <button type="submit" class="bg-linear-primary hover:bg-linear-primary-hover text-white px-6 py-3 rounded-2xl font-semibold transition-all">Cari</button>
                </form>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filter -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-linear-surface-1 rounded-3xl p-6 border border-linear-hairline sticky top-28">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-linear-ink text-lg">Filter Pencarian</h3>
                        <a href="{{ url('/jobs') }}" class="text-sm text-linear-primary hover:text-linear-primary-hover font-medium">Reset</a>
                    </div>
                    
                    <form method="GET" action="{{ url('/jobs') }}" class="space-y-6" onsubmit="this.keyword.value = document.getElementById('top-keyword').value">
                        <input type="hidden" name="keyword" value="{{ $keyword }}">
                        
                        <!-- Location Dropdown (Negara -> Kota) -->
                        <div x-data="locationDropdown('{{ addslashes($location) }}')">
                            <h4 class="font-semibold text-linear-ink text-sm mb-3">Lokasi</h4>
                            
                            <div class="space-y-3">
                                <!-- Select Negara (Custom Searchable Dropdown) -->
                                <div class="relative" x-data="{ openCountry: false, searchCountry: '' }" @click.away="openCountry = false">
                                    <div @click="if(!isLoading) openCountry = !openCountry" class="w-full pl-9 pr-8 py-2.5 bg-linear-surface-2 border border-transparent rounded-xl focus:bg-linear-surface-3 focus:ring-1 focus:ring-linear-primary cursor-pointer flex items-center justify-between" :class="isLoading ? 'opacity-50 cursor-not-allowed' : ''">
                                        <i data-lucide="globe" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-linear-ink-subtle"></i>
                                        <span class="text-sm truncate" :class="selectedCountry ? 'text-linear-ink' : 'text-linear-ink-subtle'" x-text="isLoading ? 'Memuat Negara...' : (selectedCountry ? selectedCountry : 'Semua Lokasi')"></span>
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-linear-ink-subtle"></i>
                                    </div>
                                    <div x-show="openCountry" style="display: none;" class="absolute z-50 w-full mt-2 bg-linear-surface-2 border border-linear-hairline rounded-xl shadow-xl max-h-60 overflow-y-auto" x-transition>
                                        <div class="p-2 sticky top-0 bg-linear-surface-2 border-b border-linear-hairline">
                                            <input type="text" x-model="searchCountry" placeholder="Cari negara..." class="w-full px-3 py-2 bg-linear-surface-3 border-transparent focus:border-linear-primary focus:ring-1 focus:ring-linear-primary rounded-lg text-sm text-linear-ink placeholder-linear-ink-subtle" @click.stop>
                                        </div>
                                        <div class="p-1">
                                            <div @click="selectedCountry = ''; updateCities(); openCountry = false" class="px-3 py-2 hover:bg-linear-surface-3 rounded-lg cursor-pointer text-sm text-linear-ink font-medium">Semua Lokasi</div>
                                            <template x-for="country in countriesList.filter(c => c.toLowerCase().includes(searchCountry.toLowerCase()))" :key="country">
                                                <div @click="selectedCountry = country; updateCities(); openCountry = false" class="px-3 py-2 hover:bg-linear-surface-3 rounded-lg cursor-pointer text-sm text-linear-ink" x-text="country"></div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Select Kota (Custom Searchable Dropdown) -->
                                <div class="relative" x-show="selectedCountry" x-transition x-data="{ openCity: false, searchCity: '' }" @click.away="openCity = false">
                                    <div @click="openCity = !openCity" class="w-full pl-9 pr-8 py-2.5 bg-linear-surface-2 border border-transparent rounded-xl focus:bg-linear-surface-3 focus:ring-1 focus:ring-linear-primary cursor-pointer flex items-center justify-between">
                                        <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-linear-ink-subtle"></i>
                                        <span class="text-sm truncate" :class="selectedCity ? 'text-linear-ink' : 'text-linear-ink-subtle'" x-text="selectedCity ? selectedCity : 'Semua Kota'"></span>
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-linear-ink-subtle"></i>
                                    </div>
                                    <div x-show="openCity" style="display: none;" class="absolute z-50 w-full mt-2 bg-linear-surface-2 border border-linear-hairline rounded-xl shadow-xl max-h-60 overflow-y-auto" x-transition>
                                        <div class="p-2 sticky top-0 bg-linear-surface-2 border-b border-linear-hairline">
                                            <input type="text" x-model="searchCity" placeholder="Cari kota..." class="w-full px-3 py-2 bg-linear-surface-3 border-transparent focus:border-linear-primary focus:ring-1 focus:ring-linear-primary rounded-lg text-sm text-linear-ink placeholder-linear-ink-subtle" @click.stop>
                                        </div>
                                        <div class="p-1">
                                            <div @click="selectedCity = ''; openCity = false" class="px-3 py-2 hover:bg-linear-surface-3 rounded-lg cursor-pointer text-sm text-linear-ink font-medium">Semua Kota di <span x-text="selectedCountry"></span></div>
                                            <template x-for="city in availableCities.filter(c => c.toLowerCase().includes(searchCity.toLowerCase()))" :key="city">
                                                <div @click="selectedCity = city; openCity = false" class="px-3 py-2 hover:bg-linear-surface-3 rounded-lg cursor-pointer text-sm text-linear-ink" x-text="city"></div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="location" id="sidebar-location" :value="selectedCity ? selectedCity : selectedCountry">
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-4 bg-linear-surface-2 text-linear-ink hover:bg-linear-primary hover:text-white border border-linear-hairline font-semibold py-2.5 rounded-xl transition-colors">
                            Terapkan Filter
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Job List -->
            <div class="flex-1">
                @if (isset($error))
                    <div class="rounded-2xl border border-red-500/20 bg-red-500/10 p-6 text-sm font-semibold text-red-500 mb-6 flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endif

                @if ($jobs->isNotEmpty())
                    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <p class="text-sm font-medium text-linear-ink-subtle">Menampilkan <span class="font-bold text-linear-ink">{{ $jobs->firstItem() }}&ndash;{{ $jobs->lastItem() }}</span> dari <span class="font-bold text-linear-ink">{{ $jobs->total() }}</span> lowongan</p>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-linear-ink-muted">Update: {{ $lastRefreshedAt ?? now()->format('H:i') }}</span>
                            <a href="{{ url('/jobs') }}?keyword={{ urlencode($keyword) }}&location={{ urlencode($location) }}&refresh=1" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-linear-surface-1 border border-linear-hairline text-xs font-semibold text-linear-ink hover:bg-linear-surface-2 transition-colors">
                                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Refresh
                            </a>
                        </div>
                    </div>

                    <div id="job-listings" data-next-url="{{ $jobs->hasMorePages() ? $jobs->nextPageUrl() : '' }}" class="flex flex-col gap-5">
                        @include('jobs.partials.job-cards', ['jobs' => $jobs, 'offset' => $jobs->firstItem() - 1])
                    </div>

                    <div id="job-loader" class="mt-8 hidden items-center justify-center p-6 text-linear-primary font-medium">
                        <i data-lucide="loader-2" class="w-6 h-6 animate-spin mr-2"></i> Memuat lebih banyak...
                    </div>
                    <div id="infinite-sentinel" class="mt-8 h-2"></div>

                @else
                    <div class="bg-linear-surface-1 rounded-3xl border border-linear-hairline p-12 text-center">
                        <div class="w-20 h-20 bg-linear-surface-2 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="search-x" class="w-10 h-10 text-linear-ink-subtle"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-linear-ink mb-2">Tidak ada lowongan</h3>
                        <p class="text-linear-ink-subtle max-w-md mx-auto mb-6">Kami tidak dapat menemukan pekerjaan yang cocok dengan kriteria Anda. Coba ubah kata kunci atau lokasi.</p>
                        <a href="{{ url('/jobs') }}?refresh=1" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-linear-primary text-white font-semibold hover:bg-linear-primary-hover transition-colors">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> Refresh Data
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('job-listings');
        const loader = document.getElementById('job-loader');
        const sentinel = document.getElementById('infinite-sentinel');

        if (!container || !sentinel || !loader) {
            return;
        }

        let isLoading = false;
        let nextUrl = container.dataset.nextUrl;

        const loadMoreJobs = async () => {
            if (isLoading || !nextUrl) {
                return;
            }

            isLoading = true;
            loader.classList.remove('hidden');
            loader.classList.add('flex');

            try {
                const url = new URL(nextUrl, window.location.origin);
                url.searchParams.set('ajax', '1');

                const response = await fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    throw new Error('Gagal memuat data.');
                }

                const data = await response.json();
                const fragment = document.createRange().createContextualFragment(data.html);
                container.appendChild(fragment);
                nextUrl = data.next_url || '';
                container.dataset.nextUrl = nextUrl;

                // Re-initialize lucide icons for newly added elements
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

                if (!nextUrl) {
                    sentinel.remove();
                }
            } catch (error) {
                console.error(error);
            } finally {
                loader.classList.add('hidden');
                loader.classList.remove('flex');
                isLoading = false;
            }
        };

        new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                loadMoreJobs();
            }
        }, {
            rootMargin: '200px',
        }).observe(sentinel);
    });

    // Alpine.js logic for Location Cascading Dropdown using API
    function locationDropdown(initialLocation) {
        return {
            selectedCountry: '',
            selectedCity: '',
            availableCities: [],
            countries: {},
            countriesList: [],
            isLoading: true,
            
            init() {
                this.fetchCountries();
            },
            
            async fetchCountries() {
                this.isLoading = true;
                try {
                    // Menggunakan localStorage sebagai cache agar tidak lambat saat refresh
                    const cached = localStorage.getItem('world_countries_data');
                    if (cached) {
                        this.countries = JSON.parse(cached);
                        this.countriesList = Object.keys(this.countries).sort();
                        this.setupInitial(initialLocation);
                        this.isLoading = false;
                        return;
                    }

                    const response = await fetch('https://countriesnow.space/api/v0.1/countries');
                    const data = await response.json();
                    
                    const formatted = {};
                    data.data.forEach(item => {
                        formatted[item.country] = item.cities.sort();
                    });
                    
                    this.countries = formatted;
                    this.countriesList = Object.keys(this.countries).sort();
                    
                    localStorage.setItem('world_countries_data', JSON.stringify(formatted));
                    this.setupInitial(initialLocation);
                } catch (e) {
                    console.error('Gagal mengambil data negara:', e);
                    // Fallback
                    this.countries = { 'Indonesia': ['Jakarta', 'Bandung', 'Surabaya'] };
                    this.countriesList = ['Indonesia'];
                    this.setupInitial(initialLocation);
                } finally {
                    this.isLoading = false;
                }
            },
            
            setupInitial(initialLocation) {
                if (!initialLocation) return;
                
                // Cek apakah inisial lokasi adalah Negara
                for (const [country, cities] of Object.entries(this.countries)) {
                    if (initialLocation.toLowerCase() === country.toLowerCase()) {
                        this.selectedCountry = country;
                        this.updateCities();
                        return;
                    }
                    
                    // Cek apakah inisial lokasi adalah Kota
                    const foundCity = cities.find(c => c.toLowerCase() === initialLocation.toLowerCase());
                    if (foundCity) {
                        this.selectedCountry = country;
                        this.updateCities();
                        this.selectedCity = foundCity;
                        return;
                    }
                }
                
                // Fallback jika tidak ditemukan
                this.countries[initialLocation] = [];
                if (!this.countriesList.includes(initialLocation)) {
                    this.countriesList.unshift(initialLocation);
                }
                this.selectedCountry = initialLocation;
            },
            
            updateCities() {
                this.availableCities = this.countries[this.selectedCountry] || [];
                this.selectedCity = '';
            }
        }
    }
</script>
@endsection