import Axios, { AxiosError, AxiosInstance, AxiosRequestConfig } from "axios";
import { ENTRYPOINT } from "./entrypoint";

const instance = (config: AxiosRequestConfig = {}): AxiosInstance => {
    const { headers, ...conf } = config;
    const axiosConfig: AxiosRequestConfig = {
        baseURL: ENTRYPOINT,
        ...conf,
    };

    const axiosInstance = Axios.create(axiosConfig);

    axiosInstance.interceptors.response.use(
        (response) => response,
        (error: AxiosError) => error
    );

    axiosInstance.interceptors.request.use(
        (config: AxiosRequestConfig) => {
            const { origin } = new URL(`${config.baseURL}/${config.url}`);
            const allowedOrigins = [ENTRYPOINT];
            const token = localStorage.getItem("token");
            if (token && allowedOrigins.includes(origin)) {
                config.headers.authorization = `Bearer ${token}`;
            }
            return config;
        },
        (error: AxiosError) => {
            return Promise.reject(error);
        }
    );

    return axiosInstance;
};

const axiosInstance = instance();
export default axiosInstance;
