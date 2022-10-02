<template>
    <div class="popup active">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-header">
                    <h2 class="popup-title">
                        Удаление зала
                        <a class="popup-dismiss" @click="close()"></a>
                    </h2>
                </div>
                <div class="popup-wrapper">
                    <div>
                        <p class="conf-step-paragraph">Вы действительно хотите удалить зал "<span>{{ hall?.name }}</span>"?</p>
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
    name: "DeleteHallComponent",
    components: {},
    props: {
        hall: Object,
    },
    data() {
        return {}
    },
    methods: {
        deleteItem() {
            if (this.hall?.id) {
                axios.delete(`/admin/halls/${this.hall.id}`).then((response) => {
                    console.log(response)
                    if (response.data === 'success') {
                        window.location = '/admin';
                    };
                });
            }
        },

        close() {
            this.$emit('closeModalDeleteHall', null);
        }
    }
}
</script>
<style scoped></style>
