let Login = require('./components/auth/login').default;
let Register = require('./components/auth/register').default;
let Forget = require('./components/auth/forget').default;
let Logout = require('./components/auth/TheLogout').default;

// End Authentication
let Home = require('./components/HomePage').default;

function redirectIfAuthenticated(to, from, next) {
    let isAuthenticated= false;
    if(User.loggedIn())
        isAuthenticated = true;
    else
        isAuthenticated= false;
    if(isAuthenticated)
    {
        next('/home');
    }
    else
    {
        next();
    }
}

export const routes = [
    {   path: '/',
        component: Login,
        name: '/',
        beforeEnter: redirectIfAuthenticated
    },
    {   path: '/register',
        component: Register,
        name: 'register',
        beforeEnter: redirectIfAuthenticated
    },
    {   path: '/forget-password',
        component: Forget,
        name: 'forget'
    },
    {   path: '/logout',
        component: Logout,
        name: 'logout'
    },
    {   path: '/home',
        component: Home,
        name: 'home',
        beforeEnter: (to, from, next) => {
            let isAuthenticated= false;
            if(User.loggedIn())
                isAuthenticated = true;
            else
                isAuthenticated= false;
            if(isAuthenticated)
            {
                next();
            }
            else
            {
                next('/');
            }
        },
    },
]
