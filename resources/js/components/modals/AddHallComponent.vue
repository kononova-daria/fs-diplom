<template>
    <div class="popup active">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-header">
                    <h2 class="popup-title">
                        Добавление зала
                        <a class="popup-dismiss" @click="close()"></a>
                    </h2>
                </div>
                <div class="popup-wrapper">
                    <div>
                        <label class="conf-step-label conf-step-label-fullsize" for="name">
                            <span class="input-label">Название зала</span>
                            <input class="conf-step-input" type="text" placeholder="Например, &laquo;Зал 1&raquo;" name="name" required v-model="formData.name">
                        </label>
                        <div class="conf-step-buttons text-center">
                            <button @click="save()" class="conf-step-button conf-step-button-accent">Добавить зал</button>
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
    name: "AddHallComponent",
    components: {},
    data() {
        return {
            formData: {
                name: null,
            },
        }
    },
    methods: {
        save() {
            axios.post('/admin/halls', {...this.formData}).then((response) => {
                if (response.data === 'success') {
                    window.location = '/admin';
                }
            });
        },

        close() {
            for (const key in this.formData) {
                this.formData[key] = null;
            }
            this.$emit('closeModalAddHall');
        }
    }
}
</script>
<style scoped></style>
