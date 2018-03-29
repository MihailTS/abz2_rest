import React from 'react';
import './../bootstrap';
import moment from 'moment';
import EmployeesNestedTree from "../employees/nestedTree/EmployeesNestedTree";
import EmployeesList from "../employees/list/EmployeesList";

moment.locale('ru');

export default class App extends React.Component {
    render() {
        return (
            <div id="app">
                <EmployeesNestedTree/>
                {/*<EmployeesList/>*/}
            </div>
        )
    }
}
