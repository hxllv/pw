<template>
    <form method="post" @submit="onSubmit">
        <transition name="fade">
            <div class="checkout-div" v-if="step <= 0">
                <div
                    class="cart-item"
                    v-for="(item, id) in cartItems"
                    :key="id"
                >
                    <img :src="`/storage/${item.img}`" />
                    <span class="cart-item-text">
                        {{ item.title }}
                    </span>
                    <span class="cart-item-text">
                        {{ item.price }} &euro;
                    </span>
                    <a v-on:click="removeItemFromCart(id)">
                        X
                    </a>
                </div>
                <div class="error-msg" v-if="'items' in itemErr">
                    {{ itemErr.items }}
                </div>
                <div class="form-input form-step">
                    <a v-on:click="itemsFwd">
                        Naprej
                    </a>
                </div>
                <div class="load-overlay" v-if="loading">
                    <span class="span-dot-1">.</span>
                    <span class="span-dot-2">.</span>
                    <span class="span-dot-3">.</span>
                </div>
            </div>
        </transition>
        <transition name="fade">
            <div class="checkout-div has-step-controls" v-if="step === 1">
                <h3>Osebni podatki</h3>
                <div class="form-input">
                    <label for="ime">Ime</label>
                    <input v-model="ime" type="text" name="ime" id="ime" />
                    <div class="error-msg" v-if="'ime' in userErr">
                        {{ userErr.ime[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label for="priimek">Priimek</label>
                    <input
                        v-model="priimek"
                        type="text"
                        name="priimek"
                        id="priimek"
                    />
                    <div class="error-msg" v-if="'priimek' in userErr">
                        {{ userErr.priimek[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label for="email">e-naslov</label>
                    <input
                        v-model="email"
                        type="email"
                        name="email"
                        id="email"
                    />
                    <div class="error-msg" v-if="'email' in userErr">
                        {{ userErr.email[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label for="tel">Telefonska št.</label>
                    <input v-model="tel" type="tel" name="tel" id="tel" />
                    <div class="error-msg" v-if="'tel' in userErr">
                        {{ userErr.tel[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label for="naslov">Naslov</label>
                    <input
                        v-model="naslov"
                        type="text"
                        name="naslov"
                        id="naslov"
                    />
                    <div class="error-msg" v-if="'naslov' in userErr">
                        {{ userErr.naslov[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label for="kraj">Kraj</label>
                    <input v-model="kraj" type="text" name="kraj" id="kraj" />
                    <div class="error-msg" v-if="'kraj' in userErr">
                        {{ userErr.kraj[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label for="posta">Poštna številka</label>
                    <input
                        v-model="posta"
                        type="text"
                        name="posta"
                        id="posta"
                    />
                    <div class="error-msg" v-if="'posta' in userErr">
                        {{ userErr.posta[0] }}
                    </div>
                </div>
                <div class="form-input form-step">
                    <a v-on:click="decrementStep">
                        Nazaj
                    </a>
                    <a v-on:click="userDataFwd">
                        Naprej
                    </a>
                </div>
                <div class="load-overlay" v-if="loading">
                    <span class="span-dot-1">.</span>
                    <span class="span-dot-2">.</span>
                    <span class="span-dot-3">.</span>
                </div>
            </div>
        </transition>
        <transition name="fade">
            <div class="checkout-div has-step-controls" v-if="step === 2">
                <h3>Način dostave</h3>
                <div class="form-input">
                    <input
                        type="radio"
                        name="dostava"
                        id="dostava"
                        disabled
                        checked
                    />
                    <label for="dostava">Pošta Slovenija</label>
                </div>
                <h3>Način plačila</h3>
                <div class="form-input">
                    <input
                        type="radio"
                        name="placilo"
                        id="placilo"
                        disabled
                        checked
                    />
                    <label for="placilo">Plačilo po povzetju</label>
                </div>
                <div class="form-input form-step">
                    <a v-on:click="decrementStep">
                        Nazaj
                    </a>
                    <a v-on:click="incrementStep">
                        Pregled
                    </a>
                </div>
            </div>
        </transition>
        <transition name="fade">
            <div class="checkout-div has-step-controls" v-if="step === 3">
                <h3>Pregled naročila</h3>
                <div class="form-input form-has-recaptcha">
                    <div class="form-recaptcha">
                        <vue-recaptcha
                            :load-recaptcha-script="true"
                            ref="recaptcha"
                            @verify="onCaptchaVerified"
                            @expired="onCaptchaExpired"
                            sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
                        ></vue-recaptcha>
                    </div>
                </div>
                <div class="form-input form-step">
                    <a v-on:click="decrementStep">
                        Nazaj
                    </a>
                    <input type="submit" value="Naroči" />
                </div>
            </div>
        </transition>
    </form>
</template>

<script>
import VueRecaptcha from "vue-recaptcha";
export default {
    data() {
        return {
            step: 3,
            captchaToken: null,
            userErr: {},
            ime: "",
            priimek: "",
            email: "",
            tel: "",
            naslov: "",
            kraj: "",
            posta: "",
            loading: false,
            itemErr: {},
            cartItems: JSON.parse(localStorage.cart)
        };
    },
    methods: {
        incrementStep() {
            this.step += 0.5;
            const time = setTimeout(() => {
                this.step += 0.5;
                clearTimeout(time);
            }, 500);
        },
        decrementStep() {
            this.step -= 0.5;
            const time = setTimeout(() => {
                this.step -= 0.5;
                clearTimeout(time);
            }, 500);
        },
        itemsFwd() {
            this.loading = true;
            axios
                .post("/checkout/items", {
                    items: JSON.stringify(this.cartItems)
                })
                .then(response => {
                    this.loading = false;
                    this.itemErr = {};
                    if (response.data && "error" in response.data)
                        return (this.itemErr = response.data.error);
                    this.incrementStep();
                })
                .catch(e => {
                    this.loading = false;
                    console.log(e);
                });
        },
        userDataFwd() {
            this.loading = true;
            axios
                .post("/checkout/userdata", {
                    ime: this.ime,
                    priimek: this.priimek,
                    email: this.email,
                    tel: this.tel,
                    naslov: this.naslov,
                    kraj: this.kraj,
                    posta: this.posta
                })
                .then(response => {
                    this.loading = false;
                    this.userErr = {};
                    if (response.data && "error" in response.data)
                        return (this.userErr = response.data.error);
                    this.incrementStep();
                })
                .catch(e => {
                    this.loading = false;
                    console.log(e);
                });
        },
        onCaptchaVerified(token) {
            const time = setTimeout(() => {
                this.captchaToken = token;
                clearTimeout(time);
            }, 1000);
        },
        onCaptchaExpired() {
            this.$refs.recaptcha.reset();
        },
        onSubmit(e) {
            e.preventDefault();
            this.$refs.recaptcha.reset();
            axios
                .post("/checkout/captcha", {
                    token: this.captchaToken
                })
                .then(response => {
                    console.log(response.data);
                });
        },
        removeItemFromCart(id) {
            let cart = JSON.parse(window.localStorage.cart);
            delete cart[id];
            window.localStorage.cart = JSON.stringify(cart);
            this.cartItems = cart;
        }
    },
    watch: {
        step: function() {
            if (this.$refs.recaptcha) this.$refs.recaptcha.reset();
        }
    },
    components: { VueRecaptcha }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}
.fade-enter,
.fade-leave-to,
.fade-leave-active {
    opacity: 0;
}
</style>
