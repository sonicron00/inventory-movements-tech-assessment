const Welcome = () => import('./components/Welcome.vue');
const Products = () => import('./components/Products');
const Transactions = () => import('./components/Transactions');
const Bonus = () => import('./components/Bonus');


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
    {
        name: 'bonus',
        path: '/bonus',
        component: Bonus
    }
]