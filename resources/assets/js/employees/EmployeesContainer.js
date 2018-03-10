import {connect} from 'react-redux';
import Employees from './Employees';
import {bindActionCreators} from 'redux';
import * as actions from './actions';

function mapStateToProps(state) {
    return {
        employees: state.employeesState.employees
    };
}

function mapDispatchToProps(dispatch) {
    return bindActionCreators({
        ...actions,
    }, dispatch);
}
export default connect(mapStateToProps, mapDispatchToProps)(Employees);
