import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import EmployeesContainer from './EmployeesNestedTreeNodeContainer';
import {formatDate, formatMoney} from '../../app/helper';

export default class Employees extends Component {
    componentDidMount() {
        if (this.props.node && this.props.node.isRoot) {
            this.initialLoad();
        }
        if (!this.props.node.loadingData.isFullLoaded) {
            window.addEventListener('scroll', this.loadByScroll);
        }
    }

    componentWillUnmount() {
        window.removeEventListener('scroll', this.loadByScroll);
    };

    renderChildren() {
        if (!this.props.node) {
            return null;
        }
        const {childIDs, isOpened} = this.props.node;
        if (Array.isArray(childIDs) && isOpened) {
            return childIDs.map((childID) =>
                <EmployeesContainer
                    key={childID}
                    id={childID}
                />
            )
        }
    }

    initialLoad() {
        this.props.getEmployeesData();
        this.props.getPositionsData();
    }

    getPositionName(positionID) {
        return (this.props.positions[positionID] && this.props.positions[positionID].name) || "...";
    }

    loadMore = () => {
        if (!this.props.node.isLoading && !this.props.node.loadingData.isFullLoaded) {
            return this.props.getEmployeesData(this.props.id, this.props.node.loadingData);
        }
    };

    loadByScroll = (e) => {
        e.stopPropagation();
        if (
            this.props.node.hasChildren &&
            this.props.node.isOpened &&
            !this.props.node.loadingData.isLoading
        ) {
            let bottomNodePosition = ReactDOM.findDOMNode(this).getBoundingClientRect().bottom - window.innerHeight;
            if (bottomNodePosition <= 100) {
                this.loadMore();
            }
        }
    };

    toggleNode = () => {
        return this.props.toggleEmployeesNode(this.props.id, this.props.node.isOpened, this.props.node.childIDs)
    };

    render() {
        const {employee, node} = this.props;
        const {name, salary, position, employmentDate} = employee;
        const {level, isOpened, isRoot, hasChildren, loadingData} = node;
        const {isFullLoaded, isLoading} = loadingData;

        let showOpenButton = !isFullLoaded || hasChildren;

        let employeeNodeClass = "employee-node";
        if (isRoot) {
            employeeNodeClass += " employee-node_root";
        }
        return (
            <div onScrollCapture={this.loadByScroll} className={employeeNodeClass} style={{"paddingLeft": level + '%'}}>
                <div className="employee-node__info">
                    <span onClick={this.toggleNode}
                          style={{"visibility": (showOpenButton ? "visible" : "hidden")}}
                          className={"employee-node__info-item employee-node__open-btn " +
                          (isOpened ? "fa fa-minus-circle" : "fa fa-plus-circle")}
                    />
                    <div className="employee-node__info-item employee-node__name">
                        <div>{name}</div>
                        <div className="employee-node__info-item_sub">
                            {this.getPositionName(position)}
                        </div>
                    </div>
                    <div className="employee-node__info-item employee-node__info-item_numeric employee-node__empl-date">
                        {formatDate(employmentDate)}
                    </div>
                    <div className="employee-node__info-item employee-node__info-item_numeric employee-node__salary">
                        {formatMoney(salary)}
                    </div>
                </div>

                {this.renderChildren()}
                {isLoading && <div className="employee-node__loader"/>}

            </div>
        );
    }
}