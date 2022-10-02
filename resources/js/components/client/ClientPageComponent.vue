<template>
    <div v-if="view === 'films'">
        <navigation-component @select-date="selectDate($event)"></navigation-component>

        <main>
            <div v-if="!message">
                <films-component @select-session="selectSession($event)" :information="information"></films-component>
            </div>
            <div v-if="message" class="movie">
                <div class="movie-info">
                    <p class="movie-synopsis">{{ message }}</p>
                </div>
            </div>
        </main>
    </div>
    <div v-if="view === 'hall'">
        <main>
            <hall-component :session="selectedSession" @cancel-selection="cancelSelectionSession()" @confirm-selection="confirmSelectionSession($event)"></hall-component>
        </main>
    </div>
    <div v-if="view === 'payment'">
        <main>
            <payment-component :data="selectedPlaces"></payment-component>
        </main>
    </div>
</template>

<script>
import NavigationComponent from "./NavigationComponent.vue";
import FilmsComponent from "./FilmsComponent.vue";
import HallComponent from "./HallComponent.vue";
import PaymentComponent from "./PaymentComponent.vue";

export default {
    name: "ClientPageComponent",
    components: {
        'navigation-component':  NavigationComponent,
        'films-component': FilmsComponent,
        'hall-component': HallComponent,
        'payment-component': PaymentComponent,
    },
    data() {
        return {
            selectedDate: null,
            today: {
                year: (new Date()).getFullYear(),
                month: (new Date()).getMonth(),
                date: (new Date()).getDate(),
                day: (new Date()).getDay(),
            },

            message: null,

            information: [],

            view: 'films',

            selectedSession: null,
            selectedPlaces: null,
        }
    },
    methods: {
        selectDate($event) {
            if ($event) {
                this.selectedDate = $event;

                if (this.selectedDate.year === this.today.year && this.selectedDate.month === this.today.month && this.selectedDate.day === this.today.day) {
                    this.message = null;
                    this.getInformation();
                } else {
                    this.message = 'На данный день не запланированы сеансы.';
                }
            }
        },

        getInformation() {
            axios.get('/client/films').then((response) => {
                this.information = response?.data || [];
                if (!this.information.length) this.message = 'На данный день не запланированы сеансы.';
            });
        },

        selectSession($event) {
            this.selectedSession = $event;
            this.view = 'hall';
        },

        cancelSelectionSession() {
            this.selectedSession = null;
            this.view = 'films';
        },

        confirmSelectionSession($event) {
            this.selectedPlaces = $event;
            this.view = 'payment';
        }
    }
}
</script>
<style scoped></style>
