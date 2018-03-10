import {combineReducers} from 'redux';

import employeesReducer from '../employees/reducer';
export default combineReducers({
    employeesState: employeesReducer
});
