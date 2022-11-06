<template>
    <div class="popup active">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-header">
                    <h2 class="popup-title">
                        Добавление сеанса
                        <a class="popup-dismiss" @click="close()"></a>
                    </h2>
                </div>
                <div class="popup-wrapper">
                    <div>
                        <label class="conf-step-label conf-step-label-fullsize" for="hall">
                            <span class="input-label">Название зала</span>
                            <select class="conf-step-input" name="hall" v-model="formData.hall_id" required>
                                <option v-for="hall of halls" :value="hall.id">{{ hall.name }}</option>
                            </select>
                        </label>
                        <label class="conf-step-label conf-step-label-fullsize" for="start">
                            <span class="input-label">Время начала</span>
                            <input class="conf-step-input" type="time" name="start" v-model="formData.start" required>
                        </label>
                        <p v-if="error" class="conf-step-paragraph" style="color:#a5090c; padding: 15px 0px;">{{ error }}</p>
                        <div class="conf-step-buttons text-center">
                            <button @click="save()" class="conf-step-button conf-step-button-accent">Добавить сеанс</button>
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
    name: "AddSessionComponent",
    components: {},
    props: {
        halls: Array,
        film: Object,
    },
    data() {
        return {
            formData: {
                hall_id: null,
                start: null,
            },
            error: null,
        }
    },
    methods: {
        save() {
            const time = this.formData.start && this.formData.start.split(':');
            const tstmpStart = time && (new Date(1970, 0, 1, Number(time[0]), Number(time[1]))).getTime()/1000;
            const tstmpEnd = tstmpStart + Number(this.film.duration)*60;

            axios.post('/admin/sessions', {...this.formData, film_id: this.film.id, start: tstmpStart, end: tstmpEnd}).then((response) => {
                if (response?.status === 201) {
                    this.$emit('updateSessions');
                    this.close();
                }
            }, (error) => this.error = error.response.data[0]);
        },

        close() {
            for (const key in this.formData) {
                this.formData[key] = null;
            }
            this.error = null;
            this.$emit('closeModalAddSession', null);
        }
    }
}
</script>
<style scoped></style>
