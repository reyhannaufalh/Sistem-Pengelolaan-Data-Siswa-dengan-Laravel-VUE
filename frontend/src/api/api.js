import axios from "axios"

let instance = axios.create({
    withCredentials: true,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
});

instance.interceptors.response.use(
    response => { return response; },
    error => {
        if (error.response.status === 401) {
            sessionStorage.removeItem('user');
            window.location.reload();
        }
        return Promise.reject(error);
    }
);

export default instance;