<template>
    <div class="container">
        <h2 class="mb-4">{{user.name}}</h2>

        <!-- user profile and reviews -->
        <div class="row mb-5">

            <div class="col-12 col-lg-5" id="profile-col">
                <div class="d-flex">
                    <div class="card" style="width: 30rem;">
                        <img :src="user.photo" class="card-img-top" alt="..."> 
                        <div class="card-body">
                            <h5 class="card-title">{{user.name}}</h5>
                            <div v-if="user && user.specializations && user.specializations.length > 0">
                                <strong>Specializzazione in</strong>
                                <span v-for="specialization in user.specializations" :key="specialization.id" class="badge bg-info text-light mr-1 mb-3">{{specialization.name}}</span>
                            </div>
                            <div class="mb-3"><strong>Contatta il medico al seguente indirizzo:</strong> {{user.email}}</div>
                            <p><strong class="d-block">Curriculum Vitae</strong>{{user.curriculum}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- reviews -->
            <div class="col-12 col-lg-7">
                <div class="row" id="reviews-col">
                    <div class="review-col d-flex h-100" >
                        <div v-for="(review, index) in user.reviews" :key="index">
                            <div class="review-card card text-dark bg-light mb-3">
                                <!-- card header -->
                                <div class="card-header">Recensione</div>

                                <!-- card body -->
                                <div class="card-body">
                                    <!-- autore della recensione -->
                                    <h5 class="card-title">{{ review.author }}</h5>
                                    <!-- voto -->
                                    <div><strong>Voto</strong>: <i v-for="n in stars(review.vote)" :key="n" class="fas fa-star active"></i></div>
                                    
                                    <!-- recensione -->
                                    <p class="card-text">{{ review.content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- message and revies forms -->
        <div class="row forms_row mb-3">
            <!-- FORM MESSAGGIO -->
            <div class="col">
                
                <div v-if='success_message' class="alert alert-success" role="alert">
                    Grazie per averci contattato!
                </div>

                <h4>Scrivi un messaggio al medico</h4>

                <form @submit.prevent="sendMessage()">
                    <div class="mb-3">
                        <label for="author-message" class="form-label">Nome e cognome *</label>
                        <input v-model="authorMessage" type="text" class="form-control" id="author-message" required>

                        <!-- Messaggio d'errore -->
                        <div v-if="errors.author">
                            <div v-for="(error, index) in errors.author" :key="index" class="alert alert-danger" role="alert">
                                {{ error }}
                            </div>  
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="user-mail" class="form-label">Email *</label>
                        <input v-model="userEmail" type="email" class="form-control" id="user-mail" required>

                        <div v-if="errors.email">
                            <div v-for="(error, index) in errors.email" :key="index" class="alert alert-danger" role="alert">
                                {{ error }}
                            </div>  
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="content-message" class="form-label">Messaggio *</label>
                        <textarea v-model="contentMessage" class="form-control" id="content-message" rows="8" required></textarea>

                        <div v-if="errors.content">
                            <div v-for="(error, index) in errors.content" :key="index" class="alert alert-danger" role="alert">
                                {{ error }}
                            </div>  
                        </div>
                    </div>
                    
                    <!-- Submit -->
                    <input type="submit" value="Invia Messaggio" class="btn btn-primary" :disabled="sending">
                </form>
            </div>

            <!-- FORM RECENSIONE -->
            <div class="col">
                <div v-if='success_review' class="alert alert-success" role="alert">
                    Grazie per averci recensito e dato un voto!
                </div>

                <h4>Scrivi una recensione</h4>

                <form @submit.prevent="sendReview()">
                    <div class="mb-3">
                        <label for="author-review" class="form-label">Nome e cognome *</label>
                        <input v-model="authorReview" type="text" class="form-control" id="author-review" required>

                        <div v-if="errors.author">
                            <div v-for="(error, index) in errors.author" :key="index" class="alert alert-danger" role="alert">
                                {{ error }}
                            </div>  
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="content-review" class="form-label">Recensione *</label>
                        <textarea v-model="contentReview" class="form-control" id="content-review" rows="8" required></textarea>

                        <div v-if="errors.content">
                            <div v-for="(error, index) in errors.content" :key="index" class="alert alert-danger" role="alert">
                                {{ error }}
                            </div>  
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="average_vote" style="cursor:pointer"> 
                            <span class="bold_text">Vote</span>: 
                            <span class="star_icon " :class="{ 'active': star <= voteReview }" v-for="(star,index) in 5" :key="index" @click.prevent="voteReview = star">
                                &#9733;
                            </span>
                        </div>

                        <div>
                            {{ voteReview }}
                        </div>

                        <div v-if="errors.vote">
                            <div v-for="(error, index) in errors.vote" :key="index" class="alert alert-danger" role="alert">
                                {{ error }}
                            </div>  
                        </div>
                    </div>

                    <!-- Submit -->
                    <input type="submit" value="Invia Recensione" class="btn btn-primary" :disabled="sending">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SingleProfile',
    data()  {
        return {
            user: {},
            authorMessage: '',
            userEmail: '',
            contentMessage: '',
            authorReview: '',
            contentReview: '',
            voteReview: 1,
            success_message: false, 
            success_review: false, 
            errors: {},
            sending: false,
            resize_ob: ''
        };
    },
    methods: {
        getSingleProfile() {
            axios.get('/api/users/' + this.$route.params.user_slug)
            .then((response) => {
                this.user = response.data.results;
            });
        },
        sendMessage() {
            console.log('sono in sendMessage()')
            console.log(this.authorMessage);
            console.log(this.userEmail);
            console.log(this.contentMessage);
            console.log(this.user.id);

            this.sending = true;
            this.success = false;

            axios.post('/api/messages', {
                author: this.authorMessage,
                email: this.userEmail,
                content: this.contentMessage,
                user_id: this.user.id
            })
            .then((response) => {
                console.log('then di sendMessage()');
                // this.scrollTopPage();

                if(response.data.success) {
                    this.success_message = true;
                    this.authorMessage = '';
                    this.userEmail = '';
                    this.contentMessage = '';
                    this.errors = {};
                } else {
                    this.errors = response.data.errors;
                }

                this.sending = false;
            })
        },
        sendReview() {
            console.log('sono in sendReview()')


            this.sending = true;

            axios.post('/api/reviews', {
                author: this.authorReview,
                content: this.contentReview,
                vote: this.voteReview,
                user_id: this.user.id
            })
            .then((response) => {
                console.log('then di sendReview()');
                // this.scrollToReview();

                if(response.data.success) {
                    this.success_review = true;
                    this.authorReview = '';
                    this.contentReview = '';
                    this.voteReview = 1;
                    this.errors = {};
                    this.getSingleProfile();
                } else {
                    this.errors = response.data.errors;
                }

                this.sending = false;
            })
        },
        stars(original_vote) {
            return Math.round(original_vote);
        }
    },
    created() {
        this.getSingleProfile();
    },
    mounted() {
        this.resize_ob = new ResizeObserver(function(entries) {
            let rect = entries[0].contentRect;
            let height = rect.height;

            document.getElementById('reviews-col').style.height = height + 'px';
            document.getElementById('reviews-col').style.maxHeight = height + 'px';
        });
        this.resize_ob.observe(document.getElementById('profile-col'));
    },
    beforeDestroy() {
        this.resize_ob.disconnect();
    }
}
</script>

<style lang="scss" scoped>
.review-card {
    margin-inline: 0.9rem;
    width: 18rem;
}

.star_icon {
    color: grey;
    cursor: pointer;
    font-size: 1.3rem;
}

.active {
    color: gold;
}

.forms_row {
    margin-top: 7rem;
}

#profile-col{
    display: flex;
    justify-content: center;
}

.review-col {
    justify-content: space-evenly;
    flex-wrap: wrap; 
    padding: 0; 
    overflow: auto;
}

@media screen and (min-width:568px) {
    #reviews-col {
        display: flex;
        justify-content: center;
        padding-top: 2rem;
    }
}
</style>