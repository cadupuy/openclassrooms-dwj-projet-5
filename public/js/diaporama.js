class Diaporama {
    constructor() {
        // DUREE ENTRE CHAQUE DEFILEMENT
        this.tempsInterval = 4000;
        this.slides = document.querySelectorAll('.slide');
        this.currentSlide = 0;
        this.autoMode();
    }

    slideAfter() {
        this.slides[this.currentSlide].classList.remove('active');

        if (this.currentSlide === (this.slides.length - 1)) {
            this.currentSlide = 0;
        } else {
            this.currentSlide++;
        }

        this.slides[this.currentSlide].classList.add('active');
    };

    autoMode() {
        setInterval(() => {
            this.slideAfter();
        }, this.tempsInterval);
    };
}

let diaporama = new Diaporama();