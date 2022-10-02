<template>
    <div class="popup active">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-header">
                    <h2 class="popup-title">
                        Добавление фильма
                        <a class="popup-dismiss" @click="close()"></a>
                    </h2>
                </div>
                <div class="popup-wrapper">
                    <div>
                        <label class="conf-step-label conf-step-label-fullsize" for="name">
                            <span class="input-label">Название фильма</span>
                            <input class="conf-step-input" type="text" placeholder="Например, &laquo;Гражданин Кейн&raquo;" name="name" v-model="formData.name" required>
                        </label>
                        <label class="conf-step-label conf-step-label-fullsize" for="description">
                            <span class="input-label">Описание</span>
                            <input class="conf-step-input" type="text" placeholder="Например, &laquo;В шикарном поместье умирает газетный магнат Чарльз Фостер Кейн...&raquo;" name="description" v-model="formData.description" required>
                        </label>
                        <label class="conf-step-label conf-step-label-fullsize" for="duration">
                            <span class="input-label">Длительность, мин</span>
                            <input class="conf-step-input" type="text" placeholder="Например, &laquo;119&raquo;" name="duration" v-model="formData.duration" required>
                        </label>
                        <label class="conf-step-label conf-step-label-fullsize" for="country">
                            <span class="input-label">Страна</span>
                            <input class="conf-step-input" type="text" placeholder="Например, &laquo;США&raquo;" name="country" v-model="formData.country" required>
                        </label>
                        <div class="conf-step-buttons text-center">
                            <button @click="save()" class="conf-step-button conf-step-button-accent">Добавить фильм</button>
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
    name: "AddFilmComponent",
    components: {},
    data() {
        return {
            formData: {
                name: null,
                description: null,
                duration: null,
                country: null,
            },
        }
    },
    methods: {
        save() {
            axios.post('/admin/films', {...this.formData}).then((response) => {
                if (response.data === 'success') {
                    this.$emit('updateFilms');
                    this.close();
                }
            });
        },

        close() {
            for (const key in this.formData) {
                this.formData[key] = null;
            }
            this.$emit('closeModalAddFilm');
        }
    }
}
</script>
<style scoped></style>
