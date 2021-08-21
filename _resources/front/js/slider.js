class Slider {
    constructor(selector, activeClass) {
        const slides = document.querySelectorAll(selector)

        let index = 0;

        setInterval(() => {
            slides[index].classList.remove(activeClass)

            index = index < (slides.length - 1) ? index + 1 : 0
            
            slides[index].classList.add(activeClass)
        }, 3000)
    }
}