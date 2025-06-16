import './bootstrap';
import 'flowbite';

// __________________________________________________________________ //
// 1. Navbar
// __________________________________________________________________ //
window.addEventListener('load', function () {
    const loadingOverlay = document.getElementById('loadingOverlay');
    const mainContent = document.getElementById('mainContent');

    if (loadingOverlay && mainContent) {
        setTimeout(() => {
            loadingOverlay.classList.add('hidden');
            mainContent.classList.remove('content-hidden');
            mainContent.classList.add('content-visible');
        }, 1000);
    }
});

// Drawer navigasi
document.addEventListener('DOMContentLoaded', () => {
    const html = document.documentElement;
    const observer = new MutationObserver(() => {
        if (window.innerWidth < 1024 && html.getAttribute('x-data') === '{ open: true }') {
            document.body.classList.add('drawer-open');
        } else {
            document.body.classList.remove('drawer-open');
        }
    });
    observer.observe(html, { attributes: true, attributeFilter: ['x-data'] });
});

// __________________________________________________________________ //
// 2. Halaman Login
// __________________________________________________________________ //
document.addEventListener('DOMContentLoaded', () => {
    const errorEmail = document.querySelector('.text-red-600');
    if (errorEmail && errorEmail.textContent.includes('These credentials do not match our records')) {
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: 'Email atau kata sandi salah. Silakan coba lagi.',
            confirmButtonColor: '#007022',
        });
    }
});

// __________________________________________________________________ //
// 3. Halaman Transaksi (Kasir)
// __________________________________________________________________ //
document.addEventListener('livewire:init', function () {
    // Hanya jalankan logika fokus untuk halaman transaksi kasir
    if (document.querySelector('[data-page="transaksi-kasir"]')) {
        const focusSearchInput = () => {
            const searchInput = document.getElementById('search');
            if (searchInput) {
                setTimeout(() => searchInput.focus(), 100);
            }
        };

        // Fokus awal pada input
        focusSearchInput();

        // Event listener untuk fokus input
        Livewire.on('item-added', focusSearchInput);
        Livewire.on('item-removed', focusSearchInput);
        Livewire.on('item-updated', focusSearchInput);
        Livewire.on('focus-input', focusSearchInput);

        // Event listener untuk alert
        Livewire.on('show-alert', (event) => {
            console.log('Show Alert:', event);
            Swal.fire({
                title: 'Peringatan!',
                text: event.message || 'Terjadi kesalahan.',
                icon: 'warning',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then(() => focusSearchInput());
        });

        // Event listener untuk input uang diberikan
        Livewire.on('swal:inputUangDiberikan', (event) => {
            console.log('Input Uang Diberikan:', event);
            Swal.fire({
                title: 'Masukkan Jumlah Uang yang Diberikan',
                html: `Total Harga: Rp ${new Intl.NumberFormat('id-ID').format(event.totalHarga)}`,
                input: 'number',
                inputAttributes: {
                    min: 0,
                    step: 1
                },
                inputPlaceholder: 'Masukkan jumlah uang',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed && result.value !== undefined) {
                    console.log('Uang Diberikan:', result.value);
                    Livewire.dispatch('handleUangDiberikan', { jumlah: result.value });
                } else {
                    console.log('Input Uang Diberikan Dibatalkan');
                }
            });
        });

        // Event listener untuk input opsi kembalian
        Livewire.on('swal:inputKembalianOpsi', (event) => {
            console.log('Input Kembalian Opsi:', event);
            Swal.fire({
                title: 'Apakah pelanggan mengambil kembalian?',
                html: `Total Kembalian: Rp ${new Intl.NumberFormat('id-ID').format(event.kembalian)}<br>` +
                      '<div class="swal-custom-buttons">' +
                      '<button id="swal-sebagian-btn" class="swal2-confirm swal2-styled" style="background-color: #007bff; color: white; margin-right: 5px;">Sebagian</button>' +
                      '</div>',
                showDenyButton: true,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Iya',
                denyButtonText: 'Tidak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                denyButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                didOpen: () => {
                    const sebagianBtn = document.getElementById('swal-sebagian-btn');
                    if (sebagianBtn) {
                        sebagianBtn.addEventListener('click', () => {
                            Swal.close();
                            Swal.fire({
                                title: 'Masukkan Jumlah Kembalian Sebagian',
                                html: `Total Kembalian: Rp ${new Intl.NumberFormat('id-ID').format(event.kembalian)}`,
                                input: 'number',
                                inputAttributes: {
                                    min: 0,
                                    max: event.kembalian,
                                    step: 500,
                                    placeholder: 'Masukkan jumlah kembalian'
                                },
                                inputValidator: (value) => {
                                    if (!value || value < 0) {
                                        return 'Nominal tidak boleh minus atau kosong!';
                                    }
                                    if (value > event.kembalian) {
                                        return 'Nominal melebihi total kembalian!';
                                    }
                                    return null;
                                },
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Lanjutkan',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed && result.value !== undefined) {
                                    console.log('Kembalian Sebagian:', result.value);
                                    Livewire.dispatch('handleKembalianDiambil', { jumlah: result.value, opsi: 'sebagian' });
                                } else {
                                    console.log('Input Kembalian Sebagian Dibatalkan');
                                }
                            });
                        });
                    }
                },
                preConfirm: () => {
                    return new Promise((resolve) => {
                        resolve();
                    });
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('Kembalian Diambil:', event.kembalian);
                    Livewire.dispatch('handleKembalianDiambil', { jumlah: event.kembalian, opsi: 'iya' });
                } else if (result.isDenied) {
                    console.log('Kembalian Tidak Diambil');
                    Livewire.dispatch('handleKembalianDiambil', { jumlah: 0, opsi: 'tidak' });
                } else {
                    console.log('Input Kembalian Opsi Dibatalkan');
                }
            });
        });

        // Event listener untuk konfirmasi checkout
        Livewire.on('swal:confirmCheckout', () => {
            console.log('Confirm Checkout Triggered');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Transaksi akan disimpan.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('Proceed Checkout Dispatched');
                    Livewire.dispatch('proceedCheckout');
                } else {
                    console.log('Checkout Dibatalkan');
                }
            });
        });

        // Event listener untuk notifikasi sukses
        Livewire.on('swal:success', (event) => {
            console.log('Success Notification:', event);
            Swal.fire({
                title: 'Berhasil!',
                text: event.message,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then(() => focusSearchInput());
        });

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', (e) => {
            const searchInput = document.getElementById('search');
            const dropdown = document.querySelector('.absolute.z-10');
            if (searchInput && dropdown && !searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                console.log('Clearing Search Results');
                window.Livewire.dispatch('clear-search-results');
            }
        });
    }

    // __________________________________________________________________ //
    // 4. Halaman Dashboard Kas (Admin)
    // __________________________________________________________________ //
    let lineChart, dualLineChart, topLeastBarChart, profitBarChart;

    function renderCharts(labels, penjualanData, pembelianData, topSellingLabels, topSellingData, highestProfitLabels, highestProfitData) {
        console.log('Rendering Charts:', { labels, penjualanData, pembelianData, topSellingLabels, topSellingData, highestProfitLabels, highestProfitData });
        if (lineChart) lineChart.destroy();
        if (dualLineChart) dualLineChart.destroy();
        if (topLeastBarChart) topLeastBarChart.destroy();
        if (profitBarChart) profitBarChart.destroy();

        const safeLabels = labels && labels.length ? labels : ['No Data'];
        const safePenjualanData = penjualanData && penjualanData.length ? penjualanData : [0];
        const safePembelianData = pembelianData && pembelianData.length ? pembelianData : [0];
        const safeTopSellingLabels = topSellingLabels && topSellingLabels.length ? topSellingLabels : ['No Data'];
        const safeTopSellingData = topSellingData && topSellingData.length ? topSellingData : [0];
        const safeHighestProfitLabels = highestProfitLabels && highestProfitLabels.length ? highestProfitLabels : ['No Data'];
        const safeHighestProfitData = highestProfitData && highestProfitData.length ? highestProfitData : [0];

        if (safePenjualanData.some(val => val > 0)) {
            lineChart = new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: safeLabels,
                    datasets: [{
                        label: 'Penjualan',
                        data: safePenjualanData,
                        borderColor: '#36A2EB',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Jumlah (Rp)', font: { size: 14 } },
                            ticks: { callback: value => 'Rp ' + value.toLocaleString('id-ID'), font: { size: 12 } }
                        },
                        x: { title: { display: true, text: 'Tanggal', font: { size: 14 } }, ticks: { font: { size: 12 } } }
                    },
                    plugins: {
                        legend: { position: 'top', labels: { font: { size: 14 } } },
                        tooltip: {
                            callbacks: { label: context => `${context.dataset.label}: Rp ${context.parsed.y.toLocaleString('id-ID')}` },
                            titleFont: { size: 14 },
                            bodyFont: { size: 12 }
                        }
                    }
                }
            });
        }

        if (safePenjualanData.some(val => val > 0) || safePembelianData.some(val => val > 0)) {
            dualLineChart = new Chart(document.getElementById('dualLineChart'), {
                type: 'line',
                data: {
                    labels: safeLabels,
                    datasets: [
                        {
                            label: 'Penjualan',
                            data: safePenjualanData,
                            borderColor: '#36A2EB',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y1'
                        },
                        {
                            label: 'Pembelian',
                            data: safePembelianData,
                            borderColor: '#FF6384',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y2'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y1: { position: 'left', beginAtZero: true, title: { display: true, text: 'Penjualan (Rp)', font: { size: 14 } }, ticks: { callback: value => 'Rp ' + value.toLocaleString('id-ID'), font: { size: 12 } } },
                        y2: { position: 'right', beginAtZero: true, title: { display: true, text: 'Pembelian (Rp)', font: { size: 14 } }, ticks: { callback: value => 'Rp ' + value.toLocaleString('id-ID'), font: { size: 12 } } },
                        x: { title: { display: true, text: 'Tanggal', font: { size: 14 } }, ticks: { font: { size: 12 } } }
                    },
                    plugins: {
                        legend: { position: 'top', labels: { font: { size: 14 } } },
                        tooltip: {
                            callbacks: { label: context => `${context.dataset.label}: Rp ${context.parsed.y.toLocaleString('id-ID')}` },
                            titleFont: { size: 14 },
                            bodyFont: { size: 12 }
                        }
                    }
                }
            });
        }

        if (safeTopSellingData.some(val => val > 0)) {
            topLeastBarChart = new Chart(document.getElementById('topLeastBarChart'), {
                type: 'bar',
                data: {
                    labels: safeTopSellingLabels,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: safeTopSellingData,
                        backgroundColor: ['#36A2EB', '#36A2EB', '#36A2EB', '#FF6384'],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { x: { beginAtZero: true, title: { display: true, text: 'Jumlah', font: { size: 14 } }, ticks: { font: { size: 12 } } } },
                    plugins: {
                        legend: { display: false },
                        tooltip: { titleFont: { size: 14 }, bodyFont: { size: 12 } }
                    }
                }
            });
        }

        if (safeHighestProfitData.some(val => val > 0)) {
            profitBarChart = new Chart(document.getElementById('profitBarChart'), {
                type: 'bar',
                data: {
                    labels: safeHighestProfitLabels,
                    datasets: [{
                        label: 'Laba',
                        data: safeHighestProfitData,
                        backgroundColor: ['#FF6384', '#FF6384', '#FF6384', '#36A2EB'],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { x: { beginAtZero: true, title: { display: true, text: 'Laba (Rp)', font: { size: 14 } }, ticks: { callback: value => 'Rp ' + value.toLocaleString('id-ID'), font: { size: 12 } } } },
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: context => `Laba: Rp ${context.parsed.x.toLocaleString('id-ID')}` }, titleFont: { size: 14 }, bodyFont: { size: 12 } }
                    }
                }
            });
        }
    }

    const chartData = document.getElementById('chart-data');
    if (chartData) {
        const initialLabels = JSON.parse(chartData.getAttribute('data-labels'));
        const initialPenjualanData = JSON.parse(chartData.getAttribute('data-penjualan'));
        const initialPembelianData = JSON.parse(chartData.getAttribute('data-pembelian'));
        const initialTopSellingLabels = JSON.parse(chartData.getAttribute('data-top-selling-labels'));
        const initialTopSellingData = JSON.parse(chartData.getAttribute('data-top-selling'));
        const initialHighestProfitLabels = JSON.parse(chartData.getAttribute('data-highest-profit-labels'));
        const initialHighestProfitData = JSON.parse(chartData.getAttribute('data-highest-profit'));
        console.log('Initial Chart Data:', {
            initialLabels,
            initialPenjualanData,
            initialPembelianData,
            initialTopSellingLabels,
            initialTopSellingData,
            initialHighestProfitLabels,
            initialHighestProfitData
        });
        renderCharts(
            initialLabels,
            initialPenjualanData,
            initialPembelianData,
            initialTopSellingLabels,
            initialTopSellingData,
            initialHighestProfitLabels,
            initialHighestProfitData
        );

        Livewire.on('chart-updated', () => {
            const updatedChartData = document.getElementById('chart-data');
            const updatedLabels = JSON.parse(updatedChartData.getAttribute('data-labels'));
            const updatedPenjualanData = JSON.parse(updatedChartData.getAttribute('data-penjualan'));
            const updatedPembelianData = JSON.parse(updatedChartData.getAttribute('data-pembelian'));
            const updatedTopSellingLabels = JSON.parse(updatedChartData.getAttribute('data-top-selling-labels'));
            const updatedTopSellingData = JSON.parse(updatedChartData.getAttribute('data-top-selling'));
            const updatedHighestProfitLabels = JSON.parse(updatedChartData.getAttribute('data-highest-profit-labels'));
            const updatedHighestProfitData = JSON.parse(updatedChartData.getAttribute('data-highest-profit'));
            console.log('Updated Chart Data:', {
                updatedLabels,
                updatedPenjualanData,
                updatedPembelianData,
                updatedTopSellingLabels,
                updatedTopSellingData,
                updatedHighestProfitLabels,
                updatedHighestProfitData
            });
            renderCharts(
                updatedLabels,
                updatedPenjualanData,
                updatedPembelianData,
                updatedTopSellingLabels,
                updatedTopSellingData,
                updatedHighestProfitLabels,
                updatedHighestProfitData
            );
        });
    }

    Livewire.on('open-report', (event) => {
        console.log('Opening Report:', event);
        window.open(event.url, '_blank');
    });

    Livewire.on('confirmTransferKembalian', () => {
        console.log('Confirm Transfer Kembalian Triggered', {
            timestamp: new Date().toISOString(),
            saldoKembalian: document.querySelector('#chart-data')?.dataset || 'No chart data element found',
        });
        Swal.fire({
            title: 'Konfirmasi Transfer',
            text: 'Apakah Anda yakin ingin mentransfer saldo kembalian ke kas keuntungan? Ini akan menghapus semua data kas kembalian.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007022',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Transfer',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('User Confirmed Transfer', {
                    timestamp: new Date().toISOString(),
                    user: window.Laravel ? window.Laravel.user : 'No Laravel user data available',
                });
                Livewire.dispatch('proceedTransferKembalian');
                console.log('Dispatched proceedTransferKembalian event');
            } else {
                console.log('Transfer Kembalian Dibatalkan', {
                    timestamp: new Date().toISOString(),
                });
            }
        });
    });

    Livewire.on('transferSuccess', (event) => {
        console.log('Transfer Success', {
            message: event.message,
            timestamp: new Date().toISOString(),
            event: event,
        });
        Swal.fire({
            title: 'Berhasil!',
            text: event.message,
            icon: 'success',
            confirmButtonColor: '#007022',
            confirmButtonText: 'OK'
        });
    });

    Livewire.on('transferFailed', (event) => {
        console.log('Transfer Failed', {
            message: event.message,
            timestamp: new Date().toISOString(),
            event: event,
        });
        Swal.fire({
            title: 'Gagal!',
            text: event.message || 'Terjadi kesalahan saat transfer.',
            icon: 'error',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    });

    Livewire.on('refreshComponent', () => {
        console.log('Refresh Component Triggered', {
            timestamp: new Date().toISOString(),
        });
        Livewire.dispatch('loadAllData');
        console.log('Dispatched loadAllData event');
    });
});