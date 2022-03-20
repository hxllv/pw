/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component(
    "send-message",
    require("./components/SendMessageComponent.vue").default
);
Vue.component(
    "shopping-cart",
    require("./components/ShoppingCartComponent.vue").default
);
Vue.component(
    "add-to-cart",
    require("./components/AddToCartComponent.vue").default
);
Vue.component(
    "avail-items",
    require("./components/AvailableItemsComponent.vue").default
);
Vue.component("item", require("./components/ItemComponent.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});

const navVue = new Vue({
    el: "#nav-vue"
});

if (!window.localStorage.getItem("cart")) {
    window.localStorage.setItem("cart", JSON.stringify({}));
}

/* ==========================
   intersection observers
========================== */

/* navbar + footer observer */

const navbar = document.querySelector("nav");
const logo = document.querySelector(".logo-link");

if (
    "IntersectionObserver" in window &&
    "IntersectionObserverEntry" in window &&
    "intersectionRatio" in window.IntersectionObserverEntry.prototype
) {
    const firstSection = document.querySelector("section:first-of-type");
    const footer = document.querySelector("footer");

    const observerNavFootOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.4
    };

    let navFootObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target == firstSection) {
                    navbar.classList.remove("off-start");
                    logo.classList.remove("off-start");
                    return;
                }

                if (window.innerWidth <= 768)
                    logo.classList.remove("off-start");
                return;
            }

            if (entry.intersectionRatio < 0.4 && entry.target == firstSection) {
                navbar.classList.add("off-start");
                logo.classList.add("off-start");
                return;
            }

            if (entry.intersectionRatio < 0.4 && window.innerWidth <= 768)
                logo.classList.add("off-start");
        });
    }, observerNavFootOptions);

    navFootObserver.observe(footer);
    navFootObserver.observe(firstSection);

    /* section observer */

    const navLinks = {
        onasLink: document.getElementById("onas-link"),
        izdelkiLink: document.getElementById("izdelki-link"),
        kontaktLink: document.getElementById("kontakt-link")
    };

    const sections = {
        onas: document.getElementById("onas-section"),
        izdelki: document.getElementById("izdelki-section"),
        kontakt: document.getElementById("kontakt-section")
    };

    const observerSectionOptions = {
        root: null,
        rootMargin: "-200px 0px -200px 0px"
    };

    let sectionObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            let link = null;

            console.log(entry.target);

            switch (entry.target) {
                case sections.onas:
                    link = navLinks.onasLink;
                    break;
                case sections.izdelki:
                    link = navLinks.izdelkiLink;
                    break;
                case sections.kontakt:
                    link = navLinks.kontaktLink;
                    break;
            }
            if (entry.isIntersecting) {
                link.classList.add("cur");
                return;
            }
            link.classList.remove("cur");
        });
    }, observerSectionOptions);

    for (const section in sections) {
        sectionObserver.observe(sections[section]);
    }
} else {
    navbar.classList.add("off-start");
    logo.classList.add("off-start");
}
