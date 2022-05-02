<template>
    <div class="text-right">
        <router-link class="collapse-item" :to="{name: 'Orders'}">سفارشات امروز</router-link>
        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">جستجوی سفارش</h1>
                                    </div>
                                    <form @submit.prevent="categoryInsert">
                                        <div class="form-group text-right dir-rtl">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label for="date">تاریخ مورد نظر را وارد کنید</label>
                                                    <input type="date" id="date" class="form-control text-right" v-model="form.date">
                                                    <small v-if="errors.date" class="text-danger">{{ errors.date[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">جستجو</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="orders">
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
                                <th>نام خریدار</th>
                                <th>تعداد خرید</th>
                                <th>مجموع هزینه با احتساب مالیات</th>
                                <th>مالیات</th>
                                <th>هزینه پرداخت شده</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="order in orders" :key="order.id">
                                <td>{{ order.name }}</td>
                                <td>{{ order.qty }}</td>
                                <td>{{ order.total }} $</td>
                                <td>{{ order.vat }}%</td>
                                <td>{{ order.pay }} $</td>
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
        name: "SearchOrder",
        data(){
            return{
                form:{
                    date:null,
                },
                orders:null,
                errors:{}
            }
        },
        methods:{
            categoryInsert: function () {
                axios.post('/api/order/search', this.form)
                    .then(res => {
                        this.orders = res.data
                        console.log(res.data)
                        //this.$router.push({name: 'IndexCategory'});
                        Notification.success();
                    })
                    .catch(err => {
                        this.errors = err.response.data.errors;
                    })
            },
        }
    }
</script>

<style scoped>

</style>
