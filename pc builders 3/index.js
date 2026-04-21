document.addEventListener("DOMContentLoaded", () => {
    const searchContainer = document.getElementById("search-container");
    const searchIcon = document.querySelector("#search-container .fa");
    const searchInput = document.querySelector("#search-container input");

    // Toggle search bar
    function toggleSearchBar() {
        const isActive = searchContainer.classList.toggle("active");
        if (isActive) {
            searchInput.focus();
        } else {
            searchInput.value = "";
        }
    }

    // Close search bar when clicking outside
    function closeSearchBar(event) {
        if (!searchContainer.contains(event.target)) {
            searchContainer.classList.remove("active");
            searchInput.value = "";
        }
    }

    // Close search bar on Escape key
    function closeOnEsc(event) {
        if (event.key === "Escape") {
            searchContainer.classList.remove("active");
            searchInput.value = "";
        }
    }

    // Event listeners
    searchIcon.addEventListener("click", toggleSearchBar);
    document.addEventListener("click", closeSearchBar);
    document.addEventListener("keydown", closeOnEsc);
});