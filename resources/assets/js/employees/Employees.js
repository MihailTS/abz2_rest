import React, {Component} from 'react';
import EmployeesContainer from './EmployeesContainer';

export default class Employees extends Component {
    componentDidMount() {
        if (this.props.id === 0) {
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

    isRootLevel() {
        return (this.props.level === 0);
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
                {!this.isRootLevel() ? this.props.currentEmployee.name : null}
                {!this.isFullLoaded() &&
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