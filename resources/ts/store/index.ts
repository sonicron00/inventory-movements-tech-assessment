import Vue from 'vue';
import Vuex from 'vuex';
// @ts-ignore
import {IProductState, Products} from "./modules/Products.ts";

Vue.use(Vuex);

export interface IState {
    products: IProductState;
}

export interface IPayload {
    force?: boolean;
}

const store = new Vuex.Store<IState>({
    strict: true,
    modules: {
        products: Products
    }
})

export default store