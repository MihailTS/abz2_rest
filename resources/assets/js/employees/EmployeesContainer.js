import {connect} from 'react-redux';
import Employees from './Employees';
import {bindActionCreators} from 'redux';
import * as actions from './actions';

function mapStateToProps(state, ownProps) {
    return {
        currentEmployee: state.employeesState.employees[ownProps.id],
        loadingData: state.employeesState.loadingData[ownProps.id],
    };
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        ...actions,
    }, dispatch);
}
export default connect(mapStateToProps, mapDispatchToProps)(Employees);
