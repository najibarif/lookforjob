import { useEffect, useState } from 'react';
import { motion } from 'framer-motion';
import JobFilter from '../components/jobs/JobFilter';
import { scrapedJobsAPI } from '../services/api.ts';
import Loading from '../components/common/Loading';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { Link } from 'react-router-dom';

const Jobs = () => {
  const [jobs, setJobs] = useState<any[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [error, setError] = useState<string | null>(null);
  const [filters, setFilters] = useState<any>({});
  const [page, setPage] = useState<number>(1);
  const [totalPages, setTotalPages] = useState<number>(1);

  const fetchJobs = async (params: any = {}) => {
    setLoading(true);
    setError(null);
    try {
      const res = await scrapedJobsAPI.getJobs({ ...params, page });
      const data = res.data.data ? res.data.data : res.data;
      setJobs(data);
      setTotalPages(res.data.last_page || 1);
    } catch (err) {
      setError('Gagal memuat data lowongan');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchJobs(filters);
  }, [filters, page]);

  const handleFilter = (params: any) => {
    setPage(1);
    setFilters(params);
  };

  const handlePageChange = (newPage: number) => {
    if (newPage >= 1 && newPage <= totalPages) {
      setPage(newPage);
    }
  };

  return (
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="page-container bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300"
    >
      <h1 className="text-3xl font-bold mb-8">Cari Pekerjaan</h1>
      <div className="mb-8">
        <JobFilter onFilter={handleFilter} />
      </div>
      <div>
        {loading ? (
          <div className="py-16 flex justify-center"><Loading text="Memuat Lowongan..." /></div>
        ) : error ? (
          <div className="flex flex-col items-center justify-center py-16 text-red-500">
            <span className="text-4xl mb-2">⚠️</span>
            {error}
          </div>
        ) : jobs.length === 0 ? (
          <div className="flex flex-col items-center justify-center py-16 text-gray-500">
            <span className="text-4xl mb-2">🔍</span>
            Tidak ada lowongan ditemukan.
          </div>
        ) : (
          <div className="overflow-x-auto rounded-2xl shadow border border-gray-200 bg-white dark:bg-gray-800 dark:border-gray-700">
            <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead className="bg-navy-50 dark:bg-gray-800">
                <tr>
                  <th className="px-6 py-4 text-left text-xs font-semibold text-navy-700 dark:text-gray-100 uppercase">Nama Posisi</th>
                  <th className="px-6 py-4 text-left text-xs font-semibold text-navy-700 dark:text-gray-100 uppercase">Perusahaan</th>
                  <th className="px-6 py-4 text-left text-xs font-semibold text-navy-700 dark:text-gray-100 uppercase">Lokasi</th>
                  <th className="px-6 py-4 text-left text-xs font-semibold text-navy-700 dark:text-gray-100 uppercase">Tipe</th>
                  <th className="px-6 py-4 text-left text-xs font-semibold text-navy-700 dark:text-gray-100 uppercase">Gaji</th>
                  <th className="px-6 py-4"></th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100 dark:divide-gray-700">
                {jobs.map((job) => (
                  <tr key={job.id} className="hover:bg-navy-50 dark:hover:bg-gray-700 transition">
                    <td className="px-6 py-4 font-medium text-navy-900">
                      <Link to={`/jobs/${job.id}`} className="hover:underline text-primary">
                        {job.position}
                      </Link>
                    </td>
                    <td className="px-6 py-4">{job.company}</td>
                    <td className="px-6 py-4">{job.location}</td>
                    <td className="px-6 py-4">{job.type || '-'}</td>
                    <td className="px-6 py-4">{job.salary ? `Rp${job.salary.toLocaleString()}` : '-'}</td>
                    <td className="px-6 py-4 text-right">
                      <a
                        href={job.jobUrl}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-block px-4 py-2 bg-primary text-white font-semibold rounded-xl border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,0.8)] hover:shadow-none transition-all whitespace-nowrap text-sm"
                      >
                        Lamar di Situs Asli
                      </a>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
        {totalPages > 1 && (
          <div className="flex justify-center mt-8 gap-2">
            <button onClick={() => handlePageChange(page - 1)} disabled={page === 1} className="px-4 py-2 rounded-lg border bg-white font-bold shadow-md disabled:opacity-50"><ChevronLeft size={20} /></button>
            <span className="px-4 py-2 font-bold">{page} / {totalPages}</span>
            <button onClick={() => handlePageChange(page + 1)} disabled={page === totalPages} className="px-4 py-2 rounded-lg border bg-white font-bold shadow-md disabled:opacity-50"><ChevronRight size={20} /></button>
          </div>
        )}
      </div>
    </motion.div>
  );
};

export default Jobs;