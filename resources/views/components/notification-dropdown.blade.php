<div
    x-data="notificationDropdown()"
    x-init="init()"
    class="relative"
>
    <button
        @click="toggle()"
        class="relative inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200/80 bg-white shadow-sm text-slate-500 hover:text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all focus:outline-none"
    >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        <span
            x-show="unreadCount > 0"
            x-cloak
            x-text="unreadCount"
            class="absolute -top-1 -right-1 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-red-500 rounded-full ring-2 ring-white"
        ></span>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        @keydown.escape.window="open = false"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 sm:w-96 origin-top-right"
    >
        <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900">Notifikasi</h3>
                <button
                    x-show="unreadCount > 0"
                    @click="markAllRead()"
                    class="text-xs font-medium text-primary-600 hover:text-primary-700 transition-colors"
                >
                    Tandai semua dibaca
                </button>
            </div>

            <div class="max-h-80 overflow-y-auto">
                <template x-if="loading">
                    <div class="flex items-center justify-center py-8">
                        <svg class="animate-spin h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </div>
                </template>

                <template x-if="!loading && notifications.length === 0">
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <svg class="h-10 w-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <p class="text-sm text-slate-500">Tidak ada notifikasi</p>
                    </div>
                </template>

                <template x-for="notification in notifications" :key="notification.id">
                    <a
                        :href="notification.link || '#'"
                        @click.prevent="markRead(notification)"
                        :class="{'bg-primary-50/50': !notification.is_read, 'hover:bg-slate-50': true}"
                        class="flex gap-3 px-4 py-3 border-b border-slate-50 transition-colors cursor-pointer"
                    >
                        <div class="flex-shrink-0 mt-0.5">
                            <template x-if="notification.type === 'leave_request'">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100">
                                    <svg class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </template>
                            <template x-if="notification.type === 'payroll'">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100">
                                    <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </template>
                            <template x-if="notification.type === 'attendance'">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100">
                                    <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                </div>
                            </template>
                            <template x-if="!['leave_request', 'payroll', 'attendance'].includes(notification.type)">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100">
                                    <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                </div>
                            </template>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 truncate" x-text="notification.title"></p>
                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-2" x-text="notification.message"></p>
                            <p class="text-[11px] text-slate-400 mt-1">
                                <span x-text="timeAgo(notification.created_at)"></span>
                            </p>
                        </div>
                        <template x-if="!notification.is_read">
                            <div class="flex-shrink-0 self-center">
                                <span class="flex h-2 w-2 rounded-full bg-primary-500"></span>
                            </div>
                        </template>
                    </a>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
function notificationDropdown() {
    return {
        open: false,
        loading: true,
        notifications: [],
        unreadCount: 0,
        pollInterval: null,

        async init() {
            await this.fetchNotifications();
            this.pollInterval = setInterval(() => this.fetchNotifications(), 30000);
        },

        async fetchNotifications() {
            try {
                const response = await fetch('{{ route("notifications.index") }}');
                const data = await response.json();
                this.notifications = data.notifications;
                this.unreadCount = data.unread_count;
            } catch (e) {
                console.error('Failed to fetch notifications:', e);
            } finally {
                this.loading = false;
            }
        },

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.fetchNotifications();
            }
        },

        async markRead(notification) {
            if (!notification.is_read) {
                try {
                    await fetch('{{ url("notifications") }}/' + notification.id + '/read', {
                        method: 'PATCH',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    notification.is_read = true;
                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                } catch (e) {
                    console.error('Failed to mark notification as read:', e);
                }
            }
            if (notification.link) {
                window.location.href = notification.link;
            }
        },

        async markAllRead() {
            try {
                await fetch('{{ route("notifications.read-all") }}', {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                this.notifications.forEach(n => n.is_read = true);
                this.unreadCount = 0;
            } catch (e) {
                console.error('Failed to mark all as read:', e);
            }
        },

        timeAgo(dateStr) {
            const date = new Date(dateStr);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);

            if (seconds < 60) return 'baru saja';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return minutes + ' menit lalu';
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return hours + ' jam lalu';
            const days = Math.floor(hours / 24);
            if (days < 7) return days + ' hari lalu';
            return date.toLocaleDateString('id-ID');
        }
    };
}
</script>
