<template>
    <form @submit.prevent="submit">
        <div v-if="success" class="alert alert-success mt-3">
            Success!
        </div>

        <input type="hidden" name="img" id="img" v-model="fields.img"/>

        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" v-model="fields.description"/>
            <div v-if="errors && errors.description" class="text-danger">{{ errors.description[0] }}</div>
        </div>

        <div class="form-group">
            <label for="image"><img class="col-md-3" :src="imageSrc"></label>
            <input type="file" name="file" class="form-control-file" id="image" @change="uploadFile"/>
            <div v-if="errors && errors.img" class="text-danger">{{ errors.img[0] }}</div>
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <select multiple="multiple" class="form-control" id="tags" name="tags" v-model="fields.tags">
                <option v-for="tag in tags" :value="tag.id" :selected="fields.tags.includes(tag.id)">{{ tag.name }}</option>
            </select>
            <div v-if="errors && errors.tags" class="text-danger">{{ errors.tags[0] }}</div>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</template>

<script>
export default {
    name: 'GalleriesForm',
    props: {
        id: 0,
    },
    data() {
        return {
            fields: {
                description: '',
                tags: [],
                img: '',
            },
            tags: Object,
            errors: {},
            success: false,
            loaded: true,
            imageSrc: '',
        }
    },
    mounted() {
        this.loadTags();
        this.loadGallery();
    },
    methods: {
        loadGallery: function () {
            if (!!this.id) {
                axios.get('/admin/galleries/show/' + this.id)
                    .then(response => {
                        this.fields = response.data.data;
                        this.imageSrc = '/storage/' + this.fields.img;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        loadTags: function () {
            axios.get('/tags')
                .then(response => {
                    this.tags = response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                let url = '/admin/galleries/store/';

                if (this.id) {
                    url = '/admin/galleries/update/' + this.id;
                }

                axios.post(url, this.fields)
                    .then(response => {
                        if (response.data.status) {
                            this.success = true;
                            this.loaded = true;

                            setTimeout(() => {
                                window.location.href = '/admin/galleries/';
                            }, 1000);
                        }
                    })
                    .catch(error => {
                        this.loaded = true;

                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
            }
        },
        uploadFile(event) {
            if (this.loaded) {
                this.loaded = false;
                const fd = new FormData();
                const file = event.target.files[0];
                fd.append('file', file, file.name);

                axios.post('/admin/galleries/upload/', fd)
                    .then(response => {
                        if (response.status) {
                            this.loaded = true;
                            this.$set(this.fields, 'img', response.data.data);
                            this.imageSrc = '/storage/' + this.fields.img;
                        }
                    })
                    .catch(error => {
                        this.loaded = true;

                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
            }
        },
    },
}
</script>
