/**
 * Open and close action menu
 */
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("popover-toggle")) {
        const button = e.target;
        const popover = button.nextElementSibling;
        popover.classList.toggle("hidden");
    }
});

document.addEventListener("click", (e) => {
    const popovers = document.querySelectorAll(".popover");
    popovers.forEach((popover) => {
        if (
            !popover.contains(e.target) &&
            !popover.previousElementSibling.contains(e.target)
        ) {
            popover.classList.add("hidden");
        }
    });
});
