<template>
    <div class="appointments-holder">
        <div class="appointments-holder__section">
            <div class="appointments-holder-section__title">
                <h2>Upcoming</h2>
            </div>
            <div :class="[item.requested_appointment_to.email === this.localStorage.getItem('email') ? 'appointments-holder-section__card--to-me' : '', item.canceled == true ? 'appointments-holder-section__card--canceled' : '' ]" v-for="item in upcoming" class="appointments-holder-section__card appointments-holder-section__card--upcoming">
                <div class="appointments-holder-section-card__title">
                    <h2>{{item.appointment_title}}</h2>
                </div>
                <div class="appointments-holder-section-card__description">
                    <p>{{item.appointment_description}}</p>
                </div>
                <div class="appointments-holder-section-card__related-issue">
                    <p>Related github issue: <b>{{item.related_github_issue}}</b></p>
                </div>
                <div class="appointments-holder-section-card__person-location">
                    <p v-if="item.requested_appointment_to.email === this.localStorage.getItem('email')">{{item.requested_by.name}} requested meeting @ {{item.location}}</p>
                    <p v-else>Meeting with {{item.requested_appointment_to.name}} @ {{item.location}}</p>
                </div>
                <div class="appointments-holder-section-card__starts-at">
                    <p>Starts: <b>{{item.starts_at}}</b></p>
                </div>
                <div class="appointments-holder-section-card__ends-at">
                    <p>Ends: <b>{{item.ends_at}}</b></p>
                </div>
                <div v-if="item.requested_appointment_to.email !== this.localStorage.getItem('email')" class="appointments-holder-section-card__edit-button">
                    <router-link :to="{ name: 'update-appointment' , params: { id: item.id}}" class="button submit-button">Edit</router-link>
                </div>
            </div>
            <div class="appointments-holder-section__empty-title">
                <h2 v-if="upcoming.length === 0">No upcoming appointments yet!</h2>
            </div>
        </div>

        <div class="appointments-holder__section">
            <div class="appointments-holder-section__title">
                <h2>Ongoing</h2>
            </div>
            <div :class="[item.requested_appointment_to.email === this.localStorage.getItem('email') ? 'appointments-holder-section__card--to-me' : '', item.canceled == true ? 'appointments-holder-section__card--canceled' : '' ]" v-for="item in ongoing" class="appointments-holder-section__card appointments-holder-section__card--ongoing">
                <div class="appointments-holder-section-card__title">
                    <h2>{{item.appointment_title}}</h2>
                </div>
                <div class="appointments-holder-section-card__description">
                    <p>{{item.appointment_description}}</p>
                </div>
                <div class="appointments-holder-section-card__related-issue">
                    <p>Related github issue: <b>{{item.related_github_issue}}</b></p>
                </div>
                <div class="appointments-holder-section-card__person-location">
                    <p v-if="item.requested_appointment_to.email === this.localStorage.getItem('email')">{{item.requested_by.name}} requested meeting @ {{item.location}}</p>
                    <p v-else>Meeting with {{item.requested_appointment_to.name}} @ {{item.location}}</p>
                </div>
                <div class="appointments-holder-section-card__starts-at">
                    <p>Starts: <b>{{item.starts_at}}</b></p>
                </div>
                <div class="appointments-holder-section-card__ends-at">
                    <p>Ends: <b>{{item.ends_at}}</b></p>
                </div>
                <div v-if="item.requested_appointment_to.email !== this.localStorage.getItem('email')" class="appointments-holder-section-card__edit-button">
                    <router-link :to="{ name: 'update-appointment' , params: { id: item.id}}" class="button submit-button">Edit</router-link>
                </div>
            </div>
            <div class="appointments-holder-section__empty-title">
                <h2 v-if="ongoing.length === 0">No ongoing appointments yet!</h2>
            </div>
        </div>

        <div class="appointments-holder__section">
            <div class="appointments-holder-section__title">
                <h2>Finished</h2>
            </div>
            <div :class="[item.requested_appointment_to.email === this.localStorage.getItem('email') ? 'appointments-holder-section__card--to-me' : '', item.canceled == true ? 'appointments-holder-section__card--canceled' : '' ]" v-for="item in ended" class="appointments-holder-section__card appointments-holder-section__card--ended">
                <div class="appointments-holder-section-card__title">
                    <h2>{{item.appointment_title}}</h2>
                </div>
                <div class="appointments-holder-section-card__description">
                    <p>{{item.appointment_description}}</p>
                </div>
                <div class="appointments-holder-section-card__related-issue">
                    <p>Related github issue: <b>{{item.related_github_issue}}</b></p>
                </div>
                <div class="appointments-holder-section-card__person-location">
                    <p v-if="item.requested_appointment_to.email === this.localStorage.getItem('email')">{{item.requested_by.name}} requested meeting @ {{item.location}}</p>
                    <p v-else>Meeting with {{item.requested_appointment_to.name}} @ {{item.location}}</p>
                </div>
                <div class="appointments-holder-section-card__starts-at">
                    <p>Starts: <b>{{item.starts_at}}</b></p>
                </div>
                <div class="appointments-holder-section-card__ends-at">
                    <p>Ends: <b>{{item.ends_at}}</b></p>
                </div>
            </div>
            <div class="appointments-holder-section__empty-title">
                <h2 v-if="ended.length === 0">No finished appointments yet!</h2>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                appointment: {
                    id: '',
                    appointment_title: '',
                    appointment_description: '',
                    starts_at: '',
                    ends_at: '',
                    canceled: '',
                    related_github_issue: '',
                    location: '',
                    requested_appointment_to: null,
                    requested_by: null
                },
                ended: [],
                upcoming: [],
                ongoing: [],
                requested_appointment_to: {
                    name: '',
                    email: ''
                },
                requested_by: {
                    name: '',
                    email: ''
                }
            }
        },

        created() {
            this.fetchAppointments();
        },

        methods: {
            fetchAppointments() {
                fetch(this.$apiUrl + 'appointment/', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization' : 'Bearer ' + localStorage.getItem('token')
                    }
                })
                    .then(response => response.json())
                    .then(response => {
                        this.ended = response['ended'];
                        this.ongoing = response['ongoing'];
                        this.upcoming = response['upcoming'];
                    })
                    .catch(err => console.log('Callback error:' + err));
            }
        }
    }
</script>
