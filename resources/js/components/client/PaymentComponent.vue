<template>
    <section class="ticket">
        <header class="ticket-check">
            <h2 class="ticket-check-title">{{ ticket ? 'Электронный билет' : 'Вы выбрали билеты:' }}</h2>
        </header>

        <div class="ticket-info-wrapper">
            <p class="ticket-info">На фильм: <span class="ticket-details ticket-title">{{ data?.film?.name }}</span></p>
            <p class="ticket-info">Места (ряд-место): <span class="ticket-details ticket-chairs">{{ data?.places.map((item) => `${item.row}-${item.num}`).join(', ') }}</span></p>
            <p class="ticket-info">В зале: <span class="ticket-details ticket-hall">{{ data?.hall?.name }}</span></p>
            <p class="ticket-info">Начало сеанса: <span class="ticket-details ticket-start">{{ getTime(data?.session?.start) }}</span></p>
            <p v-if="!ticket" class="ticket-info">Стоимость: <span class="ticket-details ticket-cost">{{ getCost() }}</span> рублей</p>

            <p v-if="error" class="conf-step-paragraph" style="color:#a5090c; padding: 15px 0px;">{{ error }}</p>

            <button v-if="!ticket" @click="getTicket()" class="acceptin-button">Получить код бронирования</button>

            <div v-if="ticket" v-html="ticket" style="display: flex; justify-content: center; margin-top: 1.5rem;"></div>

            <p class="ticket-hint">
                {{ ticket ?
                'Покажите QR-код нашему контроллеру для подтверждения бронирования.' :
                'После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.'}}
            </p>
            <p class="ticket-hint">Приятного просмотра!</p>
        </div>
    </section>
</template>

<script>
export default {
    name: "PaymentComponent",
    components: {},
    props: {
        data: Object,
    },
    created() {

    },
    data() {
        return {
            ticket: null,
            error: null,
        }
    },
    methods: {
        getTime(value) {
            const date = new Date(Number(value * 1000));
            const hours = date.getHours();
            const minutes = date.getMinutes();
            return `${String(hours).length === 2 ? hours : `0${hours}`}:${String(minutes).length === 2 ? minutes : `0${minutes}`}`;
        },

        getCost() {
            let cost = 0;
            if (this.data?.places && this.data?.hall) {
                this.data.places.forEach((item) => {
                    switch (Number(item.type_id)) {
                        case 1:
                            cost += Number(this.data.hall.price_standard);
                            break;
                        case 2:
                            cost += Number(this.data.hall.price_vip);
                            break;
                    }
                });
            }
            return cost;
        },

        getTicket() {
            this.error = null;

            axios.post('client/orders', {session_id: this.data.session.id, places: this.data.places.map((item) => item.id)}).then((response) => {
                this.ticket = response?.data;
            }, (error) => this.error = error.response.data[0]);
        }
    }
}
</script>
<style scoped></style>
