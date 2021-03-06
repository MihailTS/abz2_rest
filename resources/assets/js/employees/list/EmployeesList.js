import React from 'react'
import EmployeesListContentContainer from "./EmployeesListContentContainer";

const employeesList = () => (
    <div className="employees-list">
        <div className="employees-list__head">
            <div className="employees-list__head-item employees-list__head-item-img">&nbsp;</div>
            <div className="employees-list__head-item employees-list__head-item-name">ФИО</div>
            <div className="employees-list__head-item employees-list__head-item-position">
                Должность
            </div>
            <div className="employees-list__head-item employees-list__head-item-empl-date">
                Дата приема на работу
            </div>
            <div className="employees-list__head-item employees-list__head-item-salary">
                Размер зарплаты
            </div>
        </div>
        <EmployeesListContentContainer/>
    </div>
);
export default employeesList;