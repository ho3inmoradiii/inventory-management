let Login = require('./components/auth/login').default;
let Register = require('./components/auth/register').default;
let Forget = require('./components/auth/forget').default;
let Home = require('./components/HomePage').default;

export const routes = [
    {   path: '/',
        component: Login,
        name: '/',
        beforeEnter: (to, from, next) => {
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
        },
    },
    {   path: '/register',
        component: Register,
        name: 'register'
    },
    {   path: '/forget-password',
        component: Forget,
        name: 'forget'
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
