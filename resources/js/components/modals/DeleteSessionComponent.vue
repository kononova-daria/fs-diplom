<template>
    <div class="popup active">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-header">
                    <h2 class="popup-title">
                        Удаление сеанса
                        <a class="popup-dismiss" @click="close()"></a>
                    </h2>
                </div>
                <div class="popup-wrapper">
                    <div>
                        <p class="conf-step-paragraph">Вы действительно хотите удалить сеанс?</p>
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
    name: "DeleteSessionComponent",
    components: {},
    props: {
        session: Object,
    },
    data() {
        return {}
    },
    methods: {
        deleteItem() {
            if (this.session.id) {
                axios.delete(`/admin/sessions/${this.session.id}`).then((response) => {
                    if (response.status === 201) {
                        this.$emit('updateSessions');
                        this.close();
                    };
                });
            }
        },

        close() {
            this.$emit('closeModalDeleteSession', null);
        }
    }
}
</script>
<style scoped></style>
