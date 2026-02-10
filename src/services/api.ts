import axios, { AxiosInstance, AxiosResponse, InternalAxiosRequestConfig, AxiosError } from 'axios';
import toast from 'react-hot-toast';

// Create an axios instance
const api: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

// Add a request interceptor to include the token in requests
api.interceptors.request.use(
    (config: InternalAxiosRequestConfig) => {
        const token = localStorage.getItem('token');
        if (token && config.headers) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }
        return config;
    },
    (error: AxiosError) => {
        return Promise.reject(error);
    }
);

// Add a response interceptor to handle errors
api.interceptors.response.use(
    (response: AxiosResponse) => {
        return response;
    },
    (error: AxiosError) => {
        const { response } = error;

        if (response && response.status === 401) {
            // Clear token and redirect to login if unauthorized
            localStorage.removeItem('token');
            window.location.href = '/login';
            toast.error('Session expired. Please login again.');
        } else if (response && response.data && (response.data as any).message) {
            // Show error message from API
            toast.error((response.data as any).message);
        } else {
            // Show generic error message
            toast.error('An error occurred. Please try again.');
        }

        return Promise.reject(error);
    }
);

// API endpoints
export const authAPI = {
    register: (data: any, config = {}) => api.post('/register', data, config),
    login: (data: any) => api.post('/login', data),
    logout: () => api.post('/logout'),
    getProfile: () => api.get('/profile'),
    updateProfile: (data: any) => api.put('/profile', data),
};

export const cvAPI = {
    getCV: () => api.get('/cv'),
    createUpdateCV: (data: any) => api.post('/cv', data),
    generateCV: (data?: { language?: string; tone?: string }) => api.post('/cv/generate', data),
    exportCV: () => api.get('/cv/export', { responseType: 'blob' }),
    matchJobs: () => api.post('/cv/match-jobs'),
    analyzeUploadedCV: (file: File) => {
        const formData = new FormData();
        formData.append('file', file);
        return api.post('/cv/analyze-upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
    },
    aiChat: (data: any) => api.post('/cv/ai-chat', data),
};

export const experienceAPI = {
    getExperiences: () => api.get('/pengalaman'),
    createExperience: (data: any) => api.post('/pengalaman', data),
    getExperience: (id: number) => api.get(`/pengalaman/${id}`),
    updateExperience: (id: number, data: any) => api.put(`/pengalaman/${id}`, data),
    deleteExperience: (id: number) => api.delete(`/pengalaman/${id}`),
};

export const educationAPI = {
    getEducations: () => api.get('/pendidikan'),
    createEducation: (data: any) => api.post('/pendidikan', data),
    getEducation: (id: number) => api.get(`/pendidikan/${id}`),
    updateEducation: (id: number, data: any) => api.put(`/pendidikan/${id}`, data),
    deleteEducation: (id: number) => api.delete(`/pendidikan/${id}`),
};

export const skillsAPI = {
    getSkills: () => api.get('/skills'),
    createSkill: (data: any) => {
        const formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);
        }
        return api.post('/skills', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
    },
    getSkill: (id: number) => api.get(`/skills/${id}`),
    updateSkill: (id: number, data: any) => {
        const formData = new FormData();
        for (const key in data) {
            formData.append(key, data[key]);
        }
        return api.put(`/skills/${id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });
    },
    deleteSkill: (id: number) => api.delete(`/skills/${id}`),
};

export const jobsAPI = {
    getJobs: (params?: any) => api.get('/jobs', { params }),
    getJob: (id: number) => api.get(`/jobs/${id}`),
};

export const scrapedJobsAPI = {
    getJobs: (params?: any) => api.get('/jobs', { params }),
    getJob: (id: number) => api.get(`/jobs/${id}`),
};

export default api;
