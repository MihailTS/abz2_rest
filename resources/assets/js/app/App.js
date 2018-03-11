import React from 'react';
import './../bootstrap';
import EmployeesContainer from "../employees/EmployeesContainer";

export default class App extends React.Component {
    render() {
        return (
            <div id="app">
                <EmployeesContainer
                    key={0}
                    id={0}
                    name={'root'}
                    level={0}
                />
            </div>
        )
    }
}
