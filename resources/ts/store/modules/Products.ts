import { ActionContext } from "vuex";
import axios from 'axios';
import {IPayload, IState} from "../";
// @ts-ignore
import {IProductList, defaultProductList, IProduct} from "../../models/ProductList.ts";
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
        getProducts(state: IProductState): IProduct[] {
            return state.products.products;
        },
        isLoading(state: IProductState): boolean {
            return !state.products.isLoaded;
        }
    },
    mutations: {
        setProducts(state: IProductState, products: any) {
            state.products.products = products.data;
        },
        switchLoading(state: IProductState) {
            state.products.isLoaded = !state.products.isLoaded;
        },
        updateProducts(state: IProductState, productData: { "data": { "id": number, "description": string, "qty": number}}) {
            const prodIndex = state.products.products.find(function(item) {
                return item.productID === productData.data.id;
            });

            if (!prodIndex) {
                state.products.products.push(
                    {"productID": productData.data.id,
                        "description": productData.data.description,
                        "quantity": productData.data.qty,
                        "isEdit": false,
                        "calculatedPrice": 0,
                        "showPrice": false
                    });
                return;
            }
            prodIndex.description = productData.data.description;
            prodIndex.isEdit = false;
        },
        editProduct(state: IProductState, productID: number) {
            const prodIndex = state.products.products.findIndex(function(item) {
                return item.productID === productID;
            });
            const oldProd = state.products.products[prodIndex];
            const newProd = state.products.products[prodIndex];
            newProd.isEdit = !oldProd.isEdit;
            if (oldProd.calculatedPrice && oldProd.calculatedPrice > 0) {
                newProd.calculatedPrice = null;
            }
            state.products.products = [...state.products.products.slice(0, prodIndex), { ...oldProd, ...newProd }, ...state.products.products.slice(prodIndex + 1)]
        },
        updateProductCalc(state: IProductState, productData: { "data": { "id": number, "price": number } }) {
            const prodIndex = state.products.products.findIndex(function(item) {
                return item.productID === productData.data.id;
            });
            const oldProd = state.products.products[prodIndex];
            const newProd = state.products.products[prodIndex];
            newProd.calculatedPrice = productData.data.price;
            state.products.products = [...state.products.products.slice(0, prodIndex), { ...oldProd, ...newProd }, ...state.products.products.slice(prodIndex + 1)]
        },
        updateProductQty(state: IProductState, productData: { "data": { "id": number, "appliedQty": number } }) {
            const prodIndex = state.products.products.findIndex(function(item) {
                return item.productID === productData.data.id;
            });
            const oldProd = state.products.products[prodIndex];
            const newProd = state.products.products[prodIndex];
            newProd.quantity = oldProd.quantity - productData.data.appliedQty;
            newProd.isEdit = false;
            newProd.calculatedPrice = null;
            state.products.products = [...state.products.products.slice(0, prodIndex), { ...oldProd, ...newProd }, ...state.products.products.slice(prodIndex + 1)]
        }
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
                context.commit("switchLoading");
            });
        },
        async createOrUpdateProduct(context: Context, payload: any) {
            context.commit("switchLoading");
            return axios.put(`/api/products/edit/${payload.description}/${payload.productID ?? 0}/${payload.qty ?? 0}`).then((response) => {
                response.data.qty = payload.qty;
                context.commit("updateProducts", response);
                context.commit("switchLoading");
            });
        },
        async calcPriceForQuantity(context: Context, payload: any) {
            context.commit("switchLoading");
            return axios.get(`/api/products/preapply/${payload.productID}/${payload.requestedQuantity}`).then(response => {
                context.commit("updateProductCalc", { "data": { "id": payload.productID, "price": response.data } });
                context.commit("switchLoading");
            });
        },
        async commitApplication(context: Context, payload: any) {
            context.commit("switchLoading");
            return axios.put(`/api/products/apply/${payload.productID}/${payload.quantity}`).then(response => {
                context.commit("updateProductQty", { "data": { "id": payload.productID, "appliedQty": payload.quantity } });
                context.commit("switchLoading");
            });
        }
    },
};

export const Products = StoreRequestCache.cacheRequests(ProductsModule, [
    "loadProducts", "createOrUpdateProduct", "editProduct", "calcPriceForQuantity", "commitApplication"
])