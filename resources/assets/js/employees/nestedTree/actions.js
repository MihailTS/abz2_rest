import * as actions from "./actionTypes"
import axios from 'axios'
import {normalize} from 'normalizr';
import {getQueryURL, itemsListSchema} from "../../app/helper";
import {getEmployees} from "../actions"

const EMPLOYEES_URL = "/api/v1/employees";

export const getEmployeesData = (head, loadingData) => dispatch => {
    let url;
    let urlParams = {};

    urlParams.head = head ? head : "null";
    if (loadingData && loadingData.currentPage > 0) {
        urlParams.page = loadingData.currentPage + 1;
    }

    url = getQueryURL(EMPLOYEES_URL, urlParams);

    dispatch(startLoadingNode(head));
    axios({url: url}).then(response => {
        const normalizedData = normalize(response.data.data, itemsListSchema);
        let loadingData = {isLoading: false};
        if (response.data.meta) {
            loadingData.currentPage = response.data.meta.pagination["current_page"];
            loadingData.totalPages = response.data.meta.pagination["total_pages"];
            loadingData.total = response.data.meta.pagination["total"];
            loadingData.isFullLoaded = (loadingData.currentPage >= loadingData.totalPages);
        } else {
            loadingData.isFullLoaded = true;
        }
        dispatch(getEmployees(normalizedData.entities.items));
        dispatch(getEmployeesNodes(head, normalizedData.result, loadingData));
    }).catch(error => {
        console.log(error);
    });
};

export const getEmployeesNodes = (head = 0, childIDs, loadingData = {}) => ({
    type: actions.GET_EMPLOYEES_NODES,
    head,
    childIDs,
    loadingData
});

export const startLoadingNode = (head = 0) => ({
    type: actions.START_LOADING_NODE,
    head
});

export const openEmployeesNode = (head) => ({
    type: actions.OPEN_EMPLOYEES_NODE,
    head
});

export const closeEmployeesNode = (head, childIDs) => ({//close all nested child nodes
    type: actions.CLOSE_EMPLOYEES_NODE,
    head,
    childIDs
});

export const toggleEmployeesNode = (head = 0, isOpened, childIDs) => dispatch => {
    if (isOpened) {
        dispatch(closeEmployeesNode(head, childIDs));
    } else {
        if (!Array.isArray(childIDs) || childIDs.length === 0) {//if node hadn't have any child yet
            dispatch(getEmployeesData(head));
        }
        dispatch(openEmployeesNode(head));
    }
};