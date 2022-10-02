<template>
    <div class="conf-step-wrapper">
        <p class="conf-step-paragraph">
            <button class="conf-step-button conf-step-button-accent" @click="toggleModalAddFilm()">Добавить фильм</button>
        </p>
        <div class="conf-step-movies" v-if="filmsList.length">
            <div class="conf-step-movie" v-for="film of filmsList" @click="toggleModalAddSession(film)">
                <div class="conf-step-movie-poster"></div>
                <h3 class="conf-step-movie-title">{{ film.name }}</h3>
                <p class="conf-step-movie-duration">{{ film.duration }} минут</p>
                <div class="popup-dismiss-film" @click="toggleModalDeleteFilm(film, $event)"></div>
            </div>
        </div>
        <div v-if="!filmsList.length">
            <p class="conf-step-paragraph">В базе данных нет доступных для настройки фильмов.</p>
        </div>

        <div v-if="halls.length" class="conf-step-seances">
            <div class="conf-step-seances-hall" v-for="hall of halls">
                <h3 class="conf-step-seances-title">{{ hall.name }}</h3>
                <div class="conf-step-seances-timeline">
                    <div v-for="session of sessionsList.filter((item) => Number(item.hall) === Number(hall.id))" @click="toggleModalDeleteSession(session)">
                        <div class="conf-step-seances-movie" :style="{width: session?.durationView, backgroundColor: '#0a828a', left: session?.coordinateView}">
                            <p class="conf-step-seances-movie-title">{{ session?.film?.name }}</p>
                            <p class="conf-step-seances-movie-start">{{ session?.startView }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!halls.length">
            <p class="conf-step-paragraph">В базе данных нет доступных для настройки залов.</p>
        </div>
    </div>

    <div v-if="modalAddFilm">
        <add-film-modal @close-modal-add-film="toggleModalAddFilm()" @update-films="getFilms()"></add-film-modal>
    </div>
    <div v-if="modalDeleteFilm">
        <delete-film-modal @close-modal-delete-film="toggleModalDeleteFilm(null)" :film="selectedFilm" @update-films="getFilms()"></delete-film-modal>
    </div>
    <div v-if="modalAddSession">
        <add-session-modal @close-modal-add-session="toggleModalAddSession()" @update-sessions="getSessions()" :halls="halls" :film="selectedFilm"></add-session-modal>
    </div>
    <div v-if="modalDeleteSession">
        <delete-session-modal @close-modal-delete-session="toggleModalDeleteSession()" @update-sessions="getSessions()" :session="selectedSession"></delete-session-modal>
    </div>
</template>

<script>
import AddFilmComponent from "../modals/AddFilmComponent.vue";
import DeleteFilmComponent from "../modals/DeleteFilmComponent.vue";
import AddSessionComponent from "../modals/AddSessionComponent.vue";
import DeleteSessionComponent from "../modals/DeleteSessionComponent.vue";

export default {
    name: "SettingUpSessionsComponent",
    components: {
        'add-film-modal': AddFilmComponent,
        'delete-film-modal': DeleteFilmComponent,
        'add-session-modal': AddSessionComponent,
        'delete-session-modal': DeleteSessionComponent,
    },
    data() {
        return {
            modalAddFilm: false,
            modalDeleteFilm: false,
            modalAddSession: false,
            modalDeleteSession: false,

            filmsList: [],
            selectedFilm: null,

            sessionsList: [],
            selectedSession: null,

            halls: [],
        }
    },
    created: function () {
        this.getFilms();
        this.getHalls();
        this.getSessions();
    },
    methods: {
        getHalls() {
            axios.get('/admin/halls').then((response) => {
                this.halls = response?.data || [];
            });
        },
        getFilms() {
            axios.get('/admin/films').then((response) => {
                this.filmsList = response?.data || [];
            });
        },
        getSessions() {
            axios.get('/admin/sessions').then((response) => {
                this.sessionsList = response?.data || [];
                this.sessionsList.forEach((item) => {
                    const date = new Date(Number(item.start * 1000));
                    const hours = date.getHours();
                    const minutes = date.getMinutes();
                    item['coordinateView'] = `${(hours * 60 + minutes) * 0.5}px`;
                    item['durationView'] = `${((item.end - item.start) / 60) * 0.5}px`;
                    item['startView'] = `${String(hours).length === 2 ? hours : `0${hours}`}:${String(minutes).length === 2 ? minutes : `0${minutes}`}`;
                });
            });
        },

        toggleModalAddFilm() {
            this.modalAddFilm = !this.modalAddFilm;
        },
        toggleModalDeleteFilm(film, $event = null) {
            if ($event) $event.stopPropagation();
            this.modalDeleteFilm = !this.modalDeleteFilm;
            this.selectedFilm = film;
        },
        toggleModalAddSession(film) {
            this.modalAddSession = !this.modalAddSession;
            this.selectedFilm = film;
        },
        toggleModalDeleteSession(session) {
            this.modalDeleteSession = !this.modalDeleteSession;
            this.selectedSession = session;
        }
    }
}
</script>
<style scoped></style>
