@extends('Layouts.app')

@section('title', 'Pindai Stok Masuk')

@section('content')

    {{-- ======================= DETAIL STOCK IN =========================== --}}
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="fw-semibold mb-3">Detail Stock In Batch</h4>

            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="35%">Reference</th>
                            <td>{{ $stockInBatch->reference ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Source</th>
                            <td>{{ $stockInBatch->source ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diterima Oleh</th>
                            <td>{{ $stockInBatch->receiver->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="35%">Original Price</th>
                            <td>Rp {{ number_format($stockInBatch->original_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>In Items</th>
                            <td>{{ $stockInBatch->in_items }}</td>
                        </tr>
                        <tr>
                            <th>Out Items</th>
                            <td>{{ $stockInBatch->out_items }}</td>
                        </tr>
                        <tr>
                            <th>Remaining Items</th>
                            <td>{{ $stockInBatch->remaining_items }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- ======================= SCANNER UI =========================== --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4 class="fw-semibold mb-3">Scanner Barcode (Camera + Hardware Scanner)</h4>

            <label>Pilih Kamera:</label>
            <select id="camera-select" class="form-select w-auto"></select>

            <div class="mt-3">
                <button id="start-camera-btn" class="btn btn-primary">Start Camera</button>
                <button id="stop-camera-btn" class="btn btn-danger" disabled>Stop Camera</button>
                <button id="start-hw-btn" class="btn btn-secondary">Start Hardware Scanner</button>
            </div>
            <button id="scan-image-btn" class="btn btn-info mt-2">Scan by Image</button>
            <input type="file" id="image-picker" accept="image/*" class="d-none">

            <div id="reader" class="mt-4" style="width:350px;"></div>

            <h5 class="mt-4">Hasil Scan</h5>
            <div id="result" class="p-3 border rounded bg-light">Belum ada hasil</div>

            <h6 class="mt-4">Input dari Hardware Scanner:</h6>
            <input id="hw-input" type="text" class="form-control w-auto" placeholder="Scan barcode via hardware scanner"
                style="width:300px;">
        </div>
    </div>


    {{-- ======================= FORM INPUT SERIAL =========================== --}}
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="fw-semibold">Tambah Serial Baru</h4>

            <form action="{{ route('stock-in.serials.store', $stockInBatch) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Serial Number</label>
                    <input id="serial_number" type="text" name="serial_number" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Pilih Produk</label>
                    <select name="product_id" class="form-control" required>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Unit Price</label>
                    <input type="number" name="unit_price" class="form-control" required min="0">
                </div>

                <button class="btn btn-success">
                    <i class="ti ti-device-floppy"></i> Simpan Serial
                </button>
            </form>
        </div>
    </div>


    {{-- ======================= LIST SERIAL SUDAH SCAN =========================== --}}
    <div class="card">
        <div class="card-body">
            <h4 class="fw-semibold mb-3">Serial yang Sudah Ditambahkan</h4>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Serial Number</th>
                        <th>Produk</th>
                        <th>Unit Price</th>
                        <th>Status</th>
                        <th>Ditambahkan Oleh</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($serials as $serial)
                        <tr>
                            <td>{{ $serial->serial_number }}</td>
                            <td>{{ $serial->product->name ?? '-' }}</td>
                            <td>Rp {{ number_format($serial->unit_price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-success">{{ $serial->status }}</span>
                            </td>
                            <td>{{ $serial->addedBy->name ?? '-' }}</td>
                            <td>{{ $serial->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada serial</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>



    {{-- ======================= SCANNER SCRIPT =========================== --}}
    <script>
        const cameraSelect = document.getElementById("camera-select");
        const startBtn = document.getElementById("start-camera-btn");
        const stopBtn = document.getElementById("stop-camera-btn");
        const resultBox = document.getElementById("result");
        const hwInput = document.getElementById("hw-input");
        const serialInput = document.getElementById("serial_number");

        let html5QrCode;
        let cameraRunning = false;
        const readerId = "reader";

        function onScanSuccess(decodedText, decodedResult) {
            resultBox.innerHTML = `
                <b>Kode:</b> ${decodedText}<br>
                <b>Tipe Barcode:</b> ${decodedResult.result.format.formatName}
            `;

            serialInput.value = decodedText;
        }

        function onScanFailure(error) {
            console.log("Scan error:", error);
        }

        // ==================== SCAN BY IMAGE ====================
        // ==================== SCAN BY IMAGE (PERBAIKAN RESMI) ====================
        const scanImageBtn = document.getElementById("scan-image-btn");
        const imagePicker = document.getElementById("image-picker");

        scanImageBtn.addEventListener("click", () => {
            imagePicker.click();
        });

        imagePicker.addEventListener("change", async (e) => {
            if (e.target.files.length === 0) return;

            const imageFile = e.target.files[0];

            try {
                // Hentikan kamera jika sedang aktif
                if (cameraRunning && html5QrCode) {
                    await html5QrCode.stop();
                    html5QrCode.clear();
                    cameraRunning = false;
                    startBtn.disabled = false;
                    stopBtn.disabled = true;
                }

                // Pastikan html5QrCode ada
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode(readerId);
                }

                // Scan file (mengikuti pola resmi)
                const decodedText = await html5QrCode.scanFile(imageFile, true);

                resultBox.innerHTML = `
            <b>Kode:</b> ${decodedText}<br>
            <b>Sumber:</b> File Image
        `;

                serialInput.value = decodedText;

            } catch (err) {
                console.error("Scan gagal:", err);
                resultBox.innerHTML = "❌ Tidak bisa membaca barcode dari gambar.";
            }

            // reset input agar bisa pilih file yang sama lagi
            imagePicker.value = "";
        });

        async function startCameraWithDevice(deviceId) {
            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode(readerId, {
                    verbose: false
                });
            }

            if (cameraRunning) {
                try {
                    await html5QrCode.stop();
                    html5QrCode.clear();
                } catch (e) {}
                cameraRunning = false;
            }

            const config = {
                fps: 10,
                qrbox: {
                    width: 320,
                    height: 200
                },
                formatsToSupport: [
                    Html5QrcodeSupportedFormats.QR_CODE,
                    Html5QrcodeSupportedFormats.EAN_13
                ]
            };

            try {
                await html5QrCode.start({
                        deviceId: {
                            exact: deviceId
                        }
                    },
                    config,
                    onScanSuccess,
                    onScanFailure
                );

                cameraRunning = true;
                startBtn.disabled = true;
                stopBtn.disabled = false;

            } catch (err) {
                alert("Tidak bisa mengakses kamera.");
            }
        }

        async function listCameraDevices() {
            try {
                const devices = await Html5Qrcode.getCameras();
                cameraSelect.innerHTML = "";

                if (!devices.length) {
                    cameraSelect.innerHTML = '<option>(No camera detected)</option>';
                    return;
                }

                let backCam = devices.find(d =>
                    d.label.toLowerCase().includes("back") ||
                    d.label.toLowerCase().includes("rear")
                );
                if (!backCam) backCam = devices[0];

                devices.forEach((d, idx) => {
                    const opt = document.createElement("option");
                    opt.value = d.id;
                    opt.textContent = d.label || `Camera ${idx+1}`;
                    cameraSelect.appendChild(opt);
                });

                cameraSelect.value = backCam.id;

            } catch (err) {
                console.error(err);
            }
        }

        startBtn.addEventListener("click", () =>
            startCameraWithDevice(cameraSelect.value)
        );

        stopBtn.addEventListener("click", async () => {
            if (cameraRunning && html5QrCode) {
                await html5QrCode.stop();
                html5QrCode.clear();
                cameraRunning = false;
            }
            startBtn.disabled = false;
            stopBtn.disabled = true;
        });

        cameraSelect.addEventListener("change", () =>
            startCameraWithDevice(cameraSelect.value)
        );

        hwInput.addEventListener("input", () => {
            const code = hwInput.value;
            resultBox.innerHTML = `<b>Kode:</b> ${code} <br><b>Sumber:</b> Hardware Scanner`;
            serialInput.value = code;
        });

        let hwBuffer = "";
        let hwTimer = null;

        document.getElementById("start-hw-btn").addEventListener("click", () => {
            hwInput.focus();
            hwInput.value = "";
            hwBuffer = "";
            resultBox.innerHTML = "Menunggu scan dari hardware scanner...";
        });

        hwInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") return;

            hwBuffer += e.key;

            if (hwTimer) clearTimeout(hwTimer);

            hwTimer = setTimeout(() => {
                if (hwBuffer.length > 0) {
                    resultBox.innerHTML = `
                        <b>Kode:</b> ${hwBuffer}<br>
                        <b>Sumber:</b> Hardware Scanner
                    `;
                    serialInput.value = hwBuffer;
                }

                hwBuffer = "";
                hwInput.value = "";
            }, 80);
        });

        window.onload = () => listCameraDevices();
    </script>

@endsection
