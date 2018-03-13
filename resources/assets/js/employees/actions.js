import axios from 'axios'

export const getEmployees = employees => ({
    type: 'GET_EMPLOYEES',
    employees
});
export const getEmployeesData = (head) => dispatch => {
    let url = "";
    if (!head) {
        url = "/api/v1/employees?head=null";
    } else {
        url = `/api/v1/employees/${head}/subordinates`
    }
    axios({url: url}).then(response => {
        dispatch(getEmployees(response.data.data))
    }).catch(error => {
        console.log(error);
    });
};
export const openEmployeesNode = head => ({
    type: 'OPEN_EMPLOYEES_NODE',
    head
});