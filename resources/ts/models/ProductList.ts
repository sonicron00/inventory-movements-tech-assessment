export interface IProductList {
    products: [];
    isLoaded: boolean;
}

export class defaultProductList implements IProductList {
    products: [];
    isLoaded: boolean;

    constructor() {
        this.products = [];
        this.isLoaded = false;
    }
}

