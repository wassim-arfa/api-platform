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

    return axiosInstance;
};

const axiosInstance = instance();
export default axiosInstance;
