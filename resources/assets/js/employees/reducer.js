import * as actions from './actionTypes';

const initialState = {
    employees: {
        0: {
            id: 0,
            name: "root"
        }
    },
    loadingData: {
        0: {
            isLoading: false,
            isFullLoaded: true,
        }
    },
    positions: {}
};

export default (state = initialState, action) => {
    const headID = action.head;
    switch (action.type) {
        case actions.GET_EMPLOYEES: {
            action.childIDs = action.childIDs.filter(         //if child is already in state - ignore this one
                (childID) => (!(childID in state.employees))
            );
            return {
                ...state,
                employees: {
                    ...state.employees,
                    [headID]: {
                        ...state.employees[headID],
                        childIDs: [
                            ...(state.employees[headID].childIDs || []),
                            ...action.childIDs
                        ]
                    },
                    ...action.employees,
                },
                loadingData: {
                    ...state.loadingData,
                    [headID]: action.loadingData
                }
            };
        }
        case actions.OPEN_EMPLOYEES_NODE: {
            return {
                ...state,
                employees: {
                    ...state.employees,
                    [headID]: {
                        ...state.employees[headID],
                        isOpened: true
                    }
                }
            };
        }
        case actions.CLOSE_EMPLOYEES_NODE: {
            let closedChildren = action.childIDs.reduce(//close all nested nodes
                (closedChildrenObj, item) => ({
                        ...closedChildrenObj,
                        [item]: {
                            ...state.employees[item],
                            isOpened: false
                        }
                    }
                ), {});
            return {
                ...state,
                employees: {
                    ...state.employees,
                    [headID]: {
                        ...state.employees[headID],
                        isOpened: false
                    },
                    ...closedChildren
                }
            };
        }
        case actions.START_LOADING: {
            return {
                ...state,
                loadingData: {
                    ...state.loadingData,
                    [headID]: {
                        ...state.loadingData[headID],
                        isLoading: true
                    }
                }
            }
        }
        case actions.GET_POSITIONS: {
            return {
                ...state,
                positions: {
                    ...state.positions,
                    ...action.positions
                }
            }
        }
        default:
            return state;
    }
};