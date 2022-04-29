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
                                        <h1 class="h4 text-gray-900 mb-4">اضافه کردن دسته بندی</h1>
                                    </div>
                                    <form @submit.prevent="categoryInsert">
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
        data(){
            return{
                form:{
                    category_name:null,
                },
                errors:{}
            }
        },
        methods:{
            categoryInsert: function () {
                axios.post('/api/category', this.form)
                    .then(res => {
                        this.$router.push({name: 'IndexCategory'});
                        Notification.success();
                    })
                    .catch(err => {
                        this.errors = err.response.data.errors;
                    })
            },
        }
    }
</script>

<style>

</style>
