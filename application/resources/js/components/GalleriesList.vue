<template>
    <div class="col-md-12">
        <div class="row justify-content-center">
            <a :href="'/admin/galleries/create/'" class="mb-4 btn btn-success">Create</a>
        </div>
        <div class="row justify-content-center" :class="{'loading': loading}">
            <div class="col-md-8">
                <div class="list-group">
                    <div class="list-group-item list-group-item-light list-group-item-action"
                         v-for="(galleryItem, index) in gallery">
                        <div class="col-md-9 d-inline-block">{{ galleryItem.description }}</div>
                        <a :href="'/admin/galleries/edit/' + galleryItem.id" class="btn btn-primary">Edit</a>
                        <a :href="'/admin/galleries/delete/' + galleryItem.id" :id="index" @click.prevent="deleteGallery" class="btn btn-danger">Delete</a>
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
            gallery: [],
            loading: true,
            success: false,
        };
    },
    mounted() {
        this.loadGallery();
    },
    methods: {
        loadGallery: function () {
            axios.get('/admin/galleries/all')
                .then(response => {
                    this.gallery = response.data.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        deleteGallery(event) {
            axios.post(event.target.href)
                .then(response => {
                    if (response.data.status) {
                        this.success = true;
                        this.gallery.splice(event.target.id, 1);

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
