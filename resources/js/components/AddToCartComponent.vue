<template>
    <a class="add-to-cart" v-on:click="addToCart">
        V voziček
    </a>
</template>

<script>
export default {
    props: ["item-id", "item-img", "item-title", "item-price"],
    methods: {
        addToCart() {
            const self = this._props;
            let cart = JSON.parse(window.localStorage.cart);
            console.log(self.itemImg);

            cart[self.itemId] = {
                img: self.itemImg.replace("/", "/500_"),
                title: self.itemTitle,
                price: self.itemPrice
            };

            window.localStorage.cart = JSON.stringify(cart);
        }
    }
};
</script>
