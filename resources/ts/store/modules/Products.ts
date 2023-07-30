import { ActionContext } from "vuex";
import axios from 'axios';
import {IPayload, IState} from "../";
// @ts-ignore
import { IProductList, defaultProductList} from "../../models/ProductList.ts";
// @ts-ignore
import {ICachedRequest, StoreRequestCache} from "../StoreRequestCache.ts";

type Context = ActionContext<IProductState, IState>;

export interface IProductState extends ICachedRequest {
    products: IProductList;
}

const ProductsModule = {
    namespaced: true,
    state: (): IProductState => ({
        products: new defaultProductList(),
        ...StoreRequestCache.state(),
    }),
    getters: {
        getProducts(state: IProductState): [] {
            return state.products.products;
        },
    },
    mutations: {
        setProducts(state: IProductState, products: any) {
            console.log('setting products');
            console.log(products.data);
            state.products.products = products.data;
        },
    },
    actions: {
        async loadProducts(context: Context, payload?: IPayload) {

            if (!payload?.force && context.state.products.isLoaded) {
                // Product list is already loaded
                return new Promise((resolve, reject) => {
                    resolve(context.state.products);
                });
            }

            return axios.get('/api/products').then((response) => {
                context.commit("setProducts", response);
                return response;
            });
        },
    },
};

export const Products = StoreRequestCache.cacheRequests(ProductsModule, [
    "loadProducts",
])