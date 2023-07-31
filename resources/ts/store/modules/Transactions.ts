import { ActionContext } from "vuex";
import axios from 'axios';
import {IPayload, IState} from "../";
// @ts-ignore
import {ITransactionList, defaultTransactionList, ITransaction} from "../../models/TransactionList.ts";
// @ts-ignore
import {ICachedRequest, StoreRequestCache} from "../StoreRequestCache.ts";
import {IProduct} from "../../models/ProductList";
import {IProductState} from "./Products";


type Context = ActionContext<ITransactionState, IState>;

export interface ITransactionState extends ICachedRequest {
    transactions: ITransactionList;
}

const TransactionsModule = {
    namespaced: true,
    state: (): ITransactionState => ({
        transactions: new defaultTransactionList(),
        ...StoreRequestCache.state(),
    }),
    getters: {
        getTransactions(state: ITransactionState): ITransaction[] {
            return state.transactions.transactions;
        },
    },
    mutations: {
        setTransactions(state: ITransactionState, transactions: any) {
            state.transactions.transactions = transactions.data;
        },
        addTransaction(state: ITransactionState, transaction: any) {
            state.transactions.transactions.push({
                transaction_date: new Date().toDateString(),
                product_descr: transaction.description,
                product_id: transaction.productID,
                transaction_type: 'Purchase',
                qty: transaction.quantity,
                price: transaction.price
            });
        },
    },
    actions: {
        async loadTransactions(context: Context, payload?: IPayload) {
            if (!payload?.force && context.state.transactions.isLoaded) {
                // Transaction list is already loaded
                return new Promise((resolve, reject) => {
                    resolve(context.state.transactions);
                });
            }
            return axios.get('/api/transactions').then(response => {
                context.commit("setTransactions", response);
                return response;
            });
        },
        async createPurchase(context: Context, payload) {
            if (!payload?.force && context.state.transactions.isLoaded) {
                // Transaction list is already loaded
                return new Promise((resolve, reject) => {
                    resolve(context.state.transactions);
                });
            }
            return axios.put(`/api/purchases/create/${payload.productID}/${Number(payload.quantity)}/${Number(payload.price)}`).then(response => {
                context.commit("addTransaction", payload);
                return response;
            });
        },
    },

};

export const Transactions = StoreRequestCache.cacheRequests(TransactionsModule, [
    "loadTransactions, createPurchase"
])