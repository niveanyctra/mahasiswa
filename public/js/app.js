let nextId = 6;
let editingId = null;

// Initialize app
document.addEventListener("DOMContentLoaded", function () {
    renderStudents();
    updateStats();
    setupEventListeners();
});

// Setup event listeners
function setupEventListeners() {
    document
        .getElementById("searchInput")
        .addEventListener("input", filterStudents);
    document
        .getElementById("jurusanFilter")
        .addEventListener("change", filterStudents);
    document
        .getElementById("studentForm")
        .addEventListener("submit", handleSubmit);

    // Close modal when clicking outside
    window.addEventListener("click", function (e) {
        const modal = document.getElementById("studentModal");
        if (e.target === modal) {
            closeModal();
        }
    });
}

// Render students table
function renderStudents(data = students) {
    const tbody = document.getElementById("studentsTableBody");
    const emptyState = document.getElementById("emptyState");
    const tableContainer = document.getElementById("tableContainer");

    if (data.length === 0) {
        tableContainer.style.display = "none";
        emptyState.style.display = "block";
        return;
    }

    tableContainer.style.display = "block";
    emptyState.style.display = "none";

    tbody.innerHTML = data
        .map(
            (student) => `
                <tr>
                    <td>
                        <img src="${student.foto}" alt="${
                student.nama
            }" class="student-photo" onerror="this.src='https://via.placeholder.com/50x50/667eea/ffffff?text=${student.nama.charAt(
                0
            )}'">
                    </td>
                    <td><strong>${student.nim}</strong></td>
                    <td>${student.nama}</td>
                    <td>${student.jurusan}</td>
                    <td>${student.email}</td>
                    <td>${student.telepon || "-"}</td>
                    <td>
                        <span class="status-badge ${
                            student.status === "Aktif"
                                ? "status-active"
                                : "status-inactive"
                        }">
                            ${student.status}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editStudent(${
                            student.id
                        })" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteStudent(${
                            student.id
                        })" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `
        )
        .join("");
}

// Update statistics
function updateStats() {
    const totalStudents = students.length;
    const activeStudents = students.filter((s) => s.status === "Aktif").length;
    const totalJurusan = [...new Set(students.map((s) => s.jurusan))].length;
    const newStudents = students.filter(
        (s) => s.angkatan === new Date().getFullYear()
    ).length;

    document.getElementById("totalStudents").textContent = totalStudents;
    document.getElementById("activeStudents").textContent = activeStudents;
    document.getElementById("totalJurusan").textContent = totalJurusan;
    document.getElementById("newStudents").textContent = newStudents;
}

// Filter students
function filterStudents() {
    const searchTerm = document
        .getElementById("searchInput")
        .value.toLowerCase();
    const jurusanFilter = document.getElementById("jurusanFilter").value;

    const filtered = students.filter((student) => {
        const matchesSearch =
            student.nama.toLowerCase().includes(searchTerm) ||
            student.nim.toLowerCase().includes(searchTerm);
        const matchesJurusan =
            !jurusanFilter || student.jurusan === jurusanFilter;
        return matchesSearch && matchesJurusan;
    });

    renderStudents(filtered);
}

// Open modal
function openModal(student = null) {
    const modal = document.getElementById("studentModal");
    const modalTitle = document.getElementById("modalTitle");
    const form = document.getElementById("studentForm");

    if (student) {
        modalTitle.textContent = "Edit Mahasiswa";
        editingId = student.id;
        fillForm(student);
    } else {
        modalTitle.textContent = "Tambah Mahasiswa Baru";
        editingId = null;
        form.reset();
    }

    modal.style.display = "block";
}

// Close modal
function closeModal() {
    const modal = document.getElementById("studentModal");
    modal.style.display = "none";
    editingId = null;
}

// Fill form with student data
function fillForm(student) {
    document.getElementById("studentId").value = student.id;
    document.getElementById("nim").value = student.nim;
    document.getElementById("nama").value = student.nama;
    document.getElementById("jurusan").value = student.jurusan;
    document.getElementById("angkatan").value = student.angkatan;
    document.getElementById("email").value = student.email;
    document.getElementById("telepon").value = student.telepon || "";
    document.getElementById("alamat").value = student.alamat || "";
    document.getElementById("status").value = student.status;
    document.getElementById("ipk").value = student.ipk || "";
}

// Handle form submission
function handleSubmit(e) {
    e.preventDefault();

    const formData = {
        nim: document.getElementById("nim").value,
        nama: document.getElementById("nama").value,
        jurusan: document.getElementById("jurusan").value,
        angkatan: parseInt(document.getElementById("angkatan").value),
        email: document.getElementById("email").value,
        telepon: document.getElementById("telepon").value,
        alamat: document.getElementById("alamat").value,
        status: document.getElementById("status").value,
        ipk: parseFloat(document.getElementById("ipk").value) || null,
        foto: `https://images.unsplash.com/photo-${
            Math.random() > 0.5
                ? "1507003211169-0a1dd7228f2d"
                : "1494790108755-2616b612b786"
        }?w=100&h=100&fit=crop&crop=face`,
    };

    // Validate NIM uniqueness
    const existingStudent = students.find(
        (s) => s.nim === formData.nim && s.id !== editingId
    );
    if (existingStudent) {
        showToast("NIM sudah digunakan!", "error");
        return;
    }

    if (editingId) {
        // Update existing student
        const index = students.findIndex((s) => s.id === editingId);
        students[index] = { ...students[index], ...formData };
        showToast("Data mahasiswa berhasil diperbarui!");
    } else {
        // Add new student
        const newStudent = { id: nextId++, ...formData };
        students.push(newStudent);
        showToast("Mahasiswa baru berhasil ditambahkan!");
    }

    closeModal();
    renderStudents();
    updateStats();
    filterStudents(); // Apply current filters
}

// Edit student
function editStudent(id) {
    const student = students.find((s) => s.id === id);
    if (student) {
        openModal(student);
    }
}

// Delete student with confirmation
function deleteStudent(id) {
    const student = students.find((s) => s.id === id);
    if (!student) return;

    if (
        confirm(
            `Apakah Anda yakin ingin menghapus data mahasiswa "${student.nama}"?\n\nData yang dihapus tidak dapat dikembalikan.`
        )
    ) {
        students = students.filter((s) => s.id !== id);
        showToast(`Data mahasiswa "${student.nama}" berhasil dihapus!`);
        renderStudents();
        updateStats();
        filterStudents();
    }
}

// Show toast notification
function showToast(message, type = "success") {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.className = `toast ${type}`;
    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}

// Export data to Excel (simulated)
function exportData() {
    showToast("Fitur export sedang dalam pengembangan!", "error");

    // Simulate export process
    const loading = document.getElementById("loading");
    loading.style.display = "block";

    setTimeout(() => {
        loading.style.display = "none";

        // Create CSV content
        const headers = [
            "NIM",
            "Nama",
            "Jurusan",
            "Angkatan",
            "Email",
            "Telepon",
            "Status",
            "IPK",
        ];
        const csvContent = [
            headers.join(","),
            ...students.map((student) =>
                [
                    student.nim,
                    `"${student.nama}"`,
                    `"${student.jurusan}"`,
                    student.angkatan,
                    student.email,
                    student.telepon || "",
                    student.status,
                    student.ipk || "",
                ].join(",")
            ),
        ].join("\n");

        // Create download link
        const blob = new Blob([csvContent], {
            type: "text/csv;charset=utf-8;",
        });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute(
            "download",
            `data-mahasiswa-${new Date().toISOString().split("T")[0]}.csv`
        );
        link.style.visibility = "hidden";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        showToast("Data berhasil diexport ke file CSV!");
    }, 2000);
}

// Add keyboard shortcuts
document.addEventListener("keydown", function (e) {
    // Ctrl/Cmd + N = Add new student
    if ((e.ctrlKey || e.metaKey) && e.key === "n") {
        e.preventDefault();
        openModal();
    }

    // Escape = Close modal
    if (e.key === "Escape") {
        closeModal();
    }

    // Ctrl/Cmd + F = Focus search
    if ((e.ctrlKey || e.metaKey) && e.key === "f") {
        e.preventDefault();
        document.getElementById("searchInput").focus();
    }
});

// Add tooltip functionality
function initTooltips() {
    const tooltipElements = document.querySelectorAll("[title]");
    tooltipElements.forEach((el) => {
        el.addEventListener("mouseenter", function () {
            const tooltip = document.createElement("div");
            tooltip.className = "tooltip";
            tooltip.textContent = this.getAttribute("title");
            tooltip.style.cssText = `
                        position: absolute;
                        background: #333;
                        color: white;
                        padding: 5px 10px;
                        border-radius: 5px;
                        font-size: 12px;
                        z-index: 1000;
                        pointer-events: none;
                        white-space: nowrap;
                    `;
            document.body.appendChild(tooltip);

            this.addEventListener("mousemove", function (e) {
                tooltip.style.left = e.pageX + 10 + "px";
                tooltip.style.top = e.pageY - 30 + "px";
            });

            this.addEventListener("mouseleave", function () {
                if (tooltip && tooltip.parentNode) {
                    tooltip.parentNode.removeChild(tooltip);
                }
            });
        });
    });
}

// Initialize tooltips when page loads
setTimeout(initTooltips, 100);

// Add data validation
function validateForm() {
    const nim = document.getElementById("nim").value.trim();
    const nama = document.getElementById("nama").value.trim();
    const email = document.getElementById("email").value.trim();

    if (nim.length < 8) {
        showToast("NIM harus minimal 8 karakter!", "error");
        return false;
    }

    if (nama.length < 3) {
        showToast("Nama harus minimal 3 karakter!", "error");
        return false;
    }

    if (!email.includes("@")) {
        showToast("Format email tidak valid!", "error");
        return false;
    }

    return true;
}

// Enhanced search with highlighting
function highlightSearchTerm(text, searchTerm) {
    if (!searchTerm) return text;
    const regex = new RegExp(`(${searchTerm})`, "gi");
    return text.replace(
        regex,
        '<mark style="background: yellow; padding: 2px;">$1</mark>'
    );
}

// Add sorting functionality
let sortColumn = "";
let sortDirection = "asc";

function sortTable(column) {
    if (sortColumn === column) {
        sortDirection = sortDirection === "asc" ? "desc" : "asc";
    } else {
        sortColumn = column;
        sortDirection = "asc";
    }

    students.sort((a, b) => {
        let aVal = a[column];
        let bVal = b[column];

        if (typeof aVal === "string") {
            aVal = aVal.toLowerCase();
            bVal = bVal.toLowerCase();
        }

        if (sortDirection === "asc") {
            return aVal > bVal ? 1 : -1;
        } else {
            return aVal < bVal ? 1 : -1;
        }
    });

    renderStudents();
}

// Add batch operations
function selectAllStudents() {
    const checkboxes = document.querySelectorAll(".student-checkbox");
    const selectAllCheckbox = document.getElementById("selectAll");

    checkboxes.forEach((checkbox) => {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

function getSelectedStudents() {
    const checkboxes = document.querySelectorAll(".student-checkbox:checked");
    return Array.from(checkboxes).map((cb) => parseInt(cb.value));
}

function deleteSelectedStudents() {
    const selectedIds = getSelectedStudents();
    if (selectedIds.length === 0) {
        showToast("Pilih mahasiswa yang ingin dihapus!", "error");
        return;
    }

    if (confirm(`Hapus ${selectedIds.length} mahasiswa yang dipilih?`)) {
        students = students.filter((s) => !selectedIds.includes(s.id));
        showToast(`${selectedIds.length} mahasiswa berhasil dihapus!`);
        renderStudents();
        updateStats();
    }
}
