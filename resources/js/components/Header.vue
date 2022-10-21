<template>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNavAltMarkup">

                    <div class="d-flex">
                        <div v-for="link, index in menuLinks" :key="index" class="navbar-nav">
                            <router-link :to="{name: link.name}" class="nav-link">{{link.label}}</router-link>
                        </div>
                    </div>

                    <div class="navbar-nav">
                        <ul class="list-unstyled d-flex">
                            <li class="p-3">
                                <a href="/login">Accedi</a>
                            </li>

                            <li class="p-3">
                                <a href="/register">Registrati</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    name: 'Header',
    data() {
        return {
            menuLinks: [
                {
                    name: 'homepage',
                    label: 'Homepage'
                },
                // {
                //     name: 'advanced-search',
                //     label: 'Cerca'
                // },

            ]
        }
    }
}
</script>