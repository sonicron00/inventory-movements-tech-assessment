export interface IProductList {
    products: IProduct[];
    isLoaded: boolean;
}

export interface IProduct {
    description: string,
    productID: number,
    quantity: number,
    isEdit: boolean,
    calculatedPrice: number,
    showPrice: boolean
}

export class defaultProductList implements IProductList {
    products: IProduct[];
    isLoaded: boolean;

    constructor() {
        this.products = [{
            description: '',
            productID: 0,
            quantity: 0,
            isEdit: false,
            calculatedPrice: 0,
            showPrice: false
        }];
        this.isLoaded = false;
    }
}

