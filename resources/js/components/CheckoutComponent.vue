<template>
    <form method="post" @submit="onSubmit">
        <transition name="fade">
            <div class="checkout-div" v-if="step <= 0">
                <vue-recaptcha
                    :load-recaptcha-script="true"
                    ref="recaptcha"
                    @verify="onCaptchaVerified"
                    @expired="onCaptchaExpired"
                    sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
                ></vue-recaptcha>
            </div>
        </transition>
        <transition name="fade">
            <div class="checkout-div has-step-controls" v-if="step === 1">
                <h3>Osebni podatki</h3>
                <div class="form-input">
                    <label for="ime">Ime</label>
                    <input type="text" name="ime" id="ime" />
                </div>
                <div class="form-input">
                    <label for="priimek">Priimek</label>
                    <input type="text" name="priimek" id="priimek" />
                </div>
                <div class="form-input">
                    <label for="email">e-naslov</label>
                    <input type="email" name="email" id="email" />
                </div>
                <div class="form-input">
                    <label for="tel">Telefonska št.</label>
                    <input type="tel" name="tel" id="tel" />
                </div>
                <div class="form-input">
                    <label for="Naslov">Naslov</label>
                    <input type="text" name="Naslov" id="Naslov" />
                </div>
                <div class="form-input">
                    <label for="kraj">Kraj</label>
                    <input type="text" name="kraj" id="kraj" />
                </div>
                <div class="form-input">
                    <label for="posta">Poštna številka</label>
                    <input type="text" name="posta" id="posta" />
                </div>
                <div class="form-input form-step">
                    <a v-on:click="decrementStep">
                        Nazaj
                    </a>
                    <a v-on:click="incrementStep">
                        Naprej
                    </a>
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
            gcaptchaLoaded: false
        };
    },
    methods: {
        incrementStep() {
            this.step += 0.5;
            const time = setTimeout(() => {
                this.step += 0.5;
            }, 500);
        },
        decrementStep() {
            this.step -= 0.5;
            const time = setTimeout(() => {
                this.step -= 0.5;
                clearTimeout(time);
            }, 500);
        },
        onCaptchaVerified(token) {
            this.captchaToken = token;
            const time = setTimeout(() => {
                this.$refs.recaptcha.reset();
                this.incrementStep();
                clearTimeout(time);
            }, 1000);
        },
        onCaptchaExpired() {
            this.$refs.recaptcha.reset();
        },
        onSubmit() {}
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
