<template>
    <div class="text-right">
        <router-link :to="{name: 'CreateCustomer'}" class="btn btn-primary">اضافه کردن سفارش دهنده</router-link>

        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Simple Tables -->
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between dir-rtl">
                                        <h6 class="font-weight-bold text-primary text-right mt-2">لیست سفارش دهندگان</h6>
                                        <input v-model="searchBox" style="width: 300px" placeholder="جستجو" class="form-control" type="text">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush dir-rtl">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>نام</th>
                                                <th>تصویر</th>
                                                <th>شماره تماس</th>
                                                <th>ایمیل</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="customer in filteredCustomer" :key="customer.id">
                                                <td>{{ customer.name }}</td>
                                                <td><img :src="customer.photo" id="em_photo"></td>
                                                <td>{{ customer.phone }}</td>
                                                <td>{{ customer.email }}</td>
                                                <td>
                                                    <router-link :to="{name: 'EditCustomer', params: { id: customer.id }}" class="btn btn-sm btn-outline-primary">ویرایش</router-link>
                                                    <a @click="removeCustomer(customer.id)" class="btn btn-sm btn-outline-danger">حذف</a>
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
            this.getAllCustomers();
        },
        data(){
            return{
                customers:[],
                searchBox:null
            }
        },
        methods:{
            getAllCustomers(){
                axios.get('/api/customer')
                    .then(res => {
                        this.customers = res.data
                    })
                    .catch(err => console.log(err));
            },
            removeCustomer(identifier){
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
                        let index = this.customers.map(x => {
                            return x.id;
                        }).indexOf(identifier);
                        axios.delete('/api/customer/' + identifier)
                            .then(res => {
                                this.customers.splice(index,1);
                            })
                            .catch(err => {
                                this.$router.push({name: 'IndexCustomer'})
                            })
                        Swal.fire(
                            'حذف شد!',
                        )
                    }
                })
            }
        },
        computed:{
            filteredCustomer(){
                if (this.searchBox){
                    return this.customers.filter(customer => {
                        return customer.name.match(this.searchBox)
                    })
                }else {
                    return this.customers
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
