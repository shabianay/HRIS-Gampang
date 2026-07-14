<x-employee-layout>
    <div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kehadiran Mandiri</h1>
                <p class="text-sm text-slate-500 mt-1">Catat kehadiran Anda hari ini</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Clock In/Out Card --}}
            <div class="lg:col-span-1 card p-6 sm:p-8 text-center">
                <h2 class="text-xl font-bold text-slate-900 mb-2">Waktu Saat Ini</h2>
                <p class="text-5xl font-extrabold text-primary-600 mb-6" id="currentTime"></p>

                @if(!$todayAttendance)
                    <p class="text-sm text-slate-500 mb-6">Anda belum mencatat kehadiran hari ini.</p>
                    <form action="{{ route('employee.attendances.clockIn') }}" method="POST" id="clockInForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="latitude" id="latIn">
                        <input type="hidden" name="longitude" id="lngIn">
                        <input type="hidden" name="photo" id="capturedPhotoIn"> {{-- Hidden input for base64 photo --}}
                        <button type="button" onclick="openCameraModal('clockIn')" class="btn-primary w-full max-w-sm mx-auto py-3 text-lg">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Clock In Sekarang
                        </button>
                    </form>
                @elseif(!$todayAttendance->clock_out)
                    <p class="text-sm text-slate-500 mb-6">Anda sudah Clock In pada <span class="font-semibold text-emerald-600">{{ $todayAttendance->clock_in->format('H:i') }}</span>.</p>
                    <form action="{{ route('employee.attendances.clockOut') }}" method="POST" id="clockOutForm" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="latitude" id="latOut">
                        <input type="hidden" name="longitude" id="lngOut">
                        <input type="hidden" name="photo" id="capturedPhotoOut"> {{-- Hidden input for base64 photo --}}
                        <button type="button" onclick="openCameraModal('clockOut')" class="btn-danger w-full max-w-sm mx-auto py-3 text-lg">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Clock Out Sekarang
                        </button>
                    </form>
                @else
                    <p class="text-lg font-semibold text-emerald-600 mb-4">Absensi Hari Ini Selesai!</p>
                    <div class="flex items-center justify-center gap-4 text-sm font-medium text-slate-600 bg-slate-50 px-5 py-2.5 rounded-xl max-w-sm mx-auto border border-slate-100">
                        <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Clock In: {{ $todayAttendance->clock_in->format('H:i') }} &middot; Clock Out: {{ $todayAttendance->clock_out->format('H:i') }}
                    </div>
                @endif
            </div>

            {{-- Summary Stats --}}
            <div class="lg:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="bg-white border border-emerald-100 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $summary['hadir'] }}</p>
                        <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Hadir</p>
                    </div>
                </div>
                <div class="bg-white border border-amber-100 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $summary['terlambat'] }}</p>
                        <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Terlambat</p>
                    </div>
                </div>
                <div class="bg-white border border-red-100 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $summary['absen'] }}</p>
                        <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Absen</p>
                    </div>
                </div>
                <div class="bg-white border border-blue-100 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $summary['izin'] }}</p>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Izin</p>
                    </div>
                </div>
                <div class="bg-white border border-purple-100 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $summary['sakit'] }}</p>
                        <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider">Sakit</p>
                    </div>
                </div>
                <div class="bg-white border border-slate-100 rounded-xl p-5 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $summary['total_hari'] }}</p>
                        <p class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Total Hari</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter and Table --}}
        <div class="card p-4 mb-6">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-field">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-field">
                <select name="status" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="absen" {{ request('status') == 'absen' ? 'selected' : '' }}>Absen</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="btn-primary flex-1 justify-center">Filter</button>
                    @if(request('date_from') || request('date_to') || request('status'))
                        <a href="{{ route('employee.attendances.index') }}" class="btn-secondary">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card p-0 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Tanggal</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Clock In</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Selfie In</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Clock Out</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Selfie Out</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Status</th>
                            <th class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($attendances as $attendance)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $attendance->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attendance->photo_in)
                                        <a href="{{ Storage::url($attendance->photo_in) }}" target="_blank" class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700 text-sm">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Lihat Selfie
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attendance->photo_out)
                                        <a href="{{ Storage::url($attendance->photo_out) }}" target="_blank" class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700 text-sm">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Lihat Selfie
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge
                                        @if($attendance->status == 'hadir') badge-success
                                        @elseif($attendance->status == 'terlambat') badge-warning
                                        @else badge-danger
                                        @endif">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('employee.attendances.show', $attendance) }}" class="text-xs font-semibold text-primary-600 hover:text-primary-700 bg-primary-50 px-3 py-1.5 rounded-lg transition-colors">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <p class="text-sm text-slate-500">Belum ada data kehadiran</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendances->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Camera Modal --}}
    <div id="cameraModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-4 relative">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Ambil Foto Selfie</h3>
            <button type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600" onclick="closeCameraModal()">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="aspect-w-16 aspect-h-9 bg-slate-200 rounded-lg overflow-hidden flex items-center justify-center relative">
                <video id="cameraFeed" class="w-full h-full object-cover"></video>
                <canvas id="cameraCanvas" class="absolute inset-0 hidden"></canvas>
                <img id="capturedImagePreview" class="w-full h-full object-cover hidden">
            </div>

            <div class="flex justify-center gap-4 mt-6">
                <button type="button" id="takePhotoButton" class="btn-primary flex-1 py-2">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.865-1.297A2 2 0 0110.437 3h3.125a2 2 0 011.662.89l.865 1.297a2 2 0 001.664.89H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Ambil Foto
                </button>
                <button type="button" id="retakePhotoButton" class="btn-secondary flex-1 py-2 hidden">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356-2A9.993 9.993 0 0012 21.747c3.737 0 6.86-2.013 8.632-5.025m-12.66-8.225V6h-.582m15.356-2A9.993 9.993 0 0012 2.252c-3.737 0-6.86 2.013-8.632 5.025"/></svg>
                    Ulangi
                </button>
                <button type="button" id="usePhotoButton" class="btn-primary flex-1 py-2 hidden">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Gunakan Foto
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentAction = ''; // To store 'clockIn' or 'clockOut'
        let mediaStream;

        function openCameraModal(action) {
            currentAction = action;
            document.getElementById('cameraModal').classList.remove('hidden');
            startCamera();
        }

        function closeCameraModal() {
            stopCamera();
            document.getElementById('cameraModal').classList.add('hidden');
            // Reset modal state
            document.getElementById('cameraFeed').classList.remove('hidden');
            document.getElementById('cameraCanvas').classList.add('hidden');
            document.getElementById('capturedImagePreview').classList.add('hidden');
            document.getElementById('takePhotoButton').classList.remove('hidden');
            document.getElementById('retakePhotoButton').classList.add('hidden');
            document.getElementById('usePhotoButton').classList.add('hidden');
        }

        async function startCamera() {
            try {
                mediaStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }); // Use 'environment' for rear camera
                const video = document.getElementById('cameraFeed');
                video.srcObject = mediaStream;
                video.play();
                video.classList.remove('hidden');
            } catch (err) {
                console.error("Error accessing camera: ", err);
                alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin dan coba lagi.");
                closeCameraModal();
            }
        }

        function stopCamera() {
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
            }
        }

        document.getElementById('takePhotoButton').addEventListener('click', () => {
            const video = document.getElementById('cameraFeed');
            const canvas = document.getElementById('cameraCanvas');
            const context = canvas.getContext('2d');
            const preview = document.getElementById('capturedImagePreview');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageDataURL = canvas.toDataURL('image/jpeg', 0.8);
            preview.src = imageDataURL;

            // Show/hide elements
            video.classList.add('hidden');
            canvas.classList.add('hidden'); // Keep canvas hidden, use img for preview
            preview.classList.remove('hidden');
            document.getElementById('takePhotoButton').classList.add('hidden');
            document.getElementById('retakePhotoButton').classList.remove('hidden');
            document.getElementById('usePhotoButton').classList.remove('hidden');
            
            // Pause video instead of stopping the stream entirely
            video.pause(); 
        });

        document.getElementById('retakePhotoButton').addEventListener('click', () => {
            const video = document.getElementById('cameraFeed');
            document.getElementById('cameraFeed').classList.remove('hidden');
            document.getElementById('capturedImagePreview').classList.add('hidden');
            document.getElementById('takePhotoButton').classList.remove('hidden');
            document.getElementById('retakePhotoButton').classList.add('hidden');
            document.getElementById('usePhotoButton').classList.add('hidden');
            video.play(); // Resume video
        });

        document.getElementById('usePhotoButton').addEventListener('click', () => {
            const canvas = document.getElementById('cameraCanvas');
            const imageDataURL = canvas.toDataURL('image/jpeg', 0.8);

            if (currentAction === 'clockIn') {
                document.getElementById('capturedPhotoIn').value = imageDataURL;
                // Get geolocation then submit form
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            document.getElementById('latIn').value = position.coords.latitude;
                            document.getElementById('lngIn').value = position.coords.longitude;
                            document.getElementById('clockInForm').submit();
                        },
                        () => {
                            alert('Lokasi diperlukan untuk absensi. Silakan aktifkan GPS Anda.');
                            document.getElementById('clockInForm').submit(); // Submit even without location if user insists
                        }
                    );
                } else {
                    alert('Geolocation tidak didukung pada browser Anda.');
                    document.getElementById('clockInForm').submit(); // Submit without location
                }
            } else if (currentAction === 'clockOut') {
                document.getElementById('capturedPhotoOut').value = imageDataURL;
                // Get geolocation then submit form
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            document.getElementById('latOut').value = position.coords.latitude;
                            document.getElementById('lngOut').value = position.coords.longitude;
                            document.getElementById('clockOutForm').submit();
                        },
                        () => {
                            alert('Lokasi diperlukan untuk absensi. Silakan aktifkan GPS Anda.');
                            document.getElementById('clockOutForm').submit(); // Submit even without location
                        }
                    );
                } else {
                    alert('Geolocation tidak didukung pada browser Anda.');
                    document.getElementById('clockOutForm').submit(); // Submit without location
                }
            }
            closeCameraModal();
        });

        // Update current time display
        function updateCurrentTime() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', options);
        }
        setInterval(updateCurrentTime, 1000);
        updateCurrentTime(); // Initial call
    </script>
</x-employee-layout>
