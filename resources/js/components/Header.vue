<template>
    <div class="header-holder">
        <div class="container">
            <div class="header-wrapper">
                <div class="header-wrapper__row">
                    <div class="header-wrapper-row__brand-name">
                        <router-link class="header-link-home" to="/">Home</router-link>
                    </div>
                    <div class="header-wrapper-row__links">
                        <router-link v-if="!isLogged" class="header-link" to="/login">Login</router-link>
                        <router-link v-if="!isLogged" class="header-link" to="/register">Register</router-link>

                        <router-link v-if="isLogged" class="header-link" to="/create-appointment">Create new</router-link>
                        <div @click="logout" v-if="isLogged" class="header-link">Logout</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                isLogged: false
            }
        },

        created() {
            this.isLoggedIn()
        },

        watch: {
            '$route': {
                handler: 'isLoggedIn',
                immediate: true
            }
        },

        methods: {
            isLoggedIn() {
                return this.isLogged = (localStorage.getItem('token') != null);
            },
            logout() {
                localStorage.clear();
                this.isLoggedIn();
                this.$router.push('/login');
            }
        }
    }
</script>
