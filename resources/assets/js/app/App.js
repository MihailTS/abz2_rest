import React from 'react';
import './../bootstrap';
import moment from 'moment';
import EmployeesNode from "../employees/nestedTree/EmployeesNestedTreeNodeContainer";

moment.locale('ru');

export default class App extends React.Component {
    render() {
        return (
            <div id="app">
                <div className="employees-tree">
                    <div className="employees-tree__head">
                        <div className="employees-tree__head-item employees-tree__head-item-open-btn">&nbsp;</div>
                        <div className="employees-tree__head-item employees-tree__head-item-name">&nbsp;</div>
                        <div className="employees-tree__head-item employees-tree__head-item-empl-date">
                            Дата приема на работу
                        </div>
                        <div className="employees-tree__head-item employees-tree__head-item-salary">
                            Размер зарплаты
                        </div>
                    </div>
                    <EmployeesNode
                        key={0}
                        id={0}
                        level={0}
                    />
                </div>
            </div>
        )
    }
}
