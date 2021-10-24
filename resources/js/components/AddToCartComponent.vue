<template>
    <a
        tabindex="0"
        class="add-to-cart"
        v-on:click="addToCart"
        v-on:keyup.enter="addToCart"
    >
        V voziček
    </a>
</template>

<script>
export default {
    props: ["item-id", "item-img", "item-title", "item-price"],
    methods: {
        addToCart() {
            const self = this._props;
            let cart = JSON.parse(localStorage.cart || "{}");

            cart[self.itemId] = {
                img: self.itemImg.replace("/", "/500_"),
                title: self.itemTitle,
                price: self.itemPrice
            };

            localStorage.cart = JSON.stringify(cart);
        }
    }
};
</script>
