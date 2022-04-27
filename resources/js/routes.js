let Login = require('./components/auth/login').default;
let Register = require('./components/auth/register').default;
let Forget = require('./components/auth/forget').default;
let Logout = require('./components/auth/TheLogout').default;

// End Authentication

// Employee
let CreateEmployee = require('./components/employee/CrearteEmployee').default;
let IndexEmployee = require('./components/employee/IndexEmployee').default;
let EditEmployee = require('./components/employee/EditEmployee').default;

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

function redirectAfterAuth(to, from, next) {
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
        name: 'forget',
        beforeEnter: redirectIfAuthenticated
    },
    {   path: '/logout',
        component: Logout,
        name: 'logout'
    },
    {   path: '/create-employee',
        component: CreateEmployee,
        name: 'CreateEmployee',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/index-employee',
        component: IndexEmployee,
        name: 'IndexEmployee',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/edit-employee/:id',
        component: EditEmployee,
        name: 'EditEmployee',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/home',
        component: Home,
        name: 'home',
        beforeEnter: redirectAfterAuth
    },
]
