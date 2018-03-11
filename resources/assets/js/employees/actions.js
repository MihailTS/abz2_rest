import axios from 'axios'

export const getEmployees = employees => ({
    type: 'GET_EMPLOYEES',
    employees
});

export const getEmployeesData = (head) => dispatch => {
    if (!head) {
        head = "null"
    }
    axios({url: ('/api/v1/employees?head=' + head)}).then(response => {
        dispatch(getEmployees(response.data.data))
    }).catch(error => {
        console.log(error);
    });
};
export const openEmployeesNode = head => ({
    type: 'OPEN_EMPLOYEES_NODE',
    head
});