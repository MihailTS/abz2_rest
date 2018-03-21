import {schema} from "normalizr";

const itemSchema = new schema.Entity('items');
export const itemsListSchema = [itemSchema];

export const getQueryURL = (url, params) => {
    let queryUrl = url;
    let query = Object.keys(params).map((paramName) => (
            encodeURIComponent(paramName) + "=" + encodeURIComponent(params[paramName])
        )
    ).join('&');
    if (query) {
        queryUrl += "?" + query;
    }
    return queryUrl;
};