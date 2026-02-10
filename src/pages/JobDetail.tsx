import { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { scrapedJobsAPI } from '../services/api.ts';
import Loading from '../components/common/Loading';
import { Briefcase, MapPin, CreditCard, Calendar, ClipboardList } from 'lucide-react';

const getAppliedJobs = () => {
  const data = localStorage.getItem('appliedJobs');
  return data ? JSON.parse(data) : [];
};

const setAppliedJobs = (jobs: number[]) => {
  localStorage.setItem('appliedJobs', JSON.stringify(jobs));
};

const JobDetail = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [job, setJob] = useState<any>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const [applied, setApplied] = useState<number[]>(getAppliedJobs());

  useEffect(() => {
    const fetchJob = async () => {
      if (!id) {
        setError('ID lowongan tidak valid.');
        setLoading(false);
        return;
      }

      setLoading(true);
      setError(null);
      try {
        const res = await scrapedJobsAPI.getJob(Number(id));
        setJob(res.data.data ? res.data.data : res.data);
      } catch (err) {
        setError('Gagal memuat detail lowongan.');
      } finally {
        setLoading(false);
      }
    };
    fetchJob();
  }, [id]);

  useEffect(() => {
    setAppliedJobs(applied);
  }, [applied]);

  if (loading) return <div className="py-16 flex justify-center"><Loading text="Memuat detail lowongan..." /></div>;
  if (error) return <div className="text-red-500 py-16 text-center">{error}</div>;
  if (!job) return null;

  return (
    <div className="page-container max-w-3xl mx-auto bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
      <button onClick={() => navigate(-1)} className="mb-6 text-navy-700 dark:text-gray-100 hover:underline">&larr; Kembali</button>
      <div className="bg-white dark:bg-gray-800 rounded-3xl shadow p-8 border-2 border-gray-100 dark:border-gray-700">
        <div className="flex items-center mb-6">
          <div className="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center border-2 border-black overflow-hidden mr-5">
            {job.companyLogo ? (
              <img src={job.companyLogo} alt={job.company} className="w-full h-full object-cover" />
            ) : (
              <Briefcase size={32} className="text-gray-400" />
            )}
          </div>
          <div>
            <h1 className="text-2xl font-bold text-navy-900 dark:text-gray-100 mb-1">{job.position}</h1>
            <div className="text-navy-700 dark:text-gray-100 font-medium">{job.company}</div>
          </div>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <div className="flex items-center text-navy-700 dark:text-gray-100"><MapPin size={18} className="mr-2" /> {job.location}</div>
          <div className="flex items-center text-navy-700 dark:text-gray-100"><ClipboardList size={18} className="mr-2" /> {job.type || '-'}</div>
          <div className="flex items-center text-navy-700 dark:text-gray-100"><CreditCard size={18} className="mr-2" /> {job.salary ? `Rp${job.salary.toLocaleString()}` : '-'}</div>
          <div className="flex items-center text-navy-700 dark:text-gray-100"><Calendar size={18} className="mr-2" /> {job.date ? new Date(job.date).toLocaleDateString() : '-'}</div>
        </div>
        <div className="mb-6">
          <h2 className="font-bold text-lg mb-2">Deskripsi Pekerjaan</h2>
          <div className="text-gray-700 dark:text-gray-100 whitespace-pre-line">{job.description || '-'}</div>
        </div>
        {job.requirements && (
          <div className="mb-6">
            <h2 className="font-bold text-lg mb-2">Syarat & Kualifikasi</h2>
            <ul className="list-disc ml-6 text-gray-700 dark:text-gray-100">
              {Array.isArray(job.requirements)
                ? job.requirements.map((req: string, idx: number) => <li key={idx}>{req}</li>)
                : <li>{job.requirements}</li>}
            </ul>
          </div>
        )}
        <div className="mt-8">
          <a
            href={job.jobUrl}
            target="_blank"
            rel="noopener noreferrer"
            className="btn btn-primary"
          >
            Lamar di Situs Asli
          </a>
        </div>
      </div>
    </div>
  );
};

export default JobDetail; 