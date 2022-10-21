<template>
    <section>
        <section class="main-content">
            <!-- page title -->
            <div class="text-center">
                <h2 class="mt-3 text-primary">Benvenuti su BDoctors</h2>

                <p class="mt-3" >
                    Benvenuto nel sito BDoctors, dove puoi trovare la miglior scelta per la tua esigenza.
                </p>
            </div>

            <!-- image -->
            <section class="progress" style="height: 350px;">
                <img src="https://images.theconversation.com/files/59470/original/bmc3zndq-1411073854.jpg?ixlib=rb-1.1.0&q=45&auto=format&w=1200&h=1200.0&fit=crop" alt="">
                <img src="https://dr-olivier-clinic.com/wp-content/uploads/2014/10/different-doctors.jpg" alt="">
                <img src="https://img.freepik.com/free-photo/doctor-nurses-special-equipment_23-2148980721.jpg?w=2000" alt="">
                <img src="https://welpmagazine.com/wp-content/uploads/2020/09/becoming-doctor.jpg" alt="">
                <img src="https://www.optimahealth.com/_assets/images/group-of-doctors-card.jpg" alt="">   
            </section>

            <!-- ricerca avanzata per specializzazioni -->
            <section class="bg-info mt-3 text-center">
                <h5 class="py-3 text-light specialization-doctor">Ricerca qui medici per specializzazione</h5>
                <DropdownMenuSpecialization/>
            </section> 

            <!-- utenti Sponsorizzati -->
            <div class="container-lg">
                <h2 class="text-center my-2 text-primary">Medici in evidenza</h2>
                
                <SponsoredUser/>
            </div>

            <!-- about us -->
            <section class="about-us my-5">
                <div class="container">
                    <h3 class="text-primary text-center">
                        Dicono di noi 
                    </h3>

                    <div class="row justify-content-between">
                        <!-- left col with image  -->
                        <div class="col-image col col-sm-12 col-md-6 col-lg-6">
                            <img style="height: 200px;" src="https://www.ges-tt.com/wp-content/uploads/2020/11/recensioni-positive-google-perche-sono-importanti-come-gestirle.jpg" alt="reviews">
                        </div>
        
                        <!-- right col with text -->
                        <div class="col col-sm-12 col-md-5 col-lg-6">
                            <h5>
                                Oltre il 90% di pazienti soddisfatti.
                            </h5>

                            <p>
                                BDoctors è un nuovo sito in Italia di prenotazioni di visite mediche ed esami diagnostici, online dal 2022.
                                Crediamo nell'importanza dell'informazione e della trasparenza per aiutare i pazienti a scegliere il medico giusto tra gli oltre 9.000 presenti su BDoctors.
                                Per questo su BDoctors, solo i pazienti che hanno prenotato attraverso il sito e svolto la prestazione possono rilasciare un feedback sul medico: una garanzia dell'affidabilità delle 13.553 recensioni che leggi.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </section>

        <Footer/>
        
    </section>
</template>

<script>
import Footer from '../components/Footer.vue';
import DropdownMenuSpecialization from '../components/DropdownMenuSpecialization.vue';
import SponsoredUser from '../components/SponsoredUser.vue';

export default {
    name: 'HomePage',
    components: {
        Footer,
        DropdownMenuSpecialization,
        SponsoredUser
    },
    data() {
        return {
            users: [],
        }
    },
}
</script>

<style lang="scss" scoped>
@media screen and (min-width:568px) {
    .about-us {
        .row {
            justify-content: center;

            .col-image {
                display: flex;
                justify-content: center;
            }
        }
    }
}
</style>