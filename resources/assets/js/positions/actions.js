import * as actions from './actionTypes';
import axios from 'axios'
import {normalize} from 'normalizr';
import {getQueryURL, itemsListSchema} from "../app/helper";

const POSITIONS_URL = "/api/v1/positions";

export const getPositions = (positions) => ({
    type: actions.GET_POSITIONS,
    positions
});

export const getPositionsData = (page) => dispatch => {
    let urlParams = {};
    let currentPositionsPage;
    let totalPositionsPage;
    let url;

    if (page) {
        urlParams.page = page;
    }
    url = getQueryURL(POSITIONS_URL, urlParams);
    axios({url: url}).then(response => {
        const normalizedData = normalize(response.data.data, itemsListSchema);
        if (response.data.meta) {
            currentPositionsPage = response.data.meta.pagination["current_page"];
            totalPositionsPage = response.data.meta.pagination["total_pages"];
            if (currentPositionsPage < totalPositionsPage) {
                currentPositionsPage++;
                dispatch(getPositionsData(currentPositionsPage))
            }
        }
        dispatch(getPositions(normalizedData.entities.items));
    }).catch(error => {
        console.log(error);
    });
};