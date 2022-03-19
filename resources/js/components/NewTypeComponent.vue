<template>
    <form method="post" @submit="submitNewType">
        <label for="type">Nov tip izdelkov:</label>
        <input
            placeholder="Ime"
            v-model="name"
            id="type"
            type="text"
            required
        />
        <input
            placeholder="Opis"
            v-model="description"
            id="type-desc"
            type="text"
            required
        />
        <input type="submit" value="Dodaj" />
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            description: ""
        };
    },
    methods: {
        submitNewType(e) {
            e.preventDefault();
            axios
                .post("/admin/type", {
                    name: this.name,
                    description: this.description
                })
                .then(response => {
                    alert(`Nov tip z imenom: ${response.data.name} ustvarjen!`);
                    location.reload();
                });
        }
    }
};
</script>
