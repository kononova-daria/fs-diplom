<template>
    <div class="conf-step-wrapper" v-if="halls.length">
        <p class="conf-step-paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step-selectors-box">
            <li v-for="value in halls">
                <input type="radio" class="conf-step-radio" name="chairs-hall" :value="value.id" v-model="selectedHallId" @change="getSelectedHall()">
                <span class="conf-step-selector">{{ value.name }}</span>
            </li>
        </ul>

        <div v-if="selectedHall">
            <p class="conf-step-paragraph">Установите цены для типов кресел:</p>
            <div class="conf-step-legend">
                <label class="conf-step-label">
                    Цена, рублей
                    <input type="text" class="conf-step-input" v-model="price_standard">
                </label>
                за <span class="conf-step-chair conf-step-chair_standard"></span> обычные кресла
            </div>
            <div class="conf-step-legend">
                <label class="conf-step-label">
                    Цена, рублей
                    <input type="text" class="conf-step-input" v-model="price_vip">
                </label>
                за <span class="conf-step-chair conf-step-chair_vip"></span> VIP кресла
            </div>

            <fieldset class="conf-step-buttons text-center">
                <button class="conf-step-button conf-step-button-regular" @click="closePriceSettings()">Отмена</button>
                <button class="conf-step-button conf-step-button-accent" @click="savePriceSettings()">Сохранить</button>
            </fieldset>
        </div>
    </div>
    <div class="conf-step-wrapper" v-if="!halls.length">
        <p class="conf-step-paragraph">В базе данных нет доступных для настройки залов.</p>
    </div>
</template>

<script>
export default {
    name: "ConfigPriceComponent",
    components: {},
    created() {
        axios.get('/admin/halls').then((response) => {
            this.halls = response?.data || [];
        });
    },
    data() {
        return {
            halls: [],

            selectedHallId: null,
            selectedHall: null,

            price_standard: null,
            price_vip: null,
        }
    },
    methods: {
        getSelectedHall() {
            if (this.selectedHallId) this.getInformation();
        },

        getInformation() {
            axios.get(`admin/hall/${this.selectedHallId}`).then((response) => {
                this.selectedHall = response?.data || null;
                this.price_standard = response?.data?.price_standard || null;
                this.price_vip = response?.data?.price_vip || null;
            });
        },

        closePriceSettings() {
            this.selectedHallId = null;
            this.selectedHall = null;
            this.price_standard = null;
            this.price_vip = null;
        },

        savePriceSettings() {
            axios.put(`admin/hall/${this.selectedHallId}`, {price_standard: this.price_standard, price_vip: this.price_vip}).then(() => {
                this.closePriceSettings();
            });
        },
    }
}
</script>
<style scoped></style>
