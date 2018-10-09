<template>
    <div class="login-wrapper">
        <div class="container">
            <div class="login-holder">
                <div v-if="showError" class="input-error-message">
                    Oops, something went wrong. Please check your login credentials
                </div>
                <div class="form-left">
                    <label for="email">Email</label>
                    <input type="text" id="email" v-model="user.email">
                    <label for="email">Password</label>
                    <input type="password" id="password" v-model="user.password">
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
                    email: 'linas@maziukas.com',
                    password: 'test123'
                },
                showError: false
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
                        if (response['error'] === undefined) {
                            localStorage.setItem('token', response['token']);
                            localStorage.setItem('email', this.user.email);
                            this.user.password = '';
                            this.$router.push('/');
                        } else {
                            this.showError = true;
                        }
                    })
                    .catch(err => console.log('Callback error:' + err));
            },
        }
    }
</script>
