import {schema} from "normalizr";
import moment from 'moment';

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

export const formatDate = (dateString, format = "LL") => {
    if (dateString) {
        return moment(dateString).format(format);
    }
};

export const formatMoney = (moneyString, locale = 'ru-RU') => {
    let moneyValue = parseFloat(moneyString);
    if (!isNaN(moneyValue)) {
        return parseFloat(moneyString).toLocaleString(locale);
    }
};
