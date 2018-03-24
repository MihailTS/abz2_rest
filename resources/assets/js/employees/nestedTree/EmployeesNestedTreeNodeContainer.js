import {connect} from 'react-redux';
import Employees from './EmployeesNestedTreeNode';
import {bindActionCreators} from 'redux';
import * as actions from './actions';
import * as employeesActions from '../actions';
import * as positionsActions from '../../positions/actions';

function mapStateToProps(state, ownProps) {
    return {
        employee: state.employeesState.employees[ownProps.id],
        node: state.nestedTreeEmployeesState.nodes[ownProps.id],
        positions: state.positionsState.positions
    };
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        ...employeesActions,
        ...actions,
        ...positionsActions,
    }, dispatch);
}
export default connect(mapStateToProps, mapDispatchToProps)(Employees);
