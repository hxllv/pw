<template>
    <form method="post" @submit="submitEditAvail">
        <label for="avail-select"
            >Nastavi razpoložljivost (trenutno:
            {{ avail == 1 ? "na voljo" : "ni na voljo" }})</label
        >
        <br />
        <select v-model="selected" id="avail-select" name="avail">
            <option value="1">Na voljo</option>
            <option value="0">Ni na voljo</option>
        </select>
        <input type="submit" value="Nastavi" />
    </form>
</template>

<script>
export default {
    data() {
        return {
            selected: ""
        };
    },
    props: ["avail", "id"],
    methods: {
        submitEditAvail(e) {
            e.preventDefault();
            axios
                .patch(`/admin/item/${this.id}`, {
                    available: this.selected
                })
                .then(response => {
                    alert(
                        `Razpoložljivost spremenjena na ${
                            response.data == 1 ? "na voljo" : "ni na voljo"
                        }!`
                    );
                    location.reload();
                });
        }
    }
};
</script>
