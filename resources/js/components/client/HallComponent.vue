<template>
    <section class="buying">
        <div class="buying-info">
            <div class="buying-info-description">
                <h2 class="buying-info-title">{{ film?.name }}</h2>
                <p class="buying-info-start">Начало сеанса: {{ getTime(session.start) }}</p>
                <p class="buying-info-hall">{{ hall?.name }}</p>
            </div>
        </div>
        <div class="buying-scheme">
            <div class="buying-scheme-wrapper">
                <div class="buying-scheme-row" v-for="row of placesForView">
                    <span v-for="data in row" :class="`buying-scheme-chair buying-scheme-chair_${typesList.find((item) => item.id === Number(data.type))?.key || 'blocked'}`" @click="selectPlace(data)"></span>
                </div>
            </div>
            <div class="buying-scheme-legend">
                <div class="col">
                    <p class="buying-scheme-legend-price">
                        <span class="buying-scheme-chair buying-scheme-chair_standard"></span> Свободно (<span class="buying-scheme-legend-value">{{ hall?.price_standard }}</span> руб.)
                    </p>
                    <p class="buying-scheme-legend-price">
                        <span class="buying-scheme-chair buying-scheme-chair_vip"></span> Свободно VIP (<span class="buying-scheme-legend-value">{{ hall?.price_vip }}</span> руб.)
                    </p>
                </div>
                <div class="col">
                    <p class="buying-scheme-legend-price"><span class="buying-scheme-chair buying-scheme-chair_taken"></span> Занято</p>
                    <p class="buying-scheme-legend-price"><span class="buying-scheme-chair buying-scheme-chair_selected"></span> Выбрано</p>
                </div>
            </div>
        </div>
        <div style="display: flex; margin-top: 3rem; justify-content: center;">
            <button @click="confirmSelection()" class="acceptin-button" style="margin: 0;">Забронировать</button>
            <button @click="back()" class="backin-button">Отменить</button>
        </div>
    </section>
</template>

<script>
export default {
    name: "HallComponent",
    components: {},
    props: {
        session: Object,
    },
    created() {
        Promise.all([
            axios.get(`/client/halls/${this.session.hall}`),
            axios.get(`/client/films/${this.session.film}`),
            axios.get('/client/places', {params: {hall: this.session.hall}}),
            axios.get('/client/orders', {params: {session: this.session.id}}),
            axios.get('/client/types'),
        ]).then(([hall, film, places, orders, types]) => {
            this.hall = hall?.data || null;
            this.film = film?.data || null;
            this.places = places?.data || null;
            this.orders = orders?.data || null;
            if (this.orders && this.places && this.places.length) {
                this.orders.forEach((order) => {
                    const place = this.places.find((item) => item.id === order.place);
                    place.type = 4;
                })
            }
            this.typesList = types?.data || [];
            if (this.places) this.getPlacesForView(this.places);
        });
    },
    data() {
        return {
            hall: null,
            film: null,
            places: null,
            orders: null,

            typesList: [],

            placesForView: {},
            selectedPlaces: [],
        }
    },
    methods: {
        getTime(value) {
            const date = new Date(Number(value * 1000));
            const hours = date.getHours();
            const minutes = date.getMinutes();
            return `${String(hours).length === 2 ? hours : `0${hours}`}:${String(minutes).length === 2 ? minutes : `0${minutes}`}`;
        },

        getPlacesForView(data) {
            this.placesForView = {};
            data.forEach((item) => {
                delete data.id;
                if (!this.placesForView.hasOwnProperty(item.row)) this.placesForView[item.row] = [];
                this.placesForView[item.row].push(item);
            });
        },

        selectPlace(data) {
            switch (Number(data.type)) {
                case 3:
                case 4:
                    break;
                case 5:
                    data.type = this.selectedPlaces.find((item) => Number(item.id) === Number(data.id)).type;
                    this.selectedPlaces = this.selectedPlaces.filter((item) => Number(item.id) !== Number(data.id));
                    break;
                default:
                    this.selectedPlaces.push({...data});
                    data.type = 5;
            }
        },

        confirmSelection() {
            if (this.selectedPlaces.length) {
                this.$emit('confirmSelection', {places: this.selectedPlaces, hall: this.hall, film: this.film, session: this.session});
            }
        },

        back() {
            this.$emit('cancelSelection');
        }
    }
}
</script>
<style scoped></style>
