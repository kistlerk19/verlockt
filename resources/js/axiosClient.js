import axios from "axios";


const instance = axios.create();

// Add a request interceptor
axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    return config;
  });


export default instance
