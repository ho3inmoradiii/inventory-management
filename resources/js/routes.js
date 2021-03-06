let Login = require('./components/auth/login').default;
let Register = require('./components/auth/register').default;
let Forget = require('./components/auth/forget').default;
let Logout = require('./components/auth/TheLogout').default;
// End Authentication

// Employee
let CreateEmployee = require('./components/employee/CrearteEmployee').default;
let IndexEmployee = require('./components/employee/IndexEmployee').default;
let EditEmployee = require('./components/employee/EditEmployee').default;

//Supplier
let CreateSupplier = require('./components/supplier/CreateSupplier').default;
let IndexSupplier = require('./components/supplier/IndexSupplier').default;
let EditSupplier = require('./components/supplier/EditSupplier').default;

//Category
let CreateCategory = require('./components/category/CreateCategory').default;
let IndexCategory = require('./components/category/IndexCategory').default;
let EditCategory = require('./components/category/EditCategory').default;

//Product
let CreateProduct = require('./components/product/CreateProduct').default;
let IndexProduct = require('./components/product/IndexProduct').default;
let EditProduct = require('./components/product/EditProduct').default;

//Product
let CreateCustomer = require('./components/customer/CreateCustomer').default;
let IndexCustomer = require('./components/customer/IndexCustomer').default;
let EditCustomer = require('./components/customer/EditCustomer').default;

let Home = require('./components/HomePage').default;

let POS = require('./components/pos/POS').default;

//orders
let Orders = require('./components/order/Orders').default;
let ViewOrder = require('./components/order/ViewOrder').default;
let SearchOrder = require('./components/order/SearchOrder').default;

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
    {   path: '/create-supplier',
        component: CreateSupplier,
        name: 'CreateSupplier',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/index-supplier',
        component: IndexSupplier,
        name: 'IndexSupplier',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/edit-supplier/:id',
        component: EditSupplier,
        name: 'EditSupplier',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/create-category',
        component: CreateCategory,
        name: 'CreateCategory',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/index-category',
        component: IndexCategory,
        name: 'IndexCategory',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/edit-category/:id',
        component: EditCategory,
        name: 'EditCategory',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/create-product',
        component: CreateProduct,
        name: 'CreateProduct',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/index-product',
        component: IndexProduct,
        name: 'IndexProduct',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/edit-product/:id',
        component: EditProduct,
        name: 'EditProduct',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/create-customer',
        component: CreateCustomer,
        name: 'CreateCustomer',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/index-customer',
        component: IndexCustomer,
        name: 'IndexCustomer',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/edit-customer/:id',
        component: EditCustomer,
        name: 'EditCustomer',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/home',
        component: Home,
        name: 'home',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/pos',
        component: POS,
        name: 'POS',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/orders',
        component: Orders,
        name: 'Orders',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/view-order/:id',
        component: ViewOrder,
        name: 'ViewOrder',
        beforeEnter: redirectAfterAuth
    },
    {   path: '/searchOrder',
        component: SearchOrder,
        name: 'SearchOrder',
        beforeEnter: redirectAfterAuth
    },
]
