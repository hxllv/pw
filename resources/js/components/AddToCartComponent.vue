<template>
    <a v-on:click="addToCart">
        Add to cart
    </a>
</template>

<script>
export default {
    props: ["item-id", "item-img", "item-title", "item-price"],
    methods: {
        addToCart() {
            const self = this._props;
            let cart = JSON.parse(window.localStorage.getItem("cart"));
            console.log(self.itemImg);

            cart[self.itemId] = {
                img: self.itemImg,
                title: self.itemTitle,
                price: self.itemPrice
            };

            window.localStorage.setItem("cart", JSON.stringify(cart));
        }
    }
};
</script>
