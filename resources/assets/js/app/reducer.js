import {combineReducers} from 'redux';

import employeesReducer from '../employees/reducer';
import positionsReducer from '../positions/reducer';
import nestedTreeEmployeesReducer from '../employees/nestedTree/reducer'
export default combineReducers({
    employeesState: employeesReducer,
    nestedTreeEmployeesState: nestedTreeEmployeesReducer,
    positionsState: positionsReducer
});
