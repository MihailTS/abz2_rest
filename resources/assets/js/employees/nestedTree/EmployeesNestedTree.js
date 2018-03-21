import React, {Component} from 'react';
import EmployeesContainer from './EmployeesNestedTreeContainer';

export default class Employees extends Component {
    componentDidMount() {
        if (this.props.node && this.props.node.isRoot) {
            this.initialLoad();
        }
    }
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

    loadMore = () => (
        this.props.getEmployeesData(this.props.id, this.props.node.loadingData)
    );

    toggleNode = () => {
        return this.props.toggleEmployeesNode(this.props.id, this.props.node.isOpened, this.props.node.childIDs)
    };

    render() {
        const {employee, node} = this.props;
        const {name, salary, position} = employee;
        const {level, childIDs, isOpened, isRoot, hasChildren, loadingData} = node;
        const {total, isFullLoaded, isLoading} = loadingData;

        let showOpenButton = !isRoot && (!isFullLoaded || hasChildren);
        let showLoadMore = !isFullLoaded && hasChildren && isOpened;

        return (
            <div style={{"paddingLeft": level * 10}}>
                <div className={isRoot && "employees_root"}>
                    <div>{name}</div>
                    <div>{this.getPositionName(position)}</div>
                    <div>{salary}</div>
                </div>
                {showOpenButton &&
                <span onClick={this.toggleNode}
                      style={{"cursor": "pointer"}}
                      className={isOpened ? "fa fa-minus-circle" : "fa fa-plus-circle"}
                />
                }
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