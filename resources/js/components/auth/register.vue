<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">ثبت نام</h1>
                                    </div>
                                    <form @submit.prevent="register">
                                        <div class="form-group text-right">
                                            <input type="text" class="form-control text-right" placeholder="نام خود را وارد کنید" v-model="form.name">
                                            <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
                                        </div>
                                        <div class="form-group text-right">
                                            <input type="email" class="form-control text-right" aria-describedby="emailHelp" placeholder="ایمیل خود را وارد کنید" v-model="form.email">
                                            <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                                        </div>
                                        <div class="form-group text-right">
                                            <input type="password" class="form-control text-right" placeholder="رمز عبور خود را وارد کنید" v-model="form.password">
                                            <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
                                        </div>
                                        <div class="form-group text-right">
                                            <input type="password" class="form-control text-right" placeholder="رمز عبور را تکرار کنید" v-model="form.password_confirmation">
                                            <small v-if="errors.password_confirmation" class="text-danger">{{ errors.password_confirmation[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">ثبت نام</button>
                                        </div>
<!--                                        <hr>-->
<!--                                        <a href="index.html" class="btn btn-google btn-block">-->
<!--                                            <i class="fab fa-google fa-fw"></i> Register with Google-->
<!--                                        </a>-->
<!--                                        <a href="index.html" class="btn btn-facebook btn-block">-->
<!--                                            <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook-->
<!--                                        </a>-->
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <router-link to="/">حساب کاربری دارید؟</router-link>
                                    </div>
                                    <div class="text-center">
                                    </div>
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
                form:{
                    name:null,
                    email:null,
                    password:null,
                    password_confirmation:null,
                },
                errors:{}
            }
        },
        methods:{
            register(){
                axios.post('/api/auth/signup',this.form)
                    .then(res => {
                        User.responseAfterLogin(res)
                        this.$router.push({name: 'home'})
                        Toast.fire({
                            icon: 'success',
                            title:   '!خوش اومدی' + localStorage.getItem('user')
                        })
                    })
                    .catch(err => this.errors = err.response.data.errors)
                    // .catch(
                    //     Toast.fire({
                    //         icon: 'warning',
                    //         title:   'ایمیل یا پسورد وارد شده صحیح نیست'
                    //     })
                    // )
            }
        }
    }
</script>

<style>

</style>
