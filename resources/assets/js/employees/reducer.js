const initialState = {
    employees: []
};

export default (state = initialState, action) => {
    switch (action.type) {
        case 'GET_EMPLOYEES':
            return {
                ...state,
                employees: [
                    ...state.employees,
                    ...action.employees
                ]
            };
            break;
        case 'OPEN_EMPLOYEES_NODE':
            return {};
        default:
            return state;
    }
};