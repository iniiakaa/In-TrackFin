import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/**
 * Universal Liquid Frosted Glass Select Enhancer
 * Mengubah semua <select class="form-select ..."> menjadi dropdown liquid glass
 * yang seragam dengan style notif-dropdown dan search-dropdown.
 */
function initGlassSelects() {
    const selects = document.querySelectorAll('select.form-select');

    selects.forEach((select) => {
        if (select.dataset.glassSelectInit === 'true') return;
        select.dataset.glassSelectInit = 'true';

        // Sembunyikan native select secara aman (tetap di layout agar validasi HTML5 berfungsi)
        select.classList.add('glass-select-native-hidden');

        // Buat container
        const container = document.createElement('div');
        container.className = 'glass-select-container relative inline-block';

        // Salin kelas ukuran dan flex dari select asli
        const originalClasses = Array.from(select.classList);
        originalClasses.forEach((cls) => {
            if (
                cls.startsWith('w-') ||
                cls.startsWith('sm:w-') ||
                cls.startsWith('md:w-') ||
                cls.startsWith('lg:w-') ||
                cls.startsWith('max-w-') ||
                cls.startsWith('min-w-') ||
                cls.startsWith('flex-')
            ) {
                container.classList.add(cls);
            }
        });

        // Jika tidak ada kelas lebar khusus, buat default w-full jika di dalam form biasa
        if (!container.className.includes('w-')) {
            container.classList.add('w-full');
        }

        // Cari opsi yang terpilih saat ini
        const selectedIndex = select.selectedIndex >= 0 ? select.selectedIndex : 0;
        const currentOption = select.options[selectedIndex] || { textContent: 'Pilih...', value: '' };

        // Buat Trigger Button
        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'glass-select-trigger flex items-center justify-between gap-2.5 w-full h-[44px] px-4 rounded-full text-xs sm:text-sm font-semibold text-on-surface transition-all select-none cursor-pointer';
        trigger.setAttribute('aria-haspopup', 'listbox');
        trigger.setAttribute('aria-expanded', 'false');

        const label = document.createElement('span');
        label.className = 'glass-select-label truncate text-left flex-1';
        label.textContent = currentOption.textContent;

        const arrow = document.createElement('span');
        arrow.className = 'material-symbols-outlined text-[18px] text-on-surface-variant/70 transition-transform duration-200 flex-shrink-0 glass-select-arrow';
        arrow.textContent = 'expand_more';

        trigger.appendChild(label);
        trigger.appendChild(arrow);

        // Buat Menu Dropdown (Liquid Frosted Glass)
        const menu = document.createElement('div');
        menu.className = 'glass-dropdown glass-select-menu absolute mt-2 z-50 origin-top rounded-[20px] p-1.5';
        menu.setAttribute('role', 'listbox');
        menu.setAttribute('aria-hidden', 'true');
        menu.style.display = 'none';

        const list = document.createElement('ul');
        list.className = 'max-h-[260px] overflow-y-auto space-y-1 p-1 pr-1.5';

        // Render setiap opsi
        function renderOptions() {
            list.innerHTML = '';
            Array.from(select.options).forEach((opt) => {
                const li = document.createElement('li');
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'glass-select-option w-full flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-[14px] text-xs font-semibold transition-all duration-150 text-left';
                btn.setAttribute('data-value', opt.value);

                const isSelected = opt.value === select.value || (opt.selected && !select.value);

                if (isSelected) {
                    btn.classList.add('bg-primary/10', 'text-primary', 'font-bold', 'is-selected');
                } else {
                    btn.classList.add('text-on-surface', 'hover:bg-white/50');
                }

                const optText = document.createElement('span');
                optText.className = 'truncate';
                optText.textContent = opt.textContent;
                btn.appendChild(optText);

                if (isSelected) {
                    const checkIcon = document.createElement('span');
                    checkIcon.className = 'material-symbols-outlined text-[16px] text-primary flex-shrink-0 check-icon';
                    checkIcon.style.fontVariationSettings = "'FILL' 1";
                    checkIcon.textContent = 'check';
                    btn.appendChild(checkIcon);
                }

                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    // Update nilai native select
                    select.value = opt.value;
                    label.textContent = opt.textContent;

                    // Hilangkan status invalid jika ada
                    trigger.classList.remove('!border-error', '!ring-2', '!ring-error/20');

                    // Tutup menu
                    closeMenu();

                    // Trigger event pada native select
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                    select.dispatchEvent(new Event('input', { bubbles: true }));
                });

                li.appendChild(btn);
                list.appendChild(li);
            });
        }

        renderOptions();
        menu.appendChild(list);

        // Fungsi Buka / Tutup Menu
        function openMenu() {
            // Tutup dropdown lain yang terbuka
            closeAllGlassSelects();
            const notifDropdown = document.getElementById('notif-dropdown');
            if (notifDropdown && notifDropdown.classList.contains('open')) notifDropdown.classList.remove('open');
            const searchDropdown = document.getElementById('search-dropdown');
            if (searchDropdown && searchDropdown.classList.contains('open')) searchDropdown.classList.remove('open');

            // Render ulang opsi untuk memastikan status terpilih up to date
            renderOptions();

            // Cek posisi agar tidak keluar viewport layar kanan
            const rect = container.getBoundingClientRect();
            if (rect.left + 260 > window.innerWidth) {
                menu.classList.add('right-0', 'origin-top-right');
                menu.classList.remove('left-0', 'origin-top-left');
            } else {
                menu.classList.add('left-0', 'origin-top-left');
                menu.classList.remove('right-0', 'origin-top-right');
            }

            menu.style.display = 'block';
            container.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
            menu.setAttribute('aria-hidden', 'false');

            requestAnimationFrame(() => {
                menu.classList.add('open');
                arrow.classList.add('rotate-180');
            });
        }

        function closeMenu() {
            if (!container.classList.contains('is-open')) return;
            menu.classList.remove('open');
            arrow.classList.remove('rotate-180');
            container.classList.remove('is-open');
            trigger.setAttribute('aria-expanded', 'false');
            menu.setAttribute('aria-hidden', 'true');

            setTimeout(() => {
                if (!container.classList.contains('is-open')) {
                    menu.style.display = 'none';
                }
            }, 220);
        }

        container._closeMenu = closeMenu;

        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (container.classList.contains('is-open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Sinkronisasi jika select berubah dari luar (misal form reset atau update JS)
        select.addEventListener('change', () => {
            const current = select.options[select.selectedIndex];
            if (current) {
                label.textContent = current.textContent;
            }
        });

        // Tangani validasi 'required' browser
        select.addEventListener('invalid', () => {
            trigger.classList.add('!border-error', '!ring-2', '!ring-error/20');
            trigger.focus();
            trigger.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });

        // Sisipkan container ke DOM tepat sebelum select asli
        select.parentNode.insertBefore(container, select);
        container.appendChild(trigger);
        container.appendChild(menu);
        container.appendChild(select); // simpan select di dalam container
    });
}

function closeAllGlassSelects() {
    document.querySelectorAll('.glass-select-container.is-open').forEach((el) => {
        if (typeof el._closeMenu === 'function') {
            el._closeMenu();
        }
    });
}

// Tutup saat klik di luar
document.addEventListener('click', (e) => {
    if (!e.target.closest('.glass-select-container')) {
        closeAllGlassSelects();
    }
});

// Tutup saat tombol ESC ditekan
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeAllGlassSelects();
    }
});

// Jalankan otomatis
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initGlassSelects);
} else {
    initGlassSelects();
}

window.addEventListener('pageshow', initGlassSelects);
window.initGlassSelects = initGlassSelects;
window.closeAllGlassSelects = closeAllGlassSelects;
