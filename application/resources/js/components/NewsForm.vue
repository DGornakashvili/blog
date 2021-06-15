<template>
    <form @submit.prevent="submit">
        <div v-if="success" class="alert alert-success mt-3">
            Success!
        </div>

        <input type="hidden" name="main_image" id="main_image" v-model="fields.main_image"/>

        <div class="form-group">
            <label for="header">Header</label>
            <input type="text" class="form-control" name="header" id="header" v-model="fields.header"/>
            <div v-if="errors && errors.header" class="text-danger">{{ errors.header[0] }}</div>
        </div>

        <div class="form-group" v-if="fields.slug">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" name="slug" id="slug" v-model="fields.slug"/>
            <div v-if="errors && errors.slug" class="text-danger">{{ errors.slug[0] }}</div>
        </div>

        <div class="form-group">
            <label for="image"><img class="col-md-3" :src="imageSrc"></label>
            <input type="file" name="file" class="form-control-file" id="image" @change="uploadFile"/>
            <div v-if="errors && errors.main_image" class="text-danger">{{ errors.main_image[0] }}</div>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" v-model="fields.content"></textarea>
            <div v-if="errors && errors.content" class="text-danger">{{ errors.content[0] }}</div>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</template>

<script>
export default {
    name: 'NewsForm',
    props: {
        id: 0,
    },
    data() {
        return {
            fields: {
                header: '',
                slug: '',
                content: '',
                main_image: '',
            },
            errors: {},
            success: false,
            loaded: true,
            imageSrc: '',
        }
    },
    mounted() {
        this.loadNews();
    },
    methods: {
        loadNews: function () {
            if (!!this.id) {
                axios.get('/admin/news/show/' + this.id)
                    .then(response => {
                        this.fields = response.data.data;
                        this.imageSrc = '/storage/' + this.fields.main_image;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                let url = '/admin/news/store/';

                if (this.id) {
                    url = '/admin/news/update/' + this.id;
                }

                axios.post(url, this.fields)
                    .then(response => {
                        if (response.data.status) {
                            this.success = true;
                            this.loaded = true;

                            setTimeout(() => {
                                window.location.href = '/admin/news/';
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

                axios.post('/admin/news/upload/', fd)
                    .then(response => {
                        if (response.status) {
                            this.loaded = true;
                            this.$set(this.fields, 'main_image', response.data.data);
                            this.imageSrc = '/storage/' + this.fields.main_image;
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
