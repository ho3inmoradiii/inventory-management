<template>
    <div class="text-right">
        <router-link :to="{name: 'IndexCustomer'}" class="btn btn-primary">لیست سفارش دهندگان</router-link>
        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">اضافه کردن سفارش دهنده</h1>
                                    </div>
                                    <form @submit.prevent="customerInsert" enctype="multipart/form-data">
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-right" placeholder="نام را وارد کنید" v-model="form.name">
                                                    <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" class="form-control text-right" aria-describedby="emailHelp" placeholder="ایمیل را وارد کنید" v-model="form.email">
                                                    <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-right" placeholder="شماره تماس را وارد کنید" v-model="form.phone">
                                                    <small v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</small>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                                    <label class="custom-file-label" for="customFile" style="padding-right: 85px;">تصویر اضافه کنید</label>
                                                    <small v-if="errors.photo" class="text-danger">{{ errors.photo[0] }}</small>
                                                </div>
                                                <div class="col-md-1">
                                                    <img :src="photo" style="width: 40px;height: 40px;" v-if="photo">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-right" placeholder="آدرس را وارد کنید" v-model="form.address">
                                                    <small v-if="errors.address" class="text-danger">{{ errors.address[0] }}</small>
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
                    name:null,
                    email:null,
                    address:null,
                    phone:null,
                },
                photo:null,
                file:null,
                errors:{}
            }
        },
        methods:{
            onFileSelected(event){
                let file = event.target.files[0];
                if (file.size > 1048770) {
                    Notification.image_validation()
                }else{
                    let reader = new FileReader();
                    reader.onload = event =>{
                        this.photo = event.target.result
                    };
                    reader.readAsDataURL(file);
                }
                this.file = event.target.files[0];
            },
            customerInsert: function () {
                if (this.file) {
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    }
                    let formData = new FormData();
                    formData.append('file', this.file);
                    for (let key in this.form) {
                        formData.append(key, this.form[key] === null ? '' : this.form[key])
                    }
                    this.postCustomerData(formData,config);
                } else {
                    this.postCustomerData(this.form);
                }
            },
            postCustomerData(dataVal, ConfigProperty = null)
            {
                axios.post('/api/customer', dataVal, ConfigProperty)
                    .then(res => {
                        this.$router.push({name: 'IndexCustomer'});
                        Notification.success();
                    })
                    .catch(err => {
                        this.errors = err.response.data.errors;
                    })
            }
        }
    }
</script>

<style>

</style>
