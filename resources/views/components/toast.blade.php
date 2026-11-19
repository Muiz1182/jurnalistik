<div
    x-data="spelandToastManager()"
    x-init="init()"
    @toast.window="add($event.detail)"
    class="fixed top-5 right-5 z-[9999] pointer-events-none flex flex-col gap-2.5 max-w-sm sm:max-w-md w-full px-4 sm:px-0"
    aria-live="polite"
    aria-atomic="true"
>
    <template x-for="item in toasts" :key="item.id">
        <div
            x-show="item.visible"
            x-transition:enter="transform ease-out duration-300 transition-all"
            x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
            x-transition:leave="transform ease-in duration-200 transition-all"
            x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-4 scale-95"
            @mouseenter="pauseTimer(item)"
            @mouseleave="resumeTimer(item)"
            class="pointer-events-auto relative overflow-hidden rounded-xl border shadow-xl bg-white dark:bg-slate-900 transition-all"
            :class="getCardBorder(item.type)"
            role="alert"
        >
            <div class="p-3.5 sm:p-4 flex items-start gap-3">
                <!-- Icon Badge -->
                <div class="shrink-0 p-2 rounded-lg" :class="getBadgeClass(item.type)">
                    <!-- Success Icon -->
                    <template x-if="item.type === 'success'">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </template>
                    <!-- Error Icon -->
                    <template x-if="item.type === 'error'">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </template>
                    <!-- Warning Icon -->
                    <template x-if="item.type === 'warning'">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </template>
                    <!-- Info Icon -->
                    <template x-if="item.type === 'info'">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                    </template>
                </div>

                <!-- Text Body -->
                <div class="flex-1 min-w-0 pt-0.5">
                    <template x-if="item.title">
                        <h4 class="text-xs font-bold uppercase tracking-wider mb-0.5" :class="getTitleClass(item.type)" x-text="item.title"></h4>
                    </template>
                    <p class="text-xs leading-relaxed text-slate-700 dark:text-slate-200 break-words font-medium" x-text="item.message"></p>
                </div>

                <!-- Manual Close Button -->
                <button
                    type="button"
                    @click="remove(item.id)"
                    class="shrink-0 p-1 rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                    title="Tutup"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Countdown Progress Bar -->
            <div class="h-1 w-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                <div
                    class="h-full transition-all duration-75 ease-linear"
                    :class="getBarClass(item.type)"
                    :style="`width: ${(item.remaining / item.duration) * 100}%`"
                ></div>
            </div>
        </div>
    </template>
</div>

<script>
    function spelandToastManager() {
        return {
            toasts: [],
            timerInterval: null,

            init() {
                // Initialize global trigger helper
                window.showToast = (message, type = 'success', title = null, duration = null) => {
                    this.add({ message, type, title, duration });
                };

                // Push initial session flashes from Laravel if present
                @if(session('success'))
                    this.add({
                        type: 'success',
                        title: 'Berhasil',
                        message: @json(session('success')),
                        duration: 4500
                    });
                @endif

                @if(session('error'))
                    this.add({
                        type: 'error',
                        title: 'Terjadi Kesalahan',
                        message: @json(session('error')),
                        duration: 6000
                    });
                @endif

                @if(session('warning'))
                    this.add({
                        type: 'warning',
                        title: 'Peringatan',
                        message: @json(session('warning')),
                        duration: 5000
                    });
                @endif

                @if(session('info'))
                    this.add({
                        type: 'info',
                        title: 'Informasi',
                        message: @json(session('info')),
                        duration: 4500
                    });
                @endif

                @if(session('status'))
                    this.add({
                        type: 'info',
                        title: 'Status',
                        message: @json(session('status')),
                        duration: 4500
                    });
                @endif

                @if($errors->any())
                    this.add({
                        type: 'error',
                        title: 'Validasi Formulir Gagal',
                        message: @json($errors->first()),
                        duration: 6000
                    });
                @endif

                // Run progress countdown timer
                if (!this.timerInterval) {
                    this.timerInterval = setInterval(() => {
                        const step = 50;
                        this.toasts.forEach(t => {
                            if (!t.paused && t.visible) {
                                t.remaining -= step;
                                if (t.remaining <= 0) {
                                    this.remove(t.id);
                                }
                            }
                        });
                    }, 50);
                }
            },

            add(detail) {
                if (!detail) return;
                if (typeof detail === 'string') {
                    detail = { message: detail, type: 'success' };
                }

                const type = detail.type || 'info';
                const duration = detail.duration || (type === 'error' ? 6000 : 4500);
                const defaultTitle = {
                    success: 'Berhasil',
                    error: 'Terjadi Kesalahan',
                    warning: 'Peringatan',
                    info: 'Informasi'
                }[type] || 'Pemberitahuan';

                const newToast = {
                    id: Date.now() + Math.random(),
                    type: type,
                    title: detail.title ?? defaultTitle,
                    message: detail.message || '',
                    duration: duration,
                    remaining: duration,
                    paused: false,
                    visible: true
                };

                this.toasts.push(newToast);
            },

            remove(id) {
                const target = this.toasts.find(t => t.id === id);
                if (target) {
                    target.visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 250);
                }
            },

            pauseTimer(item) {
                item.paused = true;
            },

            resumeTimer(item) {
                item.paused = false;
            },

            getCardBorder(type) {
                switch(type) {
                    case 'success': return 'border-emerald-200 dark:border-emerald-800/60 shadow-emerald-500/5';
                    case 'error': return 'border-rose-200 dark:border-rose-800/60 shadow-rose-500/5';
                    case 'warning': return 'border-amber-200 dark:border-amber-800/60 shadow-amber-500/5';
                    default: return 'border-blue-200 dark:border-blue-800/60 shadow-blue-500/5';
                }
            },

            getBadgeClass(type) {
                switch(type) {
                    case 'success': return 'bg-emerald-50 dark:bg-emerald-950/70 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900';
                    case 'error': return 'bg-rose-50 dark:bg-rose-950/70 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900';
                    case 'warning': return 'bg-amber-50 dark:bg-amber-950/70 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900';
                    default: return 'bg-blue-50 dark:bg-blue-950/70 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900';
                }
            },

            getTitleClass(type) {
                switch(type) {
                    case 'success': return 'text-emerald-700 dark:text-emerald-400';
                    case 'error': return 'text-rose-700 dark:text-rose-400';
                    case 'warning': return 'text-amber-700 dark:text-amber-400';
                    default: return 'text-blue-700 dark:text-blue-400';
                }
            },

            getBarClass(type) {
                switch(type) {
                    case 'success': return 'bg-emerald-500';
                    case 'error': return 'bg-rose-500';
                    case 'warning': return 'bg-amber-500';
                    default: return 'bg-blue-500';
                }
            }
        };
    }
</script>
