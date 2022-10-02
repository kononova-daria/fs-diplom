<template>
    <div class="conf-step-wrapper text-center" v-if="halls.length">
        <p class="conf-step-paragraph">Всё готово, теперь можно:</p>
        <ul class="conf-step-selectors-box">
            <li v-for="hall in halls">
                <input type="radio" class="conf-step-radio" name="chairs-hall" :value="hall" v-model="selectedHall" @click="selectHall()">
                <span class="conf-step-selector">{{ hall.name }}</span>
            </li>
        </ul>
        <p v-if="error" class="conf-step-paragraph" style="color:#a5090c; padding: 10px 0px;">{{ error }}</p>
        <button class="conf-step-button conf-step-button-accent" @click="changeStatus()">{{ selectedHall?.status ? 'Приостановить продажу билетов' : 'Открыть продажу билетов' }}</button>
    </div>
    <div class="conf-step-wrapper text-center" v-if="!halls.length">
        <p class="conf-step-paragraph">В базе данных нет доступных для настройки залов.</p>
    </div>
</template>

<script>
export default {
    name: "SalesComponent",
    components: {},
    created() {
        this.getHalls();
    },
    data() {
        return {
            halls: [],
            selectedHall: null,
            error: null,
        }
    },
    methods: {
        getHalls() {
            axios.get('/admin/halls').then((response) => {
                this.halls = response?.data || [];
                this.halls.forEach((item) => {
                    item.status = !!Number(item.status);
                });
            });
        },

        selectHall() {
            this.error = null;
        },

        changeStatus() {
            if (this.selectedHall) {
                axios.put(`admin/hall/${this.selectedHall.id}`, {status: !this.selectedHall.status }).then(() => {
                    this.closeSettings();
                    this.getHalls();
                });
            } else {
                this.error = 'Выберите зал.'
            }
        },

        closeSettings() {
            this.selectedHall = null;
            this.error = null;
        },
    }
}
</script>
<style scoped></style>
