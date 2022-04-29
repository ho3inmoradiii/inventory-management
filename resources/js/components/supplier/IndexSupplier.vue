<template>
    <div class="text-right">
        <router-link :to="{name: 'CreateSupplier'}" class="btn btn-primary">اضافه کردن فروشنده</router-link>

        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Simple Tables -->
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between dir-rtl">
                                        <h6 class="font-weight-bold text-primary text-right mt-2">لیست فروشندگان</h6>
                                        <input v-model="searchBox" style="width: 300px" placeholder="جستجو" class="form-control" type="text">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush dir-rtl">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>نام</th>
                                                <th>تصویر</th>
                                                <th>شماره تماس</th>
                                                <th>نام فروشگاه</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="supplier in filteredSupplier" :key="supplier.id">
                                                <td>{{ supplier.name }}</td>
                                                <td><img :src="supplier.photo" id="em_photo"></td>
                                                <td>{{ supplier.phone }}</td>
                                                <td>{{ supplier.shopname }}</td>
                                                <td>
                                                    <router-link :to="{name: 'EditSupplier', params: { id: supplier.id }}" class="btn btn-sm btn-outline-primary">ویرایش</router-link>
                                                    <a @click="removeSupplier(supplier.id)" class="btn btn-sm btn-outline-danger">حذف</a>
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
            this.getAllSuppliers();
        },
        data(){
            return{
                suppliers:[],
                searchBox:null
            }
        },
        methods:{
            getAllSuppliers(){
                axios.get('/api/supplier')
                    .then(res => this.suppliers = res.data)
                    .catch(err => console.log(err));
            },
            removeSupplier(identifier){
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
                        let index = this.suppliers.map(x => {
                            return x.id;
                        }).indexOf(identifier);
                        axios.delete('/api/supplier/' + identifier)
                            .then(res => {
                                this.suppliers.splice(index,1);
                            })
                            .catch(err => {
                            this.$router.push({name: 'IndexSupplier'})
                        })
                        Swal.fire(
                            'حذف شد!',
                        )
                    }
                })
            }
        },
        computed:{
            filteredSupplier(){
                if (this.searchBox){
                    return this.suppliers.filter(supplier => {
                        return supplier.name.match(this.searchBox)
                    })
                }else {
                    return this.suppliers
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
