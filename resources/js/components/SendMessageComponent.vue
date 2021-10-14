<template>
    <form method="post" @submit="sendMsg" class="contact-form">
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
        <div class="contact-form-input contact-form-dropdown">
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
        <div class="contact-form-input">
            <button id="contact-submit">Pošlji</button>
        </div>
        <div class="contact-form-status"></div>
        <div class="contact-form-load">
            <span class="span-dot-1">.</span>
            <span class="span-dot-2">.</span>
            <span class="span-dot-3">.</span>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            ime: "",
            priimek: "",
            email: "",
            tel: "",
            zadeva: "",
            sporocilo: ""
        };
    },
    methods: {
        sendMsg(e) {
            e.preventDefault();

            const contactSubmit = document.querySelector(".contact-form-load");
            contactSubmit.classList.add("show");

            axios
                .post("/", {
                    ime: this.ime,
                    priimek: this.priimek,
                    email: this.email,
                    tel: this.tel,
                    zadeva: this.zadeva,
                    sporocilo: this.sporocilo
                })
                .then(response => {
                    contactSubmit.classList.remove("show");

                    (this.ime = ""),
                        (this.priimek = ""),
                        (this.email = ""),
                        (this.tel = ""),
                        (this.zadeva = ""),
                        (this.sporocilo = "");

                    const contactStatus = document.querySelector(
                        ".contact-form-status"
                    );

                    contactStatus.classList.remove("nonfail");
                    contactStatus.classList.remove("fail");

                    if (response.data[0]) {
                        contactStatus.classList.add("nonfail");
                        contactStatus.innerHTML = "&#10003;";
                    } else {
                        contactStatus.classList.add("fail");
                        contactStatus.innerHTML = "X";
                    }

                    contactStatus.classList.add("show");

                    const time = setTimeout(() => {
                        contactStatus.classList.remove("show");
                        clearTimeout(time);
                    }, 3000);
                })
                .catch(response => {
                    contactStatus.classList.remove("nonfail");
                    contactStatus.classList.remove("fail");

                    contactSubmit.classList.remove("show");
                    const contactStatus = document.querySelector(
                        ".contact-form-status"
                    );
                    contactStatus.classList.add("fail");
                    contactStatus.innerHTML = "X";

                    contactStatus.classList.add("show");

                    const time = setTimeout(() => {
                        contactStatus.classList.remove("show");
                        clearTimeout(time);
                    }, 3000);
                });
        }
    }
};
</script>
