<template>
    <form method="post" @submit="submitNewType">
        <label for="type">Nov tip izdelkov:</label>
        <input v-model="name" id="type" type="text" required />
        <input type="submit" value="Dodaj" />
    </form>
</template>

<script>
export default {
    data() {
        return {
            name: ""
        };
    },
    methods: {
        submitNewType(e) {
            e.preventDefault();
            axios
                .post("/admin/type", {
                    name: this.name
                })
                .then(response => {
                    alert(`Nov tip z imenom: ${response.data.name} ustvarjen!`);
                    location.reload();
                });
        }
    }
};
</script>
