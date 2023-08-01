export interface ITransactionList {
    transactions: ITransaction[];
    isLoaded: boolean;
}

export interface ITransaction {
    product_id: number,
    transaction_date: string,
    transaction_type: string,
    product_descr: string,
    qty: number,
    price: number
}

export class defaultTransactionList implements ITransactionList {
    transactions: ITransaction[];
    isLoaded: boolean;

    constructor() {
        this.transactions = [{
            product_id: 0,
            transaction_date: '',
            transaction_type: '',
            product_descr: '',
            qty: 0,
            price: 0
        }];
        this.isLoaded = false;
    }
}

