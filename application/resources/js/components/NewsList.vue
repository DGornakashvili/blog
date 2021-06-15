<template>
    <div class="col-md-12">
        <div class="row justify-content-center">
            <a :href="'/admin/news/create/'" class="mb-4 btn btn-success">Create</a>
        </div>
        <div class="row justify-content-center" :class="{'loading': loading}">
            <div class="col-md-8">
                <div class="list-group">
                    <div class="list-group-item list-group-item-light list-group-item-action" v-for="(newsItem, index) in news">
                        <div class="col-md-9 d-inline-block">{{ newsItem.header }}</div>
                        <a :href="'/admin/news/edit/' + newsItem.id" class="align-self-end btn btn-primary">Edit</a>
                        <a :href="'/admin/news/delete/' + newsItem.id" :id="index" @click.prevent="deleteNews" class="align-self-end btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="success" class="alert alert-success mt-3">
            Success!
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            news: [],
            loading: true,
            success: false,
        };
    },
    mounted() {
        this.loadNews();
    },
    methods: {
        loadNews: function () {
            axios.get('/news')
                .then(response => {
                    this.news = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        deleteNews(event) {
            axios.post(event.target.href)
                .then(response => {
                    if (response.data.status) {
                        this.success = true;
                        this.news.splice(event.target.id, 1);

                        setTimeout(() => {
                            this.success = false;
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
}
</script>
