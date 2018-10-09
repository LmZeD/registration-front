<template>
    <div class="register-wrapper">
        <div class="container">
            <div class="register-holder">
                <div class="form-left">
                    <label for="username">Username</label>
                    <input type="text" id="username" v-model="user.name">
                    <label for="email">Email</label>
                    <input type="text" id="email" v-model="user.email">
                    <label for="email">Password</label>
                    <input type="password" id="password" v-model="user.password">
                    <button @click="register()" class="button submit-button">Register</button>
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
                    name: '',
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            register() {
                fetch(this.$apiUrl + 'register', {
                    method: 'post',
                    body: JSON.stringify({
                        email: this.user.email,
                        password: this.user.password,
                        name: this.user.name
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
                            this.$router.push('/');
                        }
                        this.user.password = '';
                    })
                    .catch(err => console.log('Callback error:' + err));
            }
        }
    }
</script>
