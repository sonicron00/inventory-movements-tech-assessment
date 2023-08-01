const Welcome = () => import('./components/Welcome.vue');
const Products = () => import('./components/Products');
const Transactions = () => import('./components/Transactions');
const Bonus = () => import('./components/Bonus');
const NewBonus = () => import('./components/NewBonus.vue');
const Home = () => import('./components/Home.vue');
const NewWelcome = () => import('./components/NewWelcome.vue');
const NewQuestions = () => import('./components/NewQuestions.vue');
const NewProposal = () => import('./components/NewProposal.vue');

export const routes = [
    {
        name: 'home',
        path: '/landing',
        component: Welcome
    },
    {
        name: 'main',
        path: '/',
        component: Home
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
    },
    {
        name: 'new-bonus',
        path: '/new-bonus',
        component: NewBonus,
        children: [
            { path: '/', component: NewWelcome, name: 'new-bonus' },
            { path: 'questions', component: NewQuestions },
            { path: 'proposal', component: NewProposal }
        ]
    }
]