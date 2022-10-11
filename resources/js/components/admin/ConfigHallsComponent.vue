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
            <p class="conf-step-paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
            <div class="conf-step-legend">
                <label class="conf-step-label">
                    Рядов, шт
                    <input type="text" class="conf-step-input" v-model="rows" @input="addRows($event)">
                </label>
                <span class="multiplier">x</span>
                <label class="conf-step-label">
                    Мест, шт
                    <input type="text" class="conf-step-input" v-model="nums" @input="addNums($event)">
                </label>
            </div>

            <p class="conf-step-paragraph">Теперь Вы можете указать типы кресел на схеме зала:</p>
            <div class="conf-step-legend">
                <span class="conf-step-chair conf-step-chair_standard"></span> — обычные кресла
                <span class="conf-step-chair conf-step-chair_vip"></span> — VIP кресла
                <span class="conf-step-chair conf-step-chair_blocked"></span> — заблокированные (нет кресла)
                <p class="conf-step-hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
            </div>

            <div class="conf-step-hall">
                <div class="conf-step-hall-wrapper">
                    <div class="conf-step-row" v-for="row of placesForView">
                        <span v-for="data in row" :class="`conf-step-chair conf-step-chair_${typesList.find((item) => item.id === Number(data.type_id))?.key || 'blocked'}`" @click="changeType(data)"></span>
                    </div>
                </div>
            </div>

            <fieldset class="conf-step-buttons text-center">
                <button class="conf-step-button conf-step-button-regular" @click="closeHallSettings()">Отмена</button>
                <button class="conf-step-button conf-step-button-accent" @click="saveHallSettings()">Сохранить</button>
            </fieldset>
        </div>
    </div>
    <div class="conf-step-wrapper" v-if="!halls.length">
        <p class="conf-step-paragraph">В базе данных нет доступных для настройки залов.</p>
    </div>
</template>

<script>
export default {
    name: "ConfigHallsComponent",
    components: {},
    created() {
        axios.get('/admin/halls').then((response) => {
            this.halls = response?.data || [];
        });
    },
    data() {
        return {
            halls: [],
            typesList: [],

            selectedHallId: null,
            selectedHall: null,

            selectedPlaces: null,
            placesForView: {},
            rows: null,
            nums: null,
        }
    },
    mounted: function () {
        axios.get('/admin/types').then((response) => {
            this.typesList = response?.data || [];
        });
    },
    methods: {
        getSelectedHall() {
            if (this.selectedHallId) this.getInformation();
        },

        getInformation() {
            Promise.all([
                axios.get(`admin/hall/${this.selectedHallId}`),
                axios.get('admin/places', {params: {hall: this.selectedHallId}}),
            ]).then(([hall, places]) => {
                this.selectedHall = hall?.data || null;
                this.rows = hall?.data?.rows || null;
                this.nums = hall?.data?.columns || null;
                this.selectedPlaces = places?.data || null;
                if (this.selectedPlaces) this.getPlacesForView(this.selectedPlaces);
            });
        },

        getPlacesForView(data) {
            this.placesForView = {};
            data.forEach((item) => {
                delete data.id;
                if (!this.placesForView.hasOwnProperty(item.row)) this.placesForView[item.row] = [];
                this.placesForView[item.row].push(item);
            });
        },

        addRows($event) {
            this.rows = Number($event.target.value) || null;
            if (this.rows && this.nums) this.addPlaces();
        },

        addNums($event) {
            this.nums = Number($event.target.value) || null;
            if (this.rows && this.nums) this.addPlaces();
        },

        addPlaces() {
            const newPlaces = {};

            for (let i = 1; i <= this.rows; i++ ) {
                if (this.placesForView.hasOwnProperty(i)) {
                    newPlaces[i] = this.placesForView[i].slice();
                    if (newPlaces[i].length < this.nums) {
                        for (let j = this.nums - newPlaces[i].length; j > 0; j--) {
                            newPlaces[i].push({hall_id: this.selectedHallId, row: i, num: this.nums - j + 1, type_id: 3});
                        }
                    } else if (newPlaces[i].length > this.nums) {
                        newPlaces[i] = newPlaces[i].slice(0, this.nums);
                    }
                } else {
                    newPlaces[i] = [];
                    for (let j = 1; j <= this.nums; j++) {
                        newPlaces[i].push({hall_id: this.selectedHallId, row: i, num: j, type_id: 3});
                    }
                }
            }

            this.placesForView = Object.assign({}, newPlaces);
        },

        changeType(place) {
            const type = Number(place.type_id);
            if (type === 3) {
                place.type_id = 1;
            } else {
                place.type_id = type + 1;
            }
        },

        closeHallSettings() {
            this.selectedHallId = null;
            this.selectedHall = null;
            this.selectedPlaces = null;
            this.placesForView = {};
            this.rows = null;
            this.nums = null;
        },

        saveHallSettings() {
            let data = [];
            for (const key in this.placesForView) {
                data = data.concat(this.placesForView[key]);
            }

            Promise.all([
                axios.put(`admin/hall/${this.selectedHallId}`, {rows: this.rows, columns: this.nums}),
                axios.post('admin/places', {places: data.slice()}),
            ]).then(() => {
                this.closeHallSettings();
            });
        }
    }
}
</script>
<style scoped></style>
