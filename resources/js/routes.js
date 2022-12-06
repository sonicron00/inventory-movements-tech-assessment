const Welcome = () => import('./components/Welcome.vue');
const Products = () => import('./components/Products');
const Applications = () => import('./components/Applications');
const Purchases = () => import('./components/Purchases');


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
        name: 'applications',
        path: '/applications',
        component: Applications
    },
    {
        name: 'purchases',
        path: '/purchases',
        component: Purchases
    },
]