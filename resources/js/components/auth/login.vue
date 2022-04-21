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
                                        <h1 class="h4 text-gray-900 mb-4">ورود به حساب کاربری</h1>
                                    </div>
                                    <form class="user" @submit.prevent="login">
                                        <div class="form-group text-right">
                                            <input type="email" class="form-control text-right" id="exampleInputEmail" aria-describedby="emailHelp"
                                                   placeholder="ایمیل خود را وارد کنید" v-model="form.email">
                                            <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
                                        </div>
                                        <div class="form-group text-right">
                                            <input type="password" class="form-control text-right" id="exampleInputPassword" placeholder="پسورد خود را وارد کنید" v-model="form.password">
                                            <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
                                        </div>
                                        <div class="form-group text-right">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <label class="custom-control-label dir-rtl" for="customCheck">مرا به خاطر بسپار!</label>
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">ورود</button>
                                        </div>
<!--                                        <a href="index.html" class="btn btn-google btn-block">-->
<!--                                            <i class="fab fa-google fa-fw"></i> Login with Google-->
<!--                                        </a>-->
<!--                                        <a href="index.html" class="btn btn-facebook btn-block">-->
<!--                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook-->
<!--                                        </a>-->
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <router-link to="/register">ساخت حساب</router-link>
                                    </div>
                                    <div class="text-center">
                                        <router-link to="/forget-password">فراموشی رمز عبور</router-link>
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
                    email:null,
                    password:null
                },
                errors:{}
            }
        },
        methods:{
            login(){
                axios.post('/api/auth/login',this.form)
                .then(res => {
                    User.responseAfterLogin(res)
                    this.$router.push({name: 'home'})
                    Toast.fire({
                        icon: 'success',
                        title:   '!خوش اومدی' + localStorage.getItem('user')
                    })
                })
                .catch(err => this.errors = err.response.data.errors)
                .catch(
                    Toast.fire({
                        icon: 'warning',
                        title:   'ایمیل یا پسورد وارد شده صحیح نیست'
                    })
                )
            }
        }
    }

</script>

<style>

</style>
