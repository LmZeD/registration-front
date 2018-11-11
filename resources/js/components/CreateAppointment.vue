<template>
    <div class="create-appointment-wrapper">
        <div class="container">
            <div class="create-appointment-holder">
                <div class="create-appointment-holder__title">
                    <h1>Create appointment</h1>
                </div>
                <div v-if="showMessages" class="create-appointment-holder__error-message">
                    <p v-for="message in errorMessages" class="input-error-message">{{message}}</p>
                </div>
                <div class="create-appointment-holder__form">
                    <label for="appointment_title">Appointment title*</label>
                    <input v-model="appointment.appointment_title" type="text" id="appointment_title" required>
                    <label for="appointment_description">Appointment description*</label>
                    <input v-model="appointment.appointment_description" type="text" id="appointment_description" required>
                    <label for="requested_appointment_to">Appointment to*</label>
                    <select v-model="appointment.requested_appointment_to" name="requested_appointment_to" id="requested_appointment_to" required>
                        <option v-for="item in users" :value="item.email">{{item.email}} ({{item.name}})</option>
                    </select>
                    <label for="related_github_issue">Related github issue*</label>
                    <input v-model="appointment.related_github_issue" type="text" id="related_github_issue" required>
                    <label for="location">Location*</label>
                    <input v-model="appointment.location" placeholder="Masazine" type="text" id="location">
                    <label for="starts_at">Starts at*</label>
                    <input v-model="appointment.starts_at" placeholder="2018-10-10 10:00" type="datetime-local"
                           id="starts_at" required>
                    <label for="ends_at">Ends at*</label>
                    <input v-model="appointment.ends_at" placeholder="2018-10-10 11:00" type="datetime-local"
                           id="ends_at" required>
                    <button @click="storeAppointment" class="button submit-button">Create</button>
                </div>
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
                    appointment_title: '',
                    appointment_description: '',
                    starts_at: '',
                    ends_at: '',
                    related_github_issue: 'none',
                    location: 'Masazine',
                    requested_appointment_to: null,
                },
                user: {
                    name: '',
                    email: ''
                },
                users: [],
                errorMessages: '',
                showMessages: false
            }
        },

        created() {
            this.fetchUsers();
            this.setDate();
        },

        methods: {
            setDate() {
                let date = new Date();
                let endDate = new Date(date.getTime() + 60*60000);
                this.appointment.starts_at = date.toISOString().substr(0, 10) + ' ' + date.toTimeString().substr(0, 8);
                this.appointment.ends_at = endDate.toISOString().substr(0, 10) + ' ' + endDate.toTimeString().substr(0, 8);
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

            storeAppointment() {
                fetch(this.$apiUrl + 'appointment/store', {
                    method: 'put',
                    body: JSON.stringify({
                        appointment_title: this.appointment.appointment_title,
                        appointment_description: this.appointment.appointment_description,
                        starts_at: this.appointment.starts_at,
                        ends_at: this.appointment.ends_at,
                        related_github_issue: this.appointment.related_github_issue,
                        location: this.appointment.location,
                        appointment_to_user: this.appointment.requested_appointment_to,
                        canceled: 0
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
                            this.$router.push('/')
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
