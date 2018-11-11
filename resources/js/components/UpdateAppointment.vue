<template>
    <div class="update-appointment-wrapper">
        <div class="container">
            <div class="update-appointment-holder">
                <div class="update-appointment-holder__title">
                    <h1>Update appointment</h1>
                </div>
                <div v-if="showMessages" class="update-appointment-holder__error-message">
                    <p v-for="message in errorMessages" class="input-error-message">{{message}}</p>
                </div>
                <div v-if="!isToCurrentUser && appointment.canceled == 0" class="update-appointment-holder__form">
                    <label for="appointment_title">Appointment title</label>
                    <input v-model="appointment.appointment_title" type="text" id="appointment_title">
                    <label for="appointment_description">Appointment description</label>
                    <input v-model="appointment.appointment_description" type="text" id="appointment_description">
                    <label for="requested_appointment_to">Appointment to</label>
                    <select v-model="appointment.requested_appointment_to" name="requested_appointment_to" id="requested_appointment_to">
                        <option v-for="(item, index) in users" :value="item.email" :selected="index === 0">{{item.email}} ({{item.name}})</option>
                    </select>
                    <label for="location">Location</label>
                    <input v-model="appointment.related_github_issue" type="text" id="related_github_issue">
                    <label for="location">Location</label>
                    <input v-model="appointment.location" placeholder="Masazine" type="text" id="location">
                    <label for="starts_at">Starts at</label>
                    <input v-model="appointment.starts_at" placeholder="2018-10-10 10:00" type="datetime-local"
                           id="starts_at">
                    <label for="ends_at">Ends at</label>
                    <input v-model="appointment.ends_at" placeholder="2018-10-10 11:00" type="datetime-local"
                           id="ends_at">
                    <div class="update-appointment-holder-form__buttons">
                        <button v-if="!isToCurrentUser" @click="updateAppointment(false)" class="button submit-button">Update</button>
                        <button v-if="!isToCurrentUser" @click="deleteAppointment" class="button danger-button">Delete appointment</button>
                    </div>
                </div>
                <button v-if="appointment.canceled == 0" @click="updateAppointment(true)" class="button black-button">Cancel appointment</button>
                <button v-else @click="updateAppointment(false)" class="button black-button">Un-Cancel appointment</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Home from './Home';

    export default {
        extends: Home,

        data() {
            return {
                appointment: {
                    id: '',
                    appointment_title: '',
                    appointment_description: '',
                    starts_at: '',
                    ends_at: '',
                    related_github_issue: '',
                    location: '',
                    canceled: false,
                    requested_appointment_to: '',
                },
                user: {
                    name: '',
                    email: ''
                },
                users: [],
                errorMessages: '',
                showMessages: false,
                isToCurrentUser: true
            }
        },

        created() {
            this.fetchUsers();
            this.setData();
        },

        methods: {
            setData() {
                fetch(this.$apiUrl + 'appointment/' + this.$route.params.id, {
                    headers: {
                        'accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    }
                })
                    .then(response => response.json())
                    .then(response => {
                        if (response['message'] == 'Not found') {
                            this.$router.push('/');
                        }
                        this.appointment.requested_appointment_to = response.appointment.requested_appointment_to.email;
                        this.appointment = response.appointment;
                        this.isToCurrentUser = (response.appointment.requested_appointment_to.email == localStorage.getItem('email'));
                    })
                    .catch(err => console.log('Callback error:' + err));
            },

            deleteAppointment() {
                fetch(this.$apiUrl + 'appointment', {
                    method: 'delete',
                    headers: {
                        'accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                        'content-type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: this.$route.params.id
                    })
                })
                    .then(response => response.json())
                    .then(response => {
                        if (response['error'] === undefined && response['errors'] === undefined) {
                            this.$router.push('/');
                        } else {
                            this.showMessages = true;
                            let messages = [];
                            if (response['error']) {
                                messages.push(response['error']);
                            } else {
                                for (let key in response['errors']) {
                                    if (!response['errors'].hasOwnProperty(key)) continue;
                                    let obj = response['errors'][key];
                                    for (let prop in obj) {
                                        if(!obj.hasOwnProperty(prop)) continue;
                                        messages.push(obj[prop])
                                    }
                                }
                            }
                            this.errorMessages = messages;
                        }
                    })
                    .catch(err => console.log('Callback error:' + err));
            },

            fetchUsers() {
                fetch(this.$apiUrl + 'user/all', {
                    headers: {
                        'accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                    .then(response => response.json())
                    .then(response => {
                        if (response['error'] === undefined) {
                            this.users = response;
                        }
                    });
            },

            updateAppointment(isCanceled) {
                fetch(this.$apiUrl + 'appointment/', {
                    method: 'put',
                    body: JSON.stringify({
                        id: this.$route.params.id,
                        appointment_title: this.appointment.appointment_title,
                        appointment_description: this.appointment.appointment_description,
                        starts_at: this.appointment.starts_at,
                        ends_at: this.appointment.ends_at,
                        related_github_issue: this.appointment.related_github_issue,
                        location: this.appointment.location,
                        canceled: isCanceled
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                    .then(response => response.json())
                    .then(response => {
                        if (response['error'] === undefined && response['errors'] === undefined) {
                            this.$router.push('/');
                        } else {
                            this.showMessages = true;
                            let messages = [];
                            if (response['error']) {
                                messages.push(response['error']);
                            } else {
                                for (let key in response['errors']) {
                                    if (!response['errors'].hasOwnProperty(key)) continue;
                                    let obj = response['errors'][key];
                                    for (let prop in obj) {
                                        if(!obj.hasOwnProperty(prop)) continue;
                                        messages.push(obj[prop])
                                    }
                                }
                            }
                            this.errorMessages = messages;
                        }
                    })
                    .catch(err => console.log('Callback error:' + err));
            },
        }
    }
</script>
