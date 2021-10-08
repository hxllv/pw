<template>
    <div>
        <form method="post" @submit="onSubmit">
            <div class="form-group" v-if="step === 0">
                <vue-recaptcha
                    ref="recaptcha"
                    @verify="onCaptchaVerified"
                    @expired="onCaptchaExpired"
                    sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
                ></vue-recaptcha>
            </div>
            <div class="form-group" v-if="step === 1">
                <div>
                    f1
                </div>
                <a v-on:click="step = 2">
                    Naprej
                </a>
            </div>
            <div class="form-group" v-if="step === 2">
                <div>
                    f2
                </div>
                <a v-on:click="step = 1">
                    Nazaj
                </a>
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
            captchaToken: null
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
