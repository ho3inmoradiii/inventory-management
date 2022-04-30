<template>
    <div class="text-right">
        <router-link :to="{name: 'CreateProduct'}" class="btn btn-primary">اضافه کردن محصول</router-link>

        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Simple Tables -->
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between dir-rtl">
                                        <h6 class="font-weight-bold text-primary text-right mt-2">لیست محصولات</h6>
                                        <input v-model="searchBox" style="width: 300px" placeholder="جستجو" class="form-control" type="text">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush dir-rtl">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>نام</th>
                                                <th>کد</th>
                                                <th>تصویر</th>
                                                <th>دسته بندی</th>
                                                <th>فروشنده</th>
                                                <th>قیمت خرید</th>
                                                <th>قیمت فروش</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="product in filteredProduct" :key="product.id">
                                                <td>{{ product.product_name }}</td>
                                                <td>{{ product.product_code }}</td>
                                                <td><img :src="product.image" id="em_photo"></td>
                                                <td>{{ product.category.category_name }}</td>
                                                <td>{{ product.supplier.name }}</td>
                                                <td>{{ product.buying_price ? product.buying_price : '------' }}</td>
                                                <td>{{ product.selling_price }}</td>
                                                <td>
                                                    <router-link :to="{name: 'EditProduct', params: { id: product.id }}" class="btn btn-sm btn-outline-primary">ویرایش</router-link>
                                                    <a @click="removeProduct(product.id)" class="btn btn-sm btn-outline-danger">حذف</a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer"></div>
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
            this.getAllProducts();
        },
        data(){
            return{
                products:[],
                searchBox:null
            }
        },
        methods:{
            getAllProducts(){
                axios.get('/api/product')
                    .then(res => {
                        this.products = res.data
                    })
                    .catch(err => console.log(err));
            },
            removeProduct(identifier){
                Swal.fire({
                    title: 'آیا از حذف مطمئنی؟',
                    iconHtml: '؟',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'لغو',
                    confirmButtonText: 'حذف',
                    showCloseButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        let index = this.products.map(x => {
                            return x.id;
                        }).indexOf(identifier);
                        axios.delete('/api/product/' + identifier)
                            .then(res => {
                                this.products.splice(index,1);
                            })
                            .catch(err => {
                                this.$router.push({name: 'IndexProduct'})
                            })
                        Swal.fire(
                            'حذف شد!',
                        )
                    }
                })
            }
        },
        computed:{
            filteredProduct(){
                if (this.searchBox){
                    return this.products.filter(product => {
                        return product.product_name.match(this.searchBox)
                    })
                }else {
                    return this.products
                }
            }
        }
    }
</script>

<style>
    #em_photo{
        width: 40px;
        height: 40px;
    }
</style>
