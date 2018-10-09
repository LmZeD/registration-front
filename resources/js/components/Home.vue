<template>
    <div class="home-wrapper">
        <div class="container">
            <div class="homer-holder">
                <div class="home-holder__legend">
                    <div class="appointments-holder-section__card--upcoming">
                        Upcoming
                    </div>
                    <div class="appointments-holder-section__card--ongoing">
                        Ongoing
                    </div>
                    <div class="appointments-holder-section__card--ended">
                        Finished
                    </div>
                    <div class="appointments-holder-section__card--to-me">
                        To me
                    </div>
                    <div class="appointments-holder-section__card--canceled">
                        Canceled
                    </div>
                </div>
                <appointments></appointments>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showError: false,
                showSuccess: false,
                errorMessage: '',
                successMessage: ''
            }
        },

        created() {

        },

        methods: {

        }
    }
</script>
