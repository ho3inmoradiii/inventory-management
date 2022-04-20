import Token from './Token';
import AppStorage from './AppStorage';

class User {
    // login(data){
    //     axios.post('/api/auth/login',data)
    //         .then(res => this.responseAfterLogin(res))
    //         .catch(error => console.log(error.response.data))
    // }

    responseAfterLogin(res){
        const access_token = res.data.access_token;
        const user = res.data.name;
        if (Token.isValid(access_token)){
            AppStorage.store(access_token,user);
            //window.location = '/forum';
        }
    }

    hasToken(){
        const storedToken = AppStorage.getToken();
        if(storedToken){
            return Token.isValid(storedToken) ? true : this.logout();
        }
        return false;
    }

    loggedIn(){
        return this.hasToken();
    }

    logout(){
        AppStorage.clear();
        //window.location = '/';
    }

    name(){
        if (this.loggedIn()){
            return AppStorage.getUser();
        }
    }

    id(){
        if (this.loggedIn()){
            const payload = Token.payload(AppStorage.getToken());
            return payload.sub;
        }
    }

    // own(id){
    //     if (this.id() == id) return true;
    //     return false;
    // }
    //
    // admin(){
    //     return this.id() === 12;
    // }
}

export default User = new User;
