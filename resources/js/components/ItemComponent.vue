<template>
    <div>
        <div
            class="item-img cleary-prep"
            :class="{ cleary: onItem != item.id && onItem }"
            :style="{ zIndex: curZIndex }"
            ref="itemImg"
        >
            <picture>
                <source
                    media="(min-width:2100px)"
                    :srcset="`/storage/${item.main_image}`"
                />
                <source
                    media="(min-width:1200px)"
                    :srcset="
                        `/storage/${item.main_image.replace('/', '/1000_')}`
                    "
                />
                <img
                    loading="lazy"
                    :src="`/storage/${item.main_image.replace('/', '/500_')}`"
                    :alt="item.title"
                />
            </picture>
            <add-to-cart-component
                v-if="avail"
                :item-id="item.id"
                :item-img="item.main_image"
                :item-title="item.title"
                :item-price="item.price"
            />
        </div>
        <div class="details">
            <h1>
                {{ item.title }} |
                {{
                    Math.floor(item.price) == item.price
                        ? String(item.price).replace(".00", ".- ")
                        : item.price
                }}
                <span class="euro">
                    &euro;
                </span>
            </h1>
            <p>{{ item.description }}</p>
            <picture v-for="img in imgs" :key="img.id">
                <source
                    media="(min-width:2100px)"
                    :srcset="`/storage/${img.image}`"
                />
                <source
                    media="(min-width:1200px)"
                    :srcset="`/storage/${img.image.replace('/', '/1000_')}`"
                />
                <img
                    :style="{ maxWidth: `${maxWidth}%` }"
                    :src="`/storage/${img.image.replace('/', '/500_')}`"
                    :alt="`${item.title} extra`"
                />
            </picture>
        </div>
    </div>
</template>

<script>
import AddToCartComponent from "./AddToCartComponent.vue";
export default {
    data() {
        return {
            hasBeenHovered: false,
            imgs: [],
            curZIndex: 1,
            maxWidth: 0
        };
    },
    props: ["item", "avail", "onItem"],
    methods: {},
    watch: {
        onItem(newVal, oldVal) {
            if (
                (newVal != this.item.id || newVal === null) &&
                oldVal === this.item.id
            ) {
                this.curZIndex = 997;
                const time = setTimeout(() => {
                    this.curZIndex = 1;
                    clearTimeout(time);
                }, 100);

                this.maxWidth = 0;

                return;
            }

            if (newVal != this.item.id || newVal === null) return;

            const time = setTimeout(() => {
                this.curZIndex = 999;
                clearTimeout(time);
            }, 100);

            axios.get(`/getimages/${this.item.id}`).then(response => {
                this.imgs = response.data;
                this.maxWidth = 100;
            });
        }
    },
    components: { AddToCartComponent }
};
</script>
