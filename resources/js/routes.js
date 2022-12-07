const Welcome = () => import('./components/Welcome.vue');
const Products = () => import('./components/Products');
const Transactions = () => import('./components/Transactions');


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Welcome
    },
    {
        name: 'products',
        path: '/products',
        component: Products,
        props: {canEdit: true}
    },
    {
        name: 'transactions',
        path: '/transactions',
        component: Transactions
    },
]