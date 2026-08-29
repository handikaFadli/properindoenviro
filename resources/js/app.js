import "flowbite";
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";
import "./bootstrap";
import "./charts";
import "./dark-mode";
import "./sidebar";

window.showLoading = function () {
    const loading = document.getElementById("loading-screen");

    if (loading) {
        loading.classList.remove("hidden");
        loading.classList.add("flex");
    }
};

window.hideLoading = function () {
    const loading = document.getElementById("loading-screen");

    if (loading) {
        loading.classList.remove("flex");
        loading.classList.add("hidden");
    }
};

// Tandai bahwa klik berasal dari elemen download (Excel/PDF)
let isFileDownload = false;

document.addEventListener("click", function (e) {
    const el = e.target.closest("[data-download]");
    if (el) {
        isFileDownload = true;
    }
});

// Refresh / pindah halaman / tutup tab
window.addEventListener("beforeunload", function () {
    // Jika klik berasal dari tombol download file, jangan tampilkan loading screen
    // karena halaman tidak benar-benar berpindah dan loading akan macet.
    if (isFileDownload) {
        isFileDownload = false;
        return;
    }
    showLoading();
});

window.addEventListener("pageshow", function (event) {
    // event.persisted === true berarti halaman diambil dari bfcache
    // (misalnya lewat tombol back/forward browser)
    if (event.persisted) {
        hideLoading();
    }
});

// document.addEventListener("DOMContentLoaded", () => {
//     const table = document.getElementById("data-table");

//     if (table) {
//         new DataTable(table, {
//             searchable: true,
//             sortable: false,
//             paging: true,

//             labels: {
//                 placeholder: "Cari data...",
//                 perPage: "",
//                 noRows: "Data tidak ditemukan",
//                 info: "",
//             },
//         });
//     }
// });

new TomSelect("#fitur_ids", {
    plugins: ["remove_button"],
    placeholder: "Pilih fitur",
});
