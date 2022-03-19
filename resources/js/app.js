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
        rootMargin: "0px 0px 0px 0px",
        threshold: 0.3
    };

    let sectionObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            let link = null;

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

/* =============
  item styling
============= */

const items = document.querySelectorAll(".item");
let onItem = false;

window.itemMouseEnter = function(item, imgs) {
    if (onItem) return;

    item.classList.add("on");
    onItem = true;

    items.forEach(notItem => {
        if (item == notItem) return;

        const notItemImg = notItem.querySelector(".item-img");
        notItemImg.classList.add("cleary");
    });

    const itemImg = item.querySelector(".item-img");

    const time = setTimeout(() => {
        itemImg.style.zIndex = 999;
        clearTimeout(time);
    }, 100);

    const detailsPictures = item.querySelectorAll(".details > picture");

    const time1 = setTimeout(() => {
        for (let i = 0; i < imgs.length; i++) {
            const { image } = imgs[i];
            const detailsPictureElements = detailsPictures[i].querySelectorAll(
                "*"
            );

            if (detailsPictureElements[0].srcset) {
                detailsPictureElements[2].style.maxWidth = "100%";
                continue;
            }

            const image500 = image.replace("/", "/500_");
            const image1000 = image.replace("/", "/1000_");

            detailsPictureElements[0].srcset = `/storage/${image}`;
            detailsPictureElements[1].srcset = `/storage/${image1000}`;
            detailsPictureElements[2].src = `/storage/${image500}`;
            detailsPictureElements[2].style.maxWidth = "100%";
        }
        clearTimeout(time1);
    }, 400);
};

window.itemMouseLeave = function(item) {
    if (!item.classList.contains("on")) return;

    item.classList.remove("on");
    onItem = false;

    const itemImg = item.querySelector(".item-img");
    const detailsPictures = item.querySelectorAll(".details > picture > img");
    detailsPictures.forEach(detailPic => {
        detailPic.style.maxWidth = 0;
    });

    itemImg.style.zIndex = 997;
    const time = setTimeout(() => {
        itemImg.style.zIndex = 1;
        clearTimeout(time);
    }, 100);

    items.forEach(item => {
        const itemImg = item.querySelector(".item-img");
        itemImg.classList.remove("cleary");
    });
};
