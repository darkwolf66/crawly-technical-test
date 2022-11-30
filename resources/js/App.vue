<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-xl-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h2>Crawly Technical Challenge</h2>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-success" v-on:click="getAnswer" :disabled="loading">{{!loading ? 'Retrieve the Current Answer' : 'Processing..'}}</button>
                    </div>
                </div>
                <div class="card mt-3" v-if="answer">
                    <div class="card-body">
                        <h2>The current answer is {{answer}}</h2>
                    </div>
                </div>
                <div class="alert alert-danger mt-3" v-if="error">
                    <b>An error occurred:</b>
                    <div>
                        {{error}}
                    </div>
                    <div>
                        {{error.response.data}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    data(){
        return {
            answer: null,
            error: null,
            loading: false
        }
    },
    methods:{
        async getAnswer(){
            this.answer = null
            this.error = null
            this.loading = true
            try {
                let res = await axios.get('/crawly-answer')
                this.answer = res.data.answer
            }catch (e) {
                this.error = e
            }
            this.loading = false
        }
    }
}
</script>

<style scoped>

</style>
