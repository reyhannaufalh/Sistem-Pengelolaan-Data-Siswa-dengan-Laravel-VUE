import store from '../../../store';

export default (to, from, next) => {
    if (store.getters['authenticated']) {
        if (store.getters['user'].role === 'user') {
            next();
        } else {
            next({ name: 'AdminPost' });
        }
    } else {
        next({ name: 'login' });
    }
}