<template>
    <div class="text-right">
        <router-link :to="{name: 'IndexProduct'}" class="btn btn-primary">لیست محصولات</router-link>
        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">اضافه کردن محصول</h1>
                                    </div>
                                    <form @submit.prevent="productInsert">
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-right" placeholder="نام محصول را وارد کنید" v-model="form.product_name">
                                                    <small v-if="errors.product_name" class="text-danger">{{ errors.product_name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-right" placeholder="کد محصول را وارد کنید" v-model="form.product_code">
                                                    <small v-if="errors.product_code" class="text-danger">{{ errors.product_code[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1">دسته بندی محصول را انتخاب کنید</label>
                                                        <select class="form-control" id="exampleFormControlSelect1"  v-model="form.category_id">
                                                            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.category_name }}</option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.category_id" class="text-danger">{{ errors.category_id[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect2">فروشنده محصول را انتخاب کنید</label>
                                                        <select class="form-control" id="exampleFormControlSelect2"  v-model="form.supplier_id">
                                                            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.supplier_id" class="text-danger">{{ errors.supplier_id[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-right" placeholder="قیمت خرید محصول را وارد کنید" v-model="form.buying_price">
                                                    <small v-if="errors.buying_price" class="text-danger">{{ errors.buying_price[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-right" placeholder="قیمت فروش محصول را وارد کنید" v-model="form.selling_price">
                                                    <small v-if="errors.selling_price" class="text-danger">{{ errors.selling_price[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="buying_date">تاریخ خرید محصول را وارد کنید</label>
                                                    <input type="date" id="buying_date" class="form-control text-right" placeholder="تاریخ خرید محصول را وارد کنید" v-model="form.buying_date">
                                                    <small v-if="errors.buying_date" class="text-danger">{{ errors.buying_date[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="product_quantity">تعداد محصول را وارد کنید</label>
                                                    <input type="text" id="product_quantity" class="form-control text-right" placeholder="تعداد محصول را وارد کنید" v-model="form.product_quantity">
                                                    <small v-if="errors.product_quantity" class="text-danger">{{ errors.product_quantity[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
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
            this.getAllCategories()
            this.getAllSuppliers()
        },
        data(){
            return{
                form:{
                    category_id:null,
                    product_name:null,
                    product_code:null,
                    buying_price:null,
                    selling_price:null,
                    supplier_id:null,
                    buying_date:null,
                    product_quantity:null,
                },
                photo:null,
                file:null,
                categories:[],
                suppliers:[],
                errors:{}
            }
        },
        methods:{
            getAllCategories(){
                axios.get('/api/category')
                    .then(res => this.categories = res.data)
                    .catch(err => console.log(err))
            },
            getAllSuppliers(){
                axios.get('/api/supplier')
                    .then(res => this.suppliers = res.data)
                    .catch(err => console.log(err))
            },
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
            productInsert: function () {
                if (this.file) {
                    const config = {
                        headers: {'content-type': 'multipart/form-data'}
                    }
                    let formData = new FormData();
                    formData.append('file', this.file);
                    for (let key in this.form) {
                        formData.append(key, this.form[key] === null ? '' : this.form[key])
                    }
                    this.postSupplierData(formData,config);
                } else {
                    this.postSupplierData(this.form);
                }
            },
            postSupplierData(dataVal, ConfigProperty = null)
            {
                console.log(this.form);
                axios.post('/api/product', dataVal, ConfigProperty)
                    .then(res => {
                        this.$router.push({name: 'IndexProduct'});
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
