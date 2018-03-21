import * as actions from './actionTypes';

const initialState = {
    nodes: {
        0: {
            isOpened: true,
            isRoot: true,
            childIDs: {},
            level: 0,

            loadingData: {
                isLoading: false,
                isFullLoaded: true,
            }
        }
    }
};
const defaultNodeState = {
    isOpened: false,
    isRoot: false,
    childIDs: {},

    loadingData: {
        isLoading: false,
        isFullLoaded: false,
    }
};
export default (state = initialState, action) => {
    const headID = action.head;
    switch (action.type) {
        case actions.GET_EMPLOYEES_NODES: {
            let hasNewChildren = (
                Array.isArray(action.childIDs) &&
                action.childIDs.length > 0
            );
            let hasChildrenAlready = (
                Array.isArray(state.nodes[headID].childIDs) &&
                state.nodes[headID].childIDs.length > 0
            );
            let hasChildren = hasChildrenAlready || hasNewChildren;

            let headNodeChildrenIDs = action.childIDs;
            let headNodeChildren = {};

            if (hasNewChildren) {
                if (hasChildrenAlready) {
                    headNodeChildrenIDs = action.childIDs.filter(   //if child is already in state - ignore this one
                        (childID) => (!state.nodes[headID].childIDs.includes(childID))
                    );
                }
                headNodeChildren = action.childIDs.reduce(
                    (nodes, childID) => ({
                        ...nodes,
                        [childID]: {
                            ...defaultNodeState,
                            level: state.nodes[headID].level + 1
                        }
                    }),
                    {}
                );
            }
            return {
                ...state,
                nodes: {
                    ...state.nodes,
                    [headID]: {
                        ...state.nodes[headID],
                        childIDs: [
                            ...(state.nodes[headID].childIDs || []),
                            ...headNodeChildrenIDs
                        ],
                        hasChildren: hasChildren,

                        loadingData: {
                            ...state.nodes[headID].loadingData,
                            ...action.loadingData
                        }
                    },
                    ...headNodeChildren
                }
            };
        }
        case actions.OPEN_EMPLOYEES_NODE: {
            return {
                ...state,
                nodes: {
                    ...state.nodes,
                    [headID]: {
                        ...state.nodes[headID],
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
                            ...state.nodes[item],
                            isOpened: false
                        }
                    }
                ), {});
            return {
                ...state,
                nodes: {
                    ...state.nodes,
                    [headID]: {
                        ...state.nodes[headID],
                        isOpened: false
                    },
                    ...closedChildren
                }
            };
        }
        case actions.START_LOADING_NODE: {
            let loadingData;
            if (state.nodes.loadingData) {
                loadingData = {...state.nodes[headID].loadingData};
            }
            return {
                ...state,
                nodes: {
                    ...state.nodes,
                    [headID]: {
                        ...state.nodes[headID],
                        loadingData: {
                            ...loadingData,
                            isLoading: true
                        }
                    }
                }

            }
        }
        default:
            return state;
    }
};