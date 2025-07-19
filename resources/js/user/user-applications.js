// Select essential elements
const cardsContainer = document.getElementById("cards-container");
const prevBtn = document.getElementById("prev-btn");
const nextBtn = document.getElementById("next-btn");
const rowsPerPageSelect = document.getElementById("rowsPerPage");
const lineInfo = document.getElementById("line-info");
const filterTabs = document.querySelectorAll("#tabs a"); // Ensure tabs are within #tabs

let totalCards = 0;
let cardsPerPage = parseInt(rowsPerPageSelect.value, 10);
let currentPage = 1;
let currentFilter = "all"; // Default filter

// Function to filter cards by status and render them
function renderCards(status = currentFilter) {
    const cards = document.querySelectorAll("#cards-container > div");
    const filteredCards = Array.from(cards).filter((card) => {
        return status === "all" || card.getAttribute("data-status") === status;
    });

    totalCards = filteredCards.length;
    const start = (currentPage - 1) * cardsPerPage;
    const end = start + cardsPerPage;

    // Hide all cards initially
    cards.forEach((card) => (card.style.display = "none"));

    // Display only the cards for the current page
    filteredCards.slice(start, end).forEach((card) => {
        card.style.display = "block";
    });

    updatePaginationButtons();
    updateLineInfo();
}

// Function to update pagination buttons' state
function updatePaginationButtons() {
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage * cardsPerPage >= totalCards;
}

// Function to update the line info text
function updateLineInfo() {
    if (totalCards === 0) {
        lineInfo.textContent = "No applications found.";
        return;
    }
    const startLine = (currentPage - 1) * cardsPerPage + 1;
    const endLine = Math.min(currentPage * cardsPerPage, totalCards);
    lineInfo.textContent = `Showing ${startLine}-${endLine} of ${totalCards}`;
}

// Event listeners for pagination buttons
prevBtn.addEventListener("click", () => {
    if (currentPage > 1) {
        currentPage--;
        renderCards();
    }
});

nextBtn.addEventListener("click", () => {
    if (currentPage * cardsPerPage < totalCards) {
        currentPage++;
        renderCards();
    }
});

// Event listener for rows per page dropdown
rowsPerPageSelect.addEventListener("change", (event) => {
    cardsPerPage = parseInt(event.target.value, 10);
    currentPage = 1; // Reset to first page
    renderCards();
});

// Function to set the active tab's styling
function setActiveTab(activeTab) {
    filterTabs.forEach((tab) => {
        tab.classList.remove(
            "bg-stone-100",
            "border-b-4",
            "border-primary-500"
        );
    });
    activeTab.classList.add("bg-stone-100", "border-b-4", "border-primary-500");
}

// Function to handle tab clicks
function handleTabClick(event) {
    event.preventDefault();
    const selectedTab = event.currentTarget;
    const status = selectedTab.getAttribute("data-status").trim().toLowerCase();

    currentFilter = status === "semua" ? "all" : status;
    currentPage = 1; // Reset to first page after filtering
    renderCards();

    setActiveTab(selectedTab);
}

// Attach event listeners to all tabs
filterTabs.forEach((tab) => {
    tab.addEventListener("click", handleTabClick);
});

// Initial render on page load
document.addEventListener("DOMContentLoaded", () => {
    renderCards(); // Render all cards initially
});
