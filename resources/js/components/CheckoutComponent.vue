<template>
    <form method="post" @submit="onSubmit">
        <transition name="fade">
            <div class="checkout-div has-step-controls" v-if="step <= 0">
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
                    <a
                        tabindex="0"
                        v-on:click="removeItemFromCart(id)"
                        v-on:keyup.enter="removeItemFromCart(id)"
                    >
                        X
                    </a>
                </div>
                <div class="form-input form-input-opombe">
                    <label for="opombe">Opombe</label>
                    <textarea
                        v-model="opombe"
                        name="opombe"
                        id="opombe"
                        cols="30"
                        rows="5"
                    ></textarea>
                </div>
                <div class="error-msg" v-if="'items' in itemErr">
                    {{ itemErr }}
                </div>
                <div class="form-input form-step">
                    <a
                        tabindex="0"
                        v-on:click="itemsValidate"
                        v-on:keyup.enter="itemsValidate"
                    >
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
                    <label class="user-data" for="ime">Ime</label>
                    <input v-model="ime" type="text" name="ime" id="ime" />
                    <div class="error-msg" v-if="'ime' in userErr">
                        {{ userErr.ime[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label class="user-data" for="priimek">Priimek</label>
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
                    <label class="user-data" for="email">e-naslov</label>
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
                    <label class="user-data" for="tel">Telefonska št.</label>
                    <input v-model="tel" type="tel" name="tel" id="tel" />
                    <div class="error-msg" v-if="'tel' in userErr">
                        {{ userErr.tel[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label class="user-data" for="naslov">Naslov</label>
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
                    <label class="user-data" for="kraj">Kraj</label>
                    <input v-model="kraj" type="text" name="kraj" id="kraj" />
                    <div class="error-msg" v-if="'kraj' in userErr">
                        {{ userErr.kraj[0] }}
                    </div>
                </div>
                <div class="form-input">
                    <label class="user-data" for="posta">Poštna številka</label>
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
                    <a
                        tabindex="0"
                        v-on:click="decrementStep"
                        v-on:keyup.enter="decrementStep"
                    >
                        Nazaj
                    </a>
                    <a
                        tabindex="0"
                        v-on:click="userDataValidate"
                        v-on:keyup.enter="userDataValidate"
                    >
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
                    <a
                        tabindex="0"
                        v-on:click="decrementStep"
                        v-on:keyup.enter="decrementStep"
                    >
                        Nazaj
                    </a>
                    <a
                        tabindex="0"
                        v-on:click="incrementStep"
                        v-on:keyup.enter="incrementStep"
                    >
                        Pregled
                    </a>
                </div>
            </div>
        </transition>
        <transition name="fade">
            <div class="checkout-div has-step-controls" v-if="step === 3">
                <h3>Pregled naročila</h3>
                <div
                    class="cart-item"
                    v-for="(item, id) in cartItemsFinal"
                    :key="id"
                >
                    <img :src="`/storage/${item.main_image}`" />
                    <span class="cart-item-text">
                        {{ item.title }}
                    </span>
                    <span class="cart-item-text">
                        {{ item.price }} &euro;
                    </span>
                </div>
                <div style="text-align: center; font-size: 1.6rem">
                    Skupaj: {{ price }} &euro;
                </div>
                <div class="overview-data">
                    <div class="overview-data-row">
                        <span>Ime:</span>
                        <span>{{ userDataFinal.ime }}</span>
                    </div>
                    <div class="overview-data-row">
                        <span>Priimek:</span>
                        <span>{{ userDataFinal.priimek }}</span>
                    </div>
                    <div class="overview-data-row">
                        <span>e-naslov:</span>
                        <span>{{ userDataFinal.email }}</span>
                    </div>
                    <div class="overview-data-row">
                        <span>Telefonska št.:</span>
                        <span>{{ userDataFinal.tel }}</span>
                    </div>

                    <div class="overview-data-row">
                        <span>Naslov:</span
                        ><span>{{ userDataFinal.naslov }}</span>
                    </div>
                    <div class="overview-data-row">
                        <span>Kraj:</span>
                        <span>{{ userDataFinal.kraj }}</span>
                    </div>
                    <div class="overview-data-row">
                        <span>Poštna št.:</span>
                        <span>{{ userDataFinal.posta }}</span>
                    </div>
                    <div class="overview-data-row">
                        <span>Opombe:</span>
                        <span>{{ opombe || "/" }}</span>
                    </div>
                </div>
                <div class="form-input form-has-recaptcha">
                    <div class="form-recaptcha">
                        <vue-recaptcha
                            :load-recaptcha-script="true"
                            ref="recaptcha"
                            @verify="onCaptchaVerified"
                            @expired="onCaptchaExpired"
                            sitekey="6LfYy7IcAAAAADHJIeDTvhU1XPnhR0LIclRJ5F2t"
                        ></vue-recaptcha>
                    </div>
                </div>
                <div class="form-input form-step">
                    <a
                        tabindex="0"
                        v-on:click="decrementStep"
                        v-on:keyup.enter="decrementStep"
                    >
                        Nazaj
                    </a>
                    <input ref="formSubmit" type="submit" value="Naroči" />
                </div>
                <div class="load-overlay" v-if="loading">
                    <span class="span-dot-1">.</span>
                    <span class="span-dot-2">.</span>
                    <span class="span-dot-3">.</span>
                </div>
            </div>
        </transition>
        <transition name="fade">
            <div class="checkout-div checkout-final" v-if="step === 4">
                <h2>Naročilo je bilo uspešno!</h2>
                <h3>Hvala za nakup!</h3>
                <p>
                    Podatki o naročilo so bili poslani na vaš e-naslov ({{
                        email
                    }}).
                </p>
                <div class="form-input">
                    <a tabindex="0" href="/">Nazaj na glavno stran</a>
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
            step: 0,
            captchaToken: null,
            userErr: {},
            userDataFinal: {},
            ime: "",
            priimek: "",
            email: "",
            tel: "",
            naslov: "",
            kraj: "",
            posta: "",
            loading: false,
            itemErr: {},
            cartItems: JSON.parse(localStorage.cart || "{}"),
            opombe: "",
            cartItemsFinal: {},
            price: 0
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
        itemsValidate() {
            this.loading = true;
            axios
                .post("/checkout/items", {
                    items: JSON.stringify(this.cartItems),
                    opombe: this.opombe
                })
                .then(response => {
                    this.loading = false;
                    this.itemErr = {};
                    if ("error" in response.data)
                        return (this.itemErr = response.data.error);
                    this.cartItemsFinal = response.data.items;
                    this.price = response.data.price;
                    this.incrementStep();
                })
                .catch(e => {
                    this.loading = false;
                    console.log(e);
                });
        },
        userDataValidate() {
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
                    if ("error" in response.data)
                        return (this.userErr = response.data.error);
                    this.userDataFinal = response.data.data;
                    this.incrementStep();
                })
                .catch(e => {
                    this.loading = false;
                    console.log(e);
                });
        },
        onCaptchaVerified(token) {
            this.captchaToken = token;
            this.$refs.formSubmit.disabled = false;
        },
        onCaptchaExpired() {
            this.$refs.recaptcha.reset();
        },
        onSubmit(e) {
            e.preventDefault();
            this.loading = true;
            axios
                .post("/checkout/captcha", {
                    token: this.captchaToken
                })
                .then(response => {
                    this.loading = false;
                    this.$refs.recaptcha.reset();
                    if (response.data.success) {
                        this.incrementStep();
                    }
                })
                .catch(e => {
                    this.loading = false;
                    console.log(e);
                });
        },
        removeItemFromCart(id) {
            let cart = JSON.parse(localStorage.cart);
            if (!cart) return;

            delete cart[id];
            localStorage.cart = JSON.stringify(cart);
            this.cartItems = cart;
        }
    },
    watch: {
        step: function() {
            if (this.$refs.recaptcha) this.$refs.recaptcha.reset();
            if (this.step === 4) localStorage.cart = "{}";
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
