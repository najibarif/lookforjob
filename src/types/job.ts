export interface Job {
    id: number;
    position: string;
    company: string;
    companyLogo?: string;
    location?: string;
    salary?: number;
    date?: string;
    jobUrl?: string;
}

export interface FilterParams {
    keyword?: string;
    location?: string;
    job_type?: string;
    company?: string;
}
