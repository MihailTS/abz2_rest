import React from 'react';
import './../bootstrap';
import EmployeesNestedTreeContainer from "../employees/nestedTree/EmployeesNestedTreeContainer";

export default class App extends React.Component {
    render() {
        return (
            <div id="app">
                <EmployeesNestedTreeContainer
                    key={0}
                    id={0}
                    level={0}
                />
            </div>
        )
    }
}
