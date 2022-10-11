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
            <p v-if="Number(error.film) === Number(film.id) && Number(error.hall) === Number(hall.id)" class="conf-step-paragraph" style="color:#a5090c; padding: 5px 0px;">{{ error.message }}</p>
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
            error: {film: null, hall: null, message: 'К сожалению, для выбранного времени не осталось свободных мест.'},
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
            this.error.film = null;
            this.error.hall = null;

            if (session) {
                Promise.all([
                    axios.get('/client/places', {params: {hall: session.hall_id}}),
                    axios.get('/client/orders', {params: {session: session.id}}),
                ]).then(([places, orders]) => {
                    const placesList = places?.data || null;
                    const ordersList = orders?.data || null;
                    if (ordersList && placesList) {
                        ordersList.forEach((order) => {
                            const place = placesList.find((item) => item.id === order.place_id);
                            place.type_id = 4;
                        })
                        if (placesList.filter((item) => Number(item.type_id) === 3 || Number(item.type_id) === 4).length !== placesList.length) {
                            this.$emit('selectSession', session);
                        } else {
                            this.error.film = session.film_id;
                            this.error.hall = session.hall_id;
                        }
                    }
                });
            }
        }
    }
}
</script>
<style scoped></style>
