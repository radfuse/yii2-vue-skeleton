import axios from 'axios';
import TokenService from './token.service';
import store from '../store';
import router from '../router';

const ApiService = {
    _tokenRefreshInterceptor: null,

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
    mountTokenRefresh() {
        this._tokenRefreshInterceptor = axios.interceptors.response.use(
            (response) => {
                return response;
            },
            (error) => {
                const originalRequest = error.config;
                if (error.response.status == 401) {
                    if (error.config.url.includes('/site/refresh-token')) {
                        store.dispatch('logout')
                            .then(() => {
                                router.push({ name: 'login' });
                            })
                            .catch((err) => {
                                throw err;
                            });
                    }
                    else {
                        return store.dispatch('refreshToken')
                            .then(() => {
                                return axios({
                                    method: originalRequest.method,
                                    url: originalRequest.url,
                                    data: originalRequest.data
                                });
                            })
                            .catch((err) => {
                                throw err;
                            });
                    }
                }

                throw error;
            }
        );
    },
    unmountTokenRefresh() {
        axios.interceptors.response.eject(this._tokenRefreshInterceptor)
    }
}

export default ApiService;