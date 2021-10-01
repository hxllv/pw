<template>
    <div class="cart-div" tabindex="0">
        <a class="btn-nav shopping-cart" v-on:click="openCart">
            <i class="fas fa-shopping-cart"></i>
        </a>
        <div class="cart-items">
            <div class="empty-cart" v-if="!Object.keys(this.cartItems).length">
                Voziček je prazen!
            </div>
            <div class="cart-item" v-for="(item, id) in cartItems" :key="id">
                <img :src="`/storage/${item.img}`" />

                <span>
                    {{ item.title }}
                </span>
                <span> </span>
                <a v-on:click="removeItemFromCart(id)">
                    X
                </a>
            </div>
            <a
                class="cart-checkout"
                href=""
                v-if="Object.keys(this.cartItems).length"
            >
                Checkout
            </a>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cartItems: JSON.parse(window.localStorage.getItem("cart"))
        };
    },
    methods: {
        openCart() {
            this.cartItems = JSON.parse(window.localStorage.getItem("cart"));
        },
        removeItemFromCart(id) {
            let cart = JSON.parse(window.localStorage.getItem("cart"));
            delete cart[id];
            window.localStorage.setItem("cart", JSON.stringify(cart));
            this.cartItems = cart;
        }
    }
};
</script>
