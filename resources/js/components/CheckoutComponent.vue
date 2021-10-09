<template>
    <div class="checkout-div">
        <form method="post" @submit="onSubmit">
            <div class="form-group" v-if="step <= 0">
                <vue-recaptcha
                    :load-recaptcha-script="true"
                    ref="recaptcha"
                    @verify="onCaptchaVerified"
                    @expired="onCaptchaExpired"
                    sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
                ></vue-recaptcha>
            </div>
            <div class="form-group" v-if="step === 1">
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
                    <a v-on:click="step = 0">
                        Nazaj
                    </a>
                    <a v-on:click="step = 2">
                        Naprej
                    </a>
                </div>
            </div>
            <div class="form-group" v-if="step === 2">
                <h3>Način dostave</h3>
                <div class="form-input">
                    <input type="radio" name="dostava" id="dostava" disabled checked/>
                    <label for="dostava">Pošta Slovenija</label>
                </div>
                <h3>Način plačila</h3>
                 <div class="form-input">
                    <input type="radio" name="placilo" id="placilo" disabled checked/>
                    <label for="placilo">Plačilo po povzetju</label>

                </div>
                <div class="form-input form-step">
                    <a v-on:click="step = 1">
                        Nazaj
                    </a>
                </div>
            </div>
        </form>
    </div>
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
        onCaptchaVerified(token) {
            this.captchaToken = token;
            const time = setTimeout(() => {
                this.$refs.recaptcha.reset();
                this.step = 1;
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
