<template>
    <nav class="page-nav">
        <a class="page-nav-day page-nav-day_previous" :style="{color: dates[0].today && '#848484' || '#000000'}" href="#" @click="changeDates($event, 'previous')"></a>
        <a v-for="date in dates" class="page-nav-day"
           v-bind:class="{'page-nav-day_today': date?.today,
                          'page-nav-day_chosen': date?.selected,
                          'page-nav-day_weekend': date?.day === 6 || date?.day === 0,
           }"
           href="#" @click="selectDate($event, date)">
            <span class="page-nav-day-week">{{ dictionary.find((item) => item.id === date.day)?.name }}</span>
            <span class="page-nav-day-number">{{ date.date }}</span>
        </a>
        <a class="page-nav-day page-nav-day_next" href="#" @click="changeDates($event, 'next')"></a>
    </nav>
</template>

<script>
export default {
    name: "NavigationComponent",
    components: {},
    data() {
        return {
            dates: [],
            today: {
                year: (new Date()).getFullYear(),
                month: (new Date()).getMonth(),
                date: (new Date()).getDate(),
                day: (new Date()).getDay(),
            },
            dictionary: [
                {id: 1, name: 'Пн'},
                {id: 2, name: 'Вт'},
                {id: 3, name: 'Ср'},
                {id: 4, name: 'Чт'},
                {id: 5, name: 'Пт'},
                {id: 6, name: 'Сб'},
                {id: 0, name: 'Вс'},
            ],
            selectedDate: null,
        }
    },
    created() {
        this.getDates();
    },
    methods: {
        getDates() {
            this.dates.push({...this.today, today: true, selected: true});
            this.selectedDate = this.dates[0];
            for (let i = 1; i < 6; i++) {
                const newDate = new Date(this.dates[i - 1].year, this.dates[i - 1].month, this.dates[i - 1].date + 1);
                this.dates.push({
                    year: newDate.getFullYear(),
                    month: newDate.getMonth(),
                    date: newDate.getDate(),
                    day: newDate.getDay(),
                    today: false,
                    selected: false,
                });
            }
            this.$emit('selectDate', this.selectedDate);
        },

        changeDates($event, type) {
            $event.preventDefault();
            const index = this.dates.length - 1;
            if (type === 'next') {
                const newDate = new Date(this.dates[index].year, this.dates[index].month, this.dates[index].date + 1);
                this.dates.push({
                    year: newDate.getFullYear(),
                    month: newDate.getMonth(),
                    date: newDate.getDate(),
                    day: newDate.getDay(),
                    today: this.today.year === newDate.getFullYear() && this.today.month === newDate.getMonth() && this.today.date === newDate.getDate(),
                    selected: this.selectedDate.year === newDate.getFullYear() && this.selectedDate.month === newDate.getMonth() && this.selectedDate.date === newDate.getDate(),
                });
                if (this.dates[this.dates.length - 1].selected) {
                    this.selectedDate.selected = false;
                    this.selectedDate = this.dates[this.dates.length - 1];
                    this.selectedDate.selected = true;
                }
                this.dates.splice(0, 1);
            }
            if (type === 'previous' && !this.dates[0].today) {
                const newDate = new Date(this.dates[0].year, this.dates[0].month, this.dates[0].date - 1);
                this.dates.unshift({
                    year: newDate.getFullYear(),
                    month: newDate.getMonth(),
                    date: newDate.getDate(),
                    day: newDate.getDay(),
                    today: this.today.year === newDate.getFullYear() && this.today.month === newDate.getMonth() && this.today.date === newDate.getDate(),
                    selected: this.selectedDate.year === newDate.getFullYear() && this.selectedDate.month === newDate.getMonth() && this.selectedDate.date === newDate.getDate(),
                });
                if (this.dates[0].selected) {
                    this.selectedDate.selected = false;
                    this.selectedDate = this.dates[0];
                    this.selectedDate.selected = true;
                }
                this.dates.splice(index, 1);
            }
        },

        selectDate($event, date) {
            $event.preventDefault();
            this.selectedDate.selected = false;
            this.selectedDate = date;
            this.selectedDate.selected = true;
            this.$emit('selectDate', date);
        }
    }
}
</script>
<style scoped></style>
