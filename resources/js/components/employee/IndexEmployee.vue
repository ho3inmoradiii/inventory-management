<template>
    <div class="text-right">
        <router-link to="/create-employee" class="btn btn-primary">اضافه کردن کارمند</router-link>

        <div class="row justify-content-center" v-if="employees">

            <div class="col-xl-12 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Simple Tables -->
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between dir-rtl">
                                        <h6 class="font-weight-bold text-primary text-right mt-2">لیست کارمندان</h6>
                                        <input v-model="searchBox" style="width: 300px" placeholder="جستجو" class="form-control" type="text">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush dir-rtl">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>نام</th>
                                                <th>تصویر</th>
                                                <th>شماره تماس</th>
                                                <th>تایخ عضویت</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="employee in filteredEmployee" :key="employee.id">
                                                <td>{{ employee.fullName }}</td>
                                                <td><img :src="employee.photo" id="em_photo"></td>
                                                <td>{{ employee.phone }}</td>
                                                <td>{{ employee.joiningDate ? employee.joiningDate : '------' }}</td>
                                                <td>
                                                    <router-link :to="{name: 'EditEmployee', params: { id: employee.id }}" class="btn btn-sm btn-outline-primary">ویرایش</router-link>
                                                    <a @click="removeEmployee(employee.id)" class="btn btn-sm btn-outline-danger">حذف</a>
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
            this.getAllEmployees();
        },
        data(){
            return{
                employees:[],
                searchBox:null
            }
        },
        methods:{
            getAllEmployees(){
                axios.get('/api/employee')
                .then(res => this.employees = res.data)
                .catch(err => console.log(err));
            },
            removeEmployee(identifier){
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
                        let index = this.employees.map(x => {
                            return x.id;
                        }).indexOf(identifier);
                        axios.delete('/api/employee/' + identifier)
                            .then(res => {
                                this.employees.splice(index,1);
                            }).catch(err => {
                                this.$router.push({name: 'IndexEmployee'})
                            })
                        Swal.fire(
                            'حذف شد!',
                        )
                    }
                })
            }
        },
        computed:{
            filteredEmployee(){
                if (this.searchBox){
                    return this.employees.filter(employee => {
                        return employee.fullName.match(this.searchBox)
                    })
                }else {
                    return this.employees
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
