import axios from 'axios'

export const getEmployees = employees => ({
    type: 'GET_EMPLOYEES',
    employees
});

export const getEmployeesData = () => dispatch => {
    axios({url: ('/api/v1/employees')}).then(response => {
        dispatch(getEmployees(response.data.data))
    }).catch(error => {
        console.log(error);
    });
};
