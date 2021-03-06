import * as actions from './actionTypes';
const initialState = {
    employees: {
        0: {
            id: 0,
            name: "root",
        }
    }
};

export default (state = initialState, action) => {
    switch (action.type) {
        case actions.GET_EMPLOYEES: {
            return {
                ...state,
                employees: {
                    ...state.employees,
                    ...action.employees,
                }
            };
        }
        default:
            return state;
    }
};