import * as actions from './actionTypes';

export const getEmployees = (employees) => ({
    type: actions.GET_EMPLOYEES,
    employees
});

