<template>
    <div>
        <div class="items-subsection">
            <h3 class="text-center" v-if="!anyAvailItems">
                Žal trenutno ni nobenih izdelkov!
            </h3>
            <div class="type" v-for="fullObj in fullArr" :key="fullObj.type.id">
                <h1 class="subtitle divider pirata">{{ fullObj.type.name }}</h1>
                <p class="description">{{ fullObj.type.description }}</p>
                <div class="items">
                    <div
                        class="item"
                        :class="{ on: onItem === item.id }"
                        tabindex="0"
                        v-for="item in fullObj.items"
                        :key="item.id"
                        :ref="item.id"
                        @mouseenter="itemMouseEnter(item.id)"
                        @mouseleave="itemMouseLeave"
                        @focus="itemMouseEnter(item.id)"
                        @blur="itemMouseLeave"
                    >
                        <item-component
                            :item="item"
                            :avail="true"
                            :onItem="onItem"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="items-subsection">
            <h1 class="subtitle divider pirata">
                Izdelki, ki niso več na voljo
            </h1>
            <div>
                <div class="items">
                    <div
                        class="item"
                        :class="{ on: onItem === item.id }"
                        tabindex="0"
                        v-for="item in notAvailArr"
                        :key="item.id"
                        :ref="item.id"
                        @mouseenter="itemMouseEnter(item.id)"
                        @mouseleave="itemMouseLeave"
                        @focus="itemMouseEnter(item.id)"
                        @blur="itemMouseLeave"
                    >
                        <item-component
                            :item="item"
                            :avail="false"
                            :onItem="onItem"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ItemComponent from "./ItemComponent.vue";
export default {
    created() {
        let tempTypes = JSON.parse(this.types);
        let tempItems = JSON.parse(this.items);

        console.log(tempItems);

        tempTypes.forEach(type => {
            let tempArr = tempItems.filter(
                item => item.type_id == type.id && item.available == 1
            );

            console.log(tempArr);

            this.fullArr[`type_${type.id}`] = {
                type: type,
                items: tempArr
            };
        });

        this.notAvailArr = tempItems.filter(item => item.available == 0);

        console.log(this.notAvailArr);
        console.log(this.fullArr);
    },
    data() {
        return {
            fullArr: {},
            notAvailArr: {},
            onItem: null
        };
    },
    props: ["types", "items"],
    methods: {
        anyAvailItems() {
            return JSON.parse(this.items).some(item => {
                return item.available === 1;
            });
        },
        itemMouseEnter(item) {
            if (this.onItem) return;

            this.onItem = item;
        },
        itemMouseLeave() {
            this.onItem = null;
        }
    },
    components: { ItemComponent }
};
</script>
