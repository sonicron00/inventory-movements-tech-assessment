import { IPayload } from "./index";
import { ActionContext, StoreOptions } from "vuex";

export type ICachedRequestData = {
    value: boolean;
    request?: Promise<any>;
};

export type ICachedRequestList = Record<string, ICachedRequestData>;

export interface ICachedRequest {
    cached: ICachedRequestList;
}

type Context = ActionContext<any, any>;
type StoreModule = StoreOptions<any>;

export const StoreRequestCache = {
    state: (): ICachedRequest => ({
        cached: {},
    }),

    get: (context: Context, key: string) => {
        if (context.state.cached[key] && context.state.cached[key].value) {
            return context.state.cached[key].request;
        }

        return false;
    },

    set: (context: Context, key: string, request: any) => {
        if (!context.state.cached[key]) {
            context.state.cached[key] = {};
        }
        context.state.cached[key].value = true;
        context.state.cached[key].request = request;
    },

    getKey(prefix: string, payload: any) {
        const options = { ...payload };
        delete options.force;

        if (Object.keys(options).length) {
            return prefix + JSON.stringify(options);
        }

        return prefix;
    },

    clear: (context: Context, key: string) => {
        context.state.cached[key] = {
            value: false,
        };
    },

    cache: (fn: any, prefix: string) => {
        return (context: Context, payload?: IPayload): Promise<any> => {
            const key = StoreRequestCache.getKey(prefix, payload);
            const loadedData = StoreRequestCache.get(context, key);

            if (!payload?.force && loadedData) {
                return loadedData;
            }

            StoreRequestCache.clear(context, key);

            const request = fn(context, payload);

            StoreRequestCache.set(context, key, request);
            return request;
        };
    },

    cacheRequests(object: StoreModule, methods: string[]): StoreModule {
        if (!object.actions) {
            return object;
        }

        for (let i = 0; i < methods.length; i++) {
            const method = methods[i];
            const tempFunc = object.actions[method];
            object.actions[method] = this.cache(tempFunc, method);
        }

        object.actions.clearCache = (context: Context) => {
            for (let i = 0; i < methods.length; i++) {
                const method = methods[i];
                StoreRequestCache.clear(context, method);
            }
        };

        return object;
    },
};
