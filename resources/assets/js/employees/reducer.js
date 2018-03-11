const initialState = {
    employees: []
};

export default (state = initialState, action) => {
    switch (action.type) {
        case 'GET_EMPLOYEES':
            console.log(action.employees);
            return {
                ...state,
                employees: [
                    ...state.employees,
                    ...(action.employees.map(item => {
                        return {...item, test: (item.page ? item.page + 1 : 1)}
                    }))
                ]
            };
            break;
        case 'OPEN_EMPLOYEES_NODE':
            return {};
        default:
            return state;
    }
};