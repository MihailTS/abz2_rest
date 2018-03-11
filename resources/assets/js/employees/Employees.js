import React, {Component} from 'react';
import EmployeesContainer from './EmployeesContainer';

export default class Employees extends Component {
    componentDidMount() {
        //this.props.getEmployeesData();
    }

    renderChildren() {
        if (!this.props.employees) {
            return null;
        }
        let children = this.props.employees.filter((item) => ((this.props.id === 0 && item.head === undefined) || item.head === this.props.id));
        return children.map((employee, i) =>
            <EmployeesContainer
                key={employee.id}
                id={employee.id}
                name={employee.name}
                level={this.props.level + 1}
                openNext={() => {
                    console.log(employee.id);
                    return this.props.getEmployeesData(employee.id)
                }}
            />
        )
    }
    render() {
        return (
            <div style={{"paddingLeft": this.props.level * 10}} key={this.props.id}>
                {this.props.name}
                {<button onClick={() => {
                    return this.props.getEmployeesData(this.props.id)
                }}>{(this.props.open) ? "-" : "+"}</button>}
                {this.renderChildren()}
            </div>
            /*<div className="container">
                <div className="row">
                    {this.props.employees.map((employee, i) =>
             <EmployeeItem
             key={employee.id}
             id={employee.id}
             name={employee.name}
             level={0}
             openNextEmployeesLevel={(id)=>(()=>{console.log(id);this.props.openNextEmployeesLevel(id)})}
             childEmployeesNode={this.props.childrenNode}
             />
                    )}
                </div>
             </div>*/
        );
    }
}