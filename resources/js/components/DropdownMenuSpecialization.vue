<template>
    <!-- lista specializzazioni -->
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle mb-4" type="button" data-toggle="dropdown">Specializzazioni
        <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li class="mr-5" v-for="(specialization, index) in specializations" :key="index">
                <router-link class="text-dark specialization-name" value="Reload Page" onClick="document.location.reload(true)"
                    :to="{name:'advanced-search', params:{specialization_slug: specialization.slug} }">
                        {{specialization.name}}
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'DropdownMenuSpecialization',
    data() {
        return {
            specializations: [],
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