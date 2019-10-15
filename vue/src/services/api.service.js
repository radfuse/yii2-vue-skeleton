import axios from 'axios';
import TokenService from './token.service';

const ApiService = {
    _401interceptor: null,

    init(baseURL) {
        axios.defaults.baseURL = baseURL;
    },
    setHeader() {
        axios.defaults.headers.common["Authorization"] = `Bearer ${TokenService.getToken()}`;
    },
    removeHeader() {
        delete axios.defaults.headers.common['Authorization'];
    },
    get(resource) {
        return axios.get(resource);
    },
    post(resource, data) {
        return axios.post(resource, data);
    },
    put(resource, data) {
        return axios.put(resource, data);
    },
    delete(resource) {
        return axios.delete(resource);
    },
}

export default ApiService;