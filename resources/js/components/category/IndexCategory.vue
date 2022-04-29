<template>
    <div class="text-right">
        <router-link :to="{name: 'CreateCategory'}" class="btn btn-primary">اضافه کردن دسته بندی</router-link>

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
                                                <th>نام دسته بندی</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="category in filteredCategory" :key="category.id">
                                                <td>{{ category.category_name }}</td>
                                                <td>
                                                    <router-link :to="{name: 'EditCategory', params: { id: category.id }}" class="btn btn-sm btn-outline-primary">ویرایش</router-link>
                                                    <a @click="removeCategory(category.id)" class="btn btn-sm btn-outline-danger">حذف</a>
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
            this.getAllCategories();
        },
        data(){
            return{
                categories:[],
                searchBox:null
            }
        },
        methods:{
            getAllCategories(){
                axios.get('/api/category')
                    .then(res => {
                        this.categories = res.data
                    })
                    .catch(err => console.log(err));
            },
            removeCategory(identifier){
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
                        let index = this.categories.map(x => {
                            return x.id;
                        }).indexOf(identifier);
                        axios.delete('/api/category/' + identifier)
                            .then(res => {
                                this.categories.splice(index,1);
                            })
                            .catch(err => {
                                this.$router.push({name: 'IndexCategory'})
                            })
                        Swal.fire(
                            'حذف شد!',
                        )
                    }
                })
            }
        },
        computed:{
            filteredCategory(){
                if (this.searchBox){
                    return this.categories.filter(category => {
                        return category.category_name.match(this.searchBox)
                    })
                }else {
                    return this.categories
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
