

<?php $__env->startSection('title', __('Search Jobs') . ' - Look For Job'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen py-10 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 mb-8 border border-slate-200 dark:border-slate-800 relative overflow-hidden transition-colors">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-emerald-700/10 dark:bg-emerald-500/5 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2 transition-colors"><?php echo e(__('Find Your')); ?> <span class="text-emerald-500"><?php echo e(__('Dream Job')); ?></span></h1>
                    <p class="text-slate-500 dark:text-slate-400"><?php echo e(__('Showing results for your search.')); ?></p>
                </div>
                
                <form method="GET" action="<?php echo e(url('/jobs')); ?>" class="flex-1 max-w-xl flex gap-3" onsubmit="this.location.value = document.getElementById('sidebar-location').value">
                    <!-- Pertahankan lokasi saat mencari dari bar atas -->
                    <input type="hidden" name="location" value="<?php echo e($location); ?>">
                    <div class="flex-1 relative">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500 dark:text-slate-400" aria-hidden="true"></i>
                        <input type="text" name="keyword" id="top-keyword" aria-label="<?php echo e(__('Search position...')); ?>" value="<?php echo e($keyword); ?>" placeholder="<?php echo e(__('Search position...')); ?>" class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border-transparent rounded-2xl focus:bg-slate-100 dark:focus:bg-slate-700 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 text-sm transition-all">
                    </div>
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-semibold transition-all"><?php echo e(__('Search')); ?></button>
                </form>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filter -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 sticky top-28 transition-colors">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-slate-900 dark:text-white text-lg"><?php echo e(__('Search Filters')); ?></h3>
                        <a href="<?php echo e(url('/jobs')); ?>" class="text-sm text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-400 font-medium"><?php echo e(__('Reset')); ?></a>
                    </div>
                    
                    <form method="GET" action="<?php echo e(url('/jobs')); ?>" class="space-y-6" onsubmit="this.keyword.value = document.getElementById('top-keyword').value">
                        <input type="hidden" name="keyword" value="<?php echo e($keyword); ?>">
                        
                        <!-- Location Dropdown (Negara -> Kota) -->
                        <div x-data="locationDropdown('<?php echo e(addslashes($location)); ?>')">
                            <h4 class="font-semibold text-slate-900 dark:text-white text-sm mb-3"><?php echo e(__('Location')); ?></h4>
                            
                            <div class="space-y-3">
                                <!-- Select Negara (Custom Searchable Dropdown) -->
                                <div class="relative" x-data="{ openCountry: false, searchCountry: '' }" @click.away="openCountry = false">
                                    <div @click="if(!isLoading) openCountry = !openCountry" class="w-full pl-9 pr-8 py-2.5 bg-slate-50 dark:bg-slate-800 border border-transparent rounded-xl focus:bg-slate-100 dark:focus:bg-slate-700 focus:ring-1 focus:ring-emerald-500 cursor-pointer flex items-center justify-between transition-colors" :class="isLoading ? 'opacity-50 cursor-not-allowed' : ''">
                                        <i data-lucide="globe" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 dark:text-slate-400"></i>
                                        <span class="text-sm truncate" :class="selectedCountry ? 'text-slate-900 dark:text-white' : 'text-slate-500 dark:text-slate-400'" x-text="isLoading ? '<?php echo e(__('Loading Countries...')); ?>' : (selectedCountry ? selectedCountry : '<?php echo e(__('All Locations')); ?>')"></span>
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500 dark:text-slate-400"></i>
                                    </div>
                                    <div x-show="openCountry" style="display: none;" class="absolute z-50 w-full mt-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl max-h-60 overflow-y-auto" x-transition>
                                        <div class="p-2 sticky top-0 bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                                            <input type="text" x-model="searchCountry" aria-label="<?php echo e(__('Search country...')); ?>" placeholder="<?php echo e(__('Search country...')); ?>" class="w-full px-3 py-2 bg-slate-100 dark:bg-slate-900 border-transparent focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-lg text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500" @click.stop>
                                        </div>
                                        <div class="p-1">
                                            <div @click="selectedCountry = ''; updateCities(); openCountry = false" class="px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg cursor-pointer text-sm text-slate-900 dark:text-white font-medium"><?php echo e(__('All Locations')); ?></div>
                                            <template x-for="country in countriesList.filter(c => c.toLowerCase().includes(searchCountry.toLowerCase()))" :key="country">
                                                <div @click="selectedCountry = country; updateCities(); openCountry = false" class="px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg cursor-pointer text-sm text-slate-900 dark:text-white" x-text="country"></div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Select Kota (Custom Searchable Dropdown) -->
                                <div class="relative" x-show="selectedCountry" x-transition x-data="{ openCity: false, searchCity: '' }" @click.away="openCity = false">
                                    <div @click="openCity = !openCity" class="w-full pl-9 pr-8 py-2.5 bg-slate-50 dark:bg-slate-800 border border-transparent rounded-xl focus:bg-slate-100 dark:focus:bg-slate-700 focus:ring-1 focus:ring-emerald-500 cursor-pointer flex items-center justify-between transition-colors">
                                        <i data-lucide="map-pin" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 dark:text-slate-400"></i>
                                        <span class="text-sm truncate" :class="selectedCity ? 'text-slate-900 dark:text-white' : 'text-slate-500 dark:text-slate-400'" x-text="selectedCity ? selectedCity : '<?php echo e(__('All Cities')); ?>'"></span>
                                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500 dark:text-slate-400"></i>
                                    </div>
                                    <div x-show="openCity" style="display: none;" class="absolute z-50 w-full mt-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl max-h-60 overflow-y-auto" x-transition>
                                        <div class="p-2 sticky top-0 bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                                            <input type="text" x-model="searchCity" aria-label="<?php echo e(__('Search city...')); ?>" placeholder="<?php echo e(__('Search city...')); ?>" class="w-full px-3 py-2 bg-slate-100 dark:bg-slate-900 border-transparent focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-lg text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500" @click.stop>
                                        </div>
                                        <div class="p-1">
                                            <div @click="selectedCity = ''; openCity = false" class="px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg cursor-pointer text-sm text-slate-900 dark:text-white font-medium"><?php echo e(__('All Cities in')); ?> <span x-text="selectedCountry"></span></div>
                                            <template x-for="city in availableCities.filter(c => c.toLowerCase().includes(searchCity.toLowerCase()))" :key="city">
                                                <div @click="selectedCity = city; openCity = false" class="px-3 py-2 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg cursor-pointer text-sm text-slate-900 dark:text-white" x-text="city"></div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden input for form submission -->
                                <input type="hidden" name="location" id="sidebar-location" :value="selectedCity ? selectedCity : selectedCountry">
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-4 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white hover:bg-emerald-700 hover:text-white dark:hover:bg-emerald-700 border border-slate-200 dark:border-slate-700 font-semibold py-2.5 rounded-xl transition-colors">
                            <?php echo e(__('Apply Filters')); ?>

                        </button>
                    </form>
                </div>
            </aside>

            <!-- Job List -->
            <div class="flex-1">
                <?php if(isset($error)): ?>
                    <div class="rounded-2xl border border-red-500/20 bg-red-500/10 p-6 text-sm font-semibold text-red-500 dark:text-red-400 mb-6 flex items-start gap-3">
                        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                        <span><?php echo e(__($error)); ?></span>
                    </div>
                <?php endif; ?>

                <?php if($jobs->isNotEmpty()): ?>
                    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400"><?php echo str_replace(['{first}', '{last}', '{total}'], ['<span class="font-bold text-slate-900 dark:text-white">' . $jobs->firstItem() . '</span>', '<span class="font-bold text-slate-900 dark:text-white">' . $jobs->lastItem() . '</span>', '<span class="font-bold text-slate-900 dark:text-white">' . $jobs->total() . '</span>'], __('Showing {first}-{last} of {total} jobs')); ?></p>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-slate-500 dark:text-slate-400"><?php echo e(__('Update')); ?>: <?php echo e($lastRefreshedAt ?? now()->format('H:i')); ?></span>
                            <a href="<?php echo e(url('/jobs')); ?>?keyword=<?php echo e(urlencode($keyword)); ?>&location=<?php echo e(urlencode($location)); ?>&refresh=1" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> <?php echo e(__('Refresh')); ?>

                            </a>
                        </div>
                    </div>

                    <div id="job-listings" data-next-url="<?php echo e($jobs->hasMorePages() ? $jobs->nextPageUrl() : ''); ?>" class="flex flex-col gap-5">
                        <?php echo $__env->make('jobs.partials.job-cards', ['jobs' => $jobs, 'offset' => $jobs->firstItem() - 1], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>

                    <div id="job-loader" class="mt-8 hidden items-center justify-center p-6 text-emerald-500 font-medium">
                        <i data-lucide="loader-2" class="w-6 h-6 animate-spin mr-2"></i> <?php echo e(__('Loading more...')); ?>

                    </div>
                    <div id="infinite-sentinel" class="mt-8 h-2"></div>

                <?php else: ?>
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-12 text-center transition-colors">
                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="search-x" class="w-10 h-10 text-slate-500 dark:text-slate-400"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2"><?php echo e(__('No jobs found')); ?></h3>
                        <p class="text-slate-500 dark:text-slate-400 max-w-md mx-auto mb-6"><?php echo e(__('We couldn\'t find any jobs matching your criteria. Try changing the keyword or location.')); ?></p>
                        <a href="<?php echo e(url('/jobs')); ?>?refresh=1" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-700 text-white font-semibold hover:bg-emerald-700 transition-colors">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i> <?php echo e(__('Refresh Data')); ?>

                        </a>
                    </div>
                <?php endif; ?>
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
                    throw new Error('<?php echo e(__("Failed to load data.")); ?>');
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
                    console.error('<?php echo e(__("Failed to fetch country data:")); ?>', e);
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LookForJob\resources\views/jobs/index.blade.php ENDPATH**/ ?>