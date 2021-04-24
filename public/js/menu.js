class Menu {
    constructor(nav, navToggle) {
        this.nav = nav;
        this.navToggle = navToggle;
        this.init();
    }


    init() {
        this.navToggle.addEventListener('click', () => {
            this.toggle();
        });
    }

    // Si la classe est présente, la supprime, sinon l'ajoute
    toggle() {
        this.navToggle.classList.toggle('expanded');
        this.nav.classList.toggle('expanded');
    }
}

let menu1 = new Menu(document.querySelector('#nav'), document.querySelector('.nav-toggle'));