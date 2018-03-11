import React from 'react';

const Employee = (props) => {
    return (
        <div style={{"paddingLeft": props.level * 10}} key={props.id}>
            {props.name}
            <button onClick={props.openNextEmployeesLevel(props.id)}>{(props.open) ? "-" : "+"}</button>
            {props.childEmployeesNode}
        </div>
    );
};
export default Employee;