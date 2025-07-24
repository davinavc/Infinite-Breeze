document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.querySelector(".wrapper");
    const loginLink = document.querySelector(".logreg-link a.login-link");
    const registerLink = document.querySelector(".logreg-link a.register-link");
    
    if (registerLink) {
        registerLink.addEventListener("click", function (e) {
            e.preventDefault();
            wrapper.classList.add("active");
            setTimeout(() => {
                window.location.href = registerLink.getAttribute("href");
            }, 1350);
        });
    }
    
    if (loginLink) {
        loginLink.addEventListener("click", function (e) {
            e.preventDefault();
            wrapper.classList.remove("active");
            setTimeout(() => {
                window.location.href = loginLink.getAttribute("href");
            }, 1350);
        });
    }

    const passwordFields = document.querySelectorAll("input[type='password']");
    passwordFields.forEach((field) => {
        const toggleIcon = field.nextElementSibling;
        if (toggleIcon) {
            toggleIcon.style.cursor = "pointer";
            toggleIcon.addEventListener("click", function () {
                if (field.type === "password") {
                    field.type = "text";
                    toggleIcon.classList.add("active");
                } else {
                    field.type = "password";
                    toggleIcon.classList.remove("active");
                }
            });
        }
    });

    const toggleButton = document.getElementById('toggleDarkMode');
    const body = document.body;

    // Cek apakah sebelumnya sudah ada mode tersimpan di localStorage
    if (localStorage.getItem('darkMode') === 'enabled') {
        body.classList.add('dark-mode');
        toggleButton.textContent = "☀️";
    }

    // // Event listener untuk tombol toggle
    // toggleButton.addEventListener('click', () => {
    //     body.classList.toggle('dark-mode');

    //     if (body.classList.contains('dark-mode')) {
    //         localStorage.setItem('darkMode', 'enabled');
    //         toggleButton.textContent = "☀️";
    //     } else {
    //         localStorage.setItem('darkMode', 'disabled');
    //         toggleButton.textContent = "🌙";
    //     }
    // });

    //dropdown event di blog
    const categorySelect = document.getElementById("category");
    const eventSelect = document.getElementById("event_id");
    const titleInput = document.getElementById("judul_blog");
    const imageInput = document.getElementById("images");

    if (categorySelect && eventSelect && titleInput) {
        categorySelect.addEventListener("change", function () {
            const selected = this.value;
            if (selected === "Event") {
                eventSelect.disabled = false;
                // opsional: set otomatis title kalau ada event dipilih
                if (eventSelect.selectedIndex > 0) {
                    titleInput.value = eventSelect.options[eventSelect.selectedIndex].text;
                }
            } else {
                eventSelect.disabled = true;
                eventSelect.selectedIndex = 0;
                titleInput.value = "";
            }
        });

        eventSelect.addEventListener("change", function () {
            if (categorySelect.value === "Event") {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption) {
                    titleInput.value = selectedOption.text;
                    imageInput.value = selectedOption.text;
                }
            }
        });
    }

    //buat dropdown sidebar
    const toggleDropdown = (dropdown, menu, isOpen) => {
        dropdown.classList.toggle("open", isOpen);
        menu.style.height = isOpen ? `${menu.scrollHeight}px` : 0;
    };

    const closeAllDropdowns = () => {
        document.querySelectorAll(".dropdown-container.open").forEach(openDropdown => {
            toggleDropdown(openDropdown, openDropdown.querySelector(".dropdown-menu"), false);
        });
    }

    document.querySelectorAll(".dropdown-toggle").forEach(dropdownToggle => {
        dropdownToggle.addEventListener("click", e => {
            e.preventDefault();
            
            const dropdown = e.target.closest(".dropdown-container");
            const menu = dropdown.querySelector(".dropdown-menu");
            const isOpen = dropdown.classList.contains("open");

            closeAllDropdowns();
            
            toggleDropdown(dropdown, menu, !isOpen);
        })
    })
    
    // Buat Sidebar
    document.querySelectorAll(".sidebar-toggler, .sidebar-menu-button").forEach(button => {
        button.addEventListener("click", () => {
            closeAllDropdowns();
            document.querySelector(".sidebar").classList.toggle("collapsed");
        });
    });

    if(window.innerWidth <=1024) document.querySelector(".sidebar").classList.toggle("collapsed");
    
    const startDateInput = document.querySelector('input[name="start_date"]');
    const finishDateInput = document.querySelector('input[name="finish_date"]');

    // batasan tanggal
    if (startDateInput && finishDateInput) {
        const today = new Date();
        const minStart = new Date();
        minStart.setDate(today.getDate() + 14);

        // Fungsi format date ke yyyy-mm-dd
        const formatDate = (d) => {
            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        };

        // Set min dan max untuk start date
        startDateInput.min = formatDate(minStart);

        // Set min untuk finish date sesuai start date saat ini atau hari ini
        finishDateInput.min = startDateInput.value ? startDateInput.value : formatDate(today);

        // Ketika start date berubah, update min finish date
        startDateInput.addEventListener('change', function() {
            finishDateInput.min = this.value;
            if (finishDateInput.value < this.value) {
                finishDateInput.value = this.value;
            }
        });
    }

    //buat input additional price realtime
    const priceData = document.getElementById('price-data');
    if (priceData) {
        const hargaBooth = parseFloat(priceData.dataset.harga);
        const maxFreeElectricity = parseFloat(priceData.dataset.electricity);
        const tarifPerAmpere = parseFloat(priceData.dataset.tarif);

        const wattInput = document.getElementById('watt_listrik');
        const listrikCost = document.getElementById('listrik-cost');
        const totalCost = document.getElementById('total-cost');
        const totalPriceInput = document.getElementById('total_price');

        if (wattInput) {
            wattInput.addEventListener('input', function () {
                const usage = parseFloat(this.value) || 0;
                let excess = 0;
                if (usage > maxFreeElectricity) {
                    excess = usage - maxFreeElectricity;
                }
                const additionalCost = Math.ceil(excess) * 220 * tarifPerAmpere;
                const finalTotal = hargaBooth + additionalCost;
                listrikCost.textContent = 'Rp ' + additionalCost.toLocaleString('id-ID');
                totalCost.textContent = 'Rp ' + finalTotal.toLocaleString('id-ID');

                totalPriceInput.value = finalTotal;
            });
        }
    }
    
    
    //buat bikin auto tanggal schedule
    const scheduleEventSelect  = document.getElementById('event_ids');
    const scheduleTable = document.getElementById('schedule-table');
    const startDateInputSchedule = document.getElementById('start_date');
    const finishDateInputSchedule = document.getElementById('finish_date');

    if (scheduleEventSelect) {
        scheduleEventSelect .addEventListener('change', function () {
            
            const selected = this.options[this.selectedIndex];
            const start = selected.getAttribute('data-start');
            const end = selected.getAttribute('data-end');

            if (start && end) {
                startDateInputSchedule.value = start;
                finishDateInputSchedule.value = end;

                const startDate = new Date(start);
                const endDate = new Date(end);
                let html = '<table><tr><th>Tanggal</th><th>Max Staff</th></tr>';

                for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                    const dateStr = d.toISOString().split('T')[0];
                    html += `
                        <tr>
                            <td>${dateStr}</td>
                            <td><input type="number" name="maks_staff[${dateStr}]" required></td>
                        </tr>
                    `;
                }

                html += '</table>';
                scheduleTable.innerHTML = html;
            } else {
                startDateInputSchedule.value = '';
                finishDateInputSchedule.value = '';
                scheduleTable.innerHTML = '';
            }   
    })};

    const selectV = document.getElementById('event_idv');
    const tableView = document.getElementById('scheduleTableView');
    const startV = document.getElementById('start_date');
    const finishV = document.getElementById('finish_date');

    // Object dari server: jadwalStaff berbentuk array
    const jadwalDataElement = document.getElementById('jadwal-data');
    if (jadwalDataElement) {
        const jadwals = JSON.parse(jadwalDataElement.textContent);

        selectV.addEventListener('change', function(){
            const opt = this.options[this.selectedIndex];
            const start = opt.getAttribute('data-start');
            const end = opt.getAttribute('data-end');
            startV.value = start; finishV.value = end;

            const filtered = jadwals.filter(j => j.event_id == opt.value);
            const mapByDate = {};
            filtered.forEach(j => {
                mapByDate[j.tgl_event] = {
                    maks: j.maks_staff,
                    accepted: j.accepted_count,
                    jadwal_staff_id: j.id
                }
            });

            let html = `<table>
                <tr><th>Tanggal</th><th>Slot (terisi/maks)</th><th>Staff</th><th>Action</th></tr>`;

            let d = new Date(start);
            const dtEnd = new Date(end);

            while(d <= dtEnd){
                const dstr = d.toISOString().split('T')[0];
                const data = mapByDate[dstr] ?? {maks: '-', accepted: 0};
                const left = data.maks !== '-' ? data.maks - data.accepted : '-';
                const btnView = data.maks !== '-' 
                    ? `<div class="group-button-action">
                            <a href="/dashboard/admin/schedule/${data.jadwal_staff_id}/staff" class="btn-details" style="display: flex; align-items: center;">
                                <span class="material-symbols-outlined">group</span>
                                Staff
                            </a>
                        </div>`
                    : '-';
                const btnEdit = data.maks !== '-' 
                    ? `<div class="group-button-action">
                            <a href="/dashboard/admin/schedule/edit/${opt.value}" class="btn-edit">
                                <span class="material-symbols-outlined">edit</span>
                                Edit
                            </a>
                        </div>`
                    : '-';

                html += `<tr>
                    <td>${dstr}</td>
                    <td>${data.accepted}/${data.maks} (sisa ${left})</td>
                    <td class="button-group">${btnView}</td>
                    <td class="button-group">${btnEdit}</td>
                </tr>`;

                d.setDate(d.getDate()+1);
            }

            html += '</table>';
            tableView.innerHTML = html;
        });
    }

    document.querySelectorAll('.follow-up-btn').forEach(button => {
        button.addEventListener('click', function () {
            const transaksiId = this.dataset.id;
            const email = this.dataset.email;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/dashboard/admin/transaksi/${transaksiId}/follow-up`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Follow-up gagal');
                }
                // lanjut buka email
                window.open(`mailto:${email}`, '_blank');
            })
            .catch(error => {
                alert(error.message);
            });
        });
    });

})

