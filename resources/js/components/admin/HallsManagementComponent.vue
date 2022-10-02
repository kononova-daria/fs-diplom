<template>
    <div class="conf-step-wrapper">
        <p class="conf-step-paragraph">
            {{ halls.length ? 'Доступные залы:' : 'Данных нет.' }}
        </p>
        <ul class="conf-step-list">
            <li v-for="hall in halls">
                {{ hall.name }}
                <button class="conf-step-button conf-step-button-trash" @click="toggleModalDeleteHall(hall)"></button>
            </li>
        </ul>
        <button class="conf-step-button conf-step-button-accent" @click="toggleModalAddHall()">Создать зал</button>
    </div>

    <div v-if="modalAddHall">
        <add-hall-modal @close-modal-add-hall="toggleModalAddHall()"></add-hall-modal>
    </div>
    <div v-if="modalDeleteHall">
        <delete-hall-modal @close-modal-delete-hall="toggleModalDeleteHall()" :hall="selectedHall"></delete-hall-modal>
    </div>
</template>

<script>
import AddHallComponent from "../modals/AddHallComponent.vue";
import DeleteHallComponent from "../modals/DeleteHallComponent.vue";

export default {
    name: "HallsManagementComponent",
    components: {
        'add-hall-modal': AddHallComponent,
        'delete-hall-modal': DeleteHallComponent,
    },
    created() {
        this.getHalls()
    },
    data() {
        return {
            modalAddHall: false,
            modalDeleteHall: false,

            halls: [],
            selectedHall: null,
        }
    },
    methods: {
        getHalls() {
            axios.get('/admin/halls').then((response) => {
                this.halls = response?.data || [];
            });
        },

        toggleModalAddHall() {
            this.modalAddHall = !this.modalAddHall;
        },
        toggleModalDeleteHall(hall) {
            this.modalDeleteHall = !this.modalDeleteHall;
            this.selectedHall = hall;
        },
    }
}
</script>
<style scoped></style>
