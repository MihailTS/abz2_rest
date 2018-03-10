import React, {Component} from 'react';
import EmployeeItem from './EmployeeItem';

export default class Employees extends Component {
    componentDidMount() {
        this.props.getEmployeesData();
    }

    render() {
        return (
            <div className="container">
                <div className="row">
                    {this.props.employees.map((employee, i) =>
                        <EmployeeItem key={employee.id} id={employee.id} name={employee.name}/>
                    )}
                </div>
            </div>
        );
    }
}