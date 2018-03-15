import React, {Component} from 'react';
import EmployeesContainer from './EmployeesContainer';

export default class Employees extends Component {
    componentDidMount() {
        if (this.isRoot()) {//initial load
            this.props.toggleEmployeesNode();
        }
    }
    renderChildren() {
        let children = this.props.currentEmployee.childIDs;
        if (!children) {
            return null;
        }
        return children.map((childID) =>
            <EmployeesContainer
                key={childID}
                id={childID}
                level={this.props.level + 1}
            />
        )

    }

    hasChildren() {
        return (typeof this.props.currentEmployee.childIDs !== 'undefined' &&
        this.props.currentEmployee.childIDs.length > 0)
    }

    isOpened() {
        return this.props.currentEmployee.isOpened;
    }

    isRoot() {
        return (this.props.id === 0);
    }

    isLoading() {
        return (this.props.loadingData !== undefined && this.props.loadingData.isLoading);
    }

    isFullLoaded() {
        return (this.props.loadingData !== undefined && this.props.loadingData.isFullLoaded);
    }

    loadMore = () => (
        this.props.getEmployeesData(this.props.id, this.props.loadingData)
    );
    toggleNode = () => (
        this.props.toggleEmployeesNode(this.props.id, this.isOpened(), this.props.currentEmployee.childIDs)
    );
    render() {
        return (
            <div style={{"paddingLeft": this.props.level * 10}} key={this.props.id}>
                <div className={this.isRoot() ? "employees_root" : null}>
                    <div>{this.props.currentEmployee.name}</div>
                    <div>{this.props.currentEmployee.position}</div>
                    <div>{this.props.currentEmployee.salary}</div>
                </div>
                {!this.isRoot() && (!this.isFullLoaded() || this.hasChildren()) &&
                <button onClick={this.toggleNode}>{(this.isOpened()) ? "-" : "+"}</button>
                }
                {this.isOpened() ? this.renderChildren() : null}
                {this.isLoading() && <div>Loading...</div>}
                {!this.isFullLoaded() && this.hasChildren() && this.isOpened() &&
                <div style={{"paddingLeft": 15}}>
                    <span>({this.props.currentEmployee.childIDs.length}/{this.props.loadingData.total})</span>
                    <button onClick={this.loadMore}>Load more...</button>
                </div>
                }

            </div>
        );
    }
}