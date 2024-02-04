console.log(generateStarRating);

export default function generateStarRating(
    inputSelector,
    starsDivSelector,
    spanStarSelector
) {
    console.log(
        `generating star with generateStarRating(${inputSelector}, ${starsDivSelector}, ${spanStarSelector}) from utils.mjs`
    );
    const spanStar = document.querySelector(spanStarSelector);
    for (let i = 0; i < 5; i++) {
        spanStarClone = spanStar.cloneNode(true);
        spanStarClone.setAttribute("data-grade", i + 1);
        spanStarClone.textContent = "★";
        spanStarClone.addEventListener("mouseover", (e) => {
            const starElements = document.querySelectorAll(spanStarSelector);
            starElements.forEach((el) => {
                console.log(e.target.dataset.grade, el.dataset.grade);
                if (el.dataset.grade <= e.target.dataset.grade) {
                    el.classList.add("hovered-star");
                } else {
                    el.classList.remove("hovered-star");
                }
            });
        });
        spanStarClone.addEventListener("click", (e) => {
            document.querySelectorAll(spanStarSelector).forEach((starEl) => {
                starEl.classList.remove("clicked-star");
            });
            e.target.classList.add("clicked-star");
            document
                .querySelector(inputSelector)
                .setAttribute("value", e.target.dataset.grade);
        });
        document.querySelector(starsDivSelector).appendChild(spanStarClone);
    }
}
