<template>
    <div class="text-right">
<!--        <router-link :to="{name: 'CreateProduct'}" class="btn btn-primary">اضافه کردن محصول</router-link>-->

        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Simple Tables -->
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between dir-rtl">
                                        <h6 class="font-weight-bold text-primary text-right mt-2">فروش امروز</h6>
                                        <input v-model="searchBox" style="width: 300px" placeholder="جستجو" class="form-control" type="text">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush dir-rtl">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>نام سفارش دهنده</th>
                                                <th>مجموع خرید</th>
                                                <th>مبلغ پرداختی</th>
                                                <th>نحوه پرداخت</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="order in filteredOrders" :key="order.id">
                                                <td>{{ order.name }}</td>
                                                <td>{{ order.total }}</td>
                                                <td>{{ order.pay }}</td>
                                                <td>{{ order.payby }}</td>
                                                <td>
                                                    <router-link :to="{name: 'ViewOrder', params: { id: order.id }}" class="btn btn-sm btn-outline-primary">نمایش</router-link>
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
            this.getTodayOrders();
        },
        data(){
            return{
                orders:[],
                searchBox:null
            }
        },
        methods:{
            getTodayOrders(){
                axios.get('/api/orders')
                    .then(res => {
                        this.orders = res.data
                    })
                    .catch(err => console.log(err));
            },
        },
        computed:{
            filteredOrders(){
                if (this.searchBox){
                    return this.orders.filter(order => {
                        return order.name.match(this.searchBox)
                    })
                }else {
                    return this.orders
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
