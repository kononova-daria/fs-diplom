<template>
    <section class="movie" v-for="film in information">
        <div class="movie-info">
            <div class="movie-poster">
                <div class="movie-poster-image" style="background-color: #fd7e14"></div>
            </div>
            <div class="movie-description">
                <h2 class="movie-title">{{ film.name }}</h2>
                <p class="movie-synopsis">{{ film.description }}</p>
                <p class="movie-data">
                    <span class="movie-data-duration">{{ film.duration }} минут</span>
                    <span class="movie-data-origin">{{ film.country }}</span>
                </p>
            </div>
        </div>

        <div class="movie-seances-hall" v-for="hall in film.halls">
            <h3 class="movie-seances-hall-title">{{ hall.name }}</h3>
            <ul class="movie-seances-list">
                <li class="movie-seances-time-block" v-for="session in hall.sessions">
                    <a class="movie-seances-time" @click="selectSession(session)">{{ getTime(session.start) }}</a>
                </li>
            </ul>
        </div>
    </section>
</template>

<script>
export default {
    name: "FilmsComponent",
    components: {},
    props: {
        information: Array,
    },
    data() {
        return {

        }
    },
    methods: {
        getTime(value) {
            const date = new Date(Number(value * 1000));
            const hours = date.getHours();
            const minutes = date.getMinutes();
            return `${String(hours).length === 2 ? hours : `0${hours}`}:${String(minutes).length === 2 ? minutes : `0${minutes}`}`;
        },

        selectSession(session) {
            this.$emit('selectSession', session);
        }
    }
}
</script>
<style scoped></style>
