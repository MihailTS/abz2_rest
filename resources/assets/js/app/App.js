import React from 'react';
import './../bootstrap';
import EmployeesContainer from "../employees/EmployeesContainer";

export default class App extends React.Component {
    render() {
        return (
            <div id="app">
                <EmployeesContainer/>
            </div>
        )
    }
}
