@extends('layouts.app')

@section('title', 'Create Stock Out - Scan Serial')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Stock Out: Scan Serial Number</h1>
    <p>Scan a serial number to validate and proceed to create a stock out.</p>

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
            <input id="hw-input" type="text" class="form-control w-auto" placeholder="Scan barcode via hardware scanner" style="width:300px;">
        </div>
    </div>

    {{-- Back Button --}}
    <div class="mb-4">
        <a href="{{ route('stock-out.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

{{-- ======================= SCANNER SCRIPT =========================== --}}
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script> {{-- Pastikan library ini di-include --}}
<script>
    const cameraSelect = document.getElementById("camera-select");
    const startBtn = document.getElementById("start-camera-btn");
    const stopBtn = document.getElementById("stop-camera-btn");
    const resultBox = document.getElementById("result");
    const hwInput = document.getElementById("hw-input");

    let html5QrCode;
    let cameraRunning = false;
    const readerId = "reader";

    // Fungsi detect format
    function detectFormat(code) {
        if (!code) return "";
        const length = code.length;
        if (length >= 12 && length <= 13 && /^\d+$/.test(code)) return "EAN_13";
        if (length > 10 && /[^0-9]/.test(code)) return "QR_CODE";
        return "";
    }

    // Fungsi untuk process scan (validasi via API)
    function processScan(decodedText, source, format) {
        resultBox.innerHTML = `<b>Kode:</b> ${decodedText}<br><b>Tipe:</b> ${format}<br><b>Sumber:</b> ${source}`;
        
        fetch('{{ route("stock-out.validateScan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ serial_number: decodedText }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultBox.innerHTML += '<br><span class="text-success">✅ Valid! Redirecting...</span>';
                setTimeout(() => {
                    window.location.href = '{{ route("stock-out.confirmCreate") }}';
                }, 1000);
            } else {
                resultBox.innerHTML += '<br><span class="text-danger">❌ ' + data.message + '</span>';
            }
        })
        .catch(error => {
            resultBox.innerHTML += '<br><span class="text-danger">❌ Error: ' + error.message + '</span>';
        });
    }

    function onScanSuccess(decodedText, decodedResult) {
        processScan(decodedText, 'camera', decodedResult.result.format.formatName);
    }

    function onScanFailure(error) {
        console.log("Scan error:", error);
    }

    // Scan by image
    const scanImageBtn = document.getElementById("scan-image-btn");
    const imagePicker = document.getElementById("image-picker");

    scanImageBtn.addEventListener("click", () => imagePicker.click());

    imagePicker.addEventListener("change", async (e) => {
        if (e.target.files.length === 0) return;
        const imageFile = e.target.files[0];
        try {
            if (cameraRunning && html5QrCode) {
                await html5QrCode.stop();
                html5QrCode.clear();
                cameraRunning = false;
                startBtn.disabled = false;
                stopBtn.disabled = true;
            }
            if (!html5QrCode) html5QrCode = new Html5Qrcode(readerId);
            const decodedText = await html5QrCode.scanFile(imageFile, true);
            processScan(decodedText, 'upload_image', detectFormat(decodedText));
        } catch (err) {
            resultBox.innerHTML = "❌ Tidak bisa membaca barcode dari gambar.";
        }
        imagePicker.value = "";
    });

    // Camera functions
    async function startCameraWithDevice(deviceId) {
        if (!html5QrCode) html5QrCode = new Html5Qrcode(readerId, { verbose: false });
        if (cameraRunning) {
            try { await html5QrCode.stop(); html5QrCode.clear(); } catch (e) {}
            cameraRunning = false;
        }
        const config = { fps: 10, qrbox: { width: 320, height: 200 }, formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE, Html5QrcodeSupportedFormats.EAN_13] };
        try {
            await html5QrCode.start({ deviceId: { exact: deviceId } }, config, onScanSuccess, onScanFailure);
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
            let backCam = devices.find(d => d.label.toLowerCase().includes("back") || d.label.toLowerCase().includes("rear"));
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

    startBtn.addEventListener("click", () => startCameraWithDevice(cameraSelect.value));
    stopBtn.addEventListener("click", async () => {
        if (cameraRunning && html5QrCode) {
            await html5QrCode.stop();
            html5QrCode.clear();
            cameraRunning = false;
        }
        startBtn.disabled = false;
        stopBtn.disabled = true;
    });
    cameraSelect.addEventListener("change", () => startCameraWithDevice(cameraSelect.value));

    // Hardware scanner
    hwInput.addEventListener("input", () => {
        const code = hwInput.value;
        processScan(code, 'hardware_scanner', detectFormat(code));
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
                processScan(hwBuffer, 'hardware_scanner', detectFormat(hwBuffer));
            }
            hwBuffer = "";
            hwInput.value = "";
        }, 80);
    });

    window.onload = () => listCameraDevices();
</script>
@endsection