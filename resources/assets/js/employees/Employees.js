import React, {Component} from 'react';
import EmployeesContainer from './EmployeesContainer';

export default class Employees extends Component {
    componentDidMount() {
        if (this.props.id === 0) {//is root
            this.props.initialLoad();
        }
    }
    renderChildren() {
        const {childIDs, isOpened} = this.props.employee;
        if (!childIDs || !isOpened) {
            return null;
        }
        return childIDs.map((childID) =>
            <EmployeesContainer
                key={childID}
                id={childID}
                level={this.props.level + 1}
            />
        )
    }

    hasChildren = () => {
        const {childIDs} = this.props.employee;
        return (typeof childIDs !== "undefined" && childIDs.length > 0)
    };

    getPositionName(positionID) {
        return (this.props.positions[positionID] && this.props.positions[positionID].name) || "...";
    }

    loadMore = () => (
        this.props.getEmployeesData(this.props.id, this.props.loadingData)
    );

    toggleNode = () => (
        this.props.toggleEmployeesNode(this.props.id, this.props.employee.isOpened, this.props.employee.childIDs)
    );

    showOpenButton = () => (
        !this.props.employee.id && (!this.props.loadingData.isFullLoaded || this.hasChildren())
    );

    render() {
        const {id, level, loadingData, employee} = this.props;
        const {name, salary, position, childIDs, isOpened, isLoading} = employee;
        const {total, isFullLoaded} = loadingData;

        let isRoot = (id === 0);
        let showOpenButton = !isRoot && (!isFullLoaded || this.hasChildren());
        let showLoadMore = !isFullLoaded && this.hasChildren() && isOpened;

        return (
            <div style={{"paddingLeft": level * 10}} key={id}>
                <div className={isRoot && "employees_root"}>
                    <div>{name}</div>
                    <div>{this.getPositionName(position)}</div>
                    <div>{salary}</div>
                </div>
                {showOpenButton && <button onClick={this.toggleNode}>{isOpened ? "-" : "+"}</button>}
                {this.renderChildren()}
                {isLoading && <div>Loading...</div>}
                {showLoadMore &&
                <div style={{"paddingLeft": 15}}>
                    <span>({childIDs.length}/{total})</span>
                    <button onClick={this.loadMore}>Load more...</button>
                </div>
                }

            </div>
        );
    }
}