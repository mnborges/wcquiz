import "./bootstrap";

document.addEventListener("DOMContentLoaded", () => {
    var myCarousel = document.getElementById("carouselExampleControls");
    myCarousel.addEventListener("click", (event) => {
        const command = event.target.parentNode.dataset.bsSlide;
        if (command == "next") {
            tgt = event.target.parentNode.dataset.bsTarget;
            console.log(tgt);
        } else if (command == "prev") {
            console.log("SOE");
        }
    });
});
