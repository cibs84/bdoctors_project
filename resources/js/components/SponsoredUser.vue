<template>
    <div class="carousel d-flex">
        <div v-for="(user, index) in users" :key="index">    
            <div class="card" style="width: 12rem;">
                <img :src="user.user_photo" class="card-img-top" alt="..." style="width:190px; height:190px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">{{user.user_name}}</h5>
                    <p class="card-text">{{user.specialization_slug}}</p>
                    <div class="card-text mb-3">{{user.user_email}}</div>

                    <router-link class="btn btn-primary" 
                        :to="{
                            name: 'single-profile', 
                            params: {user_slug: user.user_slug}
                        }">
                        Scopri di più
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SponsoredUser',
    data() {
        return {
            users: []
        }   
    },
    methods: {
        getSponsoredUsers() {
            axios.get('/api/sponsored-users', {
                
            })
            .then((response) => {
                this.users = response.data.results.users;
                this.specializations = response.data.results.specializations;

                // console.log('response.data.results.users', response.data.results.users)
                // console.log('response.data.results.specializations', response.data.results.specializations)

            });
        },
    },
    mounted() {
        this.getSponsoredUsers();
    }
}
</script>

<style lang="scss" scoped>
.carousel {
    overflow-x: scroll;
    position: relative;
    &::-webkit-scrollbar {
        display: none;
    }
    .card {
        
        margin-inline: 1rem;
    }
}
</style>