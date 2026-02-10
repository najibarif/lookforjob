/**
 * Format a date in a human-readable format
 */
export const formatDate = (date: string | Date, format: 'full' | 'monthYear' | 'short' = 'full'): string => {
    if (!date) return '';

    const dateObj = new Date(date);

    const options: Record<string, Intl.DateTimeFormatOptions> = {
        full: { year: 'numeric', month: 'long', day: 'numeric' },
        monthYear: { year: 'numeric', month: 'long' },
        short: { year: 'numeric', month: 'short' }
    };

    return dateObj.toLocaleDateString('en-US', options[format] || options.full);
};

/**
 * Format currency values
 */
export const formatCurrency = (amount: number, currency: string = 'IDR'): string => {
    if (!amount && amount !== 0) return '';

    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency,
        minimumFractionDigits: 0
    }).format(amount);
};

/**
 * Truncate text to a specified length and add ellipsis
 */
export const truncateText = (text: string, length: number = 100): string => {
    if (!text) return '';
    if (text.length <= length) return text;

    return text.slice(0, length) + '...';
};

/**
 * Calculate time elapsed since a given date
 */
export const timeAgo = (date: string | Date): string => {
    if (!date) return '';

    const seconds = Math.floor((new Date().getTime() - new Date(date).getTime()) / 1000);

    let interval = seconds / 31536000;
    if (interval > 1) {
        return Math.floor(interval) + ' years ago';
    }

    interval = seconds / 2592000;
    if (interval > 1) {
        return Math.floor(interval) + ' months ago';
    }

    interval = seconds / 86400;
    if (interval > 1) {
        return Math.floor(interval) + ' days ago';
    }

    interval = seconds / 3600;
    if (interval > 1) {
        return Math.floor(interval) + ' hours ago';
    }

    interval = seconds / 60;
    if (interval > 1) {
        return Math.floor(interval) + ' minutes ago';
    }

    return Math.floor(seconds) + ' seconds ago';
};

/**
 * Capitalize the first letter of each word in a string
 */
export const capitalizeWords = (str: string): string => {
    if (!str) return '';

    return str
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join(' ');
};

/**
 * Generate a random ID
 */
export const generateId = (length: number = 8): string => {
    return Math.random().toString(36).substring(2, 2 + length);
};

/**
 * Extract image filename from a URL or path
 */
export const extractFilename = (url: string): string => {
    if (!url) return '';

    return url.split('/').pop() || '';
};
