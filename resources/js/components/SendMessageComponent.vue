<template>
    <form method="post" @submit="onSubmit" class="contact-form">
        <div class="contact-form-input inline">
            <div class="inline-group">
                <label for="ime">Ime*:</label>
                <input v-model="ime" type="text" name="ime" id="ime" />
            </div>

            <div class="inline-group">
                <label for="priimek">Priimek*:</label>
                <input
                    v-model="priimek"
                    type="text"
                    name="priimek"
                    id="priimek"
                />
            </div>
        </div>
        <div class="contact-form-input">
            <label for="email">Elektronska pošta*:</label>
            <input v-model="email" type="email" name="email" id="email" />
        </div>
        <div class="contact-form-input">
            <label for="tel">Telefonska številka*:</label>
            <input v-model="tel" type="tel" name="tel" id="tel" />
        </div>
        <div class="contact-form-input">
            <label for="zadeva">Zadeva*:</label>
            <input v-model="zadeva" type="text" name="zadeva" id="zadeva" />
        </div>
        <div class="contact-form-input">
            <label for="sporocilo">Sporočilo*:</label>
            <textarea
                v-model="sporocilo"
                name="sporocilo"
                id="sporocilo"
                cols="30"
                rows="10"
            ></textarea>
        </div>
        <div class="contact-form-input contact-form-has-recaptcha">
            <div class="contact-form-recaptcha">
                <vue-recaptcha
                    :load-recaptcha-script="true"
                    ref="recaptcha"
                    @verify="onCaptchaVerified"
                    @expired="onCaptchaExpired"
                    sitekey="6LfYy7IcAAAAADHJIeDTvhU1XPnhR0LIclRJ5F2t"
                ></vue-recaptcha>
            </div>
        </div>
        <div class="contact-form-input">
            <button id="contact-submit" ref="formSubmit" disabled>
                Pošlji
            </button>
        </div>
        <div class="contact-form-status" ref="status"></div>
        <div class="contact-form-load" ref="load">
            <span class="span-dot-1">.</span>
            <span class="span-dot-2">.</span>
            <span class="span-dot-3">.</span>
        </div>
    </form>
</template>

<script>
import VueRecaptcha from "vue-recaptcha";
export default {
    data() {
        return {
            ime: "",
            priimek: "",
            email: "",
            tel: "",
            zadeva: "",
            sporocilo: "",
            captchaToken: null
        };
    },
    methods: {
        onCaptchaVerified(token) {
            this.captchaToken = token;
            this.$refs.formSubmit.disabled = false;
        },
        onCaptchaExpired() {
            this.$refs.recaptcha.reset();
            this.$refs.formSubmit.disabled = true;
        },
        onSubmit(e) {
            e.preventDefault();

            const contactLoad = this.$refs.load;
            const contactStatus = this.$refs.status;
            contactLoad.classList.add("show");

            axios
                .post("/", {
                    ime: this.ime,
                    priimek: this.priimek,
                    email: this.email,
                    tel: this.tel,
                    zadeva: this.zadeva,
                    sporocilo: this.sporocilo,
                    token: this.captchaToken
                })
                .then(response => {
                    contactLoad.classList.remove("show");

                    (this.ime = ""),
                        (this.priimek = ""),
                        (this.email = ""),
                        (this.tel = ""),
                        (this.zadeva = ""),
                        (this.sporocilo = "");

                    contactStatus.classList.remove("nonfail");
                    contactStatus.classList.remove("fail");

                    if (response.data.success) {
                        contactStatus.classList.add("nonfail");
                        contactStatus.innerHTML = "&#10003;";
                    } else {
                        contactStatus.classList.add("fail");
                        contactStatus.innerHTML = "X";
                    }

                    this.$refs.recaptcha.reset();
                    this.$refs.formSubmit.disabled = true;
                    contactStatus.classList.add("show");

                    const time = setTimeout(() => {
                        contactStatus.classList.remove("show");
                        clearTimeout(time);
                    }, 3000);
                })
                .catch(response => {
                    contactStatus.classList.remove("nonfail");
                    contactStatus.classList.remove("fail");

                    contactLoad.classList.remove("show");
                    contactStatus.classList.add("fail");
                    contactStatus.innerHTML = "X";

                    contactStatus.classList.add("show");

                    const time = setTimeout(() => {
                        contactStatus.classList.remove("show");
                        clearTimeout(time);
                    }, 3000);
                });
        }
    },
    components: { VueRecaptcha }
};
</script>
