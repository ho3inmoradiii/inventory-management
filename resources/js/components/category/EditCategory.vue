<template>
    <div class="text-right">
        <router-link :to="{name: 'IndexCategory'}" class="btn btn-primary">لیست دسته بندی ها</router-link>
        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">ویرایش دسته بندی</h1>
                                    </div>
                                    <form @submit.prevent="categoryUpdate">
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control text-right" placeholder="نام دسته بندی را وارد کنید" v-model="form.category_name">
                                                    <small v-if="errors.category_name" class="text-danger">{{ errors.category_name[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">تایید</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.getSingleCategory();
        },
        data(){
            return{
                form:{
                    category_name:null,
                },
                errors: {}
            }
        },
        methods:{
            getSingleCategory(){
                axios.get('/api/category/' + this.$route.params.id)
                    .then(res => {
                        this.form = res.data
                    })
                    .catch(err => console.log(err))
            },
            categoryUpdate: function () {
                    let formData = new FormData();
                    for (let key in this.form) {
                        formData.append(key, this.form[key] === null ? '' : this.form[key])
                    }
                    formData.append('_method', 'PUT')
                axios.post('/api/category/' + this.$route.params.id, formData)
                    .then(res => {
                        this.$router.push({name: 'IndexCategory'});
                        Notification.success();
                    })
                    .catch(err => {
                        this.errors = err.response.data.errors;
                    })
                // if (this.file) {
                //     const config = {
                //         headers: {'content-type': 'multipart/form-data'}
                //     }
                //     let formData = new FormData();
                //     formData.append('file', this.file);
                //     for (let key in this.form) {
                //         formData.append(key, this.form[key] === null ? '' : this.form[key])
                //     }
                //     formData.append('_method', 'PUT')
                //     this.postSupplierData(formData,config);
                // } else {
                //     let formData = new FormData();
                //     for (let key in this.form) {
                //         formData.append(key, this.form[key] === null ? '' : this.form[key])
                //     }
                //     formData.append('_method', 'PUT');
                //     this.postSupplierData(formData);
                // }
            },
            // postSupplierData(dataVal, ConfigProperty = null)
            // {
            //     axios.post('/api/supplier/' + this.$route.params.id,dataVal,ConfigProperty)
            //         .then(res => {
            //             this.$router.push({name: 'IndexSupplier'});
            //             Notification.success();
            //         })
            //         .catch(err => {
            //             this.errors = err.response.data.errors;
            //         })
            // }
        }
    }
</script>

<style>

</style>
