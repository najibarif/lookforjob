import { authAPI } from './api.ts';

// Authentication service to handle token storage and user session
const authService = {
    // Store token in localStorage
    setToken: (token: string): void => {
        localStorage.setItem('token', token);
    },

    // Get token from localStorage
    getToken: (): string | null => {
        return localStorage.getItem('token');
    },

    // Remove token from localStorage
    removeToken: (): void => {
        localStorage.removeItem('token');
    },

    // Check if user is authenticated
    isAuthenticated: (): boolean => {
        return !!localStorage.getItem('token');
    },

    // Store user data in localStorage
    setUser: (user: any): void => {
        localStorage.setItem('user', JSON.stringify(user));
    },

    // Get user data from localStorage
    getUser: (): any | null => {
        const userData = localStorage.getItem('user');
        return userData ? JSON.parse(userData) : null;
    },

    // Register new user
    register: async (userData: any): Promise<any> => {
        try {
            let config: any = {};
            if (userData instanceof FormData) {
                config.headers = { 'Content-Type': 'multipart/form-data' };
            }
            const response = await authAPI.register(userData, config);
            if (response.data && response.data.data && response.data.data.token) {
                authService.setToken(response.data.data.token);
                authService.setUser(response.data.data.user);
            }
            return response.data;
        } catch (error) {
            throw error;
        }
    },

    // Login user
    login: async (credentials: any): Promise<any> => {
        try {
            const response = await authAPI.login(credentials);
            if (response.data && response.data.data && response.data.data.token) {
                authService.setToken(response.data.data.token);
                authService.setUser(response.data.data.user);
            }
            return response.data;
        } catch (error) {
            throw error;
        }
    },

    // Logout user
    logout: async (): Promise<void> => {
        try {
            if (authService.isAuthenticated()) {
                await authAPI.logout();
            }
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            authService.removeToken();
            localStorage.removeItem('user');
        }
    },

    // Update user profile
    updateProfile: async (userData: any): Promise<any> => {
        try {
            const response = await authAPI.updateProfile(userData);
            if (response.data && response.data.data) {
                authService.setUser(response.data.data);
            }
            return response.data;
        } catch (error) {
            throw error;
        }
    },

    // Get current user profile
    getProfile: async (): Promise<any> => {
        try {
            const response = await authAPI.getProfile();
            if (response.data && response.data.data) {
                authService.setUser(response.data.data);
            }
            return response.data;
        } catch (error) {
            throw error;
        }
    },
};

export default authService;
