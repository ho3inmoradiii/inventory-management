
<template>

    <div>
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">POS</h1>
            </div>

            <div class="row mb-3">
                <div class="col-xl-5 col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                            <router-link :to="{name: 'CreateCustomer'}" class="btn btn-sm btn-info"><font color="#ffffff">اضافه کردن مشتری</font></router-link>

                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th>نام</th>
                                    <th>تعداد</th>
                                    <th>واحد</th>
                                    <th>مجموع</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody style="font-size: 13px;">
                                <tr v-for="cart in carts" :key="cart.id">
                                    <th>{{ cart.pro_name }}</th>
                                    <th>
                                        <button @click="increment(cart.id)" class="btn btn-success btn-sm">+</button>
                                        <input style="width: 25px;text-align: center" type="text" readonly :value="cart.pro_quantity">
                                        <button @click="decrement(cart.id)" class="btn btn-danger btn-sm" :disabled="cart.pro_quantity == 1 ? true : false">-</button>
                                    </th>
                                    <th>{{ cart.product_price }}</th>
                                    <th>{{ cart.sub_total }}</th>
                                    <td><a @click.prevent="removeItem(cart.id)" class="btn btn-sm btn-primary">x</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <ul class="list-group p-0">
                                <li class="list-group-item d-flex justify-content-between align-items-center">مجموع تعداد:
                                    <strong>{{ qty }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">مجموع هزینه:
                                    <strong>{{ subtotal }} $</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">مالیات:
                                    <strong>{{ vats.vat }} % </strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">مجموع:
                                    <strong>{{ (subtotal * vats.vat)/100 + subtotal }} $</strong>
                                </li>
                            </ul>
                            <br>

                            <form>
                                <label>مشتری</label>
                                <select class="form-control" v-model="customer_id">
                                    <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{ customer.name }}</option>
                                </select>
                                <label>پرداخت</label>
                                <input type="text" class="form-control" required v-model="pay">
<!--                                <label>پرداخت</label>-->
<!--                                <input type="text" class="form-control" required v-model="pay">-->
                                <label>نحوه پرداخت</label>
                                <select class="form-control" v-model="payby">
                                    <option value="HandCash">نقدی</option>
                                    <option value="Cheaque">چک</option>
                                    <option value="GiftCard">کارت هدیه</option>
                                </select>
                                <button type="submit" class="btn btn-success mt-3">تایید</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">محصولات قابل فروش</h6>
                        </div>
                        <!--  Category Wise Product -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">همه محصولات</a>
                            </li>
                            <li class="nav-item" v-for="category in categories" :key="category.id">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" @click="subproduct(category.id)" >{{ category.category_name }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <div class="card-body">
                                    <input type="text" v-model="searchTerm" class="form-control" style="width: 560px;" placeholder="جستجوی محصول">

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in filtersearch" :key="product.id">
                                            <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                                <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                                    <img :src="product.image" class="card-img-top em_photo">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ product.product_name }}</h6>
                                                        <span class="badge badge-success" v-if="product.product_quantity  >= 1 ">موجود ({{ product.product_quantity }})  </span>
                                                        <span class="badge badge-danger" v-else=" ">ناموجود</span>

                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                <div class="card-body">
                                    <input type="text" v-model="getsearchTerm" class="form-control" style="width: 560px;" placeholder="جستجوی محصول">

                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getproduct in getfiltersearch" :key="getproduct.id">
                                            <button class="btn btn-sm" @click.prevent="AddToCart(getproduct.id)">
                                                <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                                    <img :src="getproduct.image" class="card-img-top em_photo">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ getproduct.product_name }}</h6>
                                                        <span class="badge badge-success" v-if="getproduct.product_quantity  >= 1 ">موجود ({{ getproduct.product_quantity }})  </span>
                                                        <span class="badge badge-danger" v-else=" ">ناموجود</span>

                                                    </div>
                                                </div>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



        </div>
        <!--Row-->



    </div>


</template>



<script type="text/javascript">

    export default {
        created(){
            this.allProduct();
            this.allCategory();
            this.allCustomer();
            this.vat();
            this.cartProduct();
            Reload.$on('AfterAdd',() =>{
                this.cartProduct();
            })

        },
        data(){
            return{
                customer_id:'',
                pay:'',
                due:'',
                payby:'',

                products:[],
                categories:[],
                customers:[],
                getproducts:[],
                searchTerm:'',
                getsearchTerm:'',
                errors:'',
                carts:[],
                vats:''

            }
        },
        computed:{
            filtersearch(){
                return this.products.filter(product => {
                    return product.product_name.match(this.searchTerm)
                })
            },
            getfiltersearch(){
                return this.getproducts.filter(getproduct => {
                    return getproduct.product_name.match(this.getsearchTerm)
                })
            },
            qty(){
                let sum = 0;
                for(let i = 0; i < this.carts.length; i++){
                    sum += (parseFloat(this.carts[i].pro_quantity));
                }
                return sum;
            },
            subtotal(){
                let sum = 0;
                for(let i = 0; i < this.carts.length; i++){
                    sum += (parseFloat(this.carts[i].pro_quantity) * parseFloat(this.carts[i].product_price));
                }
                return sum;

            },

        },

        methods:{
            // Cart Methods Here
            AddToCart(id){
                axios.get('/api/addToCart/'+id)
                    .then(() => {
                        // this.$router.go({name: 'POS'})
                        Reload.$emit('AfterAdd');
                        Notification.cart_success()
                    })
                    .catch()
            },
            cartProduct(){
                axios.get('/api/cart/product')
                    .then(({data}) => (this.carts = data))
                    .catch()
            },
            removeItem(id){
                axios.get('/api/remove/cart/'+id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.cart_delete()
                    })
                    .catch()
            },
            increment(id){
                axios.get('/api/increment/'+id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.success()
                    })
                    .catch()
            },
            decrement(id){
                axios.get('/api/decrement/'+id)
                    .then(() => {
                        Reload.$emit('AfterAdd');
                        Notification.success()
                    })
                    .catch()
            },
            vat(){
                axios.get('/api/vats/')
                    .then(({data}) => (this.vats = data))
                    .catch()
            },
            orderdone(){
                let total = this.subtotal*this.vats.vat /100 + this.subtotal;
                var data = {qty:this.qty, subtotal:this.subtotal, customer_id:this.customer_id, payby:this.payby, pay:this.pay, due:this.due, vat:this.vats.vat, total:total }

                axios.post('/api/orderdone',data)
                    .then(() => {
                        Notification.success()
                        this.$router.push({name: 'home'})
                    })

            },

            // End Cart Methods
            allProduct(){
                axios.get('/api/product/')
                    .then(({data}) => (this.products = data))
                    .catch()
            },
            allCategory(){
                axios.get('/api/category/')
                    .then(({data}) => (this.categories = data))
                    .catch()
            },
            subproduct(id){
                axios.get('/api/getting/product/'+id)
                    .then(({data}) => (this.getproducts = data))
                    .catch()
            },
            allCustomer(){
                axios.get('/api/customer')
                    .then(({data}) => (this.customers = data))
                    .catch()
            }
        }

    }

</script>


<style type="text/css" scoped>
    .em_photo{
        height: 100px;
        width: 135px;
    }
</style>
