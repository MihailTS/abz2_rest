const initialState = {
    employees: []
};

export default (state = initialState, action) => {
    switch (action.type) {
        case 'GET_EMPLOYEES':
            return {
                ...state,
                employees: action.employees
            };
            break;
        default:
            return state;
    }
};