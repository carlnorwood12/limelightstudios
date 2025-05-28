document.querySelectorAll(".menu-item").forEach(item => {
    item.addEventListener("click", function (event) {
        event.preventDefault();
        this.parentElement.classList.toggle("active");
    });
});