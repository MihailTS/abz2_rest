import * as actions from './actionTypes';

const initialState = {
    positions: {}
};

export default (state = initialState, action) => {
    switch (action.type) {
        case actions.GET_POSITIONS: {
            return {
                ...state,
                positions: {
                    ...state.positions,
                    ...action.positions
                }
            }
        }
        default:
            return state;
    }
};