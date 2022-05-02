<template>
    <div>
        <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">تعداد فروش امروز</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ todaySell }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">فروش امروز</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ todayEarning }}$</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Simple Tables -->
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between dir-rtl">
                                        <h6 class="font-weight-bold text-primary text-right mt-2">لیست محصولات ناموجود</h6>
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
                                                <th>قیمت فروش</th>
                                                <th>وضعیت</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="product in products" :key="product.id">
                                                <td>{{ product.product_name }}</td>
                                                <td>{{ product.product_code }}</td>
                                                <td><img :src="product.image" id="em_photo"></td>
                                                <td>{{ product.category.category_name }}</td>
                                                <td>{{ product.supplier.name }}</td>
                                                <td>{{ product.selling_price }}</td>
                                                <td v-if="product.product_quantity  >= 1 ">
                                                    <span class="badge badge-success">موجود </span>
                                                </td>
                                                <td v-else>
                                                    <span class="badge badge-danger">ناموجود</span>
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
        data(){
            return{
                todaySell:null,
                todayEarning:null,
                products:null
            }
        },
        created() {
            this.todaySellMethod()
            this.todayEarnMethod()
            this.stockOutProduct()
        },
        methods:{
            todaySellMethod(){
                axios.get('/api/today/sell')
                .then(res => {
                    this.todaySell = res.data
                })
                .catch(err => console.log(err))
            },
            todayEarnMethod(){
                axios.get('/api/today/earning')
                    .then(res => {
                        this.todayEarning = res.data
                    })
                    .catch(err => console.log(err))
            },
            stockOutProduct(){
                axios.get('/api/pro/StockOut/')
                    .then(res => {
                        this.products = res.data
                    })
                    .catch(err => console.log(err))
            }
        }
    }
</script>

<style>

</style>
