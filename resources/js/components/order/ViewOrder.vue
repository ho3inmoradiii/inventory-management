<template>
    <div class="text-right">
        <router-link :to="{name: 'Orders'}" class="btn btn-primary">لیست سفارشات</router-link>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">جزئیات سفارش</h1>
                            </div>
                            <!-- Simple Tables -->
                            <div class="col-lg-6 mb-4">
                                <!-- Simple Tables -->
                                <div class="card">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات مشتری</h6>
                                    </div>
                                    <div class="table-responsive">
                                        <ul class="list-group p-0" v-if="customer">
                                            <li class="list-group-item"><b>نام : </b>{{ customer.name }}</li>
                                            <li class="list-group-item"><b>شماره تماس : </b>{{ customer.phone }}</li>
                                            <li class="list-group-item"><b>آدرس : </b>{{ customer.address }}</li>
                                            <li class="list-group-item"><b>تاریخ خرید : </b>{{ customer.order_date }}</li>
                                            <li class="list-group-item"><b>نحوه پرداخت : </b>{{ customer.payby }}</li>
                                        </ul>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <!-- Simple Tables -->
                                <div class="card">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">اطلاعات پرداخت </h6>
                                    </div>
                                    <div class="table-responsive">
                                        <ul class="list-group p-0" v-if="customer">
                                            <li class="list-group-item"><b>مجموع هزینه بدون احتساب مالیات : </b>{{ customer.sub_total }}$</li>
                                            <li class="list-group-item"><b>مالیات : </b>{{ customer.vat }}%</li>
                                            <li class="list-group-item"><b>مجموع هزینه با احتساب مالیات : </b>{{ customer.total }}$</li>
                                            <li class="list-group-item"><b>هزینه پرداخت شده : </b>{{ customer.pay }}$</li>
                                        </ul>
                                    </div>
                                    <div class="card-footer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">جزئیات سفارش</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>نام محصول</th>
                                <th>کد محصول</th>
                                <th>عکس محصول</th>
                                <th>تعداد سفارش</th>
                                <th>قیمت واحد</th>
                                <th>قیمت مجموع</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="detail in details" :key="detail.id">
                                <td>{{ detail.product_name }}</td>
                                <td>{{ detail.product_code }}</td>
                                <td><img :src="'/'+detail.image" id="em_photo"></td>
                                <td>{{ detail.pro_quantity }}</td>
                                <td>{{ detail.product_price }} $</td>
                                <td>{{ detail.sub_total }} $</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.getCustomerDetail();
            this.getOrderDetails();
        },
        data(){
            return{
                customer:null,
                details: {},
            }
        },
        methods:{
            getCustomerDetail(){
                axios.get('/api/order/customer/'+this.$route.params.id)
                    .then(res => this.customer = res.data)
                    .catch(err => console.log(err))
            },
            getOrderDetails(){
                axios.get('/api/order/details/'+this.$route.params.id)
                    .then(res => {
                        this.details = res.data
                        console.log(this.details)
                    })
                    .catch(err => console.log(err))
            },
        }
    }
</script>

<style type="text/css">
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
