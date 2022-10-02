<template>
    <div class="popup active">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-header">
                    <h2 class="popup-title">
                        Удаление фильма
                        <a class="popup-dismiss" @click="close()"></a>
                    </h2>
                </div>
                <div class="popup-wrapper">
                    <div>
                        <p class="conf-step-paragraph">Вы действительно хотите удалить фильм "<span>{{ film?.name }}</span>"?</p>
                        <div class="conf-step-buttons text-center">
                            <button @click="deleteItem()" class="conf-step-button conf-step-button-accent">Удалить</button>
                            <button @click="close()" class="conf-step-button conf-step-button-regular">Отменить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DeleteFilmComponent",
    components: {},
    props: {
        film: Object,
    },
    data() {
        return {}
    },
    methods: {
        deleteItem() {
            if (this.film.id) {
                axios.delete(`/admin/films/${this.film.id}`).then((response) => {
                    if (response.data === 'success') {
                        this.$emit('updateFilms');
                        this.close();
                    };
                });
            }
        },

        close() {
            this.$emit('closeModalDeleteFilm', null);
        }
    }
}
</script>
<style scoped></style>
