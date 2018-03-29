import React, {Component} from 'react';
import {formatDate, formatMoney} from '../../app/helper';

export default class Employees extends Component {
    componentDidMount() {
        this.initialLoad();
    }

    initialLoad() {
        this.props.getEmployeesData();
        this.props.getPositionsData();
    }

    getPositionName(positionID) {
        return (this.props.positions[positionID] && this.props.positions[positionID].name) || "...";
    }

    render() {
        for (let employee in this.props.employees) {
            let {name, position, salary, employmentDate} = employee;

        }
        return (
            <div>
                <div>&nbsp;</div>
                <div></div>
                <div>&nbsp;</div>
            </div>
        )
    }
}