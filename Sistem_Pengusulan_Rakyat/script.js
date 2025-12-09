// URL API kita
const API_URL = 'api.php';

// --- FUNGSI CREATE (POST) ---
document.getElementById('form-tambah').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const data = {
        nama_pengusul: document.getElementById('nama_pengusul').value,
        topik_usulan: document.getElementById('topik_usulan').value,
        deskripsi_usulan: document.getElementById('deskripsi_usulan').value
    };

    const response = await fetch(`${API_URL}?action=create`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    alert(result.message);
    if (result.success) {
        this.reset();
        fetchUsulan(); // Refresh data setelah CREATE
    }
});

// --- FUNGSI READ/SEARCH (GET) ---
async function fetchUsulan() {
    const searchTerm = document.getElementById('input-search').value;
    // Panggil action=read yang sudah dimodifikasi di api.php
    const url = `${API_URL}?action=read&search=${encodeURIComponent(searchTerm)}`;
    
    const response = await fetch(url);
    const result = await response.json();

    const tbody = document.getElementById('tabel-usulan').querySelector('tbody');
    tbody.innerHTML = ''; // Kosongkan tabel
    
if (result.success && result.data.length > 0) {
        result.data.forEach(usulan => {
            const row = tbody.insertRow();
            
            // Hapus Baris ini: row.insertCell().textContent = usulan.id_usulan; 
            
            // Kolom Nama, Topik, dan Tanggal akan bergeser ke kiri
            row.insertCell().textContent = usulan.nama_pengusul;
            row.insertCell().textContent = usulan.topik_usulan;
            row.insertCell().textContent = usulan.tanggal_pengusulan;
            
            // Menampilkan Status Usulan
            const statusCell = row.insertCell();
            statusCell.textContent = usulan.status_usulan;

            // Tambahkan tombol untuk Aksi (Update/Delete)
            const actionCell = row.insertCell();
            
            // Logika Tombol Aksi tetap sama
            if (usulan.status_usulan === 'Selesai') {
                // ... (tetap menggunakan ID untuk fungsi updateStatus dan deleteUsulan)
                actionCell.innerHTML = `
                    <button style="background-color: gray;" disabled>Selesai</button>
                    <button onclick="deleteUsulan(${usulan.id_usulan})">Hapus (DELETE)</button>
                `;
            } else {
                actionCell.innerHTML = `
                    <button onclick="updateStatus(${usulan.id_usulan}, 'Selesai')">Selesaikan</button>
                    <button onclick="deleteUsulan(${usulan.id_usulan})">Hapus</button>
                `;
            }
        });
    } else {
         tbody.innerHTML = '<tr><td colspan="5">Tidak ada usulan yang ditemukan.</td></tr>'; 
    }
}

// --- FUNGSI UPDATE (POST) ---
async function updateStatus(id, newStatus) {
    const response = await fetch(`${API_URL}?action=update`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_usulan: id, status_usulan: newStatus })
    });
    const result = await response.json();
    alert(result.message);
    fetchUsulan();
}

// --- FUNGSI DELETE (POST) ---
async function deleteUsulan(id) {
    if (!confirm('Yakin ingin menghapus usulan ini?')) return;
    
    const response = await fetch(`${API_URL}?action=delete`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_usulan: id })
    });
    const result = await response.json();
    alert(result.message);
    fetchUsulan();
}

// Panggil saat halaman dimuat
window.onload = fetchUsulan;