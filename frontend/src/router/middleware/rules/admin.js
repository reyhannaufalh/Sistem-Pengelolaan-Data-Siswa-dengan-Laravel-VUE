import store from '../../../store';

export default (to, from, next) => {
    if (store.getters['authenticated']) {
        if (store.getters['user'].role === 'admin') {
            next();
        } else {
            next({ name: 'UserPost' });
        }
    } else {
        next({ name: 'login' });
    }
}