import Vue from 'vue';
import Vuex from 'vuex';
// @ts-ignore
import {IProductState, Products} from "./modules/Products.ts";
// @ts-ignore
import {ITransactionState, Transactions} from "./modules/Transactions.ts";

Vue.use(Vuex);

export interface IState {
    products: IProductState;
    transactions: ITransactionState;
}

export interface IPayload {
    force?: boolean;
}

const store = new Vuex.Store<IState>({
    strict: true,
    modules: {
        products: Products,
        transactions: Transactions
    }
})

export default store