import React from 'react';
import {render} from 'react-dom';
import {Provider} from 'react-redux';
import {BrowserRouter as Router} from 'react-router-dom';
import App from './app/App'
import store from './app/store';

render(
    (<Provider store={ store }>
        <Router>
            <App/>
        </Router>
    </Provider>)
    , document.getElementById('root')
)