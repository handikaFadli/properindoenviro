document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const backdrop = document.getElementById("sidebarBackdrop");
    const toggleButton = document.getElementById("toggleSidebarMobile");
    const searchButton = document.getElementById("toggleSidebarMobileSearch");
    const hamburger = document.getElementById("toggleSidebarMobileHamburger");
    const closeIcon = document.getElementById("toggleSidebarMobileClose");

    if (!sidebar || !backdrop || !toggleButton || !hamburger || !closeIcon) {
        return;
    }

    const setOpen = (open) => {
        sidebar.classList.toggle("hidden", !open);
        sidebar.classList.toggle("!flex", open);
        backdrop.classList.toggle("hidden", !open);
        hamburger.classList.toggle("hidden", open);
        closeIcon.classList.toggle("hidden", !open);
        toggleButton.setAttribute("aria-expanded", String(open));
    };

    toggleButton.addEventListener("click", () => {
        setOpen(sidebar.classList.contains("hidden"));
    });

    searchButton?.addEventListener("click", () => {
        setOpen(sidebar.classList.contains("hidden"));
    });

    backdrop.addEventListener("click", () => setOpen(false));

    window.addEventListener("resize", () => {
        if (window.innerWidth >= 1024) {
            setOpen(false);
        }
    });
});
