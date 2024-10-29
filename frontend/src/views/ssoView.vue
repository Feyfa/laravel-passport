<template>
    <!-- <h1>Hello World</h1> -->
</template>

<script>
import axios from 'axios';

export default {
    mounted() {
        this.ssoTokenValidation();
    },

    methods: {
        ssoTokenValidation() {
            let access_token = this.$route.query.access_token;

            if(access_token) {
                axios.post('http://laravel-passport.com/api/v1/openapi/token/validation',{},{
                    headers: {
                        'Authorization': `Bearer ${access_token}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log(response);

                    if(response.status == 200) {
                        window.location.href = "/home";
                    }
                })
                .catch(error => {
                    console.error(error);

                    if(error.status == 401 && error.response.data.message == "Unauthenticated.") {
                        window.location.href = "/login";
                    }
                });
            } else {
                window.location.href = "/login";
            }
        },
    }
}
</script>