<template>
    <div class="login-wrapper">
        <div class="container">
            <div class="login-holder">
                <div v-if="showMessages" class="update-appointment-holder__error-message">
                    <p v-for="message in errorMessages" class="input-error-message">{{message}}</p>
                </div>
                <div class="form-left">
                    <label for="email">Email</label>
                    <input type="text" id="email" v-model="user.email" placeholder="john@doe.com" required>
                    <label for="email">Password</label>
                    <input type="password" id="password" v-model="user.password" placeholder="password" required>
                    <button @click="login()" class="button submit-button">Log in</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    email: '',
                    password: ''
                },
                showMessages: false,
                errorMessages: []
            }
        },

        methods: {
            login() {
                fetch(this.$apiUrl + 'login', {
                    method: 'post',
                    body: JSON.stringify({
                        email: this.user.email,
                        password: this.user.password
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(response => {
                        if (response['error'] === undefined && response['errors'] === undefined) {
                            localStorage.setItem('token', response['token']);
                            localStorage.setItem('email', this.user.email);
                            this.user.password = '';
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
