<template>
    <div class="cart-div" tabindex="0" @focus="openCart" ref="cartDiv">
        <a class="btn-nav shopping-cart">
            <i class="fas fa-shopping-cart"></i>
            <div class="shopping-cart-count" v-if="cartItemCount">
                <span>
                    {{ cartItemCount }}
                </span>
            </div>
        </a>
        <div class="cart-items">
            <div class="empty-cart" v-if="!Object.keys(cartItems).length">
                Voziček je prazen!
            </div>
            <div class="cart-item" v-for="(item, id) in cartItems" :key="id">
                <img :src="`/storage/${item.img}`" />
                <span class="cart-item-title">
                    {{ item.title }}
                </span>
                <a
                    tabindex="0"
                    v-on:click="removeItemFromCart(id)"
                    v-on:keyup.enter="removeItemFromCart(id)"
                >
                    X
                </a>
            </div>
            <a
                class="cart-checkout"
                href="/checkout"
                v-if="Object.keys(cartItems).length"
            >
                Checkout
            </a>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        const ls = JSON.parse(localStorage.cart || "{}");
        return {
            cartItems: ls,
            cartItemCount: Object.keys(ls).length
        };
    },
    created() {
        setInterval(() => {
            this.cartItems = JSON.parse(localStorage.cart || "{}");
        }, 75);
    },
    methods: {
        openCart() {
            this.cartItems = JSON.parse(localStorage.cart || "{}");
        },
        removeItemFromCart(id) {
            this.$refs.cartDiv.focus();
            let cart = JSON.parse(localStorage.cart);
            delete cart[id];
            localStorage.cart = JSON.stringify(cart);
            this.cartItems = cart;
        }
    },
    watch: {
        cartItems: function(val) {
            this.cartItemCount = Object.keys(val).length;
        }
    }
};
</script>
