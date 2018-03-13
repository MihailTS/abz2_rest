import axios from 'axios'

import {normalize, schema} from 'normalizr';


export const getEmployees = (employees, head = 0, childIDs, loadingData) => ({
    type: 'GET_EMPLOYEES',
    employees,
    head,
    childIDs,
    loadingData
});
export const getEmployeesData = (head, loadingData) => dispatch => {
    let url = "/api/v1/employees";
    let urlParams = {};
    const userSchema = new schema.Entity('employees');
    const userListSchema = [userSchema];

    if (!head) {
        urlParams.head = "null";
    } else {
        url = `/api/v1/employees/${head}/subordinates`
    }

    if (loadingData && loadingData.currentPage > 0) {
        urlParams.page = loadingData.currentPage + 1;
    }

    let urlQuery = Object.keys(urlParams).map(function (paramName) {
        return encodeURIComponent(paramName) + "=" + encodeURIComponent(urlParams[paramName]);
    }).join('&');
    if (urlQuery) {
        url += "?" + urlQuery;
    }

    dispatch(startLoading(head));
    axios({url: url}).then(response => {
        const normalizedData = normalize(response.data.data, userListSchema);
        let loadingData = {isLoading: false};
        if (response.data.meta) {
            loadingData.currentPage = response.data.meta.pagination["current_page"];
            loadingData.totalPages = response.data.meta.pagination["total_pages"];
            loadingData.total = response.data.meta.pagination["total"];
            loadingData.isFullLoaded = (loadingData.currentPage >= loadingData.totalPages);
        } else {
            loadingData.isFullLoaded = true;
        }
        dispatch(getEmployees(normalizedData.entities.employees, head, normalizedData.result, loadingData));
    }).catch(error => {
        console.log(error);
    });
};
export const startLoading = (head) => ({
    type: 'START_LOADING',
    head
});
export const openEmployeesNode = (head) => ({
    type: 'OPEN_EMPLOYEES_NODE',
    head
});
export const closeEmployeesNode = (head, childIDs) => ({//close all nested child nodes
    type: 'CLOSE_EMPLOYEES_NODE',
    head,
    childIDs
});
export const toggleEmployeesNode = (head = 0, isOpened, childIDs) => dispatch => {
    if (isOpened) {
        dispatch(closeEmployeesNode(head, childIDs));
    } else {
        if (!childIDs) {//if node hadn't have any child yet
            dispatch(getEmployeesData(head));
        }
        dispatch(openEmployeesNode(head));
    }
};